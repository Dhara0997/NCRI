=== WP Media Folder ===
Tags: media, folder
Requires at least: 4.7.0
Tested up to: 6.8.1
Requires PHP: 5.6
Stable tag: 6.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP media Folder is a WordPress plugin that enhance the WordPress media manager by adding a folder manager inside.

== Description ==

If you were struggling with files and you didn't know how to organize them... 
It's over! With WP Media Folder life is easy, you can manage files, images from the native Wordpress media manager. 
YES, It's true! We did in the media manager of WordPress a file manager where you can drag and drop images and files so easely. 
I can not tell more just watch our demo and please try it to make your own idea.

Stop searching for an image through thousand of media, just navigate like you do on your desktop file manager.

= Changelog = 

= 6.0.7 =
 * Add : Compatibility with WP Media Folder cloud addon version 3.9 - supports offloading to Bunny Storage
 * Fix : Load video thumbnail issue when adding remote Youtube video

= 6.0.6 =
 * Fix : Edit image in the media library

= 6.0.5 =
 * Fix : Improve display of Google Drive video and audio players on mobile devices
 * Fix : Attachment insertion function during folder synchronization on the server

= 6.0.4 =
 * Add : Possibility to import existing server folders into the media library, referencing the original files instead of creating copies in the uploads directory

= 6.0.3 =
 * Add : Compatibility with WP Media Folder cloud addon version 3.8 - Cloudflare R2 object storage

= 6.0.2 =
 * Fix : Watermark issue on thumbnail regeneration
 * Fix : Cannot select image in some conner cases
 * Fix : PHP warning in the edit media screen

= 6.0.1 =
 * Fix : Cannot set feature image for post when creating a new post
 * Fix : Column width issue in the list view of the media library

= 6.0 =
 * Add : Possibility to replace and duplicate file in the list view in media library

= 5.9.14 =
 * Fix : Update and synchronize the image tags between the media library and Media Folder Galleries

= 5.9.13 =
 * Add : Possibility to apply watermark for Woocommerce products only

= 5.9.12 =
 * Fix : Thumbnail display issue on file uploads in some cases
 * Fix : Error physical folder upload

= 5.9.11 =
 * Fix : Disable warning _load_textdomain_just_in_time in WordPress 6.7
 * Fix : Error when missing required PHP DOM extension

= 5.9.10 =
 * Fix : Upload file to wrong folder in specific case
 * Fix : A PHP warning

= 5.9.9 =
 * Fix : Conflict with Woocomerce product listing in dashboard

= 5.9.8 =
 * Add : Create tags: Possibility to create tags for media files
 * Add : Bulk add tags: You can add tags to multiple media files at once.
 * Add : Filter by tag: Filter your media files by tag

= 5.9.7 =
 * Fix : Error while using Elementor theme builder

= 5.9.6 =
 * Add : Option to import files without subdirectories

= 5.9.5 =
 * Fix : Upload image error at the 'Add new media' page

= 5.9.4 =
 * Add : Remote video: support for Kaltura videos
 * Add : Folder selection when no folder tree
 * Add : Set the default icon folder color on the color picker

= 5.9.3 =
 * Fix : The Screen Options dropdown menu on the admin screen is not working

= 5.9.2 =
 * Fix : Error when saving post with some post type

= 5.9.1 =
 * Fix : Error with some custom post type.

= 5.9.0 =
 * Add : Possibility to organize posts with folders (activated by default)
 * Add : Possibility to organize pages with folders (not enabled by default)
 * Add : Possibility to organize custom post with folders (not enabled by default)

= 5.8.9 =
 * Fix : Drop and drag issue on Chrome browser (v127)

= 5.8.8 =
 * Fix : WPMF gallery widget issue in Divi theme

= 5.8.7 =
 * Fix : Error in the block editor

= 5.8.6 =
 * Fix : Update library for pdf.js
 * Fix : WPMF gallery widget in Elementor

= 5.8.5 =
 * Add : Support AVIF images

= 5.8.4 =
 * Add : Support align full option for the WP Media Folder gallery Gutenberg block
 * Fix : Upload folder to cloud
 * Fix : Filter media by trash
 * Fix : JQuery select2 conflict
 * Fix : Support {parent_folder} tag when rename file

= 5.8.3 =
 * Fix : Gallery option in Divi builder
 * Fix : Lazyload gallery image does not work with WP Rocket
 * Fix : Rename file with timestamp option

= 5.8.2 =
 * Fix : Upload folder to Amazon S3
 * Fix : Folder permissions when using media access by user

= 5.8.1 =
 * Fix : Export & import media folder
 * Fix : Custom link and target of image in WP Media Folder gallery
 * Fix : Duplicate image when use sync server folder

= 5.8.0 =
 * Add : Default featured image option for new post

= 5.7.4 =
 * Fix : Export selection folder and media
 * Fix : Override file when upload file (use physical folder)

= 5.7.3 =
 * Fix : Security: added current_user_can() to some functions to check authorization

= 5.7.2 =
 * Fix : Media library doesn't show images in some cases

= 5.7.1 =
 * Fix : Some image type not show after filter

= 5.7.0 =
 * Add : Possibility to select several filter at a time.
 * Add : Display the applied filters
 * Add : Enhance user interface of filter system

