=== Gutenberg ===
Contributors: matveb, joen, karmatosed
Requires at least: 4.9.6
Tested up to: 4.9.6
Stable tag: 3.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A new editing experience for WordPress is in the works, with the goal of making it easier than ever to make your words, pictures, and layout look just right. This is the beta plugin for the project.

== Description ==

Gutenberg is more than an editor. While the editor is the focus right now, the project will ultimately impact the entire publishing experience including customization (the next focus area).

<a href="https://wordpress.org/gutenberg">Discover more about the project</a>.

= Editing focus =

> The editor will create a new page- and post-building experience that makes writing rich posts effortless, and has “blocks” to make it easy what today might take shortcodes, custom HTML, or “mystery meat” embed discovery. — Matt Mullenweg

One thing that sets WordPress apart from other systems is that it allows you to create as rich a post layout as you can imagine -- but only if you know HTML and CSS and build your own custom theme. By thinking of the editor as a tool to let you write rich posts and create beautiful layouts, we can transform WordPress into something users _love_ WordPress, as opposed something they pick it because it's what everyone else uses.

Gutenberg looks at the editor as more than a content field, revisiting a layout that has been largely unchanged for almost a decade.This allows us to holistically design a modern editing experience and build a foundation for things to come.

Here's why we're looking at the whole editing screen, as opposed to just the content field:

1. The block unifies multiple interfaces. If we add that on top of the existing interface, it would _add_ complexity, as opposed to remove it.
2. By revisiting the interface, we can modernize the writing, editing, and publishing experience, with usability and simplicity in mind, benefitting both new and casual users.
3. When singular block interface takes center stage, it demonstrates a clear path forward for developers to create premium blocks, superior to both shortcodes and widgets.
4. Considering the whole interface lays a solid foundation for the next focus, full site customization.
5. Looking at the full editor screen also gives us the opportunity to drastically modernize the foundation, and take steps towards a more fluid and JavaScript powered future that fully leverages the WordPress REST API.

= Blocks =

Blocks are the unifying evolution of what is now covered, in different ways, by shortcodes, embeds, widgets, post formats, custom post types, theme options, meta-boxes, and other formatting elements. They embrace the breadth of functionality WordPress is capable of, with the clarity of a consistent user experience.

Imagine a custom “employee” block that a client can drag to an About page to automatically display a picture, name, and bio. A whole universe of plugins that all extend WordPress in the same way. Simplified menus and widgets. Users who can instantly understand and use WordPress  -- and 90% of plugins. This will allow you to easily compose beautiful posts like <a href="http://moc.co/sandbox/example-post/">this example</a>.

Check out the <a href="https://github.com/WordPress/gutenberg/blob/master/docs/faq.md">FAQ</a> for answers to the most common questions about the project.

= Compatibility =

Posts are backwards compatible, and shortcodes will still work. We are continuously exploring how highly-tailored metaboxes can be accommodated, and are looking at solutions ranging from a plugin to disable Gutenberg to automatically detecting whether to load Gutenberg or not. While we want to make sure the new editing experience from writing to publishing is user-friendly, we’re committed to finding  a good solution for highly-tailored existing sites.

= The stages of Gutenberg =

Gutenberg has three planned stages. The first, aimed for inclusion in WordPress 5.0, focuses on the post editing experience and the implementation of blocks. This initial phase focuses on a content-first approach. The use of blocks, as detailed above, allows you to focus on how your content will look without the distraction of other configuration options. This ultimately will help all users present their content in a way that is engaging, direct, and visual.

These foundational elements will pave the way for stages two and three, planned for the next year, to go beyond the post into page templates and ultimately, full site customization.

Gutenberg is a big change, and there will be ways to ensure that existing functionality (like shortcodes and meta-boxes) continue to work while allowing developers the time and paths to transition effectively. Ultimately, it will open new opportunities for plugin and theme developers to better serve users through a more engaging and visual experience that takes advantage of a toolset supported by core.

