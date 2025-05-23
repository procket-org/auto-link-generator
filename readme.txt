=== Auto Link Generator ===
Contributors: tony
Donate link: https://github.com/procket-org/auto-link-generator
Tags: seo, links, internal-links, keywords, auto-link
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically generate internal links based on keywords and tags, with admin panel support to improve your website's SEO performance.

== Description ==

**Auto Link Generator** is a powerful WordPress plugin that automatically converts tags or keywords in posts into internal or external links to improve your website's SEO performance and enhance the user experience.

= Features =

* 🌐 Supports multilingual keyword matching, including Chinese, Japanese, Korean, etc.
* 🏷️ Automatically uses all post tags as keywords
* 🔗 Automatically converts keywords into links
* 🔍 Supports case-sensitive keyword matching
* ⚙️ Limits the number of links replaced per post
* 🚫 Allows excluding specific posts from auto-linking
* 🖥️ Admin interface built with Vue.js for intuitive operation
* 🔄 Fully supports the WordPress REST API

= How It Works =

The plugin automatically scans the post content, detects predefined tags or keywords, and replaces them with target links. It handles the process intelligently to ensure the HTML structure remains intact and does not affect code blocks or other embedded content.

= Technical Details =

* **Frontend Framework**: Vue.js + Axios
* **Backend API**: WordPress REST API
* **Data Storage**: WordPress Options API

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/auto-link-generator` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the Settings->Auto Link screen to configure the plugin.

== Frequently Asked Questions ==

= How do I remove the auto-link for a specific keyword? =

Go to the keyword management page, find the corresponding keyword, and delete it.

= Why are some keywords not being auto-linked? =

Possible reasons include:
* The post is excluded from auto-linking
* The post has already reached the maximum number of allowed links
* The keyword appears inside HTML tags, code blocks, or other protected content areas

= How can I prevent tags from linking to their archive pages? =

Custom keywords take precedence over tags. You can add a keyword with the same name as the tag and set it to your desired link URL.

= Can I set a limit on the number of auto-links per post? =

Yes, you can set the maximum number of auto-added links per post in the plugin settings. Set to 0 for no limit.

== Screenshots ==

1. Plugin settings page with global configuration options
2. Keyword management interface
3. Post exclusion settings
4. Auto-linking in action on the frontend

== Changelog ==

= 2.0 =
* Added Vue.js admin interface
* Improved keyword management system
* Added REST API support
* Enhanced multilingual support
* Better performance optimization

= 1.0 =
* Initial release
* Basic auto-linking functionality
* Tag-based keyword matching

== Upgrade Notice ==

= 2.0 =
Major update with new admin interface and improved functionality. Please backup your site before upgrading.

== Support ==

For support and feature requests, please visit our [GitHub repository](https://github.com/procket-org/auto-link-generator) or use the WordPress.org support forums. 