= 5.6.4 =
 * Fix : File count on folder tree after create remote video and duplicate file
 * Fix : Download single Google Sheet file

= 5.6.3 =
 * Add : Import media and folders from HappyFiles plugin

= 5.6.2 =
 * Add : Pdf embed in Gutenberg editor improvement
 * Add : Aspect ratio option in gallery default, slider, portfolio theme
 * Add : Remote video improvement with new video format

= 5.6.1 =
 * Fix : Gallery lightbox conflict with lightbox of Enfold theme
 * Fix : Gallery masonry conflict with Divi modal & Smush lazyload
 * Fix : Error PHP when sync server folder

= 5.6.0 =
 * Add : Download a folder in the media library using right click
 * Add : Folder bulk select and remove in folder tree
 * Add : New uploader styling and notifications
 * Add : Media download button in block editor improvement
 * Fix : Single file download style
 * Fix : Update new placeholder image for page builder and classic editor
 * Fix : Gallery masonry column on mobile

= 5.5.13 =
 * Fix : Missing accented characters in title when adding remote video
 * Fix : Load gallery in divi tabs

= 5.5.12 =
 * Add : Compatibility with WP Media Folder cloud addon version 3.7 - NextCloud integration
 * Fix : Duplicate queue
 * Fix : Sync from media library to FTP

= 5.5.11 =
 * Fix : Server folder sync: remove a file from the web server folder when it's deleted from the media library
 * Fix : Support all file types in the media download module of Divi builder
 * Fix : Render thumbnail on import and sync
 * Fix : Display gallery video

= 5.5.10 =
 * Fix : Media access issue
 * Fix : Vertical scrollbar in folder tree

= 5.5.9 =
 * Fix : Support all file types in File Design feature

= 5.5.8 =
 * Add : Support WP Media Folder gallery addon v2.5

= 5.5.7 =
 * Fix : Media access with multiple user roles
 * Fix : Some PHP warnings

= 5.5.6 =
 * Fix : Gallery lightbox

= 5.5.5 =
 * Fix : Show image on gallery with WPML
 * Fix : Adding a remote video in post/page
 * Fix : Missing replace button when open image from media library in list view
 * Fix : Gallery video lightbox

= 5.5.4 =
 * Fix : Folder permissions
 * Fix : Compatible with Elementor latest
 * Fix : Counter in gallery lightbox

= 5.5.3 =
 * Fix : Auto update plugin

= 5.5.2 =
 * Fix : Auto update plugin
 * Fix : Conflict style witn Easy Digital Downloads plugin
 * Fix : Gallery image not showing when enable media access and logged with custom user role

= 5.5.1 =
 * Fix : Gallery preview does not work on Divi builder
 * Fix : PHP fatal error at install wizard in some cases

= 5.5.0 =
 * Add : Possibility to upload a folder on media library
 * Add : Import media and folders from WP Real media library, Filebird, Folders, Media library plus plugin
 * Fix : Wrong video title when adding a remote Youtube video
 * Fix : Load gallery on Elementor tab
 * Fix : Preview image on Media Library modal view
 * Fix : Counter on gallery slider lightbox

= 5.4.8 =
 * Add : Compatibility with WP Media Folder cloud addon version 3.6.2 - Google Cloud integration
 * Fix : List users on folder permission settings
 * Fix : Conflict with Forminator plugin

= 5.4.7 =
 * Add : Inherit option in the folder permissions settings
 * Fix : Open gallery in accordion on panel

= 5.4.6 =
 * Add : Compatibility with WP Media Folder cloud addon version 3.6.1 - Linode integration
 * Fix : Divi builder module warning on PHP 8

= 5.4.5 =
 * Add : Compatibility with WP Media Folder cloud addon version 3.6

= 5.4.4 =
 * Fix : Gallery lightbox conflict with Elementor
 * Fix : Conflict Select2 jQuery
 * Fix : PDF embed height on Divi & Bakery builder
 * Fix : Image hover preview position

= 5.4.3 =
 * Fix : Image hover preview position on media library grid view
 * Fix : WP Media Folder not work in MailPoet field
 * Fix : Upload remote Vimeo video
 * Fix : Gallery lightbox

= 5.4.2 =
 * Fix : Select2 jQuery error js

= 5.4.1 =
 * Fix : PHP error on frontend in some case

= 5.4.0 =
 * Add : Folder access limitation by user: view and make action on it (view, add media, remove media, move media)
 * Add : Folder access limitation by user role: view and make action on it (view, add media, remove media, move media)
 * Fix : Missing alt tag for images in slider gallery

= 5.3.26 =
 * Fix : Save Dropbox settings

= 5.3.25 =
 * Add : Support {folderslug} pattern for media rename

= 5.3.24 =
 * Add : Hook to enable download button on gallery image
 * Fix : Scroll folder tree not show in firefox on Mac
 * Fix : Right to left style
 * Fix : Adding new media in media-new.php page

= 5.3.23 =
 * Fix : Sync server folder
 * Fix : Gallery Youtube lightbox

= 5.3.22 =
 * Add : Generate thumbnail option for cloud image
 * Add : Improve NextGEN galleries importer
 * Fix : Custom order file not work when Smush plugin active
 * Fix : Load slider theme
 * Fix : Gallery settings tooltip
 * Fix : Add loader for cloud image
 * Fix : Slow site when have many galleries on builder
 * Fix : Watermark render