= Contributors =

Gutenberg is built by many contributors and volunteers. Please see the full list in <a href="https://github.com/WordPress/gutenberg/blob/master/CONTRIBUTORS.md">CONTRIBUTORS.md</a>.

== Frequently Asked Questions ==

= How can I send feedback or get help with a bug? =

We'd love to hear your bug reports, feature suggestions and any other feedback! Please head over to <a href="https://github.com/WordPress/gutenberg/issues">the GitHub issues page</a> to search for existing issues or open a new one. While we'll try to triage issues reported here on the plugin forum, you'll get a faster response (and reduce duplication of effort) by keeping everything centralized in the GitHub repository.

= How can I contribute? =

We’re calling this editor project "Gutenberg" because it's a big undertaking. We are working on it every day in GitHub, and we'd love your help building it.You’re also welcome to give feedback, the easiest is to join us in <a href="https://make.wordpress.org/chat/">our Slack channel</a>, `#core-editor`.

See also <a href="https://github.com/WordPress/gutenberg/blob/master/CONTRIBUTING.md">CONTRIBUTING.md</a>.

= Where can I read more about Gutenberg? =

- <a href="http://matiasventura.com/post/gutenberg-or-the-ship-of-theseus/">Gutenberg, or the Ship of Theseus</a>, with examples of what Gutenberg might do in the future
- <a href="https://make.wordpress.org/core/2017/01/17/editor-technical-overview/">Editor Technical Overview</a>
- <a href="http://gutenberg-devdoc.surge.sh/reference/design-principles/">Design Principles and block design best practices</a>
- <a href="https://github.com/Automattic/wp-post-grammar">WP Post Grammar Parser</a>
- <a href="https://make.wordpress.org/core/tag/gutenberg/">Development updates on make.wordpress.org</a>
- <a href="http://gutenberg-devdoc.surge.sh/">Documentation: Creating Blocks, Reference, and Guidelines</a>
- <a href="https://github.com/WordPress/gutenberg/blob/master/docs/faq.md">Additional frequently asked questions</a>


== Changelog ==

= Latest =

