<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
$wizard = new WpmfInstallWizard();
// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- View request, no action
$step      = isset($_GET['step']) ? sanitize_key($_GET['step']) : '';
$next_link = $wizard->getNextLink($step);
$ext_name = 'wp-media-folder';

$ju_update_link = JU_BASE . 'index.php?option=com_juupdater&view=connect&tmpl=component&ext_name='.$ext_name.'&site=' . site_url() . '&TB_iframe=true&width=400&height=520';

?>

<form method="post" id="quick-config-form">
    <?php wp_nonce_field('wpmf-setup-wizard', 'wizard_nonce'); ?>
    <input type="hidden" name="wpmf_save_step" value="1"/>
    <div class="wizard-header">
        <div class="title h1 font-size-35"><?php esc_html_e('JoomUnited login & plugin license', 'wpmf'); ?></div>
        <p class="description"><?php echo esc_html__('Unlock the full potential of your plugin by connecting to your JoomUnited account. Once logged in, you\'ll get access to premium plugin features and functionality, automatic plugin updates to ensure security and performance and direct access to our dedicated support team.', 'wpmf'); ?></p>
    </div>
    <div class="wizard-content">
        <div class="description center">
            <?php esc_html_e('Simply click the login button below and use your JoomUnited account credentials to get started.', 'wpmf'); ?>
        </div>
        <div class="joomunited-login-wrapper">
            <a href="<?php echo esc_url_raw($ju_update_link); ?>" class="thickbox ju-button ju-license-button" type="button"><?php esc_html_e('LOGIN NOW >>>', 'wpmf'); ?></a>
        </div>
        <div class="description center">
            <?php esc_html_e('Note: Use the same email and password as your JoomUnited website account.', 'wpmf'); ?>
        </div>
    </div>
</form>
<script>
    var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php'));?>';
    var wpmfNextStep = '<?php echo admin_url('index.php?page=wpmf-setup&step=wizard_start');  //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>';
    console.log(wpmfNextStep);
</script>