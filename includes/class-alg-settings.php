<?php
/**
 * Settings Class
 * 
 * Handles plugin settings and options
 */

if (!defined('ABSPATH')) {
    exit;
}

class ALG_Settings {
    /**
     * Default options
     */
    private static $default_options = array(
        'keywords' => array(),                // Format: keyword => configuration array
        'case_sensitive' => 0,               // Case-sensitive matching
        'auto_tag_matching' => 1,            // Automatic tag matching feature
        'max_links' => 3,                    // Maximum number of links per article
        'excluded_posts' => array(),         // Excluded posts list (new format will be 2D array with ID and exclusion time)
        'keywords_per_page' => 50,           // Number of keywords to display per page
        'posts_per_page' => 10               // Number of excluded posts to display per page
    );

    /**
     * Called on plugin activation
     */
    public static function activate() {
        // Create default options if they don't exist
        if (!get_option('alg_options')) {
            update_option('alg_options', self::$default_options);
        }
    }

    /**
     * Called on plugin uninstallation
     */
    public static function uninstall() {
        // Do not delete the configuration in the database by default when uninstalling plugins.
        // delete_option('alg_options');
    }

    /**
     * Get plugin settings
     *
     * @param string $key Optional, specific setting key
     * @return mixed Setting value or all settings
     */
    public static function get_options($key = null) {
        $options = get_option('alg_options', self::$default_options);
        
        if ($key && isset($options[$key])) {
            return $options[$key];
        }
        
        return $options;
    }

    /**
     * Update plugin settings
     *
     * @param array $new_options Array of new setting values
     * @return bool Whether update was successful (returns true even if values unchanged)
     */
    public static function update_options($new_options) {
        $options = self::get_options();
        
        // Check for actual changes (avoid unnecessary database writes)
        $has_changes = false;
        foreach ($new_options as $key => $value) {
            // Special handling for array types (like excluded_posts)
            if (is_array($value) && isset($options[$key]) && is_array($options[$key])) {
                if (json_encode($value) !== json_encode($options[$key])) {
                    $has_changes = true;
                    break;
                }
            } else if (!isset($options[$key]) || $options[$key] != $value) {
                $has_changes = true;
                break;
            }
        }
        
        // Return true even if no actual changes
        if (!$has_changes) {
            return true;
        }
        
        $options = array_merge($options, $new_options);
        return update_option('alg_options', $options);
    }

    /**
     * Get pagination options
     *
     * @return array Pagination options
     */
    public static function get_per_page_options() {
        return ALG_PER_PAGE_OPTIONS;
    }
} 