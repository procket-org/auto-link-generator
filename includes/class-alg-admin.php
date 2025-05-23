<?php
/**
 * Admin Class
 * 
 * Handles plugin's admin pages
 */

if (!defined('ABSPATH')) {
    exit;
}

class ALG_Admin {
    /**
     * Initialize
     */
    public function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Auto Link Settings', 'auto-link-generator'),
            __('Auto Link', 'auto-link-generator'),
            'manage_options',
            'auto-link-generator',
            array($this, 'render_admin_page')
        );
    }

    /**
     * Load admin interface resources
     */
    public function enqueue_admin_assets($hook) {
        // Only load resources on plugin page
        if ($hook !== 'settings_page_auto-link-generator') {
            return;
        }

        // Vue.js and other dependencies
        wp_enqueue_script(
            'vue',
            ALG_PLUGIN_URL . 'assets/js/vue.min.js',
            array(),
            '2.6.14',
            true
        );

        wp_enqueue_script(
            'axios',
            ALG_PLUGIN_URL . 'assets/js/axios.min.js',
            array(),
            '0.21.1',
            true
        );

        // Plugin CSS
        wp_enqueue_style(
            'alg-admin-css',
            ALG_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            ALG_VERSION
        );

        // Plugin JS
        wp_enqueue_script(
            'alg-admin-js',
            ALG_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery', 'vue', 'axios'),
            ALG_VERSION,
            true
        );

        // Localize script
        wp_localize_script('alg-admin-js', 'algData', array(
            'apiUrl' => esc_url_raw(rest_url('alg/v1/')),
            'nonce' => wp_create_nonce('wp_rest'),
            'perPageOptions' => ALG_Settings::get_per_page_options(),
            'i18n' => array(
                'confirm_title' => __('Confirm Action', 'auto-link-generator'),
                'button_ok' => __('OK', 'auto-link-generator'),
                'button_cancel' => __('Cancel', 'auto-link-generator'),
                'settings_saved' => __('Settings saved successfully', 'auto-link-generator'),
                'save_failed' => __('Save failed', 'auto-link-generator'),
                'network_error' => __('Network error, please try again', 'auto-link-generator'),
                'add_failed' => __('Add failed', 'auto-link-generator'),
                'update_failed' => __('Update failed', 'auto-link-generator'),
                'delete_failed' => __('Delete failed', 'auto-link-generator'),
                'keyword_empty' => __('Keyword and link URL cannot be empty', 'auto-link-generator'),
                'confirm_delete' => __('Are you sure you want to delete this keyword?', 'auto-link-generator'),
                'select_keywords' => __('Please select keywords to delete', 'auto-link-generator'),
                'confirm_delete_selected' => __('Are you sure you want to delete the selected keywords?', 'auto-link-generator'),
                'search_failed' => __('Search failed', 'auto-link-generator'),
                'post_search_failed' => __('Post search failed', 'auto-link-generator'),
                'post_exclude_failed' => __('Failed to exclude post', 'auto-link-generator'),
                'post_remove_failed' => __('Failed to remove from exclusion list', 'auto-link-generator'),
                'confirm_remove_post' => __('Are you sure you want to remove this post from the exclusion list?', 'auto-link-generator'),
                'no_search_result' => __('No matching posts found', 'auto-link-generator'),
                'please_enter_title' => __('Please enter post title to search', 'auto-link-generator'),
            ),
        ));
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        $options = ALG_Settings::get_options();
        ?>
        <div class="alg-wrap" id="alg-app">
            <h1><?php echo esc_html__('Auto Link Settings', 'auto-link-generator'); ?></h1>
            
            <!-- Global Settings -->
            <div class="alg-section">
                <h2><?php echo esc_html__('Global Settings', 'auto-link-generator'); ?></h2>
                
                <div class="alg-settings-container">
                    <div class="alg-settings-left">
                        <form @submit.prevent="saveSettings">
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="auto_tag_matching"><?php echo esc_html__('Automatic Tag Matching', 'auto-link-generator'); ?></label>
                                    </th>
                                    <td>
                                        <label>
                                            <input type="checkbox" id="auto_tag_matching" v-model="settings.auto_tag_matching">
                                            <?php echo esc_html__('Enable automatic tag matching feature', 'auto-link-generator'); ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="case_sensitive"><?php echo esc_html__('Case Sensitive', 'auto-link-generator'); ?></label>
                                    </th>
                                    <td>
                                        <label>
                                            <input type="checkbox" id="case_sensitive" v-model="settings.case_sensitive">
                                            <?php echo esc_html__('Enable case sensitive matching', 'auto-link-generator'); ?>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="max_links"><?php echo esc_html__('Maximum Links', 'auto-link-generator'); ?></label>
                                    </th>
                                    <td>
                                        <input type="number" id="max_links" v-model="settings.max_links" min="0" class="small-text">
                                        <p class="description"><?php echo esc_html__('Maximum number of links to replace per article, set to 0 for unlimited', 'auto-link-generator'); ?></p>
                                    </td>
                                </tr>
                            </table>
                            <button type="submit" class="button button-primary" :disabled="settingsSaving">
                                {{ settingsSaving ? '<?php echo esc_html__('Saving...', 'auto-link-generator'); ?>' : '<?php echo esc_html__('Save Global Settings', 'auto-link-generator'); ?>' }}
                            </button>
                        </form>
                    </div>
                    
                    <div class="alg-settings-right">
                        <h3><?php echo esc_html__('Excluded Posts', 'auto-link-generator'); ?></h3>
                        <p class="description"><?php echo esc_html__('Posts in this list will not have automatically generated links', 'auto-link-generator'); ?></p>
                        
                        <div class="alg-post-search">
                            <input 
                                type="text" 
                                v-model="postSearchTerm" 
                                @input="searchPostsDebounced" 
                                @focus="isSearchFocused = true"
                                @blur="handleSearchBlur"
                                placeholder="<?php echo esc_attr__('Enter keywords to search posts', 'auto-link-generator'); ?>">
                            <div class="alg-search-results-dropdown" v-if="postSearchResults.length > 0 && isSearchFocused">
                                <ul>
                                    <li v-for="post in postSearchResults" :key="post.id" @mousedown="excludePost(post)">
                                        {{ post.title }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="alg-excluded-posts">
                            <div class="alg-excluded-header">
                                <h4><?php echo esc_html__('Excluded Posts List', 'auto-link-generator'); ?></h4>
                                <div class="alg-per-page">
                                    <select v-model="postsPerPage" @change="changePostsPerPage">
                                        <option v-for="option in perPageOptions" :value="option">
                                            {{ option }} <?php echo esc_html__('items/page', 'auto-link-generator'); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="alg-table-container">
                                <table class="alg-table">
                                    <thead>
                                        <tr>
                                            <th class="column-title"><?php echo esc_html__('Post Title', 'auto-link-generator'); ?></th>
                                            <th class="column-date"><?php echo esc_html__('Exclusion Time', 'auto-link-generator'); ?></th>
                                            <th class="column-action"><?php echo esc_html__('Action', 'auto-link-generator'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="excludedPosts.length === 0">
                                            <td colspan="3"><?php echo esc_html__('No excluded posts', 'auto-link-generator'); ?></td>
                                        </tr>
                                        <tr v-for="post in excludedPosts" :key="post.id">
                                            <td class="column-title">
                                                <a :href="post.edit_url" target="_blank">{{ post.title }}</a>
                                            </td>
                                            <td class="column-date">
                                                {{ post.excluded_at }}
                                            </td>
                                            <td class="column-action">
                                                <button @click="removeExcludedPost(post.id)" class="button button-small button-link-delete" :disabled="postsSaving">
                                                    <?php echo esc_html__('Remove', 'auto-link-generator'); ?>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="alg-pagination" v-if="postsTotalPages > 1">
                                <button @click="goToPostsPage(postsCurrentPage - 1)" :disabled="postsCurrentPage === 1" class="button">
                                    <?php echo esc_html__('Previous', 'auto-link-generator'); ?>
                                </button>
                                <span class="alg-page-info">
                                    {{ postsCurrentPage }} / {{ postsTotalPages }}
                                </span>
                                <button @click="goToPostsPage(postsCurrentPage + 1)" :disabled="postsCurrentPage === postsTotalPages" class="button">
                                    <?php echo esc_html__('Next', 'auto-link-generator'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keyword Management -->
            <div class="alg-section">
                <h2><?php echo esc_html__('Keyword Management', 'auto-link-generator'); ?></h2>
                
                <!-- Add Keyword -->
                <div class="alg-keyword-form">
                    <form @submit.prevent="addKeyword">
                        <div class="alg-form-row">
                            <div class="alg-form-field">
                                <label for="keyword"><?php echo esc_html__('Keyword', 'auto-link-generator'); ?></label>
                                <input type="text" id="keyword" v-model="newKeyword.keyword" required>
                            </div>
                            <div class="alg-form-field">
                                <label for="link_url"><?php echo esc_html__('Link URL', 'auto-link-generator'); ?></label>
                                <input type="text" id="link_url" v-model="newKeyword.url" required>
                            </div>
                            <div class="alg-form-submit">
                                <button type="submit" class="button button-primary" :disabled="keywordSaving">
                                    {{ keywordSaving ? '<?php echo esc_html__('Adding...', 'auto-link-generator'); ?>' : '<?php echo esc_html__('Add Keyword', 'auto-link-generator'); ?>' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Keyword List -->
                <div class="alg-section">
                    <div class="alg-keywords-header">
                        <h2><?php echo esc_html__('Keyword List', 'auto-link-generator'); ?></h2>
                        <div class="alg-keywords-search">
                            <div class="search-input-wrapper">
                                <input type="text" v-model="searchTerm" placeholder="<?php echo esc_attr__('Search keywords or links', 'auto-link-generator'); ?>" @input="searchKeywordsDebounced">
                                <span v-if="searchTerm" class="search-clear-icon" @click="clearSearch">×</span>
                            </div>
                            <button @click="searchKeywords" class="button">
                                <?php echo esc_html__('Search', 'auto-link-generator'); ?>
                            </button>
                        </div>
                    </div>
                    
                    <div class="alg-table-actions">
                        <div class="alg-bulk-actions">
                            <select v-model="bulkAction">
                                <option value=""><?php echo esc_html__('Bulk Actions', 'auto-link-generator'); ?></option>
                                <option value="delete"><?php echo esc_html__('Delete', 'auto-link-generator'); ?></option>
                            </select>
                            <button @click="applyBulkAction" class="button alg-apply-bulk-action" :disabled="!bulkAction || !selectedKeywords.length">
                                <?php echo esc_html__('Apply', 'auto-link-generator'); ?>
                            </button>
                        </div>
                        
                        <div class="alg-per-page">
                            <select v-model="keywordsPerPage" @change="changePerPage">
                                <option v-for="option in perPageOptions" :value="option">
                                    {{ option }} <?php echo esc_html__('items/page', 'auto-link-generator'); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="alg-table-container">
                        <table class="alg-table">
                            <thead>
                                <tr>
                                    <th class="check-column">
                                        <input class="alg-keyword-checkbox" type="checkbox" @change="toggleAllKeywords" :checked="allKeywordsSelected">
                                    </th>
                                    <th class="column-primary"><?php echo esc_html__('Keyword', 'auto-link-generator'); ?></th>
                                    <th><?php echo esc_html__('Link URL', 'auto-link-generator'); ?></th>
                                    <th><?php echo esc_html__('Creation Time', 'auto-link-generator'); ?></th>
                                    <th class="actions"><?php echo esc_html__('Actions', 'auto-link-generator'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="keywords.length === 0">
                                    <td colspan="5"><?php echo esc_html__('No keywords found', 'auto-link-generator'); ?></td>
                                </tr>
                                <tr v-for="(keyword, index) in keywords" :key="index">
                                    <td class="check-column">
                                        <input type="checkbox" :value="keyword.id" v-model="selectedKeywords">
                                    </td>
                                    <td class="column-primary">
                                        <template v-if="editingKeyword === keyword.id">
                                            <input type="text" v-model="keyword.edit_keyword" class="regular-text">
                                        </template>
                                        <template v-else>
                                            {{ keyword.keyword }}
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="editingKeyword === keyword.id">
                                            <input type="text" v-model="keyword.edit_url" class="regular-text">
                                        </template>
                                        <template v-else>
                                            <a :href="keyword.url" target="_blank">{{ keyword.url }}</a>
                                        </template>
                                    </td>
                                    <td>{{ keyword.created_at }}</td>
                                    <td class="actions">
                                        <template v-if="editingKeyword === keyword.id">
                                            <button @click="updateKeyword(keyword)" class="button button-small" :disabled="keywordSaving">
                                                <?php echo esc_html__('Save', 'auto-link-generator'); ?>
                                            </button>
                                            <button @click="cancelEdit" class="button button-small">
                                                <?php echo esc_html__('Cancel', 'auto-link-generator'); ?>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button @click="editKeyword(keyword)" class="button button-small">
                                                <?php echo esc_html__('Edit', 'auto-link-generator'); ?>
                                            </button>
                                            <button @click="deleteKeyword(keyword.id)" class="button button-small button-link-delete">
                                                <?php echo esc_html__('Delete', 'auto-link-generator'); ?>
                                            </button>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="alg-pagination" v-if="totalPages > 1">
                        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="button">
                            <?php echo esc_html__('Previous', 'auto-link-generator'); ?>
                        </button>
                        <span class="alg-page-info">
                            {{ currentPage }} / {{ totalPages }}
                        </span>
                        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="button">
                            <?php echo esc_html__('Next', 'auto-link-generator'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>

        </style>
        <?php
    }
} 