<?php
/*
Plugin Name: Auto Link Generator
Plugin URI: https://github.com/procket-org/auto-link-generator
Description: Automatically generate internal links based on keywords and tags, with admin panel support
Version: 2.0
Author: tony
Author URI: https://github.com/procket-org
License: GPLv2
Text Domain: auto-link-generator
Domain Path: /languages
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('ALG_VERSION', '3.0');
define('ALG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ALG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ALG_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('ALG_PER_PAGE_OPTIONS', array(10, 20, 50, 100, 200, 500, 1000));

// Load translation files
function alg_load_textdomain() {
    load_plugin_textdomain('auto-link-generator', false, dirname(ALG_PLUGIN_BASENAME) . '/languages');
}
add_action('init', 'alg_load_textdomain');

// Include required files
require_once ALG_PLUGIN_DIR . 'includes/class-alg-settings.php';
require_once ALG_PLUGIN_DIR . 'includes/class-alg-admin.php';
require_once ALG_PLUGIN_DIR . 'includes/class-alg-keywords.php';
require_once ALG_PLUGIN_DIR . 'includes/class-alg-content-processor.php';
require_once ALG_PLUGIN_DIR . 'includes/class-alg-api.php';

// Register activation and uninstall hooks
register_activation_hook(__FILE__, 'ALG_Settings::activate');
register_uninstall_hook(__FILE__, 'ALG_Settings::uninstall');

// Initialize plugin
function alg_init() {
    // Instantiate main classes
    $admin = new ALG_Admin();
    $keywords = new ALG_Keywords();
    $content_processor = new ALG_Content_Processor();
    $api = new ALG_API();

    // Initialize
    $admin->init();
    $keywords->init();
    $content_processor->init();
    $api->init();
}
add_action('plugins_loaded', 'alg_init');

// Add settings link to plugins page
function alg_add_settings_link($links) {
    $settings_link = '<a href="' . admin_url('options-general.php?page=auto-link-generator') . '">' . __('Settings', 'auto-link-generator') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . ALG_PLUGIN_BASENAME, 'alg_add_settings_link');

function alg_enqueue_admin_scripts() {
    // SweetAlert2 dependencies
    wp_enqueue_style('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css');
    wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array(), null, true);
    
    // Plugin's own styles and scripts
    wp_enqueue_style('alg-admin-css', plugins_url('assets/css/admin.css', __FILE__));
    wp_enqueue_script('alg-admin-js', plugins_url('assets/js/admin.js', __FILE__), array('vue', 'sweetalert2'), ALG_VERSION, true);
}
add_action('admin_enqueue_scripts', 'alg_enqueue_admin_scripts');