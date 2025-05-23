<?php
/**
 * API Class
 *
 * Handle REST API endpoint registration and callbacks
 */

if (!defined('ABSPATH')) {
    exit;
}

class ALG_API
{
    /**
     * Initialize
     */
    public function init()
    {
        add_action('rest_api_init', array($this, 'register_endpoints'));
    }

    /**
     * Register API endpoints
     */
    public function register_endpoints()
    {
        // Base namespace
        $namespace = 'alg/v1';

        // Settings related
        register_rest_route($namespace, '/settings', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_settings'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/settings', array(
            'methods' => 'POST',
            'callback' => array($this, 'update_settings'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        // Keywords related
        register_rest_route($namespace, '/keywords', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_keywords'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/keywords/add', array(
            'methods' => 'POST',
            'callback' => array($this, 'add_keyword'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/keywords/update/(?P<id>[a-zA-Z0-9_]+)', array(
            'methods' => 'POST',
            'callback' => array($this, 'update_keyword'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/keywords/delete/(?P<id>[a-zA-Z0-9_]+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'delete_keyword'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/keywords/bulk-delete', array(
            'methods' => 'POST',
            'callback' => array($this, 'bulk_delete_keywords'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        // Excluded posts related
        register_rest_route($namespace, '/excluded-posts', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_excluded_posts'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/posts/search', array(
            'methods' => 'GET',
            'callback' => array($this, 'search_posts'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/posts/exclude', array(
            'methods' => 'POST',
            'callback' => array($this, 'exclude_post'),
            'permission_callback' => array($this, 'permissions_check')
        ));

        register_rest_route($namespace, '/posts/remove-exclude/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => array($this, 'remove_excluded_post'),
            'permission_callback' => array($this, 'permissions_check')
        ));
    }

    /**
     * Permission check
     * @param WP_REST_Request $request Request object
     * @return bool Whether it has permission
     */
    public function permissions_check($request)
    {
        return current_user_can('manage_options');
    }

    /**
     * Get settings
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function get_settings($request)
    {
        $options = ALG_Settings::get_options();

        return rest_ensure_response(array(
            'auto_tag_matching' => (bool)$options['auto_tag_matching'],
            'case_sensitive' => (bool)$options['case_sensitive'],
            'max_links' => (int)$options['max_links'],
            'keywords_per_page' => (int)$options['keywords_per_page'],
            'posts_per_page' => (int)$options['posts_per_page']
        ));
    }

    /**
     * Update settings
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function update_settings($request)
    {
        try {
            $options = array();

            if (isset($request['auto_tag_matching'])) {
                $options['auto_tag_matching'] = (bool)$request['auto_tag_matching'] ? 1 : 0;
            }

            if (isset($request['case_sensitive'])) {
                $options['case_sensitive'] = (bool)$request['case_sensitive'] ? 1 : 0;
            }

            if (isset($request['max_links'])) {
                $options['max_links'] = absint($request['max_links']);
            }

            if (isset($request['keywords_per_page'])) {
                $options['keywords_per_page'] = absint($request['keywords_per_page']);
            }

            if (isset($request['posts_per_page'])) {
                $options['posts_per_page'] = absint($request['posts_per_page']);
            }

            // Ensure excluded posts data won't be lost
            $current_options = ALG_Settings::get_options();
            if (!empty($current_options['excluded_posts'])) {
                // Don't convert data format here, just keep existing format
                $options['excluded_posts'] = $current_options['excluded_posts'];
            }

            if (ALG_Settings::update_options($options)) {
                return rest_ensure_response(array(
                    'success' => true,
                    'message' => __('Settings saved', 'auto-link-generator')
                ));
            }

            return new WP_Error(
                'settings_update_failed',
                __('Failed to save settings', 'auto-link-generator'),
                array('status' => 500)
            );
        } catch (Exception $e) {
            return new WP_Error(
                'settings_update_error',
                __('Error occurred while saving settings: ', 'auto-link-generator') . $e->getMessage(),
                array('status' => 500)
            );
        }
    }

    /**
     * Get keyword list
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function get_keywords($request)
    {
        $search = sanitize_text_field($request->get_param('search') ?: '');
        $page = absint($request->get_param('page') ?: 1);
        $per_page = absint($request->get_param('per_page') ?: 50);

        $keywords_manager = new ALG_Keywords();
        $result = $keywords_manager->get_keywords($search, $page, $per_page);

        return rest_ensure_response($result);
    }

    /**
     * Add keyword
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function add_keyword($request)
    {
        $keyword = sanitize_text_field($request['keyword']);
        $url = esc_url_raw($request['url']);

        $keywords_manager = new ALG_Keywords();
        $result = $keywords_manager->add_keyword($keyword, $url);

        if (is_wp_error($result)) {
            return new WP_Error(
                $result->get_error_code(),
                $result->get_error_message(),
                array('status' => 400)
            );
        }

        return rest_ensure_response(array(
            'success' => true,
            'keyword' => $result,
            'message' => __('Keyword added successfully', 'auto-link-generator')
        ));
    }

    /**
     * Update keyword
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function update_keyword($request)
    {
        $id = $request['id'];
        $keyword = sanitize_text_field($request['keyword']);
        $url = esc_url_raw($request['url']);

        $keywords_manager = new ALG_Keywords();
        $result = $keywords_manager->update_keyword($id, $keyword, $url);

        if (is_wp_error($result)) {
            return new WP_Error(
                $result->get_error_code(),
                $result->get_error_message(),
                array('status' => 400)
            );
        }

        return rest_ensure_response(array(
            'success' => true,
            'keyword' => $result,
            'message' => __('Keyword updated successfully', 'auto-link-generator')
        ));
    }

    /**
     * Delete keyword
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function delete_keyword($request)
    {
        $id = $request['id'];

        $keywords_manager = new ALG_Keywords();
        $result = $keywords_manager->delete_keyword($id);

        if (!$result) {
            return new WP_Error(
                'delete_failed',
                __('Failed to delete keyword', 'auto-link-generator'),
                array('status' => 400)
            );
        }

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Keyword deleted successfully', 'auto-link-generator')
        ));
    }

    /**
     * Bulk delete keywords
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function bulk_delete_keywords($request)
    {
        $ids = $request['ids'];

        if (!is_array($ids) || empty($ids)) {
            return new WP_Error(
                'invalid_ids',
                __('Invalid keyword IDs', 'auto-link-generator'),
                array('status' => 400)
            );
        }

        $keywords_manager = new ALG_Keywords();
        $result = $keywords_manager->bulk_delete_keywords($ids);

        if (!$result) {
            return new WP_Error(
                'bulk_delete_failed',
                __('Failed to delete keywords', 'auto-link-generator'),
                array('status' => 400)
            );
        }

        return rest_ensure_response(array(
            'success' => true,
            'message' => __('Keywords deleted successfully', 'auto-link-generator')
        ));
    }

    /**
     * Get excluded posts list
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function get_excluded_posts($request)
    {
        try {
            $page = absint($request->get_param('page') ?: 1);
            $per_page = absint($request->get_param('per_page') ?: 10);

            $options = ALG_Settings::get_options();
            $excluded_posts = isset($options['excluded_posts']) ? $options['excluded_posts'] : array();

            // Handle compatibility between old and new data formats
            $formatted_excluded_posts = array();
            if (!empty($excluded_posts)) {
                // Check data format
                if (isset($excluded_posts[0]) && !is_array($excluded_posts[0])) {
                    // Old format: ID array
                    foreach ($excluded_posts as $post_id) {
                        if (!empty($post_id) && is_numeric($post_id)) {
                            $formatted_excluded_posts[] = array(
                                'post_id' => $post_id,
                                'excluded_at' => gmdate('Y-m-d H:i:s') // Use current time for old data
                            );
                        }
                    }
                    // Update data format
                    ALG_Settings::update_options(array('excluded_posts' => $formatted_excluded_posts));
                } else {
                    // New format: already array structure
                    foreach ($excluded_posts as $post) {
                        if (!empty($post['post_id']) && is_numeric($post['post_id'])) {
                            $excluded_at = isset($post['excluded_at']) && !empty($post['excluded_at'])
                                ? $post['excluded_at']
                                : gmdate('Y-m-d H:i:s');

                            $formatted_excluded_posts[] = array(
                                'post_id' => $post['post_id'],
                                'excluded_at' => $excluded_at
                            );
                        }
                    }
                }
            }

            // Sort by exclusion time in descending order
            usort($formatted_excluded_posts, function ($a, $b) {
                return strtotime($b['excluded_at']) - strtotime($a['excluded_at']);
            });

            $total = count($formatted_excluded_posts);
            $total_pages = $total > 0 ? ceil($total / $per_page) : 1;

            // Calculate current page data
            $page = max(1, min($page, $total_pages));
            $offset = ($page - 1) * $per_page;
            $paged_posts = array_slice($formatted_excluded_posts, $offset, $per_page);

            // Get post data
            $posts = array();
            foreach ($paged_posts as $post_data) {
                $post_id = $post_data['post_id'];
                $post = get_post($post_id);
                if ($post) {
                    $posts[] = array(
                        'id' => $post->ID,
                        'title' => $post->post_title,
                        'edit_url' => get_permalink($post->ID),
                        'excluded_at' => $post_data['excluded_at']
                    );
                }
            }

            return rest_ensure_response(array(
                'posts' => $posts,
                'total' => $total,
                'total_pages' => $total_pages,
                'current_page' => $page,
                'per_page' => $per_page
            ));
        } catch (Exception $e) {
            return new WP_Error(
                'get_excluded_posts_error',
                __('Error occurred while getting excluded posts: ', 'auto-link-generator') . $e->getMessage(),
                array('status' => 500)
            );
        }
    }

    /**
     * Search posts
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function search_posts($request)
    {
        $search_term = sanitize_text_field($request->get_param('search') ?: '');

        if (empty($search_term)) {
            return rest_ensure_response(array('posts' => array()));
        }

        $args = array(
            's' => $search_term,
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 10
        );

        $query = new WP_Query($args);
        $posts = array();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $posts[] = array(
                    'id' => $post_id,
                    'title' => get_the_title(),
                    'edit_url' => get_edit_post_link($post_id, 'raw')
                );
            }
            wp_reset_postdata();
        }

        return rest_ensure_response(array('posts' => $posts));
    }

    /**
     * Add post to exclusion list
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function exclude_post($request)
    {
        try {
            $post_id = absint($request['post_id']);

            if (!$post_id || !get_post($post_id)) {
                return new WP_Error(
                    'invalid_post',
                    __('Invalid post', 'auto-link-generator'),
                    array('status' => 400)
                );
            }

            $options = ALG_Settings::get_options();
            $excluded_posts = isset($options['excluded_posts']) ? $options['excluded_posts'] : array();

            // Check if post is already excluded
            $already_excluded = false;
            if (!empty($excluded_posts)) {
                if (isset($excluded_posts[0]) && !is_array($excluded_posts[0])) {
                    // Old format: ID array
                    if (in_array($post_id, $excluded_posts)) {
                        $already_excluded = true;
                    }
                } else {
                    // New format: array structure
                    foreach ($excluded_posts as $post) {
                        if (isset($post['post_id']) && $post['post_id'] == $post_id) {
                            $already_excluded = true;
                            break;
                        }
                    }
                }
            }

            if ($already_excluded) {
                return rest_ensure_response(array(
                    'success' => true,
                    'message' => __('Post is already excluded', 'auto-link-generator')
                ));
            }

            // Add to exclusion list with current time
            $current_time = gmdate('Y-m-d H:i:s');

            // Convert old format
            if (isset($excluded_posts[0]) && !is_array($excluded_posts[0])) {
                $new_excluded_posts = array();
                foreach ($excluded_posts as $old_post_id) {
                    if (!empty($old_post_id) && is_numeric($old_post_id)) {
                        $new_excluded_posts[] = array(
                            'post_id' => $old_post_id,
                            'excluded_at' => $current_time // Use current time
                        );
                    }
                }
                $excluded_posts = $new_excluded_posts;
            }

            $excluded_posts[] = array(
                'post_id' => $post_id,
                'excluded_at' => $current_time
            );

            if (ALG_Settings::update_options(array('excluded_posts' => $excluded_posts))) {
                $post = get_post($post_id);
                return rest_ensure_response(array(
                    'success' => true,
                    'post' => array(
                        'id' => $post->ID,
                        'title' => $post->post_title,
                        'edit_url' => get_edit_post_link($post->ID, 'raw'),
                        'excluded_at' => $current_time
                    ),
                    'message' => __('Post excluded successfully', 'auto-link-generator')
                ));
            }

            return new WP_Error(
                'exclude_failed',
                __('Failed to exclude post', 'auto-link-generator'),
                array('status' => 500)
            );
        } catch (Exception $e) {
            return new WP_Error(
                'exclude_post_error',
                __('Error occurred while excluding post: ', 'auto-link-generator') . $e->getMessage(),
                array('status' => 500)
            );
        }
    }

    /**
     * Remove post from exclusion list
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response Response object
     */
    public function remove_excluded_post($request)
    {
        try {
            $post_id = absint($request['id']);

            $options = ALG_Settings::get_options();
            $excluded_posts = isset($options['excluded_posts']) ? $options['excluded_posts'] : array();

            // Handle compatibility between old and new data formats
            if (!empty($excluded_posts)) {
                if (isset($excluded_posts[0]) && !is_array($excluded_posts[0])) {
                    // Old format: ID array
                    $key = array_search($post_id, $excluded_posts);
                    if ($key !== false) {
                        unset($excluded_posts[$key]);
                        $excluded_posts = array_values($excluded_posts); // Rebuild array indexes
                    }
                } else {
                    // New format: array with timestamps
                    foreach ($excluded_posts as $key => $post) {
                        if (isset($post['post_id']) && $post['post_id'] == $post_id) {
                            unset($excluded_posts[$key]);
                            $excluded_posts = array_values($excluded_posts); // Rebuild array indexes
                            break;
                        }
                    }
                }

                if (ALG_Settings::update_options(array('excluded_posts' => $excluded_posts))) {
                    return rest_ensure_response(array(
                        'success' => true,
                        'message' => __('Post removed from exclusion list', 'auto-link-generator')
                    ));
                }
            }

            return new WP_Error(
                'remove_failed',
                __('Failed to remove post from exclusion list', 'auto-link-generator'),
                array('status' => 400)
            );
        } catch (Exception $e) {
            return new WP_Error(
                'remove_excluded_post_error',
                __('Error occurred while removing excluded post: ', 'auto-link-generator') . $e->getMessage(),
                array('status' => 500)
            );
        }
    }
} 