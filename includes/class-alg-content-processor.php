<?php
/**
 * Content Processor Class
 *
 * Process article content, automatically replace keywords with links
 */

if (!defined('ABSPATH')) {
    exit;
}

class ALG_Content_Processor {
    /**
     * Cached tag keywords
     *
     * @var array|null
     */
    private $cached_tag_keywords = null;

    /**
     * Initialize
     */
    public function init() {
        add_filter('the_content', array($this, 'process_content'));
    }

    /**
     * Process article content, replace keywords with links
     *
     * @param string $content Article content
     * @return string Processed content
     */
    public function process_content($content) {
        // Don't process if not a single post or page
        if (!is_singular()) {
            return $content;
        }

        // Get current post ID
        $post_id = get_the_ID();

        // Get plugin settings
        $options = ALG_Settings::get_options();

        // Check if post is excluded
        if (!empty($options['excluded_posts'])) {
            $excluded_posts = $options['excluded_posts'];

            // Compatibility with old format
            if (isset($excluded_posts[0]) && !is_array($excluded_posts[0])) {
                // Old format: direct array
                if (in_array($post_id, $excluded_posts)) {
                    return $content;
                }
            } else {
                // New format: 2D array with metadata
                foreach ($excluded_posts as $post) {
                    if (isset($post['post_id']) && $post['post_id'] == $post_id) {
                        return $content;
                    }
                }
            }
        }

        // Get keyword list
        $keywords = $options['keywords'];

        // Check if automatic tag matching is enabled
        if (!empty($options['auto_tag_matching'])) {
            $keywords = $this->add_tags_to_keywords($keywords);
        }

        // If no keywords, don't process
        if (empty($keywords)) {
            return $content;
        }

        // Case sensitive matching
        $case_sensitive = isset($options['case_sensitive']) ? $options['case_sensitive'] : false;

        // Maximum number of replacements
        $max_links = isset($options['max_links']) ? (int) $options['max_links'] : 0;

        // Get other matching settings
        $match_settings = array(
            // Enable smart matching
            'smart_matching' => isset($options['smart_matching']) ? $options['smart_matching'] : true,

            // Enable strict CJK character matching
            'strict_cjk_matching' => isset($options['strict_cjk_matching']) ? $options['strict_cjk_matching'] : true,

            // Enable strict single character matching
            'strict_single_char' => isset($options['strict_single_char']) ? $options['strict_single_char'] : true,

            // Enable multilingual support
            'multilingual_support' => isset($options['multilingual_support']) ? $options['multilingual_support'] : true
        );

        // Use regex to process HTML content directly
        return $this->replace_with_regex($content, $keywords, $case_sensitive, $max_links, $match_settings);
    }

