<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
use Joomunited\WPMediaFolder\WpmfHelper;

/**
 * Class WpmfDisplayGallery
 * This class that holds most of the gallery functionality for Media Folder.
 */
class WpmfDisplayGallery
{

    /**
     * Wpmf_Display_Gallery constructor.
     */
    public function __construct()
    {
        add_action('wp_enqueue_media', array($this, 'galleryEnqueueAdminScripts'));
        add_action('wp_enqueue_scripts', array($this, 'galleryScripts'));
        add_action('enqueue_block_editor_assets', array($this, 'addEditorAssets'));
        add_shortcode('wpmf_gallery', array($this, 'galleryShortcode'));
        add_filter('post_gallery', array($this, 'galleryDefaultShortcode'), 11, 3);
        add_action('print_media_templates', array($this, 'galleryPrintMediaTemplates'));
        add_filter('attachment_fields_to_edit', array($this, 'galleryAttachmentFieldsToEdit'), 10, 2);
        add_filter('attachment_fields_to_save', array($this, 'galleryAttachmentFieldsToSave'), 10, 2);
        add_filter('widget_media_gallery_instance_schema', array($this, 'mediaGalleryInstanceSchema'), 10, 2);
        add_filter('jetpack_lazy_images_new_attributes', array($this, 'jetpackLazyImagesNewAttributes'), 99, 1);
        add_action('wp_ajax_gallery_block_update_image_infos', array($this, 'galleryBlockUpdateImageInfos'));
        add_action('wp_ajax_gallery_block_load_image_infos', array($this, 'galleryBlockLoadImageInfos'));
        add_action('wp_ajax_wpmf_gallery_from_folder', array($this, 'getImagesFromFolder'));
        if (defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '3.5', '<')) {
            add_action('elementor/widgets/widgets_registered', array($this, 'loadElementorWidget'));
        } else {
            add_action('elementor/widgets/register', array($this, 'loadElementorWidget'));
        }
        add_action('wp_ajax_wpmf_divi_load_gallery_html', array($this, 'loadGalleryHtml'));
    }

    /**
     * Load gallery html
     *
     * @return void
     */
    public function loadGalleryHtml()
    {
        if (empty($_REQUEST['et_admin_load_nonce'])
            || !wp_verify_nonce($_REQUEST['et_admin_load_nonce'], 'et_admin_load_nonce')) {
            wp_send_json(array('status' => false, 'html' => '<p>'. esc_html__('Load failed!', 'wpmf') .'</p>'));
        }
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        if (empty($data['items']) && empty($data['gallery_folder_id'])) {
            $html = '<div class="wpmf-divi-container">
            <div id="divi-gallery-placeholder" class="divi-gallery-placeholder">
                        <span class="wpmf-divi-message">
                            ' . esc_html__('Please add some images to the gallery to activate the preview', 'wpmf') . '
                        </span>
            </div>
          </div>';
            wp_send_json(array('status' => false, 'html' => $html));
        }

        $html = do_shortcode('[wpmf_gallery is_divi="1" include="'. esc_attr($data['items']) .'" display="' . esc_attr($data['display']) . '" columns="' . esc_attr($data['columns']) . '" size="' . esc_attr($data['size']) . '" targetsize="' . esc_attr($data['targetsize']) . '" link="' . esc_attr($data['link']) . '" wpmf_orderby="' . esc_attr($data['orderby']) . '" wpmf_order="' . esc_attr($data['order']) . '" gutterwidth="' . esc_attr($data['gutterwidth']) . '" border_width="' . esc_attr($data['border_width']) . '" border_style="' . esc_attr($data['border_style']) . '" border_color="' . esc_attr($data['border_color']) . '" img_shadow="' . esc_attr($data['img_shadow']) . '" img_border_radius="' . esc_attr($data['border_radius']) . '" wpmf_autoinsert="' . esc_attr($data['wpmf_autoinsert']) . '" wpmf_folder_id="' . esc_attr($data['wpmf_folder_id']) . '"]');
        wp_send_json(array('status' => true, 'html' => $html));
    }

    /**
     * Load elementor widget
     *
     * @return void
     */
    public function loadElementorWidget()
    {
        require_once(WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/elementor-widgets/class-gallery-elementor-widget.php');
        if (defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '3.5', '<')) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \WpmfGalleryElementorWidget());
        } else {
            \Elementor\Plugin::instance()->widgets_manager->register(new \WpmfGalleryElementorWidget());
        }
    }

    /**
     * Override the attributes on the image
     *
     * @param array $attributes Image attributes
     *
     * @return mixed
     */
    public function jetpackLazyImagesNewAttributes($attributes)
    {
        if (isset($attributes) && isset($attributes['data-type']) && $attributes['data-type'] === 'wpmfgalleryimg') {
            $attributes['src'] = $attributes['data-lazy-src'];
            unset($attributes['data-lazy-src']);
        }

        return $attributes;
    }

    /**
     * Compatible with elementor plugin
     *
     * @param array $schema Params of gallery
     *
     * @return mixed
     */
    public function mediaGalleryInstanceSchema($schema)
    {
        $schema['display'] = array(
            'type' => 'string',
            'enum' => array(
                'default',
                'masonry',
                'portfolio',
                'slider',
            ),
            'default' => 'default'
        );

        $schema['wpmf_autoinsert'] = array(
            'type' => 'string',
            'enum' => array(0, 1),
            'default' => 0
        );

        $schema['wpmf_orderby'] = array(
            'type' => 'string',
            'enum' => array(
                'post__in',
                'rand',
                'title',
                'date'
            ),
            'default' => 'post__in'
        );

        $schema['wpmf_order'] = array(
            'type' => 'string',
            'enum' => array(
                'ASC',
                'DESC'
            ),
            'default' => 'ASC'
        );

        return $schema;
    }

    /**
     * Includes styles and some scripts
     *
     * @return void
     */
    public function galleryScripts()
    {
        $is_builder = (function_exists('fusion_is_preview_frame') && fusion_is_preview_frame()) || (function_exists('fusion_is_builder_frame') && fusion_is_builder_frame());
        if (!$is_builder) {
            wp_register_style(
                'wpmf-gallery-popup-style',
                plugins_url('/assets/css/display-gallery/magnific-popup.css', dirname(__FILE__)),
                array(),
                '0.9.9'
            );

            wp_register_style(
                'wpmf-gallery-style',
                plugins_url('/assets/css/display-gallery/style-display-gallery.css', dirname(__FILE__)),
                array(),
                WPMF_VERSION
            );

            wp_register_script(
                'wordpresscanvas-imagesloaded',
                plugins_url('/assets/js/display-gallery/imagesloaded.pkgd.min.js', dirname(__FILE__)),
                array('jquery'),
                '3.1.5',
                true
            );

            wp_register_script(
                'wpmf-gallery-popup',
                plugins_url('/assets/js/display-gallery/jquery.magnific-popup.min.js', dirname(__FILE__)),
                array('jquery'),
                '0.9.9',
                true
            );

            wp_register_style(
                'wpmf-slick-style',
                WPMF_PLUGIN_URL . 'assets/js/slick/slick.css',
                array(),
                WPMF_VERSION
            );

            wp_register_style(
                'wpmf-slick-theme-style',
                WPMF_PLUGIN_URL . 'assets/js/slick/slick-theme.css',
                array(),
                WPMF_VERSION
            );

            wp_register_script(
                'wpmf-slick-script',
                WPMF_PLUGIN_URL . 'assets/js/slick/slick.min.js',
                array('jquery'),
                WPMF_VERSION,
                true
            );

            wp_register_script(
                'wpmf-gallery',
                plugins_url('assets/js/display-gallery/site_gallery.js', dirname(__FILE__)),
                array('jquery', 'wordpresscanvas-imagesloaded'),
                WPMF_VERSION,
                true
            );

            wp_localize_script(
                'wpmf-gallery',
                'wpmfggr',
                $this->localizeScript()
            );
        }
    }

    /**
     * Enqueue script styles by editor
     *
     * @param string $editor Editor name
     *
     * @return void
     */
    public function enqueueScript($editor = '')
    {
        if ($editor === 'divi' || $editor === 'avada') {
            wp_enqueue_style('wpmf-slick-style');
            wp_enqueue_style('wpmf-slick-theme-style');
            wp_enqueue_script('wpmf-slick-script');
            wp_enqueue_style('wpmf-gallery-style');
            wp_enqueue_script('wordpresscanvas-imagesloaded');
            wp_enqueue_script('jquery-masonry');
        }
    }

    /**
     * Localize a script.
     * Works only if the script has already been added.
     *
     * @return array
     */
    public function localizeScript()
    {
        $option_usegellery_lightbox = get_option('wpmf_usegellery_lightbox');
        $option_current_theme = get_option('current_theme');
        $slider_animation = get_option('wpmf_slider_animation');
        $smush_settings = get_option('wp-smush-settings');
        return array(
            'wpmf_lightbox_gallery' => (int)$option_usegellery_lightbox,
            'wpmf_current_theme' => $option_current_theme,
            'slider_animation' => $slider_animation,
            'smush_lazyload' => (is_plugin_active('wp-smushit/wp-smush.php') && isset($smush_settings) && isset($smush_settings['lazy_load']) && $smush_settings['lazy_load']) ? true : false,
            'img_url' => WPMF_PLUGIN_URL . 'assets/images/',
        );
    }

    /**
     * Includes some scripts
     *
     * @return void
     */
    public function galleryEnqueueAdminScripts()
    {
        global $pagenow;
        if ($pagenow !== 'upload.php') {
            wp_enqueue_script(
                'wpmf-gallery-admin-js',
                plugins_url('assets/js/display-gallery/admin_gallery.js', dirname(__FILE__)),
                array('jquery'),
                WPMF_VERSION,
                true
            );
        }
    }

    /**
     * Render gallery by shortcode
     *
     * @param array $attr All attribute in shortcode
     *
     * @return string
     */
    public function gallery($attr)
    {
        if (!is_array($attr)) {
            return '';
        }

        wp_enqueue_style(
            'wpmf-material-icon',
            'https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined'
        );
        $post = get_post();
        static $instance = 0;
        $instance++;
        $gallery_configs = wpmfGetOption('gallery_settings');
        $caption_lightbox = wpmfGetOption('caption_lightbox_gallery');
        if (isset($gallery_configs['theme']['slider_theme']['auto_animation'])) {
            $autoplay = $gallery_configs['theme']['slider_theme']['auto_animation'];
        } else {
            $autoplay = 0;
        }

        if (isset($gallery_configs['theme']['slider_theme']['duration'])) {
            $duration = $gallery_configs['theme']['slider_theme']['duration'];
        } else {
            $duration = 4000;
        }

        if (empty($attr['crop_image'])) {
            $attr['crop_image'] = 1;
        }

        $attrs = shortcode_atts(array(
            'order' => 'ASC',
            'orderby' => 'menu_order ID',
            'id' => $post ? $post->ID : 0,
            'aspect_ratio' => 'default',
            'columns' => 3,
            'gutterwidth' => 5,
            'link' => 'post',
            'size' => 'thumbnail',
            'targetsize' => 'large',
            'display' => 'default',
            'wpmf_orderby' => 'post__in',
            'wpmf_order' => 'ASC',
            'customlink' => 0,
            'bottomspace' => 'default',
            'hidecontrols' => 'false',
            'class' => '',
            'include' => '',
            'exclude' => '',
            'wpmf_folder_id' => array(),
            'wpmf_autoinsert' => '',
            'include_children' => 0,
            'img_border_radius' => 0,
            'border_width' => 0,
            'border_color' => 'transparent',
            'border_style' => 'solid',
            'img_shadow' => '',
            'autoplay' => $autoplay,
            'duration' => $duration,
            'is_divi' => 0,
            'limit' => -1,
            'crop_image' => 1,
            'align' => 'none'
        ), $attr, 'gallery');

        foreach ($attrs as $attr_key => $attr_value) {
            ${$attr_key} = $attr_value;
        }

        if (!is_array($wpmf_folder_id)) {
            $wpmf_folder_id = explode(',', $wpmf_folder_id);
        }

        foreach ($wpmf_folder_id as $folderIndex => $folder_id) {
            if ((int)$folder_id === 0) {
                unset($wpmf_folder_id[$folderIndex]);
            }
        }

        $custom_class = trim($class);
        if (isset($wpmf_autoinsert) && ((int)$wpmf_autoinsert === 1 || $wpmf_autoinsert === 'on') && !empty($wpmf_folder_id)) {
            if ($wpmf_orderby === 'post__in') {
                $wpmf_orderby = 'meta_value_num title';
                $wpmf_order = 'ASC';
                $meta_key = 'wpmf_order';
            }

            $args = array(
                'posts_per_page' => $limit,
                'post_status' => 'any',
                'post_type' => 'attachment',
                'post_mime_type' => array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/x-icon', 'image/webp', 'image/avif', 'application/pdf'),
                'order' => $wpmf_order,
                'orderby' => $wpmf_orderby,
                'wpmf_gallery' => 1
            );

            if (!empty($meta_key)) {
                $args['meta_key'] = $meta_key;
            }

            $args['tax_query'] = array(
                array(
                    'taxonomy' => WPMF_TAXO,
                    'field' => 'term_id',
                    'terms' => $wpmf_folder_id,
                    'operator' => 'IN',
                    'include_children' => ((int) $include_children === 1)
                )
            );

            /**
             * Filter gallery query argument to get images.
             *
             * @param array Gallery query arguments
             *
             * @return array
             */
            $args     = apply_filters('wpmf_gallery_query_args', $args);
            $query = new WP_Query($args);
            $_attachments = $query->get_posts();
            $gallery_items = array();
            
            $last_folder_parent = $this->getFolderParent($wpmf_folder_id[0]);
            foreach ($_attachments as $key => $val) {
                if ($last_folder_parent->slug !== 'nextcloud' || !strpos($val->post_mime_type, 'avif')) { // hide avif in nextcloud folder
                    $gallery_items[$val->ID] = $_attachments[$key];
                }
            }
        } else {
            $args = array(
                'post_status' => 'inherit',
                'post_type' => 'attachment',
                'post_mime_type' => array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/x-icon', 'image/webp',  'image/avif', 'application/pdf'),
                'order' => $wpmf_order,
                'orderby' => $wpmf_orderby,
                'wpmf_gallery' => 1
            );

            if (!empty($meta_key)) {
                $args['meta_key'] = $meta_key;
            }
            //var_dump($args);die;
            if (!empty($include)) {
                $args['include'] = $include;
                $_attachments = get_posts($args);
                $gallery_items = array();
                foreach ($_attachments as $key => $val) {
                    $gallery_items[$val->ID] = $_attachments[$key];
                }
            } elseif (!empty($exclude)) {
                $args['exclude'] = $exclude;
                $args['post_parent'] = (int) $id;
                $gallery_items = get_children($args);
            } else {
                $args['post_parent'] = (int) $id;
                $gallery_items = get_children($args);
            }
        }

        if (is_feed()) {
            $output = "\n";
            foreach ($gallery_items as $att_id => $attachment) {
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            }

            return $output;
        }

        $columns = intval($columns);
        $selector = 'gallery-' . $instance;
        $size_class = sanitize_html_class($size);

        /**
         * Filter to enable/disable download image on gallery
         *
         * @param boolean Enable/disable download image
         *
         * @return boolean
         */
        $enable_download = apply_filters('wpmf_gallery_enable_download', false);
        $class = array();
        $class[] = 'wpmf-gallery';

        if ($link === 'file' || $link === 'none' || $link === 'post') {
            $customlink = false;
        } else {
            $customlink = true;
        }

        if (!empty($custom_class)) {
            $class[] = esc_attr($custom_class);
        }

        if (!$customlink) {
            $class[] = 'gallery-link-' . $link;
        }

        if ($link === 'file') {
            wp_enqueue_script('wpmf-gallery-popup');
        }

        wp_enqueue_script('jquery');
        wp_enqueue_style('wpmf-gallery-style');
        wp_enqueue_style('wpmf-gallery-popup-style');

        switch ($display) {
            case 'slider':
                require(WP_MEDIA_FOLDER_PLUGIN_DIR . 'themes-gallery/gallery-slider.php');
                break;

            case 'masonry':
                require(WP_MEDIA_FOLDER_PLUGIN_DIR . 'themes-gallery/gallery-mansory.php');
                break;

            case 'portfolio':
                require(WP_MEDIA_FOLDER_PLUGIN_DIR . 'themes-gallery/gallery-portfolio.php');
                break;

            default:
                require(WP_MEDIA_FOLDER_PLUGIN_DIR . 'themes-gallery/gallery-default.php');
                break;
        }

        return $output;
    }

    /**
     * Get vimeo video ID from URL
     *
     * @param string $url URl of video
     *
     * @return mixed|string
     */
    public function getVimeoVideoIdFromUrl($url = '')
    {
        $regs = array();
        $id   = '';
        $vimeo_pattern = '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im';
        if (preg_match($vimeo_pattern, $url, $regs)) {
            $id = $regs[3];
        }

        return $id;
    }

    /**
     * Display gallery on frontend
     *
     * @param string $blank The current output
     * @param array  $attr  Attributes of the gallery shortcode.
     *
     * @return string $output The gallery output. Default empty.
     */
    public function galleryDefaultShortcode($blank, $attr)
    {
        $output = $this->gallery($attr);
        return $output;
    }

    /**
     * Display gallery from folder on frontend
     *
     * @param array $attr Attributes of the gallery shortcode.
     *
     * @return string $output   The gallery output. Default empty.
     */
    public function galleryShortcode($attr)
    {
        $output = $this->gallery($attr);
        return $output;
    }

    /**
     * Get attachment download link
     *
     * @param integer $attachment_id Attachment ID
     *
     * @return false|string|string[]
     */
    public function wpmfGalleryGetDownloadLink($attachment_id)
    {
        $drive_type = get_post_meta($attachment_id, 'wpmf_drive_type', true);
        if (empty($drive_type)) {
            $download_link = wp_get_attachment_image_url($attachment_id, 'full');
            $type = 'local';
        } else {
            $drive_id = get_post_meta($attachment_id, 'wpmf_drive_id', true);
            switch ($drive_type) {
                case 'onedrive':
                    $download_link = admin_url('admin-ajax.php') . '?action=wpmf_onedrive_download&id=' . urlencode($drive_id) . '&link=true&dl=1';
                    break;

                case 'onedrive_business':
                    $download_link = admin_url('admin-ajax.php') . '?action=wpmf_onedrive_business_download&id=' . urlencode($drive_id) . '&link=true&dl=1';
                    break;

                case 'google_drive':
                    $download_link = admin_url('admin-ajax.php') . '?action=wpmf-download-file&id=' . urlencode($drive_id) . '&dl=1';
                    break;

                case 'dropbox':
                    $download_link = admin_url('admin-ajax.php') . '?action=wpmf-dbxdownload-file&id=' . urlencode($drive_id) . '&link=true&dl=1';
                    break;
                default:
                    $download_link = wp_get_attachment_image_url($attachment_id, 'full');
            }

            $download_link = str_replace('&amp;', '&', $download_link);
            $download_link = str_replace('&#038;', '&', $download_link);
            $type = 'cloud';
        }

        return array('download_link' => $download_link, 'type' => $type);
    }

    /**
     * Generate html attachment link
     *
     * @param integer $id         Id of image
     * @param string  $size       Size of image
     * @param boolean $permalink  Permalink of current image
     * @param string  $targetsize Optional. Image size. Accepts any valid image size, or an array of width
     * @param boolean $customlink Custom link URL
     * @param string  $target     Target of link
     * @param string  $pos        Possition
     *
     * @return mixed|string
     */
    public function getAttachmentLink(
        $id = 0,
        $size = 'thumbnail',
        $permalink = false,
        $targetsize = 'large',
        $customlink = false,
        $target = '_self',
        $pos = 0
    ) {
        $id = intval($id);
        $_post = get_post($id);

        $url = wp_get_attachment_url($_post->ID);
        if (empty($_post) || ('attachment' !== $_post->post_type) || !$url) {
            return __('Missing Attachment', 'wpmf');
        }

        $lb = 0;
        $url = get_post_meta($_post->ID, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
        if ($url === '') {
            if ($permalink) {
                if ($_post->post_mime_type === 'application/pdf') {
                    $target = '_blank';
                }
            } elseif ($targetsize) {
                $lb = 1;
                if ($_post->post_mime_type === 'application/pdf') {
                    $target = '_blank';
                    $lb = 0;
                }
            }
        }

        $caption_lightbox = wpmfGetOption('caption_lightbox_gallery');
        if (!empty($caption_lightbox) && $_post->post_excerpt !== '') {
            $title = $_post->post_excerpt;
        } else {
            $title = $_post->post_title;
        }

        $alt_post     = get_post_meta($_post->ID, '_wp_attachment_image_alt', true);
        if ($alt_post === '') {
            $alt_post = $_post->post_title;
        }

        if ($size && 'none' !== $size) {
            $drive_id = get_post_meta($id, 'wpmf_drive_id', true);
            if (!empty($drive_id)) {
                $text = '<img class="wpmf_img wpmf_img_cloud" alt="'. esc_attr($alt_post) .'" src="'. wp_get_attachment_image_url($id, $size) .'" data-type="wpmfgalleryimg" data-lazy-src="0">';
            } else {
                $text = '<img class="wpmf_img" alt="'. esc_attr($alt_post) .'" src="'. wp_get_attachment_image_url($id, $size) .'" data-type="wpmfgalleryimg" data-lazy-src="'. wp_get_attachment_image_url($id, $size) .'">';
            }
        } else {
            $text = '';
        }

        if (trim($text) === '') {
            $text = $_post->post_title;
        }

        $current_theme = get_option('current_theme');
        if (isset($current_theme) && $current_theme === 'Gleam') {
            $tclass = 'fancybox';
        } else {
            $tclass = '';
        }

        $remote_video = get_post_meta($id, 'wpmf_remote_video_link', true);
        if (empty($remote_video)) {
            $class = $tclass . ' not_video';
        } else {
            $class = $tclass . ' isvideo';
        }

        $lightbox_urls = $this->getLightboxUrl($id, $targetsize);
        $url = $lightbox_urls['url'];

        if (defined('WPMF_DISABLE_GALLERY_TITLE')) {
            return '<a class="' . $class . ' noLightbox" data-lightbox="' . $lb . '" data-href="' . $url . '" target="' . $target . '" data-index="'. (int)$pos .'">' . $text . '</a>';
        } else {
            return '<a class="' . $class . ' noLightbox" data-lightbox="' . $lb . '" data-href="' . $url . '" title="' . esc_attr($title) . '" target="' . $target . '" data-index="'. (int)$pos .'">' . $text . '</a>';
        }
    }

    /**
     * Display settings gallery when custom gallery in back-end
     *
     * @return void
     */
    public function galleryPrintMediaTemplates()
    {
        if (isset($_GET['action']) && $_GET['action'] === 'elementor') { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No action, nonce is not required
            return;
        }

        $cf = wpmfGetOption('gallery_settings');
        $display_types = array(
            'default' => __('Default', 'wpmf'),
            'masonry' => __('Masonry', 'wpmf'),
            'portfolio' => __('Portfolio', 'wpmf'),
            'slider' => __('Slider', 'wpmf'),
        );
        $auto_insert_image_in_folder = apply_filters('auto_insert_image_in_folder_yes', false);
        ?>

        <script type="text/html" id="tmpl-wpmf-gallery-settings">
            <label class="setting">
                <span><?php esc_html_e('Gallery themes', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="display wpmf_display" name="display" data-setting="display">
                    <?php foreach ($display_types as $key => $value) : ?>
                        <option
                                value="<?php echo esc_attr($key); ?>" <?php selected($key, 'masonry'); ?>>
                            <?php echo esc_html($value); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="setting">
                <span><?php esc_html_e('Columns', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="columns wpmf_columns" name="columns" data-setting="columns">
                    <option value="1" <?php selected($cf['theme']['masonry_theme']['columns'], 1) ?>>1</option>
                    <option value="2" <?php selected($cf['theme']['masonry_theme']['columns'], 2) ?>>2</option>
                    <option value="3" <?php selected($cf['theme']['masonry_theme']['columns'], 3) ?>>3</option>
                    <option value="4" <?php selected($cf['theme']['masonry_theme']['columns'], 4) ?>>4</option>
                    <option value="5" <?php selected($cf['theme']['masonry_theme']['columns'], 5) ?>>5</option>
                    <option value="6" <?php selected($cf['theme']['masonry_theme']['columns'], 6) ?>>6</option>
                    <option value="7" <?php selected($cf['theme']['masonry_theme']['columns'], 7) ?>>7</option>
                    <option value="8" <?php selected($cf['theme']['masonry_theme']['columns'], 8) ?>>8</option>
                    <option value="9" <?php selected($cf['theme']['masonry_theme']['columns'], 9) ?>>9</option>
                </select>
            </label>

            <label class="setting size">
                <span><?php esc_html_e('Gallery image size', 'wpmf'); ?></span>
            </label>

            <label class="setting size">
                <select class="size wpmf_size" name="size" data-setting="size">
                    <?php
                    $sizes_value = json_decode(get_option('wpmf_gallery_image_size_value'));
                    $sizes = apply_filters('image_size_names_choose', array(
                        'thumbnail' => __('Thumbnail', 'wpmf'),
                        'medium' => __('Medium', 'wpmf'),
                        'large' => __('Large', 'wpmf'),
                        'full' => __('Full Size', 'wpmf'),
                    ));
                    ?>

                    <?php foreach ($sizes_value as $key) : ?>
                        <option value="<?php echo esc_attr($key); ?>"
                            <?php selected($cf['theme']['masonry_theme']['size'], esc_attr($key)); ?>>
                            <?php echo esc_html($sizes[$key]); ?></option>
                    <?php endforeach; ?>

                </select>
            </label>

            <label class="setting">
                <span><?php esc_html_e('Lightbox size', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="targetsize wpmf_targetsize" name="targetsize" data-setting="targetsize">
                    <?php
                    $sizes = array(
                        'thumbnail' => __('Thumbnail', 'wpmf'),
                        'medium' => __('Medium', 'wpmf'),
                        'large' => __('Large', 'wpmf'),
                        'full' => __('Full Size', 'wpmf'),
                    );
                    ?>

                    <?php foreach ($sizes as $key => $name) : ?>
                        <option value="<?php echo esc_attr($key); ?>"
                            <?php selected($cf['theme']['masonry_theme']['targetsize'], esc_attr($key)); ?>>
                            <?php echo esc_html($name); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="setting">
                <span><?php esc_html_e('Action on click', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="link-to wpmf_link-to" name="link" data-setting="link">
                    <option value="file"
                        <?php selected($cf['theme']['masonry_theme']['link'], 'file'); ?>>
                        <?php esc_html_e('Lightbox', 'wpmf'); ?>
                    </option>
                    <option value="post"
                        <?php selected($cf['theme']['masonry_theme']['link'], 'post'); ?>>
                        <?php esc_html_e('Attachment Page', 'wpmf'); ?>
                    </option>
                    <option value="none"
                        <?php selected($cf['theme']['masonry_theme']['link'], 'none'); ?>>
                        <?php esc_html_e('None', 'wpmf'); ?>
                    </option>
                    <option value="custom"
                        <?php selected($cf['theme']['masonry_theme']['link'], 'custom'); ?>>
                        <?php esc_html_e('Custom link', 'wpmf'); ?>
                    </option>
                </select>
            </label>

            <label class="setting">
                <span><?php esc_html_e('Auto insert image in folder', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="wpmf_autoinsert" name="wpmf_autoinsert" data-setting="wpmf_autoinsert">
                    <option value="0" <?php echo !$auto_insert_image_in_folder ? 'selected' : ''; ?>><?php esc_html_e('No', 'wpmf'); ?></option>
                    <option value="1" <?php echo $auto_insert_image_in_folder ? 'selected' : ''; ?>><?php esc_html_e('Yes', 'wpmf'); ?></option>
                </select>
            </label>

            <label class="setting">
                <span><?php esc_html_e('Order by', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="wpmf_orderby" name="wpmf_orderby" data-setting="wpmf_orderby">
                    <option value="post__in"
                        <?php selected($cf['theme']['masonry_theme']['orderby'], 'post__in'); ?>>
                        <?php esc_html_e('Custom', 'wpmf'); ?>
                    </option>
                    <option value="rand"
                        <?php selected($cf['theme']['masonry_theme']['orderby'], 'rand'); ?>>
                        <?php esc_html_e('Random', 'wpmf'); ?>
                    </option>
                    <option value="title"
                        <?php selected($cf['theme']['masonry_theme']['orderby'], 'title'); ?>>
                        <?php esc_html_e('Title', 'wpmf'); ?>
                    </option>
                    <option value="date"
                        <?php selected($cf['theme']['masonry_theme']['orderby'], 'date'); ?>>
                        <?php esc_html_e('Date', 'wpmf'); ?>
                    </option>
                </select>
            </label>

            <label class="setting">
                <span><?php esc_html_e('Order', 'wpmf'); ?></span>
            </label>

            <label class="setting">
                <select class="wpmf_order" name="wpmf_order" data-setting="wpmf_order">
                    <option value="ASC"
                        <?php selected($cf['theme']['masonry_theme']['order'], 'ASC'); ?>>
                        <?php esc_html_e('Ascending', 'wpmf'); ?>
                    </option>
                    <option value="DESC"
                        <?php selected($cf['theme']['masonry_theme']['order'], 'DESC'); ?>>
                        <?php esc_html_e('Descending', 'wpmf'); ?>
                    </option>
                </select>
            </label>

            <label>
                <input type="text" class="wpmf_folder_id" data-setting="wpmf_folder_id" style="display: none">
            </label>
        </script>
        <?php
    }

    /**
     * Add custom field for attachment
     * Based on /wp-admin/includes/media.php
     *
     * @param array   $form_fields An array of attachment form fields.
     * @param WP_Post $post        The WP_Post attachment object.
     *
     * @return mixed $form_fields
     */
    public function galleryAttachmentFieldsToEdit($form_fields, $post)
    {
        $form_fields['wpmf_gallery_custom_image_link'] = array(
            'label' => __('Image gallery link to', 'wpmf'),
            'input' => 'html',
            'html' => '<input type="text" class="text"
             id="attachments-' . $post->ID . '-wpmf_gallery_custom_image_link"
              name="attachments[' . $post->ID . '][wpmf_gallery_custom_image_link]"
               value="' . get_post_meta($post->ID, _WPMF_GALLERY_PREFIX . 'custom_image_link', true) . '">
                <button type="button" id="link-btn"
                 class="link-btn"><span class="dashicons dashicons-admin-links wpmf-zmdi-link"></span></button>'
        );

        $target_value = get_post_meta($post->ID, '_gallery_link_target', true);
        $form_fields['gallery_link_target'] = array(
            'label' => __('Link target', 'wpmf'),
            'input' => 'html',
            'html' => '
                        <select name="attachments[' . $post->ID . '][gallery_link_target]"
                         id="attachments[' . $post->ID . '][gallery_link_target]">
                                <option value="">' . __('Same Window', 'wpmf') . '</option>
                                <option value="_blank"' . ($target_value === '_blank' ? ' selected="selected"' : '') . '>
                                ' . __('New Window', 'wpmf') . '</option>
                        </select>'
        );

        return $form_fields;
    }

    /**
     * Save custom field for attachment
     * Based on /wp-admin/includes/media.php
     *
     * @param array $post       An array of post data.
     * @param array $attachment An array of attachment metadata.
     *
     * @return mixed $post
     */
    public function galleryAttachmentFieldsToSave($post, $attachment)
    {
        if (isset($attachment['wpmf_gallery_custom_image_link'])) {
            update_post_meta(
                $post['ID'],
                _WPMF_GALLERY_PREFIX . 'custom_image_link',
                esc_url_raw($attachment['wpmf_gallery_custom_image_link'])
            );
        }

        if (isset($attachment['gallery_link_target'])) {
            update_post_meta($post['ID'], '_gallery_link_target', $attachment['gallery_link_target']);
        }

        return $post;
    }

    /**
     * Enqueue styles and scripts for gutenberg
     *
     * @return void
     */
    public function addEditorAssets()
    {
        wp_register_script(
            'wordpresscanvas-imagesloaded',
            WPMF_PLUGIN_URL . 'assets/js/display-gallery/imagesloaded.pkgd.min.js',
            array('jquery'),
            '3.1.5',
            true
        );

        wp_enqueue_script('jquery-masonry');
        global $pagenow;
        $deps = (isset($pagenow) && $pagenow === 'widgets.php') ? array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-data', 'wp-block-editor', 'lodash', 'wordpresscanvas-imagesloaded') : array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-data', 'wp-editor', 'lodash', 'wordpresscanvas-imagesloaded');
        wp_enqueue_script(
            'wpmf_gallery_blocks',
            WPMF_PLUGIN_URL . 'assets/js/blocks/gallery/block.js',
            $deps,
            WPMF_VERSION
        );

        wp_enqueue_style(
            'wpmf-slick-style',
            WPMF_PLUGIN_URL . 'assets/js/slick/slick.css',
            array(),
            WPMF_VERSION
        );

        wp_enqueue_style(
            'wpmf-slick-theme-style',
            WPMF_PLUGIN_URL . 'assets/js/slick/slick-theme.css',
            array(),
            WPMF_VERSION
        );

        wp_enqueue_script(
            'wpmf-slick-script',
            WPMF_PLUGIN_URL . 'assets/js/slick/slick.min.js',
            array('jquery'),
            WPMF_VERSION,
            true
        );

        $sizes = apply_filters('image_size_names_choose', array(
            'thumbnail' => __('Thumbnail', 'wpmf'),
            'medium' => __('Medium', 'wpmf'),
            'large' => __('Large', 'wpmf'),
            'full' => __('Full Size', 'wpmf'),
        ));

        $sizes_value = json_decode(get_option('wpmf_gallery_image_size_value'));
        if (!empty($sizes_value)) {
            foreach ($sizes as $k => $size) {
                if (!in_array($k, $sizes_value)) {
                    unset($sizes[$k]);
                }
            }
        }

        $gallery_configs = wpmfGetOption('gallery_settings');
        $params = array(
            'l18n' => array(
                'block_gallery_title' => __('WP Media Folder Gallery', 'wpmf'),
                'no_post_found' => __('No post found', 'wpmf'),
                'select_label' => __('Select a News Block', 'wpmf')
            ),
            'vars' => array(
                'sizes' => $sizes,
                'gallery_configs'       => $gallery_configs,
                'wpmf_nonce' => wp_create_nonce('wpmf_nonce'),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'block_cover' => WPMF_PLUGIN_URL .'assets/js/blocks/gallery/preview.png'
            )
        );

        wp_localize_script('wpmf_gallery_blocks', 'wpmf_blocks', $params);
    }

    /**
     * Update image infos
     *
     * @return void
     */
    public function galleryBlockUpdateImageInfos()
    {
        if (empty($_REQUEST['wpmf_nonce'])
            || !wp_verify_nonce($_REQUEST['wpmf_nonce'], 'wpmf_nonce')) {
            die();
        }


        if (isset($_REQUEST['id']) && isset($_REQUEST['title']) && isset($_REQUEST['caption']) && isset($_REQUEST['custom_link'])) {
            if (!current_user_can('edit_post', (int)$_REQUEST['id'])) {
                wp_send_json(array('status' => false, 'msg' => esc_html__('You not have a permission to update image information!', 'wpmf')));
            }

            $my_post = array(
                'ID' => (int)$_REQUEST['id'],
                'post_title' => $_REQUEST['title'],
                'post_excerpt' => $_REQUEST['caption'],
            );

            $post_id = wp_update_post($my_post);

            update_post_meta($post_id, _WPMF_GALLERY_PREFIX . 'custom_image_link', $_REQUEST['custom_link']);
            update_post_meta($post_id, '_gallery_link_target', $_REQUEST['link_target']);
            if (is_wp_error($post_id)) {
                wp_send_json(array(
                    'status' => false
                ));
            } else {
                wp_send_json(array(
                    'status' => true,
                    'infos' => array('title' => $_REQUEST['title'], 'caption' => $_REQUEST['caption'], 'custom_link' => $_REQUEST['custom_link'], 'link_target' => $_REQUEST['link_target'])
                ));
            }
        }
    }

    /**
     * Load image title
     *
     * @return void
     */
    public function galleryBlockLoadImageInfos()
    {
        if (empty($_REQUEST['wpmf_nonce'])
            || !wp_verify_nonce($_REQUEST['wpmf_nonce'], 'wpmf_nonce')) {
            die();
        }

        $titles = array();
        $captions = array();
        $custom_links = array();
        $link_targets = array();
        if (isset($_REQUEST['ids'])) {
            $ids = explode(',', $_REQUEST['ids']);
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $image = get_post($id);
                    if (empty($image)) {
                        continue;
                    }

                    $url = get_post_meta($id, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
                    $target = get_post_meta($id, '_gallery_link_target', true);
                    $titles[$id] = $image->post_title;
                    $captions[$id] = $image->post_excerpt;
                    $custom_links[$id] = $url;
                    $link_targets[$id] = $target;
                }
            }
        }

        wp_send_json(array(
            'status' => true,
            'titles' => $titles,
            'captions' => $captions,
            'custom_links' => $custom_links,
            'link_targets' => $link_targets
        ));
    }

    /**
     * Get image from folder
     *
     * @return void
     */
    public function getImagesFromFolder()
    {
        if (empty($_REQUEST['wpmf_nonce'])
            || !wp_verify_nonce($_REQUEST['wpmf_nonce'], 'wpmf_nonce')) {
            die();
        }

        $folders = explode(',', $_REQUEST['ids']);
        $orderby = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'title';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : 'ASC';
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'orderby' => $orderby,
            'order' => $order,
            'tax_query' => array(
                array(
                    'taxonomy' => WPMF_TAXO,
                    'field' => 'term_id',
                    'terms' => $folders,
                    'operator' => 'IN',
                    'include_children' => false
                )
            )
        );

        $query = new WP_Query($args);
        $attachments = $query->get_posts();
        $last_folder_parent = $this->getFolderParent($folders[0]);
        $list_images = array();
        foreach ($attachments as $attachment) {
            if (strpos($attachment->post_mime_type, 'image') !== false && ($last_folder_parent->slug !== 'nextcloud' || !strpos($attachment->post_mime_type, 'avif'))) {
                $custom_link = get_post_meta($attachment->ID, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
                $target = get_post_meta($attachment->ID, '_gallery_link_target', true);
                $details = array(
                    'id' => $attachment->ID,
                    'title' => $attachment->post_title,
                    'url' => wp_get_attachment_url($attachment->ID),
                    'caption' => $attachment->post_excerpt,
                    'custom_link' => $custom_link,
                    'link_target' => $target
                );



                $metadata = wp_get_attachment_metadata($attachment->ID);
                if (!empty($metadata['sizes'])) {
                    $sizes = $metadata['sizes'];
                    foreach ($sizes as $size => &$value) {
                        $url = wp_get_attachment_image_src($attachment->ID, $size);
                        $value['url'] = $url[0];
                    }
                    $details['sizes'] = $sizes;
                }

                $list_images[] = $details;
            }
        }

        wp_send_json(array('status' => true, 'images' => $list_images));
    }

    /**
     * Get last folder parent
     *
     * @param integer $folder_id Folder ID
     *
     * @return object
     */
    public function getFolderParent($folder_id)
    {
        if ($folder_id) {
            $term = get_term($folder_id, 'wpmf-category');
            if ($term && $term->parent) {
                $parent = $this->getFolderParent($term->parent);
            } else {
                return $term;
            }
        }
        return $parent;
    }

    /**
     * Get lightbox URL and type
     *
     * @param integer $attachmentID Attachment ID
     * @param string  $targetsize   Lightbox size
     *
     * @return array
     */
    public function getLightboxUrl($attachmentID, $targetsize)
    {
        $type = 'image';
        $item_url = get_post_meta($attachmentID, _WPMF_GALLERY_PREFIX . 'custom_image_link', true);
        if ($item_url === '') {
            if ($targetsize) {
                $attachment = get_post($attachmentID);
                if ($attachment->post_mime_type === 'application/pdf') {
                    $item_url = wp_get_attachment_url($attachmentID);
                } else {
                    $item_url = wp_get_attachment_image_url($attachmentID, $targetsize);
                }
            } else {
                $item_url = wp_get_attachment_image_url($attachmentID, $targetsize);
            }
        }

        $remote_video = get_post_meta($attachmentID, 'wpmf_remote_video_link', true);
        $url = (!empty($remote_video)) ? $remote_video : $item_url;
        if ((!empty($remote_video)) && strpos($url, 'vimeo') !== false) {
            $vimeo_id = WpmfHelper::getVimeoVideoIdFromUrl($url);
            $url = 'https://player.vimeo.com/video/' . $vimeo_id;
            $type = 'iframe';
        }

        if ((!empty($remote_video)) && (strpos($remote_video, 'youtube') !== false || strpos($remote_video, 'youtu.be') !== false)) {
            if (strpos($url, '/embed/') === false) {
                $parts = parse_url($url);
                if ($parts['host'] === 'youtu.be') {
                    $youtube_id = trim($parts['path'], '/');
                } else {
                    parse_str($parts['query'], $query);
                    $youtube_id = $query['v'];
                }
                $url = 'http://www.youtube.com/watch?v=' . $youtube_id;
            } else {
                $url = $remote_video;
            }

            $type = 'iframe';
        }

        if ((!empty($remote_video)) && (strpos($url, 'dailymotion') !== false)) {
            $type = 'iframe';
            $id = strtok(basename($url), '_');
            $url = 'https://dailymotion.com/embed/video/' . $id;
        }

        if (!empty($remote_video)) {
            if (strpos($url, '.mp4') !== false || strpos($url, '.mov') !== false || strpos($url, '.flv') !== false) {
                $type = 'iframe';
            }
        }

        if ((!empty($remote_video)) && (strpos($url, 'wistia') !== false)) {
            $type = 'iframe';
        }

        if ((!empty($remote_video)) && (strpos($url, 'facebook') !== false)) {
            $type = 'iframe';
            $url = 'https://www.facebook.com/plugins/video.php?height=314&href='. urlencode($url) .'&show_text=false&width=560';
        }

        if ((!empty($remote_video)) && (strpos($url, 'twitch') !== false)) {
            $type = 'iframe';
            $parts = parse_url($url);
            if (strpos($parts['path'], '/video') !== false) {
                $twitch_id = str_replace('/videos/', '', $parts['path']);
                $url = 'https://player.twitch.tv/?video='. $twitch_id .'&parent=' . $_SERVER['SERVER_NAME'];
            } else {
                $twitch_id = trim($parts['path'], '/');
                $url = 'https://player.twitch.tv/?channel='. $twitch_id .'&parent=' . $_SERVER['SERVER_NAME'];
            }
        }

        return array('type' => $type, 'url' => $url);
    }
}