* Fix permalink editor not appearing in 3.1.0.
* Fix sibling block inserter not working in Firefox and Safari in 3.1.0.
* Implement Tips Interface to guide a user in the new editor interface.
* New design version of sibling inserter (the ability to insert blocks between other blocks).
* Allow users to re-enable Tips.
* Allow the user to preview changes to a published post without first updating the post.
* Show the preview mode for HTML blocks converted into shared blocks. This streamlines the process of creating straightforward HTML blocks and letting users insert them visually.
* Exclude the currently focused block from the block completer options. (i.e. don’t show paragraph as an option if already on a paragraph)
* Trigger autosave as standard save for draft by current user.
* Add mime type checking to the pre-upload error messaging system when uploading media.
* Allow block hover outlines to draw color from admin theme.
* Allow transforming multiple paragraph blocks into a single quote block.
* Block API: move useOnce block configuration to supports.multiple = false.
* Add strikethrough support for Markdown conversion when pasting.
* Add yAxis=middle support to Popover to allow showing arrows vertically centered for NUX tips.
* Add BlockIconWithColors component and use it for the block header with description in the inspector.
* Add error notices mechanism directly to media placeholder.
* Refactor the initialization of the editor to only require a post ID.
* Optimize the default column width for character length and use the same width for the text editor.
* Incremental improvements and polish to the mobile block toolbar.
* Visually compensate nested blocks for block padding.
* Prevent slash autocompleter from letting users insert two cases of a useOnce block.
* Let screen readers announce the block aria label.
* Improve the accessibility of featured images.
* Make aria-multiline true by default in RichText so the content field is properly announced.
* Add back role textbox to the List block and improve aria-multiline usage.
* Replace the renderBlockMenu prop with Slot/Fill.
* Hide disabled blocks from shortcut inserter.
* Avoid deprecated React Lifecycle hooks in withAPIData.
* Improve the element serializer to avoid double ampersand encoding of valid character references.
* Update drop-cap design to better balance line length.
* Describe expanded state of “more options” panel.
* Improve DotTip positioning fix.
* Implement Button component as assigning ref via forwardRef (new React API).
* Improve serialising JSON to PHP-compatible query strings.
* Introduce rendererPathWithAttributes() for ServerSideRender.
* Refactor the getPostEdits selector to avoid relying on Lodash’s _.get.
* Refactor withSelect to use getDerivedStateFromProps.
* Replace JSON-escaped quotation mark with unicode escape sequence in Block API. Fixes PlainText component not properly escaping attributes under some specific user roles.
* Fix regression in Columns block’s front-end style.
* Fix regression in SVG support for block icons.
* Fix PHP 5.2 notice by ensuring $memo is always an array.
* Fix margins of embed block content.
* Fix autocomplete behaviour in IE11.
* Fix regression with formatting toolbar not showing divider between some block controls.
* Fix issue where pasting an inline shortcode would produce a separate shortcode block.
* Fix issue when copy pasting images in Chrome.
* Fix typos in code comments.
* Fix consistency of hover styles in toolbars.
* Fix option for linking to attachment page on gallery block.
* Fix Classic Editor adding paragraphs from block boundaries.
* Fix post publish panel showing incorrect UX for contributors who don’t have publishing capability.
* Fix issues with floats and the side UI on wide and full-wide.
* Fix issue where server side upload errors disappear automatically.
* Fix block inserter popover in RTL mode.
* Fix mp3 uploads on chrome.
* Fix getMimeTypesArray return documentation.
* Avoid showing error if autosave runs and there are no changes to save.
* Prevent any disabled button from changing the cursor to pointer.
* Remove ‘who’=>’authors’ compatibility shim as it’s part of WP 4.9.6.
* Remove confusing “wrap text” from Button settings.
* Remove the usage of the componentWillMount lifecycle.
* Remove the componentWillReceiveProps lifecycle usage.
* Remove createInnerBlockList utility / context. This should be a simplification of block context, potentially with some performance and/or memory improvements, as an intermediary component is no longer created.
* Improve translatable strings containing “%s” to have a translator comment.
* Move trash post URL change to the BrowserUrl component. Consolidates all browser navigation (url changes and actual navigation).
* Simplify the withColors HOC so we can avoid the usage of memoize while still having a correct implementation without unnecessary rerenders.
* Refactor Higher-order components in data module to avoid the use of componentWillMount.
* Use mdash for block description in cover image.
* Ensure that only the latest promise updates the autocompleter state for more predictable behaviour.
* Wrap PluginPostStatusInfo with PanelRow rather than Slot. Fix issue with hard to style divs.
* Update demo content to avoid dirtying embed.
* Allow using ServerSideRender component without defined attributes.
* Avoid loading Gutenberg assets in other admin pages.
* Add a new @wordpress/api-request package. Instead of relying on globals to set the nonce/rootURL, it users configurable middlewares. Preloading support is also built as a middleware.
* Move the Core Data Module to packages.
* Move Plugins module to packages.
* Rename all the hooks moved from blocks to editor.
* Add NUX e2e tests.
* Add e2e tests for Plugins API.
* Add es5 samples to edit-post and plugins.
* Add e2e test to blocks.BlockEdit filter.
* Add snapshot test for MoreMenu component.
* Fix broken links in readme files.
* Build tooling: add linting for package.json files.
* Further explanation for why .normalize() is optional in raw-handling.
* Update icon color readme example.
* Generate docs for the data module.
* Enable Strict-Mode of React.
* Publish new versions of WP packages.
* Regenerate integrity checks to sha512.
* Drop deprecations slated for 3.1 removal.
* Upgrade React 16.3.2 to React 16.4.1.