    /**
     * Use regex to process HTML content directly, avoid DOM operations that might lose attributes
     *
     * @param string $html HTML content
     * @param array $keywords Keyword list
     * @param bool $case_sensitive Whether case sensitive
     * @param int $max_links Maximum number of replacements
     * @param array $match_settings Matching settings
     * @return string Processed HTML
     */
    private function replace_with_regex($html, $keywords, $case_sensitive, $max_links, $match_settings) {
        // If content is empty or no keywords, return directly
        if (empty($html) || empty($keywords)) {
            return $html;
        }

        // Replacement counter
        $replacement_count = 0;

        // Sort keywords by length (longest to shortest)
        uasort($keywords, function($a, $b) {
            return mb_strlen($b['keyword']) - mb_strlen($a['keyword']);
        });

        // Get site domain
        $site_host = wp_parse_url(get_site_url(), PHP_URL_HOST);

        // Use regex to split HTML, separate HTML tags and text
        $html_parts = preg_split('/(<[^>]*>)/i', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        // Excluded tags
        $excluded_tags = array('a', 'script', 'style', 'code', 'pre', 'textarea', 'option', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6');

        $placeholders = [];
        $placeholder_id_counter = 0;

        // Iterate through keywords (outer loop)
        foreach ($keywords as $id => $keyword_data) {
            // If reached maximum replacements, stop processing
            if ($max_links > 0 && $replacement_count >= $max_links) {
                break; // from keywords loop
            }

            $keyword = $keyword_data['keyword'];
            $url = $keyword_data['url'];

            // Check if external link
            $is_external = $this->is_external_url($url);

            // Prepare title attribute for link
            $title_text = $keyword;
            if (strpos($id, 'tag_') === 0) {
                /* translators: %s: the post tag name */
                $title_text = sprintf(__('View all posts tagged "%s"', 'auto-link-generator'), $keyword);
            }

            // Prepare link attributes
            $link_attributes = ' title="' . esc_attr($title_text) . '"';

            if ($is_external) {
                // External link: add target="_blank" and security attributes
                $link_attributes .= ' target="_blank"';

                // Check if nofollow needed
                $url_host = wp_parse_url($url, PHP_URL_HOST);
                if ($this->should_add_nofollow($url, $url_host, $site_host)) {
                    $link_attributes .= ' rel="nofollow noopener noreferrer"';
                } else {
                    $link_attributes .= ' rel="noopener noreferrer"';
                }
            } else {
                // Internal link: add target="_self"
                $link_attributes .= ' target="_self"';
            }

            // Intelligently determine matching pattern
            $pattern_str = $this->get_smart_pattern($keyword, $match_settings);
            if (!$case_sensitive) {
                $pattern_str .= 'i';
            }

            // Track if in excluded tag
            $in_excluded_tag = false;
            $excluded_tag_stack = array();

            // Iterate through HTML parts (inner loop)
            foreach ($html_parts as $idx => &$part) { // Iterate by reference to modify $html_parts
                // Check if opening tag
                if (preg_match('/^<([a-z0-9]+)(\\s|>)/i', $part, $matches_tag_open)) {
                    $tag = strtolower($matches_tag_open[1]);
                    if (in_array($tag, $excluded_tags)) {
                        $in_excluded_tag = true;
                        array_push($excluded_tag_stack, $tag);
                    }
                }
                // Check if closing tag
                elseif (preg_match('/^<\\/([a-z0-9]+)>/i', $part, $matches_tag_close)) {
                    $tag = strtolower($matches_tag_close[1]);
                    if (in_array($tag, $excluded_tags) && !empty($excluded_tag_stack) && $excluded_tag_stack[count($excluded_tag_stack)-1] === $tag ) {
                        array_pop($excluded_tag_stack);
                        $in_excluded_tag = !empty($excluded_tag_stack);
                    }
                }
                // Process plain text parts (or parts that might contain placeholders from previous keywords)
                elseif (!$in_excluded_tag && trim($part) != '') {
                    if (preg_match($pattern_str, $part, $match_details, PREG_OFFSET_CAPTURE)) {
                        $current_match_is_valid = true;

                        // For CJK characters, if strict CJK matching is enabled, check if part of a word
                        if (!empty($match_settings['strict_cjk_matching']) &&
                            $this->is_cjk_keyword($keyword)) {
                            if (!$this->is_valid_cjk_match($keyword, $part)) { // $part is the current text segment
                                $current_match_is_valid = false;
                            }
                        }

                        // For single characters, if strict single char matching is enabled, extra check
                        if ($current_match_is_valid && !empty($match_settings['strict_single_char']) &&
                            mb_strlen($keyword) === 1) {
                            if (!$this->is_valid_single_char_match($keyword, $part)) { // $part is the current text segment
                                $current_match_is_valid = false;
                            }
                        }

                        if ($current_match_is_valid) {
                            $matched_keyword_text = $match_details[1][0]; // Text captured by the first group in pattern, e.g., ($keyword_escaped)
                            $full_match_text    = $match_details[0][0];    // Full text matched by pattern
                            $full_match_offset  = $match_details[0][1];  // Offset of full match

                            $placeholder_key = "%%ALG_PLACEHOLDER_" . $placeholder_id_counter++ . "%%";
                            // Escape the matched keyword text before inserting it as the link's display text
                            $link_text_display = htmlspecialchars($matched_keyword_text, ENT_QUOTES, 'UTF-8');
                            $link_html = '<a href="' . esc_url($url) . '"' . $link_attributes . '>' . $link_text_display . '</a>';
                            
                            $placeholders[$placeholder_key] = $link_html;

                            // Replace the first occurrence (identified by $full_match_offset and strlen($full_match_text)) with placeholder
                            $part = substr_replace($part, $placeholder_key, $full_match_offset, strlen($full_match_text));

                            $replacement_count++;

                            // Match keyword only once, break HTML parts loop after successful match
                            // This means for the current keyword, we stop after its first valid replacement.
                            break; 
                        }
                        // If !current_match_is_valid, this specific match is ignored.
                        // The loop over html_parts continues for the current keyword, to find another potential valid match in another part.
                    }
                }
            } // End inner html_parts loop

            // If reached maximum replacements, stop processing keywords
            if ($max_links > 0 && $replacement_count >= $max_links) {
                break; // from keywords loop
            }
        } // End outer keywords loop

        // Merge all parts (some of which are now placeholders) into complete HTML
        $html_with_placeholders = implode('', $html_parts);
        
        // Substitute placeholders with their actual HTML link content
        if (!empty($placeholders)) {
            // Using strtr for potentially safer replacement if keys/values have overlaps,
            // though with unique placeholders like %%...%%, str_replace is usually fine.
            $final_html = str_replace(array_keys($placeholders), array_values($placeholders), $html_with_placeholders);
        } else {
            $final_html = $html_with_placeholders;
        }

        return $final_html;
    }

    /**
     * Add all tags as keywords
     *
     * @param array $keywords Existing keyword list
     * @return array Keyword list with tags added
     */
    private function add_tags_to_keywords($keywords) {
        if (is_array($this->cached_tag_keywords)) {
            return array_merge($keywords, $this->cached_tag_keywords);
        }

        // Get all tags
        $args = array(
            'taxonomy' => 'post_tag',
            'hide_empty' => true,
            'number' => 0 // Get all tags
        );

        $all_tags = get_terms($args);

        if (!$all_tags || is_wp_error($all_tags) || empty($all_tags)) {
            return $keywords;
        }

        // Copy existing keyword array, avoid modifying original data
        $enhanced_keywords = $keywords ? $keywords : array();
        $tag_keywords = array();

        // Iterate through all tags, add to keyword list
        foreach ($all_tags as $tag) {
            $tag_name = $tag->name;
            $tag_link = get_tag_link($tag->term_id);

            // Check if same keyword already exists
            $exists = false;
            foreach ($enhanced_keywords as $keyword_data) {
                if (strtolower($keyword_data['keyword']) === strtolower($tag_name)) {
                    $exists = true;
                    break;
                }
            }

            // If tag name not in keyword list, add
            if (!$exists) {
                $id = 'tag_' . $tag->term_id;
                $tag_keywords[$id] = array(
                    'keyword' => $tag_name,
                    'url' => $tag_link,
                    'created_at' => current_time('mysql')
                );
            }
        }

        // Cache tag keywords
        $this->cached_tag_keywords = $tag_keywords;

        // Merge manually added keywords and tag keywords
        return array_merge($enhanced_keywords, $tag_keywords);
    }

    /**
     * Check if external link
     *
     * @param string $url Link address
     * @return bool Whether external link
     */
    private function is_external_url($url) {
        $site_url = get_site_url();
        $site_host = wp_parse_url($site_url, PHP_URL_HOST);
        $url_host = wp_parse_url($url, PHP_URL_HOST);

        return $site_host !== $url_host;
    }

    /**
     * Check if should add nofollow attribute to link
     *
     * @param string $url Link URL
     * @param string $url_host Link domain
     * @param string $site_host Site domain
     * @return bool Whether should add nofollow
     */
    private function should_add_nofollow($url, $url_host, $site_host) {
        // Exclude own subdomain
        if ($url_host === $site_host) {
            return false;
        }

        // Check if site subdomain
        $site_domain_parts = explode('.', $site_host);
        if (count($site_domain_parts) >= 2) {
            $main_domain = $site_domain_parts[count($site_domain_parts) - 2] . '.' . $site_domain_parts[count($site_domain_parts) - 1];
            // Check if link domain is site subdomain
            if (strpos($url_host, '.' . $main_domain) !== false) {
                return false; // Don't add nofollow to subdomain
            }
        }

        // Exclude specific domains, such as other sites
        $trusted_domains = array(
            // Add trusted domains, such as:
            // 'example.com',
            // 'myotherblog.com'
            // Default empty, can add setting in backend management interface
        );

        if (in_array($url_host, $trusted_domains)) {
            return false;
        }

        // Check if URL contains specific string, such as product link
        $affiliate_indicators = array('affiliate', 'ref=', 'partner');
        foreach ($affiliate_indicators as $indicator) {
            if (stripos($url, $indicator) !== false) {
                return true;
            }
        }

        // Based on domain type, decide whether to add nofollow
        $common_domains = array(
            '.gov', '.edu', // Educational and government websites are usually high quality, no need for nofollow
            'wikipedia.org', // Wikipedia is also a high quality information source
            'github.com' // GitHub is also a high quality technical resource
        );

        foreach ($common_domains as $domain) {
            if (stripos($url_host, $domain) !== false) {
                return false; // Don't add nofollow to high quality domain
            }
        }

        // Default to adding nofollow to external links, this is safer SEO practice
        // If your website trustworthiness is high, you can change to false
        return true;
    }

    /**
     * Intelligently determine matching pattern
     *
     * @param string $keyword Keyword
     * @param array $match_settings Matching settings
     * @return string Regex matching pattern
     */
    private function get_smart_pattern($keyword, $match_settings) {
        // Check if smart matching is enabled
        if (empty($match_settings['smart_matching'])) {
            // Don't enable smart matching, use simple string matching
            return '/(' . preg_quote($keyword, '/') . ')/';
        }

        // Check keyword length
        $keyword_length = mb_strlen($keyword);
        $keyword_escaped = preg_quote($keyword, '/');

        // Check if single character
        if ($keyword_length === 1) {
            // Check if strict single char matching is enabled
            if (!empty($match_settings['strict_single_char'])) {
                // For single character, we need more precise processing
                return $this->get_single_char_pattern($keyword, $keyword_escaped);
            } else {
                // Don't enable strict single char matching, use loose word boundary
                return '/\b(' . $keyword_escaped . ')\b/';
            }
        }

        // Check if multilingual support is enabled
        if (empty($match_settings['multilingual_support'])) {
            // Don't enable multilingual support, use same matching rules for all keywords
            return '/\b(' . $keyword_escaped . ')\b/';
        }

        // Check if CJK (Chinese, Japanese, Korean) characters
        if (preg_match('/^[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]+$/u', $keyword)) {
            // For pure CJK characters
            return '/(' . $keyword_escaped . ')/u';
        }

        // Check if Arabic, Hebrew, etc. from right to left written languages
        if (preg_match('/[\p{Arabic}\p{Hebrew}]/u', $keyword)) {
            // For RTL languages, use special processing
            return '/(' . $keyword_escaped . ')/u';
        }

        // For mixed characters (such as English+Chinese)
        if (preg_match('/[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}\p{Thai}\p{Lao}\p{Myanmar}\p{Khmer}]/u', $keyword)) {
            // If contains CJK or Southeast Asian etc. without obvious word boundaries, don't use \b boundary
            return '/(' . $keyword_escaped . ')/u';
        }

        // For general Latin characters (such as English) and other languages using space separation
        return '/\b(' . $keyword_escaped . ')\b/';
    }

    /**
     * Get single character matching pattern
     *
     * @param string $keyword Single character keyword
     * @param string $keyword_escaped Escaped keyword
     * @return string Regex matching pattern
     */
    private function get_single_char_pattern($keyword, $keyword_escaped) {
        // Latin letters, numbers and basic symbols
        if (preg_match('/^[a-zA-Z0-9]$/', $keyword)) {
            // Latin letters or numbers, use strict word boundary
            return '/\b(' . $keyword_escaped . ')\b/';
        }

        // Greek letters
        if (preg_match('/^\p{Greek}$/u', $keyword)) {
            return '/\b(' . $keyword_escaped . ')\b/u';
        }

        // Cyrillic letters
        if (preg_match('/^\p{Cyrillic}$/u', $keyword)) {
            return '/\b(' . $keyword_escaped . ')\b/u';
        }

        // Arabic letters
        if (preg_match('/^\p{Arabic}$/u', $keyword)) {
            // Use zero width assertion to ensure not Arabic text before and after
            return '/(?<![\p{Arabic}])(' . $keyword_escaped . ')(?![\p{Arabic}])/u';
        }

        // Hebrew letters
        if (preg_match('/^\p{Hebrew}$/u', $keyword)) {
            return '/(?<![\p{Hebrew}])(' . $keyword_escaped . ')(?![\p{Hebrew}])/u';
        }

        // Thai characters
        if (preg_match('/^\p{Thai}$/u', $keyword)) {
            return '/(?<![\p{Thai}])(' . $keyword_escaped . ')(?![\p{Thai}])/u';
        }

        // CJK characters (Chinese, Japanese, Korean)
        if (preg_match('/^[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]$/u', $keyword)) {
            // Chinese, Japanese, Korean characters need to ensure not same character before and after
            return '/(?<![\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}])(' . $keyword_escaped .
                ')(?![\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}])/u';
        }

        // Other language characters (default strategy)
        // Use generic zero width assertion, ensure before and after are blank or punctuation
        return '/(?<![^\s\p{P}])(' . $keyword_escaped . ')(?![^\s\p{P}])/u';
    }

    /**
     * Check if CJK (Chinese, Japanese, Korean) keyword
     *
     * @param string $keyword Keyword
     * @return bool Whether CJK keyword
     */
    private function is_cjk_keyword($keyword) {
        // Check if keyword contains Chinese, Japanese, Korean characters
        return preg_match('/[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]/u', $keyword);
    }

    /**
     * Check if valid CJK match
     *
     * @param string $keyword Keyword
     * @param string $text Text content
     * @return bool Whether valid CJK match
     */
    private function is_valid_cjk_match($keyword, $text) {
        // For single character CJK keywords, special processing needed
        if (mb_strlen($keyword) === 1) {
            // Find all positions of keyword in text
            $matches = array();
            preg_match_all('/' . preg_quote($keyword, '/') . '/u', $text, $matches, PREG_OFFSET_CAPTURE);

            if (empty($matches[0])) {
                return false;
            }

            // For each match position, check its surrounding characters
            foreach ($matches[0] as $match) {
                $pos = $match[1];
                $is_valid = true;

                // Check previous character (if any)
                if ($pos > 0) {
                    $prev_char = mb_substr($text, $pos - 1, 1, 'UTF-8');
                    // If previous character is CJK character, not valid match
                    if (preg_match('/[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]/u', $prev_char)) {
                        $is_valid = false;
                    }
                }

                // Check next character (if any)
                $next_pos = $pos + mb_strlen($match[0], 'UTF-8');
                if ($next_pos < mb_strlen($text, 'UTF-8')) {
                    $next_char = mb_substr($text, $next_pos, 1, 'UTF-8');
                    // If next character is CJK character, not valid match
                    if (preg_match('/[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]/u', $next_char)) {
                        $is_valid = false;
                    }
                }

                // If found valid match, return true
                if ($is_valid) {
                    return true;
                }
            }

            // No valid match found
            return false;
        }

        // For multi-character CJK keywords
        // Here we temporarily consider all multi-character CJK keywords valid,
        // Because current regex pattern is already able to handle most cases
        return true;
    }

    /**
     * Check if valid single character match
     *
     * @param string $keyword Single character keyword
     * @param string $text Text content
     * @return bool Whether valid single character match
     */
    private function is_valid_single_char_match($keyword, $text) {
        // Latin letters, numbers and basic symbols
        if (preg_match('/^[a-zA-Z0-9]$/', $keyword)) {
            // Latin letters or numbers, use strict word boundary
            return preg_match('/^\b(' . preg_quote($keyword, '/') . ')\b$/', $text);
        }

        // Greek letters
        if (preg_match('/^\p{Greek}$/u', $keyword)) {
            return preg_match('/^\b(' . preg_quote($keyword, '/') . ')\b$/u', $text);
        }

        // Cyrillic letters
        if (preg_match('/^\p{Cyrillic}$/u', $keyword)) {
            return preg_match('/^\b(' . preg_quote($keyword, '/') . ')\b$/u', $text);
        }

        // Arabic letters
        if (preg_match('/^\p{Arabic}$/u', $keyword)) {
            // Use zero width assertion to ensure not Arabic text before and after
            return preg_match('/^(?<![\p{Arabic}])(' . preg_quote($keyword, '/') . ')(?![\p{Arabic}])$/u', $text);
        }

        // Hebrew letters
        if (preg_match('/^\p{Hebrew}$/u', $keyword)) {
            return preg_match('/^(?<![\p{Hebrew}])(' . preg_quote($keyword, '/') . ')(?![\p{Hebrew}])$/u', $text);
        }

        // Thai characters
        if (preg_match('/^\p{Thai}$/u', $keyword)) {
            return preg_match('/^(?<![\p{Thai}])(' . preg_quote($keyword, '/') . ')(?![\p{Thai}])$/u', $text);
        }

        // CJK characters (Chinese, Japanese, Korean)
        if (preg_match('/^[\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}]$/u', $keyword)) {
            // Chinese, Japanese, Korean characters need to ensure not same character before and after
            return preg_match('/^(?<![\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}])(' . preg_quote($keyword, '/') .
                ')(?![\p{Han}\p{Hiragana}\p{Katakana}\p{Hangul}])$/u', $text);
        }

        // Other language characters (default strategy)
        // Use generic zero width assertion, ensure before and after are blank or punctuation
        return preg_match('/^(?<![^\s\p{P}])(' . preg_quote($keyword, '/') . ')(?![^\s\p{P}])$/u', $text);
    }
}