= 5.3.21 =
 * Fix : Amazon S3 tooltip info don't show on Media Library
 * Fix : Embed pdf from cloud
 * Fix : Import FTP with Japanese language
 * Fix : Open PDF from gallery

= 5.3.20 =
 * Fix : PHP warnings on WordPress 5.8
 * Fix : Missing translation strings

= 5.3.19 =
 * Fix : Conflict with WPBakery Page Builder on WordPress 5.8
 * Fix : Breadcrumb hidden on popup view
 * Fix : Duplicate root folder when enable media access
 * Fix : Clear filter on media library
 * Fix : filter not keep on media library
 * Fix : Watermark not appy on upload new image

= 5.3.18 =
 * Fix : PHP fatal error on Wordpress multisite

= 5.3.17 =
 * Fix : Translation not work when setup language by user profile
 * Fix : Move the files on mobile

= 5.3.16 =
 * Fix : Remove some jQuery deprecated functions
 * Fix : PHP error on Avada builder
 * Fix : Export folder
 * Fix : Add remote video from Vimeo, Dailymotion
 * Fix : Include images from subfolder in Bakery builder gallery

= 5.3.15 =
 * Fix : Gallery lightbox on default theme
 * Fix : Gallery display on Elementor

= 5.3.14 =
 * Fix : Load gallery on Betheme
 * Fix : Upload svg file

= 5.3.13 =
 * Fix : Error 'String empty' when sharing translation in some cases

= 5.3.12 =
 * Fix : Update requirements

= 5.3.11 =
 * Add : Update to using global background tasks manager

= 5.3.10 =
 * Fix : Fatal PHP error: Class 'WpmfAvadaGalleryClass' not found

= 5.3.9 =
 * Add : WP Media Folder gallery module for Avada page builder
 * Add : WP Media Folder media download module for Avada page builder
 * Add : WP Media Folder PDF embed module for Avada page builder
 * Fix : Remote Vimeo video
 * Fix : Gallery slider style conflict

= 5.3.8 =
 * Add : WP Media Folder gallery module for WPBakery page builder
 * Add : WP Media Folder media download module for WPBakery page builder
 * Add : WP Media Folder PDF embed module for WPBakery page builder

= 5.3.7 =
 * Add : WP Media Folder gallery module for Divi page builder
 * Add : WP Media Folder media download module for Divi page builder
 * Add : WP Media Folder PDF embed module for Divi page builder
 * Add : Single media download options: border, icon, margin, padding
 * Fix : Get count the files of a folder

= 5.3.6 =
 * Fix : Conflict css with PDF Embeder plugin
 * Fix : Hide clear queue, stop queue button if not queue running

= 5.3.5 =
 * Fix : Infinite looping of admin-ajax.php calls
 * Fix : Move existing physical media on large site

= 5.3.4 =
 * Add : Compatibility with automatic cloud connection

= 5.3.3 =
 * Fix : Sync and import wrong folder name
 * Fix : Missing message on queue listing

= 5.3.2 =
 * Add : WP Media Folder gallery widget for Elementor page builder
 * Add : WP Media Folder file download widget for Elementor page builder
 * Add : WP Media Folder PDF embed widget for Elementor page builder
 * Add : Add copyright character to settings of rename file
 * Fix : Search folders
 * Fix : Gallery custom link click open two tabs

= 5.3.1 =
 * Fix : Disable option status menu bar by default

= 5.3.0 =
 * Add : Physical folders: transform WordPress media folders into real folders
 * Add : Physical folders: allow filename edition of WordPress media
 * Add : Background file synchronizer for physical media and folders
 * Add : Background file synchronizer for cloud files (Dropbox, Google Drive, OneDrive)
 * Add : Implement server folder synchronization feature in background task
 * Add : Implement server folder import feature in background task
 * Add : Setup background file synchronizer priority to save resources
 * Add : Option to display file synchronization queue in the Wordpress top bar

= 5.2.5 =
 * Add : Option to download media from the media manager using a right click
 * Add : Gallery from folder compatibility with with Gutenberg tabs block
 * Add : Gallery from folder compatibility with with Gutenberg Ultimate Blocks
 * Add : Gallery from folder compatibility with with Gutenberg Kadence Blocks
 * Fix : Export media folders to local drive
 * Fix : Settings help tooltips not shown on mouse hover
 * Fix : Enbed in your content a PDF from Dropbox

= 5.2.4 =
 * Fix : JoomUnited Updater compatible with WordPress 5.5

= 5.2.3 =
 * Fix : Right click on media and folder not work when use Elementor
 * Fix : Open Youtube video on gallery lightbox

= 5.2.2 =
 * Add : Detect and reload the media manager to detect changes in DIVI modules
 * Add : Detect and reload the media manager to detect changes in Elementor content elements
 * Fix : Move file in list view

= 5.2.1 =
 * Fix : Gallery order not correct
 * Fix : Unable to access the dashboard of WP multisite
 * Fix : Open context menu on bottom folder
 * Fix : Wrong media count in folder after using media selection folders

