**🌐 Language**:
[English](./README.md) |
[Deutsch](doc/README-de_DE.md) |
[Español](doc/README-es_ES.md) |
[Français](doc/README-fr_FR.md) |
[日本語](doc/README-ja.md) |
[한국어](doc/README-ko_KR.md) |
[简体中文](doc/README-zh_CN.md) |
[繁體中文](doc/README-zh_TW.md)

---

# Auto Link Generator

**Auto Link Generator** is a WordPress plugin that automatically converts tags or keywords in posts into internal or external links to improve your website's SEO performance and enhance the user experience.

---

## ✨ Features

- 🌐 Supports multilingual keyword matching, including Chinese, Japanese, Korean, etc.
- 🏷️ Automatically uses all post tags as keywords
- 🔗 Automatically converts keywords into links
- 🔍 Supports case-sensitive keyword matching
- ⚙️ Limits the number of links replaced per post
- 🚫 Allows excluding specific posts from auto-linking
- 🖥️ Admin interface built with Vue.js for intuitive operation
- 🔄 Fully supports the WordPress REST API

---

## 🧩 Plugin Installation

1. Download the plugin ZIP package
2. Log in to your WordPress admin panel and go to **Plugins > Add New > Upload Plugin**
3. Upload the ZIP file, then install and activate the plugin

---

## ⚙️ Usage Guide

### Global Settings

1. Go to **Settings > Auto Link** in the WordPress admin panel
2. Configure the following options:
   - **Auto Tag Matching**: When enabled, post tags will be used as keywords automatically
   - **Case Sensitivity**: When enabled, keyword matching will be case-sensitive
   - **Max Links per Post**: Set the maximum number of auto-added links per post (set to `0` for no limit)

### Exclude Specific Posts

- Select and exclude posts you don't want to be auto-linked
- You can remove posts from the exclusion list at any time

### Keyword Management

- Add keywords to be automatically replaced with links, and set their target URLs
- Supports editing, deleting, and batch operations for keywords

---

## ⚙️ How It Works

The plugin automatically scans the post content, detects predefined tags or keywords, and replaces them with target links. It handles the process intelligently to ensure the HTML structure remains intact and does not affect code blocks or other embedded content.

---

## 🔧 Technical Details

- **Frontend Framework**: Vue.js + Axios
- **Backend API**: WordPress REST API
- **Data Storage**: WordPress Options API

---

## ⚠️ Notes

- Too many auto links may affect user experience; it is recommended to set a reasonable link limit
- Important posts should be added to the exclusion list to avoid unnecessary link generation

---

## ❓ FAQ

**Q: How do I remove the auto-link for a specific keyword?**  
A: Go to the keyword management page, find the corresponding keyword, and delete it.

**Q: Why are some keywords not being auto-linked?**  
A: Possible reasons include:
- The post is excluded from auto-linking
- The post has already reached the maximum number of allowed links
- The keyword appears inside HTML tags, code blocks, or other protected content areas

**Q: How can I prevent tags from linking to their archive pages?**  
A: Custom keywords take precedence over tags. You can add a keyword with the same name as the tag and set it to your desired link URL.

---

## 📄 Open Source License

This plugin is licensed under the [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html).