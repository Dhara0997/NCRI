<?php
if (!defined('ABSPATH')) {
    exit;
}
require_once(WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/install-wizard/handler-wizard.php');
/**
 * Class WpmfInstallWizard
 */
class WpmfInstallWizard
{
    /**
     * Init step params
     *
     * @var array
     */
    protected $steps = array(
            'environment' => array(
                    'name' => 'Environment Check',
                    'view' => 'viewEvironment',
                    'action' => 'saveEvironment'
            ),
            'image_config' => array(
                    'name' => 'Image Configuration',
                    'view' => 'viewImageConfig',
                    'action' => 'saveImageConfiguration'
            ),
            'additional_features' => array(
                    'name' => 'Additional Features',
                    'view' => 'viewAdditionalFeatures',
                    'action' => 'saveAdditionalFeatures',
            )
    );
    /**
     * Init current step params
     *
     * @var array
     */
    protected $current_step = array();
    /**
     * WpmfInstallWizard constructor.
     */
    public function __construct()
    {
        /**
         * Filter check capability of current user to run first install plugin
         *
         * @param boolean The current user has the given capability
         * @param string  Action name
         *
         * @return boolean
         *
         * @ignore Hook already documented
         */
        $wpmf_capability = apply_filters('wpmf_user_can', current_user_can('manage_options'), 'first_install_plugin');
        if ($wpmf_capability) {
            add_action('admin_menu', array($this, 'adminMenus'));
            add_action('admin_init', array($this, 'runWizard'));
        }
    }
    /**
     * Add admin menus/screens.
     *
     * @return void
     */
    public function adminMenus()
    {
        add_dashboard_page('', '', 'manage_options', 'wpmf-setup', '');
    }

    /**
     * Execute wizard
     *
     * @return void
     */
    public function runWizard()
    {
        // phpcs:disable WordPress.Security.NonceVerification.Recommended -- View request, no action
        wp_enqueue_style(
            'wpmf_wizard',
            WPMF_PLUGIN_URL  . 'class/install-wizard/install-wizard.css',
            array(),
            WPMF_VERSION
        );

        // Get step
        $this->steps = apply_filters('wpmf_setup_wizard_steps', $this->steps);
        $this->current_step  = isset($_GET['step']) ? sanitize_key($_GET['step']) : '';

        // Save action
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- No action, nonce is not required
        if (!empty($_POST['wpmf_save_step']) && isset($this->steps[$this->current_step]['action'])) {
            call_user_func(array('WpmfHandlerWizard', $this->steps[$this->current_step]['action']), $this->current_step);
        }

        // juLicense
        if (!isset($_GET['step'])) {
            // Include the javascript
            wp_enqueue_script('jquery');
            wp_enqueue_script('thickbox', null, array('jquery'));

            // Include the thickbox styles
            wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
            wp_enqueue_script('wpmf_install', WPMF_PLUGIN_URL  . 'class/install-wizard/script.js', array('jquery'));
            $params = $this->localizeScript();
            wp_localize_script('wpmf_install', 'updaterV2params', $params);
        }

        // Render
        $this->setHeader();
        if (!isset($_GET['step'])) {
            require_once(WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/install-wizard/content/license.php');
        } elseif (isset($_GET['step']) && $_GET['step'] === 'wizard_start') {
            require_once(WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/install-wizard/content/viewWizard.php');
        } elseif (isset($_GET['step']) && $_GET['step'] === 'wizard_done') {
            require_once(WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/install-wizard/content/viewDone.php');
        } else {
            $this->setMenu();
            $this->setContent();
        }
        $this->setFooter();
        // phpcs:enable
        exit();
    }

    /**
     * Localize script
     *
     * @return array
     */
    public function localizeScript()
    {
        global $wp_version;

        $token = get_site_option('wpmf_license_token');
        return array(
            'ajaxurl'        => admin_url('admin-ajax.php'),
            'token'          => $token,
            'ju_base'        => JU_BASE,
            'ju_content_url' => admin_url(),
            'site_url' => site_url(),
            'version'        => $wp_version,
            'ju_updater_nonce'            => wp_create_nonce('ju_updater_nonce')
        );
    }

    /**
     * Get next link step
     *
     * @param string $step Current step
     *
     * @return string
     */
    public function getNextLink($step = '')
    {
        if (!$step) {
            $step = $this->current_step;
        }

        $keys = array_keys($this->steps);

        if (end($keys) === $step) {
            return add_query_arg('step', 'wizard_done', remove_query_arg('activate_error'));
        }

        $step_index = array_search($step, $keys, true);
        if (false === $step_index) {
            return '';
        }

        return add_query_arg('step', $keys[$step_index + 1], remove_query_arg('activate_error'));
    }

    /**
     * Output the menu for the current step.
     *
     * @return void
     */
    public function setMenu()
    {
        $output_steps = $this->steps;
        ?>
        <div class="wpmf-wizard-steps">
            <ul class="wizard-steps">
                <?php
                $i = 0;
                foreach ($output_steps as $key => $step) {
                    $position_current_step = array_search($this->current_step, array_keys($this->steps), true);
                    $position_step = array_search($key, array_keys($this->steps), true);
                    $is_visited = $position_current_step > $position_step;
                    $i ++;
                    if ($key === $this->current_step) {
                        ?>
                        <li class="actived"><div class="layer"><?php echo esc_html($i) ?></div></li>
                        <?php
                    } elseif ($is_visited) {
                        ?>
                        <li class="visited">
                            <a href="<?php echo esc_url(add_query_arg('step', $key, remove_query_arg('activate_error'))); ?>">
                                <div class="layer"><?php echo esc_html($i) ?></div></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li><div class="layer"><?php echo esc_html($i) ?></div></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <?php
    }


    /**
     * Output the content for the current step.
     *
     * @return void
     */
    public function setContent()
    {
        echo '<div class="">';
        if (!empty($this->steps[$this->current_step]['view'])) {
            require_once(WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/install-wizard/content/' . $this->steps[$this->current_step]['view'] . '.php');
        }
        echo '</div>';
    }

    /**
     * Setup Wizard Header.
     *
     * @return void
     */
    public function setHeader()
    {
        $cls = 'juLicense';
        if (!empty($this->steps[$this->current_step]['view'])) {
            $cls = 'wpmf-wizard-setup-' . $this->current_step;
        }
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta name="viewport" content="width=device-width" />
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php esc_html_e('WP Media Folder &rsaquo; Setup Wizard', 'wpmf'); ?></title>
            <?php  wp_admin_css('dashicons', true); ?>
            <?php  wp_admin_css('wpmf_wizard', true); ?>
        </head>
        <body class="wpmf-wizard-setup wp-core-ui <?php echo esc_attr($cls); ?>">
        <div class="wpmf-wizard-content p-d-20">
        <?php
    }

    /**
     * Setup Wizard Footer.
     *
     * @return void
     */
    public function setFooter()
    {
        ?>
        </div>
        </body>
        <?php wp_print_footer_scripts(); ?>
        </html>
        <?php
    }
}

new WpmfInstallWizard();