= 5.2.0 =
 * Add : New UX design
 * Add : Import categories from Enhanced Media Library plugin
 * Add : Option to enable or disable folders on right part
 * Add : Filter button to show the files in a folder and its subfolder
 * Add : Remove classic design theme
 * Add : Quick button to display all files without subfolders
 * Add : Improve media sort and filtering
 * Add : Option to search media in its folder and subfolders

= 5.1.4 =
 * Fix : Change default filter to date on Media library
 * Fix : Conflict with FlexSlider gallery of Elementor

= 5.1.3 =
 * Add : Add include children option in gallery from folder shortcode
 * Add : Upload single file and multiple files from media library to s3
 * Fix : Hide environment notification when user click dismiss
 * Fix : Check load pdf embed with elementor
 * Fix : Open lightbox on click cloud image gallery

= 5.1.2 =
 * Fix : Display both title and caption of image on portfolio and slider gallery
 * Fix : PDF embed not working on elementor builder
 * Fix : Add remote private vimeo video

= 5.1.1 =
 * Add : Add an option to search media in a folder and its subfolders
 * Fix : Frontend css not loaded correctly on plugin activation

= 5.1.0 =
 * Add : Import Export WordPress Media library with media
 * Add : Import Export WordPress Media folder structure only
 * Add : Import Export WordPress Media folder selection
 * Add : Import IPTC/metadata on upload, import and synchronization
 * Add : Add a filter to display all media from the media library
 * Add : Create a helper.php for developers and webdesigners
 * Fix : Saved into a cookie to display the same filters if the page is reloaded
 * Fix : Load gallery slider one column on front end
 * Fix : Load PDF embed

= 5.0.1 =
 * Add : PDF embed without the pagination
 * Add : Possibility to connect Google shared drive using a G Suite account

= 5.0.0 =
 * Add : Server folder synchonization: run syncho on file update
 * Add : Server folder synchonization filter by file type
 * Add : Watermark margin unit can be dined in px or %
 * Add : Watermark image opacity option
 * Add : Watermark image margin option
 * Add : Gutenberg block preview images
 * Fix : File importer window style
 * Fix : PDF embed not loaded properly using the classic editor

= 4.9.10 =
 * Add : Google Photos settings ready (related to plugin Addon)
 * Fix : Change style of media tree selection

= 4.9.9 =
 * Fix : Translation sharing issue in some browsers

= 4.9.8 =
 * Fix : Import server folder
 * Fix : WordPress gallery slider lightbox display
 * Fix : Edit inline CSS for WordPress gallery styling

= 4.9.7 =
 * Fix : Import server folder: file not created
 * Fix : Get media count in folders with WPML plugin
 * Fix : Load gallery when switch tabs and slider style

= 4.9.6 =
 * Fix : Remote video cannot be fetched
 * Fix : Masonry gallery not working with WP smush lazyloading

= 4.9.5 =
 * Fix : Auto play on gallery slider theme
 * Fix : Style on for WordPress RC 5.3
 * Fix : Import media feature: size & filetype
 * Fix : Import server folder speed

= 4.9.4 =
 * Fix : Gallery style
 * Fix : Reload attachments after upload
 * Fix : Resize folder tree

= 4.9.3 =
 * Fix : Responsive behaviour for WorDPress default gallery style
 * Fix : FTP synchronization and server media import
 * Fix : Folder cover not applied on folders

= 4.9.2 =
 * Fix : Default gallery settings not applied automatically on creation
 * Fix : Custom link on image gallery
 * Fix : Preview portfolio theme in backend is missing some margin

= 4.9.1 =
 * Fix : Php warning on customize.php page
 * Fix : Add custom link option for gallery in classic editor

= 4.9.0 =
 * Add : Display and copy folder ID with a right click (to call a gallery)
 * Add : New gallery block option: border, radius, margin, shadow
 * Add : Create a gallery from folder in Gutenberg
 * Add : Gallery shortcode generator to include Wordpress gallery everywhere
 * Fix : Replace file

= 4.8.10 =
 * Fix : Gallery lightbox is missing title
 * Fix : Synchronization with server folder

= 4.8.9 =
 * Fix : Load popup corresponding to picture on portfolio
 * Fix : Better way to click on slider arrow gallery theme

= 4.8.8 =
 * Add : Gallery navigation load video and plays it
 * Add : Load video thumbnail sizes and include srcset in galleries
 * Fix : Get media file type
 * Fix : Warning php in subpage of upload.php page
 * Fix : Import FTP and server folder sync

= 4.8.7 =
 * Add : Automatic synchronization for cloud media
 * Fix : Change background color for OneDrive folder

= 4.8.6 =
 * Fix : Wrong folder structure when using WPML plugin
 * Fix : Sync from FTP to WordPress media
 * Fix : Replace png image with transparent background
 * Fix : Get count file with WPML plugin

= 4.8.5 =
 * Fix : Jutranslation url

= 4.8.4 =
 * Fix : JU Updater process
 * Fix : Watermark makes a black background instead of transparent
 * Fix : Quality on .png image replace feature
 * Fix : Get count attachment in folder and exclude trash attachment

= 4.8.3 =
 * Fix : Only load juupdater from admin
 * Fix : Conflict between sync S3 and regenerate thumbnail
 * Fix : Lightbox not working on slider theme

= 4.8.2 =
 * Fix : No gallery options
 * Fix : Wrong file quality used after replacing file

