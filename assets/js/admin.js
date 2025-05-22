/**
 * Auto Link Generator Admin Interface Script
 */

(function() {
    'use strict';

    // Initialize after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Check if on the plugin admin page
        if (!document.getElementById('alg-app')) {
            return;
        }

        // Initialize Vue application
        const app = new Vue({
            el: '#alg-app',
            data: {
                // Global settings
                settings: {
                    auto_tag_matching: false,
                    case_sensitive: false,
                    max_links: 3,
                    keywords_per_page: 50,
                    posts_per_page: 10
                },
                settingsSaving: false,

                // Keyword management
                keywords: [],
                newKeyword: {
                    keyword: '',
                    url: ''
                },
                keywordSaving: false,
                editingKeyword: null,
                selectedKeywords: [],
                bulkAction: '',
                searchTerm: '',
                keywordsPerPage: 50,
                currentPage: 1,
                totalPages: 1,
                totalKeywords: 0,

                // Excluded posts
                excludedPosts: [],
                postSearchTerm: '',
                postSearchResults: [],
                postsSaving: false,
                postsPerPage: 10,
                postsCurrentPage: 1,
                postsTotalPages: 1,
                
                // Delayed search timer
                searchPostsTimeout: null,

                // Add isSearchFocused flag
                isSearchFocused: false,

                // New search keywords timeout
                searchKeywordsTimeout: null
            },
            computed: {
                // Check if all keywords are selected
                allKeywordsSelected: function() {
                    return this.keywords.length > 0 && this.selectedKeywords.length === this.keywords.length;
                },
                // Pagination options
                perPageOptions: function() {
                    return algData.perPageOptions || [10, 20, 50, 100, 200, 500, 1000];
                }
            },
            created: function() {
                // Only load settings on initialization
                // Keyword list and excluded posts list will be called automatically after settings are loaded
                this.currentPage = 1; // Ensure starting from the first page
                this.postsCurrentPage = 1; 
                this.loadSettings();
            },
            methods: {
                /**
                 * Load global settings
                 */
                loadSettings: function() {
                    axios.get(algData.apiUrl + 'settings', {
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        this.settings = response.data;
                        this.keywordsPerPage = response.data.keywords_per_page;
                        this.postsPerPage = response.data.posts_per_page;
                        
                        // After getting the settings, immediately load keywords and excluded posts to ensure correct pagination values
                        this.loadKeywords();
                        this.loadExcludedPosts();
                    })
                    .catch(error => {
                        console.error('Failed to load settings:', error);
                        this.showAlert(algData.i18n.network_error, 'error');
                    });
                },

                /**
                 * Save global settings
                 */
                saveSettings: function() {
                    this.settingsSaving = true;
                    
                    axios.post(algData.apiUrl + 'settings', this.settings, {
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        this.showAlert(algData.i18n.settings_saved, 'success');
                    })
                    .catch(error => {
                        console.error('Failed to save settings:', error);
                        this.showAlert(algData.i18n.save_failed, 'error');
                    })
                    .finally(() => {
                        this.settingsSaving = false;
                    });
                },

                /**
                 * Load keyword list
                 */
                loadKeywords: function() {
                    // Ensure the correct number per page is used
                    if (!this.keywordsPerPage || this.keywordsPerPage < 1) {
                        this.keywordsPerPage = this.settings.keywords_per_page || 10;
                    }
                    
                    axios.get(algData.apiUrl + 'keywords', {
                        params: {
                            search: this.searchTerm,
                            page: this.currentPage,
                            per_page: this.keywordsPerPage
                        },
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        const data = response.data;
                        this.keywords = data.keywords.map(keyword => ({
                            ...keyword,
                            edit_keyword: keyword.keyword,
                            edit_url: keyword.url
                        }));
                        this.totalKeywords = data.total;
                        this.totalPages = data.total_pages;
                        this.currentPage = data.current_page;
                        this.selectedKeywords = [];
                    })
                    .catch(error => {
                        console.error('Failed to load keywords:', error);
                        this.showAlert(algData.i18n.network_error, 'error');
                    });
                },

                /**
                 * Add keyword
                 */
                addKeyword: function() {
                    if (!this.newKeyword.keyword || !this.newKeyword.url) {
                        this.showAlert(algData.i18n.keyword_empty, 'error');
                        return;
                    }

                    this.keywordSaving = true;
                    
                    axios.post(algData.apiUrl + 'keywords/add', this.newKeyword, {
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        this.showAlert(response.data.message, 'success');
                        this.newKeyword.keyword = '';
                        this.newKeyword.url = '';
                        this.loadKeywords();
                    })
                    .catch(error => {
                        console.error('Failed to add keyword:', error);
                        if (error.response && error.response.data && error.response.data.message) {
                            this.showAlert(error.response.data.message, 'error');
                        } else {
                            this.showAlert(algData.i18n.add_failed, 'error');
                        }
                    })
                    .finally(() => {
                        this.keywordSaving = false;
                    });
                },

                /**
                 * Edit keyword
                 */
                editKeyword: function(keyword) {
                    this.editingKeyword = keyword.id;
                    keyword.edit_keyword = keyword.keyword;
                    keyword.edit_url = keyword.url;
                },

                /**
                 * Cancel editing
                 */
                cancelEdit: function() {
                    this.editingKeyword = null;
                },

                /**
                 * Update keyword
                 */
                updateKeyword: function(keyword) {
                    if (!keyword.edit_keyword || !keyword.edit_url) {
                        this.showAlert(algData.i18n.keyword_empty, 'error');
                        return;
                    }

                    this.keywordSaving = true;
                    
                    axios.post(algData.apiUrl + 'keywords/update/' + keyword.id, {
                        keyword: keyword.edit_keyword,
                        url: keyword.edit_url
                    }, {
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        this.showAlert(response.data.message, 'success');
                        this.editingKeyword = null;
                        this.loadKeywords();
                    })
                    .catch(error => {
                        console.error('Failed to update keyword:', error);
                        if (error.response && error.response.data && error.response.data.message) {
                            this.showAlert(error.response.data.message, 'error');
                        } else {
                            this.showAlert(algData.i18n.update_failed, 'error');
                        }
                    })
                    .finally(() => {
                        this.keywordSaving = false;
                    });
                },

                /**
                 * Show alert message
                 */
                showAlert: function(message, type = 'success') {
                    // Choose different display method based on message type
                    if (type === 'error') {
                        // Error messages use centered popup
                        Swal.fire({
                            title: 'Error',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#2271b1',
                            position: 'center'
                        });
                    } else {
                        // Success messages use Toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: type,
                            title: message
                        });
                    }
                },

                /**
                 * Show confirmation dialog
                 */
                showConfirm: function(message) {
                    return Swal.fire({
                        title: algData.i18n.confirm_title,
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2271b1',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: algData.i18n.button_ok,
                        cancelButtonText: algData.i18n.button_cancel,
                        position: 'center',
                        customClass: {
                            popup: 'alg-confirm-dialog'
                        }
                    });
                },

                /**
                 * Delete keyword
                 */
                deleteKeyword: function(id) {
                    this.showConfirm(algData.i18n.confirm_delete)
                        .then((result) => {
                            if (result.isConfirmed) {
                                this.keywordSaving = true;
                                
                                axios.delete(algData.apiUrl + 'keywords/delete/' + id, {
                                    headers: { 'X-WP-Nonce': algData.nonce }
                                })
                                .then(response => {
                                    this.showAlert(response.data.message, 'success');
                                    this.loadKeywords();
                                })
                                .catch(error => {
                                    console.error('Failed to delete keyword:', error);
                                    this.showAlert(algData.i18n.delete_failed, 'error');
                                })
                                .finally(() => {
                                    this.keywordSaving = false;
                                });
                            }
                        });
                },

                /**
                 * Apply bulk action
                 */
                applyBulkAction: function() {
                    if (!this.bulkAction) {
                        return;
                    }

                    if (this.selectedKeywords.length === 0) {
                        this.showAlert(algData.i18n.select_keywords, 'error');
                        return;
                    }

                    if (this.bulkAction === 'delete') {
                        this.showConfirm(algData.i18n.confirm_delete_selected)
                            .then((result) => {
                                if (result.isConfirmed) {
                                    this.keywordSaving = true;
                                    
                                    axios.post(algData.apiUrl + 'keywords/bulk-delete', {
                                        ids: this.selectedKeywords
                                    }, {
                                        headers: { 'X-WP-Nonce': algData.nonce }
                                    })
                                    .then(response => {
                                        this.showAlert(response.data.message, 'success');
                                        this.loadKeywords();
                                        this.bulkAction = '';
                                    })
                                    .catch(error => {
                                        console.error('Failed to bulk delete keywords:', error);
                                        this.showAlert(algData.i18n.delete_failed, 'error');
                                    })
                                    .finally(() => {
                                        this.keywordSaving = false;
                                    });
                                }
                            });
                    }
                },

                /**
                 * Select/deselect all keywords
                 */
                toggleAllKeywords: function() {
                    if (this.selectedKeywords.length === this.keywords.length) {
                        this.selectedKeywords = [];
                    } else {
                        this.selectedKeywords = this.keywords.map(keyword => keyword.id);
                    }
                },

                /**
                 * Search keywords
                 */
                searchKeywords: function() {
                    this.currentPage = 1;
                    this.loadKeywords();
                },

                /**
                 * Search keywords with debounce
                 */
                searchKeywordsDebounced: function() {
                    // Clear previous timer
                    if (this.searchKeywordsTimeout) {
                        clearTimeout(this.searchKeywordsTimeout);
                    }
                    
                    // Set a new timer, delay 300ms to execute search
                    this.searchKeywordsTimeout = setTimeout(() => {
                        this.searchKeywords();
                    }, 300);
                },

                /**
                 * Clear search and reload keywords
                 */
                clearSearch: function() {
                    this.searchTerm = '';
                    this.currentPage = 1;
                    this.loadKeywords();
                },

                /**
                 * Change items per page
                 */
                changePerPage: function() {
                    this.currentPage = 1;
                    this.loadKeywords();
                    
                    // Update settings
                    this.settings.keywords_per_page = this.keywordsPerPage;
                    this.saveSettings();
                },

                /**
                 * Pagination jump
                 */
                goToPage: function(page) {
                    if (page < 1 || page > this.totalPages) {
                        return;
                    }
                    this.currentPage = page;
                    this.loadKeywords();
                },

                /**
                 * Load excluded posts list
                 */
                loadExcludedPosts: function() {
                    // Ensure the correct number per page is used
                    if (!this.postsPerPage || this.postsPerPage < 1) {
                        this.postsPerPage = this.settings.posts_per_page || 10;
                    }
                    
                    axios.get(algData.apiUrl + 'excluded-posts', {
                        params: {
                            page: this.postsCurrentPage,
                            per_page: this.postsPerPage
                        },
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        const data = response.data;
                        this.excludedPosts = data.posts;
                        this.postsTotalPages = data.total_pages;
                        this.postsCurrentPage = data.current_page;
                    })
                    .catch(error => {
                        console.error('Failed to load excluded posts:', error);
                    });
                },

                /**
                 * Search posts (with delay)
                 */
                searchPostsDebounced: function() {
                    // Clear previous timer
                    if (this.searchPostsTimeout) {
                        clearTimeout(this.searchPostsTimeout);
                    }
                    
                    // If search term is empty, clear search results
                    if (!this.postSearchTerm) {
                        this.postSearchResults = [];
                        return;
                    }
                    
                    // Set a new timer, delay 300ms to execute search
                    this.searchPostsTimeout = setTimeout(() => {
                        this.searchPosts();
                    }, 300);
                },

                /**
                 * Search posts
                 */
                searchPosts: function() {
                    if (!this.postSearchTerm) {
                        this.postSearchResults = [];
                        return;
                    }

                    this.postsSaving = true;
                    
                    axios.get(algData.apiUrl + 'posts/search', {
                        params: { search: this.postSearchTerm },
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        this.postSearchResults = response.data.posts;
                        if (this.postSearchResults.length === 0 && this.postSearchTerm) {
                            this.showAlert(algData.i18n.no_search_result, 'info');
                        }
                    })
                    .catch(error => {
                        console.error('Failed to search posts:', error);
                        this.showAlert(algData.i18n.post_search_failed, 'error');
                    })
                    .finally(() => {
                        this.postsSaving = false;
                    });
                },

                /**
                 * Exclude post
                 */
                excludePost: function(post) {
                    this.postsSaving = true;
                    this.isSearchFocused = false;
                    
                    axios.post(algData.apiUrl + 'posts/exclude', {
                        post_id: post.id
                    }, {
                        headers: { 'X-WP-Nonce': algData.nonce }
                    })
                    .then(response => {
                        // Clear search results
                        this.postSearchResults = [];
                        this.postSearchTerm = '';
                        
                        // Reload excluded posts list
                        this.loadExcludedPosts();
                        
                        this.showAlert(response.data.message, 'success');
                    })
                    .catch(error => {
                        console.error('Failed to exclude post:', error);
                        this.showAlert(algData.i18n.post_exclude_failed, 'error');
                    })
                    .finally(() => {
                        this.postsSaving = false;
                    });
                },

                /**
                 * Remove post from exclusion list
                 */
                removeExcludedPost: function(id) {
                    this.showConfirm(algData.i18n.confirm_remove_post)
                        .then((result) => {
                            if (result.isConfirmed) {
                                this.postsSaving = true;
                                
                                axios.delete(algData.apiUrl + 'posts/remove-exclude/' + id, {
                                    headers: { 'X-WP-Nonce': algData.nonce }
                                })
                                .then(response => {
                                    this.loadExcludedPosts();
                                    this.showAlert(response.data.message, 'success');
                                })
                                .catch(error => {
                                    console.error('Failed to remove post from exclusion list:', error);
                                    this.showAlert(algData.i18n.post_remove_failed, 'error');
                                })
                                .finally(() => {
                                    this.postsSaving = false;
                                });
                            }
                        });
                },

                /**
                 * Change the number of excluded posts per page
                 */
                changePostsPerPage: function() {
                    this.postsCurrentPage = 1;
                    this.loadExcludedPosts();
                    
                    // Update settings
                    this.settings.posts_per_page = this.postsPerPage;
                    this.saveSettings();
                },

                /**
                 * Excluded posts pagination jump
                 */
                goToPostsPage: function(page) {
                    if (page < 1 || page > this.postsTotalPages) {
                        return;
                    }
                    this.postsCurrentPage = page;
                    this.loadExcludedPosts();
                },

                // Add handleSearchBlur method
                handleSearchBlur: function() {
                    this.isSearchFocused = false;
                }
            }
        });
    });
})(); 