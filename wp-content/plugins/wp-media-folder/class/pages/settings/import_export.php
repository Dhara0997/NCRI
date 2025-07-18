<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
wp_enqueue_style(
    'wpmf-mdl',
    WPMF_PLUGIN_URL . 'assets/css/modal-dialog/mdl-jquery-modal-dialog.css',
    array(),
    WPMF_VERSION
);

wp_enqueue_style(
    'wpmf-deep_orange',
    WPMF_PLUGIN_URL . 'assets/css/modal-dialog/material.deep_orange-amber.min.css',
    array(),
    WPMF_VERSION
);

wp_enqueue_script(
    'wpmf-mdl',
    WPMF_PLUGIN_URL . 'assets/js/modal-dialog/mdl-jquery-modal-dialog.js',
    array('jquery'),
    WPMF_VERSION
);

wp_enqueue_style(
    'wpmf-notice-style',
    WPMF_PLUGIN_URL . 'assets/css/notice_style.css',
    array(),
    WPMF_VERSION
);

wp_enqueue_script(
    'wpmf-import-external-cats',
    WPMF_PLUGIN_URL . 'assets/js/imports/import_eml.js',
    array('jquery'),
    WPMF_VERSION
);
$bytes = apply_filters('import_upload_size_limit', wp_max_upload_size());
$size = size_format($bytes);
?>
<div id="wordpress_import" class="tab-content">
    <div id="server_export" class="wpmf_width_100">
        <div class="wpmf_width_100 top_bar">
            <h1><?php echo esc_html__('Library Import/Export', 'wpmf') ?></h1>
            <p class="import_export_desc description"><?php echo esc_html__('Export and Import your WP Media Folder library (folder and media)', 'wpmf') ?></p>
        </div>
        <div class="content-box">
            <div class="ju-settings-option wpmf_width_100 p-tb-20">
                <label data-wpmftippy="Select what do you want to export and run to generate a file that you will import on another website"
                       class="ju-setting-label text wpmftippy"><?php esc_html_e('Export Media/Folders', 'wpmf'); ?></label>
                <select name="export_folder_type" class="ju-select export_folder_type">
                    <option value="all" <?php selected($export_folder_type, 'all') ?>><?php esc_html_e('All folders and media', 'wpmf'); ?></option>
                    <option value="only_folder" <?php selected($export_folder_type, 'only_folder') ?>><?php esc_html_e('Only the folder structure', 'wpmf'); ?></option>
                    <option value="selection_folder" <?php selected($export_folder_type, 'selection_folder') ?>><?php esc_html_e('A selection of folders and media', 'wpmf'); ?></option>
                </select>
                <input type="hidden" name="wpmf_export_folders" class="wpmf_export_folders">
                <a href="#open_export_tree_folders"
                   class="ju-button no-background  open_export_tree_folders <?php echo ($export_folder_type === 'selection_folder') ? 'show' : 'hide' ?>"><?php esc_html_e('Select folders', 'wpmf'); ?></a>
                <a href="<?php echo esc_url(admin_url('options-general.php?page=option-folder&action=wpmf_export&wpmf_nonce=' . wp_create_nonce('wpmf_nonce') . '#server_export')) ?>"
                   class="ju-button export_folder_btn no-background orange-button waves-effect waves-light"><?php esc_html_e('Run export', 'wpmf'); ?></a>
            </div>

            <div class="ju-settings-option wpmf_width_100 p-tb-20">
                <div class="wpmf_width_100">
                    <label data-wpmftippy="Browse and select the file you've previously exported to run the media & folders import"
                           class="ju-setting-label text wpmftippy"><?php esc_html_e('Import Media/Folders', 'wpmf'); ?></label>
                    <input type="file" name="import" class="wpmf_import_folders">
                    <input type="hidden" name="max_file_size" value="<?php echo esc_attr($bytes); ?>"/>
                    <button name="import_folders_btn" type="submit"
                            class="ju-button import_folder_btn no-background orange-button waves-effect waves-light"
                            data-path="<?php echo (!empty($path)) ? esc_attr($path) : '' ?>"
                            data-id="<?php echo (!empty($id)) ? esc_attr($id) : '' ?>"
                            data-import_only_folder="<?php echo (!empty($import_only_folder)) ? esc_attr($import_only_folder) : '' ?>">
                        <?php esc_html_e('Run import', 'wpmf'); ?>
                    </button>
                </div>
                <div class="wpmf_width_100 p-lr-20 info-export-wrap">
                    <label class="wpmftippy"
                           data-wpmftippy="<?php esc_html_e('Server values are upload_max_filesize and post_max_size', 'wpmf'); ?>">
                        <?php
                        printf(esc_html__('Maximum size, server value: %s', 'wpmf'), esc_html($size));
                        ?>
                    </label>

                    <?php if (apply_filters('import_allow_import_only_folder', true)) : ?>
                        <p>
                            <input type="checkbox" value="1" name="import_only_folder" id="import-attachments" checked/>
                            <label for="import-attachments"><?php esc_html_e('Import only folder structure (not media)', 'wpmf'); ?></label>
                        </p>
                    <?php endif; ?>
                    <div class="import_error_message_wrap">
                        <?php
                        if (isset($error_message) && $error_message !== '') {
                            // phpcs:ignore WordPress.Security.EscapeOutput -- Content already escaped in the method
                            echo '<div class="import_error_message">' . $error_message . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="white-popup mfp-hide" id="open_export_tree_folders">
                <div class="export_tree_folders"></div>
                <button class="ju-button save_export_folders orange-button"><?php esc_html_e('Save', 'wpmf'); ?></button>
                <span class="spinner save_export_folders_spinner"></span>
            </div>
        </div>
    </div>

    <div>
        <div class="wpmf_width_100 top_bar">
            <h1><?php echo esc_html__('Import server folders', 'wpmf') ?></h1>
        </div>
        <div class="content-box">
            <div class="ju-settings-option wpmf_width_100 p-d-20 btnoption">
                <p class="description">
                    <?php esc_html_e('Import folder structure and media from your
     server in the standard WordPress media manager', 'wpmf'); ?>
                    <br><span class="text-orange"
                              style="word-break: break-all;"><?php echo esc_html($allow_sync_extensions) ?></span>
                </p>
                <div class="wpmf_row_full">
                    <div id="wpmf_foldertree" class="wpmf-no-padding"></div>
                    <div class="wpmf-process-bar-full process_import_ftp_full" style="">
                        <div class="wpmf-process-bar process_import_ftp" data-w="0"></div>
                    </div>
                    <div class="wpmf-setting-only-file-import">
                        <input type="checkbox" id="only_file">
                        <span><?php esc_html_e('Import folders without their subdirectories', 'wpmf'); ?></span>
                    </div>
                    <div class="wpmf-setting-only-file-import">
                        <input type="checkbox" id="keep_root_directory">
                        <span><?php esc_html_e("Use original media paths (Don't copy)", 'wpmf'); ?></span>
                    </div>
                    <button type="button"
                            class="ju-button no-background orange-button waves-effect waves-light import_ftp_button"
                            style="padding: 8.5px 15px">
                        <label style="line-height: 20px"><?php esc_html_e('Import Folder', 'wpmf'); ?></label>
                        <span class="spinner" style="display:none; margin: 0; vertical-align: middle"></span>
                    </button>
                    <span class="info_import"><?php esc_html_e('Imported!', 'wpmf'); ?></span>
                </div>
            </div>
        </div>
    </div>


    <?php
    /**
     * Filter check capability of current user to show import categories button
     *
     * @param boolean The current user has the given capability
     * @param string  Action name
     *
     * @return boolean
     *
     * @ignore Hook already documented
     */
    $wpmf_capability = apply_filters('wpmf_user_can', current_user_can('manage_options'), 'show_import_categories_button');
    if ($wpmf_capability) :
        ?>
        <div id="server_import">
            <div class="wpmf_width_100 top_bar">
                <h1><?php echo esc_html__('Import WP media categories', 'wpmf') ?></h1>
            </div>
            <div class="content-box">
                <div class="ju-settings-option wpmf_width_100 p-d-20">
                    <p class="description">
                        <?php esc_html_e('Import current media and post categories as media folders', 'wpmf'); ?>
                    </p>
                    <p>
                        <button type="button"
                                class="ju-button no-background orange-button waves-effect waves-light wmpf_import_category"
                                style="padding: 8.5px 15px">
                            <label style="line-height: 20px"><?php esc_html_e('Import Now', 'wpmf'); ?></label>
                            <span class="spinner" style="display:none; margin: 0; vertical-align: middle"></span>
                        </button>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php
$folders = array();
?>
<div id="other_plugin_import" class="tab-content">
    <?php
    $find = false;
    $total = $wpdb->get_var('SELECT COUNT(term_id) as total FROM ' . $wpdb->term_taxonomy . ' WHERE taxonomy = "media_category"');
    if ($total > 0) :
        $eml_categories = $wpdb->get_results('SELECT * FROM ' . $wpdb->terms . ' as t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON tt.term_id = t.term_id WHERE taxonomy = "media_category"');
        $eml_categories = Joomunited\WPMediaFolder\wpmfHelper::parentSort($eml_categories);
        $fs = Joomunited\WPMediaFolder\wpmfHelper::loadImportExternalCatsScript($eml_categories, 'media_category');
        $folders = array_merge($folders, $fs);
        $find = true;
        ?>
        <div class="tab-content">
            <div class="wpmf_width_100 top_bar">
                <h1><?php echo esc_html__('Import Enhanced Media Library media and folders', 'wpmf') ?></h1>
            </div>
            <div class="content-box">
                <div class="ju-settings-option wpmf_width_100 p-d-20">
                    <p class="description">
                        <?php echo sprintf(esc_html__('We found that you have %d media folders in Enhanced Media Library plugin. Would you like to import media and folders in your media library?', 'wpmf'), esc_html($total)) ?>
                    </p>
                    <p>
                        <button type="button"
                                class="ju-button no-background orange-button waves-effect waves-light open_import_eml open_import_external_cats"
                                style="margin-left: 0 !important;" data-cat-name="media_category"><?php esc_html_e('Import Now', 'wpmf'); ?></button>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
    $total = $wpdb->get_var('SELECT COUNT(term_id) as total FROM ' . $wpdb->term_taxonomy . ' WHERE taxonomy = "happyfiles_category"');
    if ($total > 0) :
        $happy_categories = $wpdb->get_results('SELECT * FROM ' . $wpdb->terms . ' as t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON tt.term_id = t.term_id WHERE taxonomy = "happyfiles_category"');
        $happy_categories = Joomunited\WPMediaFolder\wpmfHelper::parentSort($happy_categories);
        $fs = Joomunited\WPMediaFolder\wpmfHelper::loadImportExternalCatsScript($happy_categories, 'happyfiles_category');
        $folders = array_merge($folders, $fs);
        $find = true;
        ?>
        <div class="tab-content">
            <div class="wpmf_width_100 top_bar">
                <h1><?php echo esc_html__('Import HappyFiles media and folders', 'wpmf') ?></h1>
            </div>
            <div class="content-box">
                <div class="ju-settings-option wpmf_width_100 p-d-20">
                    <p class="description">
                        <?php echo sprintf(esc_html__('We found that you have %d media folders in HappyFiles plugin. Would you like to import media and folders in your media library?', 'wpmf'), esc_html($total)) ?>
                    </p>
                    <p>
                        <button type="button"
                                class="ju-button no-background orange-button waves-effect waves-light open_import_eml open_import_external_cats"
                                style="margin-left: 0 !important;" data-cat-name="happyfiles_category"><?php esc_html_e('Import Now', 'wpmf'); ?></button>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
    $table_name = $wpdb->prefix . 'realmedialibrary';
    if ($wpdb->get_var('show tables like "'. $wpdb->prefix .'realmedialibrary"') === $table_name) {
        $total = $wpdb->get_var('SELECT COUNT(id) as total FROM ' . $wpdb->prefix . 'realmedialibrary');
        if ($total > 0) :
            $rml_categories = $wpdb->get_results('SELECT id as term_id, name, parent FROM ' . $wpdb->prefix . 'realmedialibrary');
            $rml_categories = Joomunited\WPMediaFolder\wpmfHelper::parentSort($rml_categories);
            $fs = Joomunited\WPMediaFolder\wpmfHelper::loadImportExternalCatsScript($rml_categories, 'real_media_library');
            $folders = array_merge($folders, $fs);
            $find = true;
            ?>
            <div class="wpmf_width_100">
                <div class="wpmf_width_100 top_bar">
                    <h1><?php echo esc_html__('Import Real Media Library media and folders', 'wpmf') ?></h1>
                </div>
                <div class="content-box">
                    <div class="ju-settings-option wpmf_width_100 p-d-20">
                        <p class="description">
                            <?php echo sprintf(esc_html__('We found that you have %d media folders in Real Media Library plugin. Would you like to import media and folders in your media library?', 'wpmf'), esc_html($total)) ?>
                        </p>
                        <p><button type="button" class="ju-button no-background orange-button waves-effect waves-light open_import_fbv open_import_external_cats" data-cat-name="rml_category" style="margin-left: 0 !important;"><?php esc_html_e('Import Now', 'wpmf'); ?></button></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php } ?>
    <?php
    $table_name = $wpdb->prefix . 'fbv';
    if ($wpdb->get_var('show tables like "'. $wpdb->prefix .'fbv"') === $table_name) {
        $total = $wpdb->get_var('SELECT COUNT(id) as total FROM ' . $wpdb->prefix . 'fbv');
        if ($total > 0) :
            $fbv_categories = $wpdb->get_results('SELECT id as term_id, name, parent FROM ' . $wpdb->prefix . 'fbv');
            $fbv_categories = Joomunited\WPMediaFolder\wpmfHelper::parentSort($fbv_categories);
            $fs = Joomunited\WPMediaFolder\wpmfHelper::loadImportExternalCatsScript($fbv_categories, 'filebird');
            $folders = array_merge($folders, $fs);
            $find = true;
            ?>
            <div class="wpmf_width_100">
                <div class="wpmf_width_100 top_bar">
                    <h1><?php echo esc_html__('Import FileBird media and folders', 'wpmf') ?></h1>
                </div>
                <div class="content-box">
                    <div class="ju-settings-option wpmf_width_100 p-d-20">
                        <p class="description">
                            <?php echo sprintf(esc_html__('We found that you have %d media folders in FileBird plugin. Would you like to import media and folders in your media library?', 'wpmf'), esc_html($total)) ?>
                        </p>
                        <p><button type="button" class="ju-button no-background orange-button waves-effect waves-light open_import_fbv open_import_external_cats" data-cat-name="filebird" style="margin-left: 0 !important;"><?php esc_html_e('Import Now', 'wpmf'); ?></button></p>
                    </div>
                </div>
            </div>
        <?php  endif; ?>
    <?php } ?>
    <?php
    $total = $wpdb->get_var('SELECT COUNT(term_id) as total FROM ' . $wpdb->term_taxonomy . ' WHERE taxonomy = "media_folder"');
    if ($total > 0) :
        $eml_categories = $wpdb->get_results('SELECT * FROM ' . $wpdb->terms . ' as t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON tt.term_id = t.term_id WHERE taxonomy = "media_folder"');
        $eml_categories = Joomunited\WPMediaFolder\wpmfHelper::parentSort($eml_categories);
        $fs = Joomunited\WPMediaFolder\wpmfHelper::loadImportExternalCatsScript($eml_categories, 'media_folder');
        $folders = array_merge($folders, $fs);
        $find = true;
        ?>
        <div class="wpmf_width_100">
            <div class="wpmf_width_100 top_bar">
                <h1><?php echo esc_html__('Import Folders media and folders', 'wpmf') ?></h1>
            </div>
            <div class="content-box">
                <div class="ju-settings-option wpmf_width_100 p-d-20">
                    <p class="description">
                        <?php echo sprintf(esc_html__('We found that you have %d media folders in Folders plugin. Would you like to import media and folders in your media library?', 'wpmf'), esc_html($total)) ?>
                    </p>
                    <p><button type="button" class="ju-button no-background orange-button waves-effect waves-light open_import_fbv open_import_external_cats" data-cat-name="media_folder" style="margin-left: 0 !important;"><?php esc_html_e('Import Now', 'wpmf'); ?></button></p>
                </div>
            </div>
        </div>
    <?php  endif; ?>

    <?php
    /**
     * Filter check capability of current user to show import categories button
     *
     * @param boolean The current user has the given capability
     * @param string  Action name
     *
     * @return boolean
     *
     * @ignore Hook already documented
     */
    $wpmf_capability = apply_filters('wpmf_user_can', current_user_can('manage_options'), 'show_import_nextgen_gallery_button');
    if ($wpmf_capability && defined('NGG_PLUGIN_VERSION')) :
        $find = true;
        ?>
        <div id="server_import" class="tab-content">
            <div class="wpmf_width_100 top_bar">
                <h1><?php echo esc_html__('Sync/Import NextGEN galleries', 'wpmf') ?></h1>
            </div>
            <div class="content-box">
                <div class="ju-settings-option wpmf_width_100 p-d-20">
                    <p class="description">
                        <?php esc_html_e('Import nextGEN albums as image in folders in the media manager.
         You can then create new galleries from WordPress media manager', 'wpmf'); ?>
                    </p>
                    <p>
                        <button type="button"
                                class="ju-button no-background orange-button waves-effect waves-light btn_import_gallery"
                                style="padding: 8.5px 15px">
                            <label style="line-height: 20px"><?php esc_html_e('Import Now', 'wpmf'); ?></label>
                            <span class="spinner" style="display:none; margin: 0; vertical-align: middle"></span>
                        </button>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php
    if (!$find) {
        echo '<p class="description" style="text-align: center">'. esc_html__('No supported plugin detected, plugin supported are: WP Real media library, Filebird, Folders, Media library plus, HappyFiles plugins', 'wpmf') .'</p>';
    }
    ?>
</div>
<?php
global $pagenow;
$vars            = array(
    'ajaxurl'               => admin_url('admin-ajax.php'),
    'pagenow'          => $pagenow,
    'wpmf_nonce'            => wp_create_nonce('wpmf_nonce')
);


$params = array('l18n' => array(
    'import_all_label' => esc_html__('Import All', 'wpmf'),
    'import_selected_label' => esc_html__('Import selected', 'wpmf'),
    'cancel_label' => esc_html__('Cancel', 'wpmf'),
    'eml_label_dialog' => esc_html__('Import categories from Enhanced Media Library plugin', 'wpmf'),
    'happyfiles_label_dialog' => esc_html__('Import categories from HappyFiles plugin', 'wpmf'),
    'rml_label_dialog' => esc_html__('Import categories from Real Media Library plugin', 'wpmf'),
    'fbv_label_dialog' => esc_html__('Import categories from FileBird plugin', 'wpmf'),
    'mf_label_dialog' => esc_html__('Import categories from Folders plugin', 'wpmf'),
), 'vars' => array_merge($vars, $folders));
wp_localize_script('wpmf-import-external-cats', 'import_external_cats_objects', $params);