= 4.8.1 =
 * Fix : Enhance requirements tests
 * Fix : Can't edit gallery with elementor plugin

= 4.8.0 =
 * Add : Implement OneDrive Business connection settings with link types
 * Add : Replace Gutenberg cloud blocks by native media library integration
 * Add : Integrate Google Drive media in WordPress media library folder tree
 * Add : Integrate Dropbox media in WordPress media library folder tree
 * Add : Integrate OneDrive & OneDrive Business media in WordPress media library folder tree
 * Add : Run full synchronization on right click
 * Add : Remove data option when uninstall the plugin
 * Fix : Get count file in folder with WPML plugin
 * Fix : Conflict with prettyPhoto plugin

= 4.7.12 =
 * Fix : PDF embed that contains hyperlink
 * Fix : Remove preview image when reload attachment
 * Fix : Replace PNG image
 * Fix : Remove watermark from images

= 4.7.11 =
 * Fix : Check version requirements

= 4.7.10 =
 * Fix : Save plugin settings
 * Fix : Load gallery on frontend
 * Fix : Gallery slider auto play feature
 * Fix : Watermark does not apply on original size images
 * Fix : Snackbar always displayed when deleting a folder with its media

= 4.7.9 =
 * Fix : Security patch for file replace feature

= 4.7.8 =
 * Fix : Autoplay slider gallery theme
 * Fix : Add media folder block category
 * Fix : Remove folder along with its media

= 4.7.7 =
 * Add : Addon, Amazon S3 support: copy and load media from Amazon S3
 * Add : Addon, Offload your media on Amazon S3
 * Add : Addon Amazon S3: automatic and manual synchronization
 * Add : Addon, retrieve media links and files from Amazon S3
 * Add : Addon, create and manage S3 buckets

= 4.7.6 =
 * Add : Embed PDF Gutenberg block
 * Add : Embed file with button style in Gutenberg
 * Fix : Save filters to cookie to reload filters among navigation

= 4.7.5 =
 * Fix : WPMF Addon requirement version

= 4.7.4 =
 * Add : WordPress gallery Gutenberg block
 * Add : WordPress gallery Addon Gutenberg block
 * Add : Possibility to edit galleries from Gutenberg
 * Add : Add images transition on lightbox
 * Add : Use masonry to display gallery on Gutenberg admin side

= 4.7.3 =
 * Add : Requirement to check if the addon version fit the main plugin version
 * Add : Option to display caption on lightbox
 * Fix : JUUpdater login enhancement

= 4.7.2 =
 * Fix : Gallery image size loaded is not correct
 * Fix : Replace PDF file by an image thumbnail

= 4.7.1 =
 * Fix : Conflict with editor style
 * Fix : Upload a remote Youtube video
 * Fix : Date filter not displayed on ImageRecycle page
 * Fix : Update lightbox size of single image
 * Fix : Conflict with the Jetpack image lazy loading

= 4.7.0 =
 * Add : New settings UX and design
 * Add : Possibility to search in plugin menus and settings
 * Add : Plugin installer with quick configuration
 * Add : Environment checker on install (PHP Version, PHP Extensions, Apache Modules)
 * Add : System Check menu to notify of server configuration problems after install
 * Add : Server testing before plugin activation to avoid all fatal errors

= 4.6.0 =
 * Add : Exclude some folder from the Watermark process
 * Add : Compatibility with Gutenberg editor
 * Fix : Import FTP & sync media

= 4.5.9 =
 * Fix : Delete folder
 * Fix : Import Nextgen gallery
 * Fix : Save theme and plugin file
 * Fix : Import category button

= 4.5.8 =
 * Add : Add actions and filters for developers

= 4.5.7 =
 * Fix : Deleting folder with its media
 * Fix : Duplicate attachment
 * Fix : Load google font on IE browser

= 4.5.6 =
 * Fix : Move media with WPML plugin (compatibility)
 * Fix : Upload the files when enable media access by user
 * Fix : Login to JUupdater for plugin update

= 4.5.5 =
 * Fix : Duplicate file when import and sync

= 4.5.4 =
 * Fix : Enhance code readability and performance

= 4.5.3 =
 * Add : Enable/disable remote video feature
 * Add : Option to enable/disable format media title
 * Add : Shortcode generator for Gallery Addon: Load images by gallery, tag and all options
 * Fix : Remove a folder with its media
 * Fix : Count files in folder tree

= 4.5.2 =
 * Fix : Notification display success on video upload
 * Fix : Display .svg file in content
 * Fix : Conflict with elementor, clientside plugin
 * Fix : Preview image when uploading

= 4.5.1 =
 * Fix : Sync from FTP to media library
 * Fix : Remove the right click edit button on the popup view
 * Fix : Compability with WPML plugin
 * Fix : Folder not displayed after reload attachment in modal view
 * Fix : Change lists plugin updater

= 4.5.0 =
 * Add : Handle animated GIF in the media manager with option to load it in content
 * Add : Vimeo video and Dailymotion video support in the media manager
 * Add : Display the folder name on the upload view
 * Add : Regenerate images thumbnail from the latest uploaded
 * Add : Watermark: Image scaling and image margins
 * Fix : Gallery conflict with lazy loading of WP Speed of Light plugin
 * Fix : Conflict: Saving PHP file themes not working

