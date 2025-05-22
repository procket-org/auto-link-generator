<?php
/**
 * Keywords Management Class
 * 
 * Handles CRUD operations for keywords
 */

if (!defined('ABSPATH')) {
    exit;
}

class ALG_Keywords {
    /**
     * Initialize
     */
    public function init() {
        // No additional initialization needed
    }

    /**
     * Add keyword
     *
     * @param string $keyword Keyword
     * @param string $url Link URL
     * @return array|WP_Error Returns keyword data on success, error on failure
     */
    public function add_keyword($keyword, $url) {
        if (empty($keyword) || empty($url)) {
            return new WP_Error('invalid_input', __('Keyword and link URL cannot be empty', 'auto-link-generator'));
        }

        $options = ALG_Settings::get_options();
        $keywords = $options['keywords'];
        
        // Generate unique ID
        $id = uniqid('kw_');
        
        // Check if keyword already exists
        foreach ($keywords as $existing_id => $existing_data) {
            if (strtolower($existing_data['keyword']) === strtolower($keyword)) {
                return new WP_Error('duplicate_keyword', __('Keyword already exists', 'auto-link-generator'));
            }
        }
        
        // Add new keyword
        $keywords[$id] = array(
            'keyword' => $keyword,
            'url' => esc_url_raw($url),
            'created_at' => current_time('mysql')
        );
        
        $options['keywords'] = $keywords;
        if (ALG_Settings::update_options(array('keywords' => $keywords))) {
            return array(
                'id' => $id,
                'keyword' => $keyword,
                'url' => esc_url_raw($url),
                'created_at' => current_time('mysql')
            );
        }
        
        return new WP_Error('save_failed', __('Save failed, please try again', 'auto-link-generator'));
    }

    /**
     * Update keyword
     *
     * @param string $id Keyword ID
     * @param string $keyword Keyword
     * @param string $url Link URL
     * @return array|WP_Error Returns keyword data on success, error on failure
     */
    public function update_keyword($id, $keyword, $url) {
        if (empty($keyword) || empty($url)) {
            return new WP_Error('invalid_input', __('Keyword and link URL cannot be empty', 'auto-link-generator'));
        }

        $options = ALG_Settings::get_options();
        $keywords = $options['keywords'];
        
        if (!isset($keywords[$id])) {
            return new WP_Error('not_found', __('Keyword does not exist', 'auto-link-generator'));
        }
        
        // Check for duplicate keywords
        foreach ($keywords as $existing_id => $existing_data) {
            if ($existing_id === $id) {
                continue;
            }
            
            if (strtolower($existing_data['keyword']) === strtolower($keyword)) {
                return new WP_Error('duplicate_keyword', __('Keyword already exists', 'auto-link-generator'));
            }
        }
        
        // Update keyword
        $keywords[$id]['keyword'] = $keyword;
        $keywords[$id]['url'] = esc_url_raw($url);
        
        $options['keywords'] = $keywords;
        if (ALG_Settings::update_options(array('keywords' => $keywords))) {
            return array(
                'id' => $id,
                'keyword' => $keyword,
                'url' => esc_url_raw($url),
                'created_at' => $keywords[$id]['created_at']
            );
        }
        
        return new WP_Error('update_failed', __('Update failed, please try again', 'auto-link-generator'));
    }

    /**
     * Delete keyword
     *
     * @param string $id Keyword ID
     * @return bool Whether deletion was successful
     */
    public function delete_keyword($id) {
        $options = ALG_Settings::get_options();
        $keywords = $options['keywords'];
        
        if (!isset($keywords[$id])) {
            return false;
        }
        
        unset($keywords[$id]);
        $options['keywords'] = $keywords;
        
        return ALG_Settings::update_options(array('keywords' => $keywords));
    }

    /**
     * Bulk delete keywords
     *
     * @param array $ids Array of keyword IDs
     * @return bool Whether deletion was successful
     */
    public function bulk_delete_keywords($ids) {
        if (empty($ids) || !is_array($ids)) {
            return false;
        }
        
        $options = ALG_Settings::get_options();
        $keywords = $options['keywords'];
        
        foreach ($ids as $id) {
            if (isset($keywords[$id])) {
                unset($keywords[$id]);
            }
        }
        
        $options['keywords'] = $keywords;
        return ALG_Settings::update_options(array('keywords' => $keywords));
    }

    /**
     * Get all keywords
     *
     * @param string $search Optional search term
     * @param int $page Current page number
     * @param int $per_page Items per page
     * @return array List of keywords and pagination info
     */
    public function get_keywords($search = '', $page = 1, $per_page = 50) {
        $options = ALG_Settings::get_options();
        $all_keywords = $options['keywords'];
        $keywords = array();
        
        // Filter by search term if provided
        if (!empty($search)) {
            $search = strtolower($search);
            foreach ($all_keywords as $id => $data) {
                if (strpos(strtolower($data['keyword']), $search) !== false || 
                    strpos(strtolower($data['url']), $search) !== false) {
                    $keywords[$id] = $data;
                }
            }
        } else {
            $keywords = $all_keywords;
        }
        
        // Sort by creation time in descending order
        uasort($keywords, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Calculate pagination data
        $total = count($keywords);
        $total_pages = ceil($total / $per_page);
        $page = max(1, min($page, $total_pages));
        $offset = ($page - 1) * $per_page;
        
        // Get current page data
        $paged_keywords = array_slice($keywords, $offset, $per_page, true);
        
        // Format return data
        $result = array();
        foreach ($paged_keywords as $id => $data) {
            $result[] = array(
                'id' => $id,
                'keyword' => $data['keyword'],
                'url' => $data['url'],
                'created_at' => $data['created_at']
            );
        }
        
        return array(
            'keywords' => $result,
            'total' => $total,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page
        );
    }

    /**
     * Get single keyword
     *
     * @param string $id Keyword ID
     * @return array|false Returns keyword data on success, false on failure
     */
    public function get_keyword($id) {
        $options = ALG_Settings::get_options();
        $keywords = $options['keywords'];
        
        if (isset($keywords[$id])) {
            return array(
                'id' => $id,
                'keyword' => $keywords[$id]['keyword'],
                'url' => $keywords[$id]['url'],
                'created_at' => $keywords[$id]['created_at']
            );
        }
        
        return false;
    }
} 