= 4.4.3 =
 * Fix : Conflict with WP Smush, Enhanced Media Library plugin
 * Fix : Create gallery from folder
 * Fix : Filters hidden

= 4.4.2 =
 * Add : Settings for the new gallery plugin ADDON
 * Add : Reload button to handle some page builder content refresh
 * Fix : Open context menu when attachment is empty
 * Fix : Drag media to folder tree in list view

= 4.4.1 =
 * Fix : Media window is not loaded (modal)
 * Fix : Align controls in settings, improve layout in settings
 * Fix : Change settings text, add help text

= 4.4.0 =
 * Add : New admin design, Google Drive grid like
 * Add : Implement right click manu and actions for folders and media
 * Add : Store Open/Close folder status (folder tree)
 * Add : Search bar on top of the folder tree to filter folder only
 * Add : Custom ordering inplementation for folders and media (global, not by user)
 * Add : Fallback to legacy design accessible though a new setting
 * Add : Move folders from folder tree
 * Add : Rename folders from folder tree (double click)

= 4.3.6 =
 * Fix : rename file when upload
 * Fix : import & sync
 * Fix : move file

= 4.3.5 =
 * Fix : Replace file failed in some case
 * Fix : Conflict with Envira Gallery, Easing Slider plugins
 * Fix : Sort image with auto update gallery

= 4.3.4 =
 * Fix : Auto update image to gallery
 * Fix : Import folders including special characters in name
 * Fix : Duplicate media, replace, media folder selection button with next and prev media items

= 4.3.3 =
 * Fix : Apply status filter
 * Fix : Conflict with post filters

= 4.3.2 =
 * Fix : Move multiple files in list view
 * Fix : Media Folder in modal view not loaded properly
 * Fix : Right to left style

= 4.3.1 =
 * Fix : Import and Synchronization feature folder selection
 * Fix : Translation tool (JU Translation)
 * Fix : Conflict with WP Smush, ImageRecycle, Master Slider plugin
 * Fix : JS Error on folder tree resizing

= 4.3.0 =
 * Add : Full code rewriting to enhance plugin performance
 * Add : Implement progressive loading in every folder from post edition media lightbox
 * Add : New resizable folder tree
 * Add : Rewrite media filtering system based on a dropdown lists

= 4.2.8 =
 * Fix : Create folder by user/role

= 4.2.7 =
 * Fix : Prohibit direct script loading
 * Fix : Remove some unused code
 * Fix : Change filename for some class file

= 4.2.6 =
 * Fix : WPMF gallery conflict with DIVI builder gallery
 * Fix : Encoding issue when embeded a pdf

= 4.2.5 =
 * Fix : Overflow width in the plugin settings
 * Fix : Update dimensions when replacing an image

= 4.2.4 =
 * Fix : Escaping of already secured datas
 * Fix : Update compatibility with old addon versions

= 4.2.3 =
 * Add : Microsoft OneDrive settings and comaptibility (addon)
 * Fix : Conflict with Enhanced Media Library plugin
 * Fix : File replacement .svg and .html formats
 * Fix : Upload a remote video

= 4.2.2 =
 * Fix : XSS issue when hover image
 * Fix : Add video in lightbox
 * Fix : Check user permissions for AJAX requests

= 4.2.1 =
 * Fix : Update the updater for WordPress 4.8

= 4.2.0 =
 * Add : Possibility to add a remote Youtube video among other media
 * Add : Apply image watermark to the library and on media upload
 * Add : Option to remove additional characters in the rename feature
 * Add : User media access restriction activated: Select a media root folder

= 4.1.4 =
 * Fix : Upload slow down when WPML plugin is active

= 4.1.3 =
 * Fix : Media automatic rename
 * Fix : Conflict with Enhanced Media Library plugin
 * Fix : Query attachment
 * Fix : Import from server folders

= 4.1.2 =
 * Fix : Display all files in the root folder in list view
 * Fix : Error of synchronization
 * Fix : Missing translation strings
 * Fix : Wrong path when site install is in a subdirectory

= 4.1.1 =
 * Fix : Media not shown when not affected to a folder
 * Fix : PHP warning in grid view

= 4.1.0 =
 * Add : 2 ways synchronization: From server to Media Folder and From Media Folder to server
 * Add : Apply multiple folders per media
 * Add : Batch apply multiple folders per media
 * Add : Avanced rename on upload: remove/add special characters, control capitalization

= 4.0.2 =
 * Fix : Use default en_US language
 * Fix : Allow saving an empty translation override file

= 4.0.1 =
 * Fix : Folder tree style fix whith long titles
 * Fix : Hover effect with very small image height or long titles

= 4.0.0 =
 * Add : New material design interface
 * Add : Notification system on media actions: upload, remove, rename, move, replace, apply filter
 * Add : Undo last action from notification when: delete folder, edit folder, move folder, move file, filter
 * Add : Load medium image size on mouse hover as an option
 * Add : New media replace tool with intant refresh and thumbnail generation
 * Add : Extensible folder tree using CSS
 * Add : All settings now use material design

= 3.8.7 =
 * Fix : SVG format error on regenerate thumbnail
 * Fix : Style right to left
 * Fix : FTP import & sync not work when rename the wp-content folder

= 3.8.6 =
 * Fix : Media rename don't apply
 * Fix : Replace PNG file keep transparency background
 * Fix : Auto insert image in folder feature

= 3.8.5 =
 * Fix : SQL get count post
 * Fix : Undefined function get_userdata error

= 3.8.4 =
 * Fix : Import meta size and file type on large image
 * Fix : Some folder not displayed in tree folder
 * Fix : Duplicate folder when double click on the folder tree

= 3.8.3 =
 * Fix : Compatibility with WordPress theme customizer
 * Fix : Open PDF file new window

= 3.8.2 =
 * Fix : User permissions not correctly checked

= 3.8.1 =
 * Add : Add cloud configuration documentation link in settings
 * Fix : JoomUnited updater compatible with new WordPress 4.6 shiny updates

= 3.8.0 =
 * Add : Embed pdf from media library option
 * Add : Add settings to connect Google Drive and Dropbox (for the addon)
 * Fix : Speed optimization
 * Fix : Duplicate replace button when saving parameters

= 3.7.0 =
 * Add : ImageRecycle Image compression integration in parameters
 * Add : Lightbox on single image, as an option
 * Add : Display the direct number files in a folder
 * Fix : Conflict with CFS image plugin (Custom Field Suite)

= 3.6.0 =
 * Add : Option to disable by default the JS called on frontend (for frontend page builders)
 * Add : Whole code optimization regarding plugin performance
 * Add : SQL query optimization regarding plugin performance
 * Add : Sanitize all elements prints on frontend (XSS)
 * Add : Update folder and tree design
 * Fix : Drag and drop when edit multiple selection
 * Fix : Button insert link not working on some specific configuration
 * Fix : Masonry gallery display on small screen size
 * Fix : Duplicate folder when using an access restriction by user role

= 3.5.6 =
 * Fix : Conflict with Autoptimize plugin
 * Fix : Display folder tree in custom media frame
 * Fix : Load script in page table on multiple site

= 3.5.5 =
 * Fix : Clean CSS & JS on frontend
 * Fix : CSS layout when filter and ordering feature is disabled
 * Fix : Display folder per user
 * Fix : Server folder import with uppercase file extension

= 3.5.4 =
 * Add : Setting Animation for slider gallery
 * Fix : Compatiblility with Cornerstone plugin
 * Fix : Install / blank white screen

= 3.5.3 =
 * Add : Load jQuery on frontend to be conpatible with public side edition plugins
 * Add : Compatiblity with WP Sweep plugin
 * Add : Make WPMF work with all plugins that use Media Library in front-end

= 3.5.2 =
 * Add : Make media folder work with svg images
 * Fix : Display limitation of post and folder by user role
 * Fix : Remove filter wp_generate_attachment_metadata when regenerate thumbnail

= 3.5.1 =
 * Fix : fix FTP Import doesn't show directories

= 3.5.0 =
 * Add : Media access: limit access by user role (a folder per user role)
 * Add : Possibility to duplicate a media
 * Add : Possibility drag'n drop a media in the current folder from desktop
 * Add : Possibility to replace all file types, not just images (zip, pdf...)
 * Add : Compatibility/work with with ACF
 * Add : Compatibility/work with Beaver builder
 * Add : Compatibility/work with Site Origine page builder
 * Add : Compatibility/work with Themify builder
 * Add : Compatibility/work with Live composer page builder
 * Fix : fix sync media and import ftp with file name has special characters
 * Fix : compatibility with Beaver Builder , Live composer page builder ...
 * Fix : replace other file than image

= 3.4.2 =
 * Fix : Fix image conflict style with YoImages plugin
 * Fix : unbind click when drag folder
 * Fix : update langguages

= 3.4.1 =
 * Fix : Fix image replacer

= 3.4.0 =
 * Add : Regenerate thumbnails tool in parameters
 * Add : Add process bar when use FTP import, allow massive import
 * Add : Sync external media
 * Add : Sort images by title and date in gallery
 * Add : DIVI builder compatibility
 * Fix : Remove css background for image replacement

= 3.3.6 =
 * Fix : FTP import
 * Fix : Folder stay opened when called from multiple media views

= 3.3.5 =
 * Fix : Update file size when file replace is complete
 * Fix : Portfolio theme JS wrong calculation when resizing the screen

= 3.3.4 =
 * Fix : conflict with RokSprocket plugin
 * Fix : conflict with WP Table Manager plugin

= 3.3.3 =
 * Fix : fix error when active plugin on multisite
 * Fix : fix conflict with Gleam theme
 * Fix : fix conflict with retina 2x plugin

= 3.3.1 =
 * Fix : Update filter layout to fit new WP 4.4 admin CSS
 * Fix : Portfolio gallery style is not loading proper thumbnail size
 * Fix : Clean CSS & JS from portfolio gallery theme
 * Fix : Update Material-Design-Iconic-Font
 * Fix : Use current_user_can to check user rights for importer from FTP

= 3.3.0 =
 * Add : Rename file on upload with a pattern
 * Add : Remove a folder with all it's media inside (as an option)
 * Fix : File insertion, remove file on clicking on the cross
 * Fix : Gallery lightbox going to top of the screen

= 3.2.0 =
 * Add : Search option to search in current folder or in the whole media library
 * Add : Possibility to setup an image as folder cover
 * Fix : .pot laguage file for translators

= 3.1.0 =
 * Fix : Single file insertion design

= 3.0.7 =
 * Fix : AJAX automatic reload
 * Fix : Get url lightbox not work
 * Fix : Register taxonomy in back-end and front-end

= 3.0.6 =
 * Add : Include the automatic updater

= 3.0.5 =
 * Add : New file type in import tool
 * Add : Defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
 * Fix : Remove file github=checked.php
 * Fix : Warning and get role
 * Fix : Change general settings title

= 3.0.4 =
 * Add : New file type in import tool
 * Add : Search attachment on all folders function
 * Fix : Same variable name
 * Fix : Optimize code when active plugin

= 3.0.3 =
 * Fix : duplicate #jao
 * Fix : js conflict with wp-table-manager plugin

= 3.0.2 =
 * Fix : .js error when adding media into post

= 3.0.1 =
 * Add : WordPress 4.3 compatibility
 * Add : Compatibility with plugin with WPML plugin
 * Fix : Slider @ single column don't load the good image size
 * Fix : Image disappear when using the bulk select
 * Fix : Upload file to folder in list view
 * Fix : Check page when using move_file

= 3.0.0 =
 * Add : Import media and folder structure from folder/sub-folder from your server
 * Add : Style settings in 4 tabs
 * Fix : Image size not selected properly in masonry theme
 * Fix : Single Jquery load
 * Fix : Style gallery conflict with WPML plugin
 * Fix : Set 'wpmf-category' is default

= 2.4.1 =
 * Fix : Error script and performance
 * Fix : Auto insert gallery from folder
 * Fix : Update title when replace image
 * Fix : Auto insert gallery from folder
 * Fix : Style in screen ipad
 * Fix : Import nextgen gallery

= 2.4.0 =
 * Add : Possibility to override a media with another one (replace media)
 * Fix : Move a parent folder into one of its subfolders
 * Fix : Change name $_SESSION['child'] to $_SESSION['wpmf_child']
 * Fix : Conflict style with Advanced Custom Fields plugin

= 2.3.0 =
 * Add : Possibility to drag'n drop media in left column folder tree
 * Fix : Style broken in right to left language
 * Fix : Enqueue style gallery when the gallery is not empty
 * Fix : Change image on hover
 * Fix : Error in the french file

= 2.2.0 =
 * Add : Media filtering by image dimension
 * Add : Filtering by media type (zip, image, pdf,...)
 * Add : Media filtering by media weight
 * Add : Define custom weight and dimension to be applied in media filtering
 * Add : Small and large view of media
 * Add : Sorting folders by name and ID
 * Add : Sorting media by date
 * Add : Sorting media by title
 * Add : Sorting media by size
 * Add : Sorting media by file type
 * Add : Save user sorting and ordering using cookies
 * Add : Possibility to disable the feature
 * Add : Spanish and German languages

= 2.1.0 =
 * Add : Localization standard files (English and french included)

= 2.0.0 =
 * Add : Own media display restriction
 * Add : Admin option to filter own media with session
 * Fix : Firefox display
 * Fix : Default gallery theme broken in some themes
 * Fix : Alert display when create same folder with same name

= 1.3.1 =
 * Add : Use backbone js to create progress bar when upload attachment
 * Fix : Style conflict with enhanced media library pro
 * Fix : Error : images after upload vanished
 * Fix : JS conflict MailPoet Plugin
 * Fix : Reset query when delete folder
 * Fix : Support right to left language
 * Fix : Use $wpdb->prefix.'table_name' instead use wp_ prefix
 * Fix : Sanitize sql function
 * Fix : Slider theme disappear when select size = 'large' or 'fullsize'

= 1.3.0 =
 * Add : NextGEN gallery importer
 * Add : Change config text and add NextGEN sync button

= 1.2.1 =
 * Add : Possibility to disable gallery feature
 * Add : Use svg icon for button next and prev
 * Fix : Theme conflict WP Latest Posts plugin
 * Fix : Random order selected by default
 * Fix : Custom link in gallery broken
 * Fix : Custom _blank link in portfolio gallery
 * Fix : When lightbox open , double click to load next/previous image in portfolio theme
 * Fix : Random order is broken when active Advanced Custom Fields plugin
 * Fix : Auto insert image from folder in Page

= 1.2.0 =
 * Add : Gallery function: masonry
 * Add : Gallery function: portfolio
 * Add : Gallery function: slider
 * Add : Override default WordPress gallery function with new parameters and lightbox
 * Add : Parameter view for custom image size choice
 * Add : Parameter for gallery display

= 1.1.3 =
 * Fix : WordPress 4.2 compatibility, in some case only folders are loaded, not images

= 1.1.2 =
 * Fix : Progress bar disappear on image upload
 * Fix : Date filter disappear in the media popup from an article

= 1.1.1 =
 * Add : JS and CSS compatibility with theme builder

= 1.1.0 =
 * Add : Folder tree on left part

= 1.0.3 to 1.0.4 =
 * Fix : JS error and style

= 1.0.2 =
 * Add : Custom taxonomy for folder
 * Add : Import post into new categories
 * Fix : JS error on post page which are not articles or posts or pages

= 1.0.1 =
 * Fix : Fix backend display, the folder are going over media parameters

= 1.0.0 =
 * Add : Initial release version 

