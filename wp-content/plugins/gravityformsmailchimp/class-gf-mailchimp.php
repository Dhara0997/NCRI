<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

GFForms::include_feed_addon_framework();

/**
 * Gravity Forms Mailchimp Add-On.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2016, Rocketgenius
 */
class GFMailChimp extends GFFeedAddOn {

	const POST_ACTION = 'gravityformsmailchimp_disconnect';

	/**
	 * Contains an instance of this class, if available.
	 *
	 * @since  3.0
	 * @access private
	 * @var    GFMailChimp $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;

	/**
	 * Enabling background feed processing.
	 *
	 * @since 5.1.1
	 *
	 * @var bool
	 */
	protected $_async_feed_processing = true;

	/**
	 * Defines the version of the Mailchimp Add-On.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_version Contains the version, defined from mailchimp.php
	 */
	protected $_version = GF_MAILCHIMP_VERSION;

	/**
	 * Defines the minimum Gravity Forms version required.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_min_gravityforms_version The minimum version required.
	 */
	protected $_min_gravityforms_version = '2.5.0';

	/**
	 * Defines the plugin slug.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_slug The slug used for this plugin.
	 */
	protected $_slug = 'gravityformsmailchimp';

	/**
	 * Defines the main plugin file.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_path The path to the main plugin file, relative to the plugins folder.
	 */
	protected $_path = 'gravityformsmailchimp/mailchimp.php';

	/**
	 * Defines the full path to this class file.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_full_path The full path.
	 */
	protected $_full_path = __FILE__;

	/**
	 * Defines the URL where this Add-On can be found.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string The URL of the Add-On.
	 */
	protected $_url = 'http://www.gravityforms.com';

	/**
	 * Defines the title of this Add-On.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_title The title of the Add-On.
	 */
	protected $_title = 'Gravity Forms Mailchimp Add-On';

	/**
	 * Defines the short title of the Add-On.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_short_title The short title.
	 */
	protected $_short_title = 'Mailchimp';

	/**
	 * Defines if Add-On should use Gravity Forms servers for update data.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    bool
	 */
	protected $_enable_rg_autoupgrade = true;

	/**
	 * Defines the capabilities needed for the Mailchimp Add-On
	 *
	 * @since  3.0
	 * @access protected
	 * @var    array $_capabilities The capabilities needed for the Add-On
	 */
	protected $_capabilities = array( 'gravityforms_mailchimp', 'gravityforms_mailchimp_uninstall' );

	/**
	 * Defines the capability needed to access the Add-On settings page.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_capabilities_settings_page The capability needed to access the Add-On settings page.
	 */
	protected $_capabilities_settings_page = 'gravityforms_mailchimp';

	/**
	 * Defines the capability needed to access the Add-On form settings page.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_capabilities_form_settings The capability needed to access the Add-On form settings page.
	 */
	protected $_capabilities_form_settings = 'gravityforms_mailchimp';

	/**
	 * Defines the capability needed to uninstall the Add-On.
	 *
	 * @since  3.0
	 * @access protected
	 * @var    string $_capabilities_uninstall The capability needed to uninstall the Add-On.
	 */
	protected $_capabilities_uninstall = 'gravityforms_mailchimp_uninstall';

	/**
	 * Defines the Mailchimp list/audience field tag name.
	 *
	 * @since  3.7
	 * @access protected
	 * @var    string $merge_var_name The Mailchimp list/audience field tag name; used by gform_mailchimp_field_value.
	 */
	protected $merge_var_name = '';

	/**
	 * Defines the Mailchimp merge fields used in the current request.
	 *
	 * @since  4.2.4
	 * @access protected
	 * @var    array $merge_fields The Mailchimp merge fields used in the current request.
	 */
	protected $merge_fields = array();

	/**
	 * Contains an instance of the Mailchimp API library, if available.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    GF_MailChimp_API $api If available, contains an instance of the Mailchimp API library.
	 */
	public $api = null;

	/**
	 * Get an instance of this class.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @return GFMailChimp
	 */
	public static function get_instance() {

		if ( null === self::$_instance ) {
			self::$_instance = new self;
		}

		return self::$_instance;

	}

	/**
	 * Autoload the required libraries.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @uses GFAddOn::is_gravityforms_supported()
	 */
	public function pre_init() {

		parent::pre_init();

		if ( $this->is_gravityforms_supported() ) {

			// Load the Mailchimp API library.
			if ( ! class_exists( 'GF_MailChimp_API' ) ) {
				require_once( 'includes/class-gf-mailchimp-api.php' );
			}

		}

	}

	/**
	 * Plugin starting point. Handles hooks, loading of language files and PayPal delayed payment support.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @uses GFFeedAddOn::add_delayed_payment_support()
	 */
	public function init() {

		parent::init();

		$this->add_delayed_payment_support(
			array(
				'option_label' => esc_html__( 'Subscribe user to Mailchimp only when payment is received.', 'gravityformsmailchimp' ),
			)
		);

	}

	/**
	 * Add actions for admin_init
	 *
	 * @since 4.10
	 *
	 * @return void
	 */
	public function init_admin() {
		parent::init_admin();

		add_action( 'admin_init', array( $this, 'maybe_update_auth_creds' ) );
		if ( GFForms::is_gravity_page() ) {
			add_action( 'admin_init', array( $this, 'warn_for_deprecated_key' ) );
		}
		add_action( 'admin_post_' . self::POST_ACTION, array( $this, 'handle_disconnection' ) );
	}

	/**
	 * Remove unneeded settings.
	 *
	 * @since  4.0
	 * @access public
	 */
	public function uninstall() {

		parent::uninstall();

		GFCache::delete( 'mailchimp_plugin_settings' );
		delete_option( 'gf_mailchimp_settings' );
		delete_option( 'gf_mailchimp_version' );

	}

	/**
	 * Register needed styles.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @return array
	 */
	public function styles() {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		$styles = array(
			array(
				'handle'  => 'gravityformsmailchimp_form_settings',
				'src'     => $this->get_base_url() . "/css/form_settings{$min}.css",
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings', 'form_settings' ),
						'tab'        => $this->_slug,
					),
				),
			),
		);

		return array_merge( parent::styles(), $styles );

	}

	/**
	 * Return the plugin's icon for the plugin/form settings menu.
	 *
	 * @since 4.7
	 *
	 * @return string
	 */
	public function get_menu_icon() {

		return $this->is_gravityforms_supported( '2.5-beta-4' ) ? 'gform-icon--mailchimp' : 'dashicons-admin-generic';

	}


	// # OAUTH SETTINGS -----------------------------------------------------------------------------------------------

	/**
	 * Get the authorization payload data.
	 *
	 * Returns the auth POST request if it's present, otherwise attempts to return a recent transient cache.
	 *
	 * @since 3.10
	 *
	 * @return array
	 */
	private function get_oauth_payload() {
		$payload = array_filter(
			array(
				'auth_payload' => rgpost( 'auth_payload' ),
				'state'        => rgpost( 'state' ),
				'auth_error'   => rgpost( 'auth_error' ),
			)
		);

		if ( count( $payload ) === 2 || isset( $payload['auth_error'] ) ) {
			return $payload;
		}

		$payload = get_transient( "gravityapi_response_{$this->_slug}" );

		if ( ! is_array( $payload ) ) {
			return array();
		}

		delete_transient( "gravityapi_response_{$this->_slug}" );

		return $payload;
	}

	/**
	 * Update Auth Creds if they have changed.
	 *
	 * @since 4.10
	 *
	 * @return void
	 */
	public function maybe_update_auth_creds() {
		if ( rgget( 'subview' ) !== $this->_slug ) {
			return;
		}

		$payload = $this->get_oauth_payload();

		// No payload, bail.
		if ( empty( $payload ) ) {
			return;
		}

		// Auth Error form API - log and bail.
		if ( isset( $payload['auth_error'] ) ) {
			$this->add_error_notice( __METHOD__, 'error authenticating with the API Server' );

			return;
		}

		$state        = $payload['state'];
		$auth_payload = json_decode( $payload['auth_payload'], true );

		// State didn't pass our nonce - log and bail.
		if ( $state !== get_transient( "gravityapi_request_{$this->_slug}" ) ) {
			$this->add_error_notice( __METHOD__, 'could not verify the state value from the API Server.' );

			return;
		}

		// Incorrect/missing auth data - log and bail.
		if ( ! isset( $auth_payload['access_token'] ) || ! isset( $auth_payload['server_prefix'] ) ) {
			$this->add_error_notice( __METHOD__, 'missing access_token or server_prefix in API response.' );

			return;
		}

		// Store the auth payload.
		$this->update_plugin_settings( $auth_payload );
	}

	/**
	 * Add an error notice to admin if something goes awry. Also logs error to error_log.
	 *
	 * @since 4.10
	 *
	 * @param string $method  The method being called.
	 * @param string $message The message to display.
	 *
	 * @return void
	 */
	private function add_error_notice( $method, $message ) {
		add_action( 'admin_notices', function () {
			$message = __( 'Could not authenticate with Mailchimp.', 'gravityformsmailchimp' );

			printf( '<div class="notice below-h1 notice-error gf-notice"><p>%1$s</p></div>', esc_html( $message ) );
		} );

		$this->log_error( $method . ': ' . $message );
	}

	/**
	 * Get the authentication state, which was created from a wp nonce.
	 *
	 * @since 4.10
	 *
	 * @return string
	 */
	private function get_authentication_state_action() {
		return 'gform_mailchimp_authentication_state';
	}

	// # PLUGIN SETTINGS -----------------------------------------------------------------------------------------------

	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {

		return array(
			array(
				// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
				'description' => '<p>' . sprintf( esc_html__( 'Mailchimp makes it easy to send email newsletters to your customers, manage your subscriber audiences, and track campaign performance. Use Gravity Forms to collect customer information and automatically add it to your Mailchimp subscriber audience. If you don\'t have a Mailchimp account, you can %1$ssign up for one here.%2$s', 'gravityformsmailchimp' ), '<a href="http://www.mailchimp.com/" target="_blank">', '</a>' ) . '</p>',
				'fields'      => array(

					array(
						'name'              => 'connection',
						'type'              => 'html',
						'feedback_callback' => array( $this, 'initialize_api' ),
						'html'              => array( $this, 'render_connection_button' ),
						'callback'          => array( $this, 'render_connection_button' ),
					),
					array(
						'type' => 'save',
						'class'  => 'hidden',
					),
				),
			),
		);

	}

	/**
	 * Render the Connection Button on the Settings Page.
	 *
	 * @since 4.10
	 *
	 * @return string
	 */
	public function render_connection_button() {
		$valid = $this->is_valid_connection();

		if ( ! $valid ) {
			$nonce          = wp_create_nonce( $this->get_authentication_state_action() );
			$transient_name = 'gravityapi_request_' . $this->_slug;

			if ( get_transient( $transient_name ) ) {
				delete_transient( $transient_name );
			}

			set_transient( $transient_name, $nonce, 10 * MINUTE_IN_SECONDS );
		}

		$before = $this->get_before_button_content( $valid );
		$button = $this->get_button_content( $valid );
		$after  = $this->get_after_button_content( $valid );

		if ( version_compare( GFForms::$version, '2.5', '<' ) ) {
			echo $before . $button . $after;

			return;
		}

		return $before . $button . $after;
	}

	/**
	 * Get the markup to display before the connect button.
	 *
	 * @since 4.10
	 *
	 * @param bool $valid Whether the current connection is valid.
	 *
	 * @return string
	 */
	private function get_before_button_content( $valid ) {
		$html = '';

		if ( ! $valid ) {
			return '';
		}

		$account = $this->api->account_details();
		$name    = isset( $account['account_name'] ) ? $account['account_name'] : false;

		if ( $this->is_gravityforms_supported( '2.8.8' ) ) {
			$html  = '<p><span class="gform-status-indicator gform-status-indicator--size-sm gform-status-indicator--theme-cosmos gform-status--active gform-status--no-icon gform-status--no-hover">';
			$html .= '<span class="gform-status-indicator-status gform-typography--weight-medium gform-typography--size-text-xs">';

			if ( $name ) {
				$html .= esc_html__( 'Connected to Mailchimp as: ', 'gravityformsmailchimp' );
				$html .= esc_html( $name ) . '</span></span></p>';
			} else {
				$html .= esc_html__( 'Connected to Mailchimp.', 'gravityformsmailchimp' );
				$html .= '</span></span></p>';
			}
		} else {
			$html .= '<p><span class="gform-status-indicator gform-status--active gform-status--static">';

			if ( $name ) {
				$html .= esc_html__( 'Connected to Mailchimp as: ', 'gravityformsmailchimp' );
				$html .= esc_html( $name ) . '</span></p>';
			} else {
				$html .= esc_html__( 'Connected to Mailchimp.', 'gravityformsmailchimp' );
				$html .= '</span></p>';
			}
		}

		/**
		 * Allows third-party code to modify the HTML content which appears before the Connect button.
		 *
		 * @since 4.10
		 *
		 * @param string $html  The current HTML markup.
		 * @param bool   $valid Whether the current API connection is valid (connected and using oAuth).
		 *
		 * @return string
		 */
		return apply_filters( 'gform_mailchimp_before_connect_button', $html, $valid );
	}

	/**
	 * Get the markup to display the connect button.
	 *
	 * @since 4.10
	 *
	 * @param bool $valid Whether the current connection is valid.
	 *
	 * @return string
	 */
	private function get_button_content( $valid ) {
		$html = sprintf(
			'<a href="%1$s" target="%3$s" class="gform-button %4$s">%2$s</a>',
			$valid ? $this->get_disconnect_url() : $this->get_connect_url(),
			$valid ? __( 'Disconnect from Mailchimp', 'gravityformsmailchimp' ) : __( 'Connect to Mailchimp', 'gravityformsmailchimp' ),
			'_self',
			$valid ? 'gform-button--secondary' : 'gform-button--primary'
		);

		/**
		 * Allows third-party code to modify the Connect button HTML markup.
		 *
		 * @since 4.10
		 *
		 * @param string $html  The current button HTML markup.
		 * @param bool   $valid Whether the current API connection is valid (connected and using oAuth).
		 *
		 * @return string
		 */
		return apply_filters( 'gform_mailchimp_connect_button', $html, $valid );
	}

	/**
	 * Get the markup to display after the connect button.
	 *
	 * @since 4.10
	 *
	 * @param bool $valid Whether the current connection is valid.
	 *
	 * @return string
	 */
	private function get_after_button_content( $valid ) {
		if ( ! $valid ) {
			return '';
		}

		$html = '<p><em>';
		// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
		$html .= sprintf( __( 'In order to remove this site from your Mailchimp account, you\'ll need to remove it from your Mailchimp Account. %1$sLearn More.%2$s' ), '<a href="https://docs.gravityforms.com/mailchimp-disconnect-account/">', '</a>' );
		$html .= '</em></p>';

		/**
		 * Allows third-party code to modify the HTML content which appears after the Connect button.
		 *
		 * @since 4.10
		 *
		 * @param string $html  The current HTML markup.
		 * @param bool   $valid Whether the current API connection is valid (connected and using oAuth).
		 *
		 * @return string
		 */
		return apply_filters( 'gform_mailchimp_after_connect_button', $html, $valid );
	}

	/**
	 * Get the correct disconnect URL
	 *
	 * @since 4.10
	 *
	 * @return string
	 */
	private function get_disconnect_url() {
		return add_query_arg( array( 'action' => self::POST_ACTION ), admin_url( 'admin-post.php' ) );
	}

	/**
	 * Get the correct connect URL
	 *
	 * @since 4.10
	 *
	 * @return string
	 */
	private function get_connect_url() {
		$settings_url = urlencode( admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug ) );
		$connect_url  = sprintf( '%1$s/auth/mailchimp', GRAVITY_API_URL );
		$nonce        = wp_create_nonce( $this->get_authentication_state_action() );

		return add_query_arg( array( 'redirect_to' => $settings_url, 'state' => $nonce, 'license' => GFCommon::get_key() ), $connect_url );
	}


	// # FEED SETTINGS -------------------------------------------------------------------------------------------------

	/**
	 * Configures the settings which should be rendered on the feed edit page.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @return array
	 */
	public function feed_settings_fields() {

		$settings = array(
			array(
				'title'  => esc_html__( 'Mailchimp Feed Settings', 'gravityformsmailchimp' ),
				'fields' => array(
					array(
						'name'     => 'feedName',
						'label'    => esc_html__( 'Name', 'gravityformsmailchimp' ),
						'type'     => 'text',
						'required' => true,
						'class'    => 'medium',
						'tooltip'  => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Name', 'gravityformsmailchimp' ),
							esc_html__( 'Enter a feed name to uniquely identify this setup.', 'gravityformsmailchimp' )
						),
					),
					array(
						'name'     => 'mailchimpList',
						'label'    => esc_html__( 'Mailchimp Audience', 'gravityformsmailchimp' ),
						'type'     => 'mailchimp_list',
						'required' => true,
						'tooltip'  => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Mailchimp Audience', 'gravityformsmailchimp' ),
							esc_html__( 'Select the Mailchimp audience you would like to add your contacts to.', 'gravityformsmailchimp' )
						),
					),
				),
			),
			array(
				'dependency' => 'mailchimpList',
				'fields'     => array(
					array(
						'name'      => 'mappedFields',
						'label'     => esc_html__( 'Map Fields', 'gravityformsmailchimp' ),
						'type'      => 'field_map',
						'field_map' => $this->merge_vars_field_map(),
						'tooltip'   => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Map Fields', 'gravityformsmailchimp' ),
							esc_html__( 'Associate your Mailchimp merge tags to the appropriate Gravity Form fields by selecting the appropriate form field from the list.', 'gravityformsmailchimp' )
						),
					),
					array(
						'name'       => 'interestCategories',
						'label'      => esc_html__( 'Groups', 'gravityformsmailchimp' ),
						'dependency' => array( $this, 'has_interest_categories' ),
						'type'       => 'interest_categories',
						'tooltip'    => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Groups', 'gravityformsmailchimp' ),
							esc_html__( 'When one or more groups are enabled, users will be assigned to the groups in addition to being subscribed to the Mailchimp audience. When disabled, users will not be assigned to groups.', 'gravityformsmailchimp' )
						),
					),
					array(
						'name'    => 'options',
						'label'   => esc_html__( 'Options', 'gravityformsmailchimp' ),
						'type'    => 'checkbox',
						'choices' => array(
							array(
								'name'          => 'double_optin',
								'label'         => esc_html__( 'Double Opt-In', 'gravityformsmailchimp' ),
								'default_value' => 1,
								'onclick'       => 'if(this.checked){jQuery("#mailchimp_doubleoptin_warning").hide();} else{jQuery("#mailchimp_doubleoptin_warning").show();}',
								'tooltip'       => sprintf(
									'<h6>%s</h6>%s',
									esc_html__( 'Double Opt-In', 'gravityformsmailchimp' ),
									esc_html__( 'When the double opt-in option is enabled, Mailchimp will send a confirmation email to the user and will only add them to your Mailchimp audience upon confirmation.', 'gravityformsmailchimp' )
								),
							),
							array(
								'name'  => 'markAsVIP',
								'label' => esc_html__( 'Mark subscriber as VIP', 'gravityformsmailchimp' ),
							),
						),
					),
					array(
						'name'    => 'tags',
						'type'    => 'text',
						'class'   => 'medium merge-tag-support mt-position-right mt-hide_all_fields',
						'label'   => esc_html__( 'Tags', 'gravityformsmailchimp' ),
						'tooltip' => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Tags', 'gravityformsmailchimp' ),
							esc_html__( 'Associate tags to your Mailchimp contacts with a comma separated list (e.g. new lead, Gravity Forms, web source). Commas within a merge tag value will be created as a single tag.', 'gravityformsmailchimp' )
						),
					),
					array(
						'name'  => 'note',
						'type'  => 'textarea',
						'class' => 'medium merge-tag-support mt-position-right mt-hide_all_fields',
						'label' => esc_html__( 'Note', 'gravityformsmailchimp' ),
					),
					array(
						'name'    => 'optinCondition',
						'label'   => esc_html__( 'Conditional Logic', 'gravityformsmailchimp' ),
						'type'    => 'feed_condition',
						'tooltip' => sprintf(
							'<h6>%s</h6>%s',
							esc_html__( 'Conditional Logic', 'gravityformsmailchimp' ),
							esc_html__( 'When conditional logic is enabled, form submissions will only be exported to Mailchimp when the conditions are met. When disabled all form submissions will be exported.', 'gravityformsmailchimp' )
						),
					),
					array(
						'type'       => 'save',
						'dependency' => 'mailchimpList',
					),
				),
			),
		);

		// Get currently selected list/audience.
		$list = $this->get_setting( 'mailchimpList' );

		// If a list/audience is selected, get marketing permissions and add setting.
		if ( $list ) {

			$list = $this->api->get_list( $list );

			if ( is_wp_error( $list ) ) {
				$this->log_error( __METHOD__ . '(): Unable to add Marketing Permissions field because audience could not be retrieved; ' . $list->get_error_message() );
			} elseif ( rgar( $list, 'marketing_permissions' ) ) {

				// Prepare setting.
				$setting = array(
					'name'    => 'marketingPermissions',
					'label'   => esc_html__( 'Marketing Permissions', 'gravityformsmailchimp' ),
					'type'    => 'marketing_permissions',
					'tooltip' => sprintf(
						'<h6>%s</h6>%s',
						esc_html__( 'Marketing Permissions', 'gravityformsmailchimp' ),
						esc_html__( 'When enabled and conditions are met, users will be opted into your Mailchimp audience marketing permissions. If a user is already subscribed to your audience, they will not be opted out of permissions they are already opted into.', 'gravityformsmailchimp' )
					),
				);

				// Add setting.
				$settings = $this->add_field_after( 'interestCategories', $setting, $settings );

			}

		}

		return $settings;

	}

	/**
	 * Define the markup for the mailchimp_list type field.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param array $field The field properties.
	 * @param bool  $echo  Should the setting markup be echoed. Defaults to true.
	 *
	 * @return string
	 */
	public function settings_mailchimp_list( $field, $echo = true ) {

		// Initialize HTML string.
		$html = '';

		// If API is not initialized, return.
		if ( ! $this->initialize_api() ) {
			return $html;
		}

		// Prepare list/audience request parameters.
		$params = array( 'start' => 0, 'limit' => 100 );

		// Filter parameters.
		$params = apply_filters( 'gform_mailchimp_lists_params', $params );

		// Convert start parameter to 3.0.
		if ( isset( $params['start'] ) ) {
			$params['offset'] = $params['start'];
			unset( $params['start'] );
		}

		// Convert limit parameter to 3.0.
		if ( isset( $params['limit'] ) ) {
			$params['count'] = $params['limit'];
			unset( $params['limit'] );
		}

		$this->log_debug( __METHOD__ . '(): Retrieving contact audiences; params: ' . print_r( $params, true ) );
		$lists = $this->api->get_lists( $params );

		if ( is_wp_error( $lists ) ) {
			$this->log_error( __METHOD__ . '(): Could not retrieve Mailchimp contact audiences; ' . $lists->get_error_message() );

			// Display error message.
			$html = sprintf( esc_html__( 'Could not load Mailchimp contact audiences. %sError: %s', 'gravityformsmailchimp' ), '<br/>', $lists->get_error_message() );
			if ( $echo ) {
				echo $html;
			}

			return $html;
		}

		// If no lists/audiences were found, display error message.
		if ( 0 === $lists['total_items'] ) {

			// Log that no lists/audiences were found.
			$this->log_error( __METHOD__ . '(): Could not load Mailchimp contact audiences; no audiences found.' );

			// Display error message.
			$html = sprintf( esc_html__( 'Could not load Mailchimp contact audiences. %sError: %s', 'gravityformsmailchimp' ), '<br/>', esc_html__( 'No audiences found.', 'gravityformsmailchimp' ) );
			if ( $echo ) {
				echo $html;
			}

			return $html;

		}

		// Log number of lists/audiences retrieved.
		$this->log_debug( __METHOD__ . '(): Number of audiences: ' . count( $lists['lists'] ) );

		// Initialize select options.
		$options = array(
			array(
				'label' => esc_html__( 'Select a Mailchimp Audience', 'gravityformsmailchimp' ),
				'value' => '',
			),
		);

		// Loop through Mailchimp lists/audiences.
		foreach ( $lists['lists'] as $list ) {

			// Add list/audience to select options.
			$options[] = array(
				'label' => esc_html( $list['name'] ),
				'value' => esc_attr( $list['id'] ),
			);

		}

		// Add select field properties.
		$field['type']     = 'select';
		$field['choices']  = $options;
		$field['onchange'] = 'jQuery(this).parents("form").submit();';

		// Generate select field.
		$html = $this->settings_select( $field, false );

		if ( $echo ) {
			echo $html;
		}

		return $html;

	}

	/**
	 * Return an array of Mailchimp list/audience fields which can be mapped to the Form fields/entry meta.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @return array
	 */
	public function merge_vars_field_map() {

		// Initialize field map array.
		$field_map = array(
			'EMAIL' => array(
				'name'       => 'EMAIL',
				'label'      => esc_html__( 'Email Address', 'gravityformsmailchimp' ),
				'required'   => true,
				'field_type' => array( 'email', 'hidden' ),
			),
		);

		// If unable to initialize API, return field map.
		if ( ! $this->initialize_api() ) {
			return $field_map;
		}

		// Get current list/audience ID.
		$list_id = $this->get_setting( 'mailchimpList' );

		// Get merge fields.
		$merge_fields = $this->get_list_merge_fields( $list_id );

		// If merge fields exist, add to field map.
		if ( ! empty( $merge_fields['merge_fields'] ) ) {

			// Loop through merge fields.
			foreach ( $merge_fields['merge_fields'] as $merge_field ) {

				// Define required field type.
				$field_type = null;

				// If this is an email merge field, set field types to "email" or "hidden".
				if ( 'EMAIL' === strtoupper( $merge_field['tag'] ) ) {
					$field_type = array( 'email', 'hidden' );
				}

				// If this is an address merge field, set field type to "address".
				if ( 'address' === $merge_field['type'] ) {
					$field_type = array( 'address' );
				}

				// Add to field map.
				$field_map[ $merge_field['tag'] ] = array(
					'name'       => $merge_field['tag'],
					'label'      => $merge_field['name'],
					'required'   => $merge_field['required'],
					'field_type' => $field_type,
				);

			}

		}

		return $field_map;
	}

	/**
	 * Prevent feeds being listed or created if the API key isn't valid.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @return bool
	 */
	public function can_create_feed() {

		return $this->initialize_api();

	}

	/**
	 * Allow the feed to be duplicated.
	 *
	 * @since 4.7
	 *
	 * @param array|int $id The ID of the feed to be duplicated or the feed object when duplicating a form.
	 *
	 * @return bool
	 */
	public function can_duplicate_feed( $id ) {

		return true;

	}

	/**
	 * Configures which columns should be displayed on the feed list page.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @return array
	 */
	public function feed_list_columns() {

		return array(
			'feedName'            => esc_html__( 'Name', 'gravityformsmailchimp' ),
			'mailchimp_list_name' => esc_html__( 'Mailchimp List', 'gravityformsmailchimp' ),
		);

	}

	/**
	 * Returns the value to be displayed in the Mailchimp List/Audience column.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param array $feed The feed being included in the feed list/audience.
	 *
	 * @return string
	 */
	public function get_column_value_mailchimp_list_name( $feed ) {

		// If unable to initialize API, return the list/audience ID.
		if ( ! $this->initialize_api() ) {
			return rgars( $feed, 'meta/mailchimpList' );
		}

		$list = $this->api->get_list( rgars( $feed, 'meta/mailchimpList' ) );

		if ( is_wp_error( $list ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get Mailchimp audience for feed list; ' . $list->get_error_message() );

			// Return list/audience ID.
			return rgars( $feed, 'meta/mailchimpList' );
		}

		return rgar( $list, 'name' );
	}

	/**
	 * Define the markup for the interest categories type field.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @param array $field The field properties.
	 * @param bool  $echo  Should the setting markup be echoed.
	 *
	 * @return string
	 */
	public function settings_interest_categories( $field, $echo = true ) {

		// Get interest categories.
		$categories = $this->get_interest_categories();

		// If no categories are found, return.
		if ( empty( $categories ) ) {
			$this->log_debug( __METHOD__ . '(): No categories found.' );

			return '';
		}

		// Start field markup.
		$html = "<div id='gaddon-mailchimp_interest_categories'>";

		// Loop through interest categories.
		foreach ( $categories as $category ) {

			// Open category container.
			$html .= '<div class="gaddon-mailchimp-category">';

			// Define label.
			$label = rgar( $category, 'title' );

			// Display category label.
			$html .= '<div class="gaddon-mailchimp-categoryname">' . esc_html( $label ) . '</div><div class="gf_animate_sub_settings">';

			// Get interests category interests.
			$interests = $this->api->get_interest_category_interests( $category['list_id'], $category['id'] );

			// Loop through interests.
			foreach ( $interests as $interest ) {

				// Define interest key.
				$interest_key = 'interestCategory_' . $interest['id'];

				// Define enabled checkbox key.
				$enabled_key = $interest_key . '_enabled';

				// Get interest checkbox markup.
				$html .= $this->settings_checkbox(
					array(
						'name'    => esc_html( $interest['name'] ),
						'type'    => 'checkbox',
						'onclick' => "if(this.checked){jQuery('#{$interest_key}_condition_container').slideDown();} else{jQuery('#{$interest_key}_condition_container').slideUp();}",
						'choices' => array(
							array(
								'name'  => $enabled_key,
								'label' => esc_html( $interest['name'] ),
							),
						),
					),
					false
				);

				$html .= $this->interest_category_condition( $interest_key );

			}

			$html .= '</div></div>';
		}

		$html .= '</div>';

		if ( $echo ) {
			echo $html;
		}

		return $html;

	}

	/**
	 * Define the markup for the interest category conditional logic.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @param string $setting_name_root The category setting key.
	 *
	 * @return string
	 */
	public function interest_category_condition( $setting_name_root ) {

		$condition_enabled_setting = "{$setting_name_root}_enabled";
		$is_enabled                = $this->get_setting( $condition_enabled_setting ) == '1';
		$container_style           = ! $is_enabled ? "style='display:none;'" : '';

		$str = "<div id='{$setting_name_root}_condition_container' {$container_style} class='condition_container gform-settings-field__conditional-logic'>" .
		       esc_html__( 'Assign to group:', 'gravityformsmailchimp' ) . ' ';

		$str .= $this->settings_select(
			array(
				'name'     => "{$setting_name_root}_decision",
				'type'     => 'select',
				'choices'  => array(
					array(
						'value' => 'always',
						'label' => esc_html__( 'Always', 'gravityformsmailchimp' )
					),
					array(
						'value' => 'if',
						'label' => esc_html__( 'If', 'gravityformsmailchimp' )
					),
				),
				'onchange' => "if(jQuery(this).val() == 'if'){jQuery('#{$setting_name_root}_decision_container').show();}else{jQuery('#{$setting_name_root}_decision_container').hide();}",
			), false
		);

		$decision = $this->get_setting( "{$setting_name_root}_decision" );
		if ( empty( $decision ) ) {
			$decision = 'always';
		}

		$conditional_style = $decision == 'always' ? "style='display:none;'" : '';

		$str .= '   <span id="' . $setting_name_root . '_decision_container" class="gform-settings-simple-condition gf_conditional_logic_rules_container" ' . $conditional_style . '><br />' .
		        $this->simple_condition( $setting_name_root, $is_enabled ) .
		        '   </span>' .

		        '</div>';

		return $str;

	}

	/**
	 * Define the markup for the Marketing Permissions feed settings field.
	 *
	 * @since  4.6
	 * @access public
	 *
	 * @param array $field The field properties.
	 * @param bool  $echo  Should the setting markup be echoed.
	 *
	 * @return string
	 */
	public function settings_marketing_permissions( $field, $echo = true ) {

		// Get current list/audience.
		$list = $this->get_setting( 'mailchimpList' );

		// Get marketing permissions.
		$permissions = $this->get_marketing_permissions( $list );

		// If permissions are not available, display error message.
		if ( ! $permissions ) {

			$html = esc_html__( 'You must have at least one audience subscriber to configure Marketing Permissions.', 'gravityformsmailchimp' );
			$html .= '&nbsp;' . gform_tooltip( esc_html__( "Due to limitations with Mailchimp's API, we are only able to get available Marketing Permissions when the selected audience has at least one subscriber.", 'gravityformsmailchimp' ), '', true );

			if ( $echo ) {
				echo $html;
			}

			return $html;

		}

		// Start field markup.
		$html = "<div id='gaddon-mailchimp_marketing_permissions'>";

		// Loop through marketing permissions, add conditional logic for each.
		foreach ( $permissions as $permission ) {

			// Prepare permission key.
			$permission_key = $field['name'] . '_' . $permission['marketing_permission_id'];

			// Open category container.
			$html .= '<div class="gaddon-mailchimp-permission">';

			// Display toggle checkbox.
			$html .= $this->settings_checkbox(
				array(
					'name'    => esc_html( $permission['marketing_permission_id'] ),
					'type'    => 'checkbox',
					'choices' => array(
						array(
							'name'    => $permission_key . '_enabled',
							'label'   => esc_html( $permission['text'] ),
							'class'   => 'gaddon-mailchimp-permission-toggle',
							'onclick' => "if(this.checked){jQuery('#{$permission_key}_condition_container').slideDown();} else{jQuery('#{$permission_key}_condition_container').slideUp();}",
						),
					),
				),
				false
			);

			// Display condition field for permission.
			$html .= $this->marketing_permissions_condition( $permission_key );

			$html .= '</div>';

		}

		$html .= '</div>';

		if ( $echo ) {
			echo $html;
		}

		return $html;

	}

	/**
	 * Define the markup for the Marketing Permissions conditional logic.
	 *
	 * @since  4.6
	 * @access public
	 *
	 * @param string $setting_name_root The category setting key.
	 *
	 * @return string
	 */
	public function marketing_permissions_condition( $setting_name_root ) {

		$condition_enabled_setting = "{$setting_name_root}_enabled";
		$is_enabled                = '1' === $this->get_setting( $condition_enabled_setting );
		$container_style           = ! $is_enabled ? "style='display:none;'" : '';

		$str = sprintf(
			'<div id="%s_condition_container" %s class="condition_container gf_animate_sub_settings gform-settings-field__conditional-logic"><span id="%s_condition_label" class="condition_label">%s</span>',
			$setting_name_root,
			$container_style,
			$setting_name_root,
			esc_html__( 'Enable permission if:', 'gravityformsmailchimp' )
		);


		$str .= '   <span id="' . $setting_name_root . '_decision_container" class="gform-settings-simple-condition gf_conditional_logic_rules_container"><br />' .
		        $this->simple_condition( $setting_name_root, $is_enabled ) .
		        '   </span>' .

		        '</div>';

		return $str;

	}


	/**
	 * Define which field types can be used for the group conditional logic.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @uses GFAddOn::get_current_form()
	 * @uses GFCommon::get_label()
	 * @uses GF_Field::get_entry_inputs()
	 * @uses GF_Field::get_input_type()
	 * @uses GF_Field::is_conditional_logic_supported()
	 *
	 * @return array
	 */
	public function get_conditional_logic_fields() {

		// Initialize conditional logic fields array.
		$fields = array();

		// Get the current form.
		$form = $this->get_current_form();

		/**
		 * Loop through the form fields.
		 *
		 * @var GF_Field $field
		 */
		foreach ( $form['fields'] as $field ) {

			// If this field does not support conditional logic, skip it.
			if ( ! $field->is_conditional_logic_supported() ) {
				continue;
			}

			// Get field inputs.
			$inputs = $field->get_entry_inputs();

			// If field has multiple inputs, add them as individual field options.
			if ( $inputs && 'checkbox' !== $field->get_input_type() ) {

				// Loop through the inputs.
				foreach ( $inputs as $input ) {

					// If this is a hidden input, skip it.
					if ( rgar( $input, 'isHidden' ) ) {
						continue;
					}

					// Add input to conditional logic fields array.
					$fields[] = array(
						'value' => $input['id'],
						'label' => GFCommon::get_label( $field, $input['id'] ),
					);

				}

			} else {

				// Add field to conditional logic fields array.
				$fields[] = array(
					'value' => $field->id,
					'label' => GFCommon::get_label( $field ),
				);

			}

		}

		return $fields;

	}

	/**
	 * Define the markup for the double_optin checkbox input.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param array  $choice     The choice properties.
	 * @param string $attributes The attributes for the input tag.
	 * @param string $value      Is choice selected (1 if field has been checked. 0 or null otherwise).
	 * @param string $tooltip    The tooltip for this checkbox item.
	 *
	 * @return string
	 */
	public function checkbox_input_double_optin( $choice, $attributes, $value, $tooltip ) {

		// Get checkbox input markup.
		$markup = $this->checkbox_input( $choice, $attributes, $value, $tooltip );

		// Define visibility status of warning.
		$display = $value ? 'none' : 'block-inline';

		// Add warning to checkbox markup.
		$markup .= '<span id="mailchimp_doubleoptin_warning" style="padding-left: 10px; font-size: 10px; display:' . $display . '">(' . esc_html__( 'Abusing this may cause your Mailchimp account to be suspended.', 'gravityformsmailchimp' ) . ')</span>';

		return $markup;

	}





	// # FEED PROCESSING -----------------------------------------------------------------------------------------------

	/**
	 * Process the feed, subscribe the user to the list/audience.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param array $feed  The feed object to be processed.
	 * @param array $entry The entry object currently being processed.
	 * @param array $form  The form object currently being processed.
	 *
	 * @return array|WP_Error
	 */
	public function process_feed( $feed, $entry, $form ) {

		// Log that we are processing feed.
		$this->log_debug( __METHOD__ . '(): Processing feed.' );

		// If unable to initialize API, log error and return.
		if ( ! $this->initialize_api() ) {
			$this->add_feed_error( esc_html__( 'Unable to process feed because API could not be initialized.', 'gravityformsmailchimp' ), $feed, $entry, $form );

			return new WP_Error( 'api_not_initialized', 'API was not initialized.' );
		}

		// Set current merge variable name.
		$this->merge_var_name = 'EMAIL';

		// Get field map values.
		$field_map = $this->get_field_map_fields( $feed, 'mappedFields' );

		// Get mapped email address.
		$email = $this->get_field_value( $form, $entry, $field_map['EMAIL'] );

		// If email address is invalid, log error and return.
		if ( GFCommon::is_invalid_or_empty_email( $email ) ) {
			$this->add_feed_error( esc_html__( 'A valid Email address must be provided.', 'gravityformsmailchimp' ), $feed, $entry, $form );

			return new WP_Error( 'invalid_email', 'Invalid email address.' );
		}

		$member = $this->get_existing_member( $email, $feed, $entry, $form );
		if ( is_wp_error( $member ) ) {
			return $member;
		}

		/**
		 * Modify whether a user that currently has a status of unsubscribed on your list/audience is resubscribed.
		 * By default, the user is resubscribed.
		 *
		 * @param bool $allow_resubscription If the user should be resubscribed.
		 * @param array $form                The form object.
		 * @param array $entry               The entry object.
		 * @param array $feed                The feed object.
		 */
		$allow_resubscription = gf_apply_filters( array( 'gform_mailchimp_allow_resubscription', $form['id'] ), true, $form, $entry, $feed );

		if ( 'unsubscribed' === rgar( $member, 'status' ) && ! $allow_resubscription ) {
			$this->log_debug( __METHOD__ . '(): Contact is unsubscribed and resubscription is not allowed.' );

			return $entry;
		}

		$subscription = array(
			'email_address'         => $email,
			'status_if_new'         => $this->get_subscription_status( (bool) rgars( $feed, 'meta/double_optin' ), $member, $feed, $entry, $form ),
			'email_type'            => 'html',
			'merge_fields'          => $this->get_subscription_merge_fields( $field_map, $feed, $entry, $form ),
			'interests'             => $this->get_subscription_interests( $member, $feed, $entry, $form ),
			'vip'                   => $this->is_vip( $member, $feed ),
			'marketing_permissions' => $this->get_subscription_marketing_permissions( $member, $feed, $entry, $form ),
			'ip_signup'             => rgar( $entry, 'ip' ),
			'tags'                  => $this->get_subscription_tags( $member, $feed, $entry, $form ),
			// note is not a supported property, including for filter, then removing.
			'note'                  => rgars( $feed, 'meta/note' ),
		);

		// Populate the legacy status property.
		$subscription['status'] = $subscription['status_if_new'];

		$list_id = rgars( $feed, 'meta/mailchimpList' );

		$subscription = $this->filter_subscription( $subscription, $list_id, $member, $feed, $entry, $form );

		// Remove note from the subscription object and process any merge tags.
		$note = GFCommon::replace_variables( $subscription['note'], $form, $entry, false, true, false, 'text' );
		unset( $subscription['note'] );

		$action = ! empty( $member ) ? 'updated' : 'added';

		$this->log_debug( __METHOD__ . "(): Contact to be {$action}: " . print_r( $subscription, true ) );
		$result = $this->api->update_list_member( $list_id, $subscription['email_address'], $subscription );

		if ( is_wp_error( $result ) ) {
			$note = empty( $member ) ? esc_html__( 'Unable to add contact: %s', 'gravityformsmailchimp' ) : esc_html__( 'Unable to update contact. %s', 'gravityformsmailchimp' );
			$this->add_feed_error( sprintf( $note, $result->get_error_message() ), $feed, $entry, $form );

			$error_data = $result->get_error_data();
			if ( ! empty( $error_data ) ) {
				$this->log_error( __METHOD__ . '(): Field errors: ' . print_r( $error_data, true ) );
			}

			return $result;
		}

		$this->log_debug( __METHOD__ . "(): Contact successfully {$action}. Result: " . json_encode( $result ) );

		$message = empty( $member ) ? esc_html__( 'Contact added. ID: %s.', 'gravityformsmailchimp' ) : esc_html__( 'Contact updated. ID: %s.', 'gravityformsmailchimp' );
		$this->add_note( rgar( $entry, 'id' ), sprintf( $message, rgar( $result, 'contact_id' ) ), 'success' );

		if ( ! $note ) {
			// Abort as there is no note to process.
			return $entry;
		}

		$result = $this->api->add_member_note( $list_id, $subscription['email_address'], $note );

		if ( is_wp_error( $result ) ) {
			$this->add_feed_error( sprintf( esc_html__( 'Unable to add note to contact: %s', 'gravityformsmailchimp' ), $result->get_error_message() ), $feed, $entry, $form );

			return $result;
		}

		$this->log_debug( __METHOD__ . '(): Note successfully added to contact.' );

		return $entry;
	}

	/**
	 * Returns the existing member details for the given email address.
	 *
	 * @since 5.5
	 *
	 * @param string $email The email address.
	 * @param array  $feed  The feed currently being processed.
	 * @param array  $entry The entry currently being processed.
	 * @param array  $form  The form currently being processed.
	 *
	 * @return array|false|WP_Error
	 */
	public function get_existing_member( $email, $feed, $entry, $form ) {
		$this->log_debug( __METHOD__ . "(): Checking to see if $email is already on the audience." );

		$member = $this->api->get_list_member( rgars( $feed, 'meta/mailchimpList' ), $email );

		if ( is_wp_error( $member ) ) {
			// If the exception code is not 404, abort feed processing.
			if ( 404 !== $member->get_error_code() ) {
				$this->add_feed_error( sprintf( esc_html__( 'Unable to check if email address is already used by a contact: %s', 'gravityformsmailchimp' ), $e->getMessage() ), $feed, $entry, $form );

				return new WP_Error( $e->getCode(), $e->getMessage(), $e->getErrors() );
			}

			$this->log_debug( __METHOD__ . "(): $email was not found on audience." );

			return false;
		}

		$this->log_debug( __METHOD__ . "(): $email was found on audience. Status: {$member['status']}" );

		return $member;
	}

	/**
	 * Returns the status to be added to the subscription array.
	 *
	 * Also, if the member already exists with a status is pending, and double opt-in is enabled, the status is patched to unsubscribed.
	 * This is so Mailchimp will send the opt-in email when the status changes back to pending on the update member request.
	 *
	 * @since 5.4
	 *
	 * @param bool        $double_optin Indicates if double opt-in is enabled.
	 * @param false|array $member       False or the existing member properties.
	 * @param array       $feed         The feed currently being processed.
	 * @param array       $entry        The entry currently being processed.
	 * @param array       $form         The form currently being processed.
	 *
	 * @return string
	 */
	private function get_subscription_status( $double_optin, $member, $feed, $entry, $form ) {
		$existing_status = rgar( $member, 'status' );
		if ( ! $double_optin || $existing_status === 'subscribed' ) {
			return 'subscribed';
		}

		if ( $existing_status === 'pending' ) {
			$this->log_debug( __METHOD__ . '(): Patching contact status for opt-in.' );
			$result = $this->api->update_list_member( rgar( $member, 'list_id' ), rgar( $member, 'email_address' ), array( 'status' => 'unsubscribed' ), 'PATCH' );

			if ( is_wp_error( $result ) ) {
				$this->add_feed_error( sprintf( esc_html__( __METHOD__ . '(): Unable to update contact status: %s', 'gravityformsmailchimp' ), $result->get_error_message() ), $feed, $entry, $form );

				$error_data = $result->get_error_data();
				if ( ! empty( $error_data ) ) {
					$this->log_error( __METHOD__ . '(): Error when attempting to update contact status: ' . print_r( $error_data, true ) );
				}
			}

			$this->log_debug( __METHOD__ . '(): Contact status successfully updated.' );
		}

		return 'pending';
	}

	/**
	 * Prepares the merge fields data for the member.
	 *
	 * @since 5.5
	 *
	 * @param array $field_map The mappings from the mappedFields setting.
	 * @param array $feed      The feed currently being processed.
	 * @param array $entry     The entry currently being processed.
	 * @param array $form      The form currently being processed.
	 *
	 * @return array
	 */
	public function get_subscription_merge_fields( $field_map, $feed, $entry, $form ) {
		/**
		 * Prevent empty form fields erasing values already stored in the mapped Mailchimp MMERGE fields
		 * when updating an existing subscriber.
		 *
		 * @param bool  $override If the merge field should be overridden.
		 * @param array $form     The form object.
		 * @param array $entry    The entry object.
		 * @param array $feed     The feed object.
		 */
		$override_empty_fields = gf_apply_filters( 'gform_mailchimp_override_empty_fields', array( $form['id'] ), true, $form, $entry, $feed );

		// Log that empty fields will not be overridden.
		if ( ! $override_empty_fields ) {
			$this->log_debug( __METHOD__ . '(): Empty fields will not be overridden.' );
		}

		// Initialize array to store merge vars.
		$merge_vars = array();

		// Loop through field map.
		foreach ( $field_map as $name => $field_id ) {

			// If no field is mapped, skip it.
			if ( rgblank( $field_id ) ) {
				continue;
			}

			// If this is the email field, skip it.
			if ( strtoupper( $name ) === 'EMAIL' ) {
				continue;
			}

			// Set merge var name to current field map name.
			$this->merge_var_name = $name;

			// Get field object.
			$field = GFFormsModel::get_field( $form, $field_id );

			// Get field value.
			$field_value = $this->get_field_value( $form, $entry, $field_id );

			// If field value is empty and we are not overriding empty fields, skip it.
			if ( empty( $field_value ) && ( ! $override_empty_fields || ( is_object( $field ) && 'address' === $field->get_input_type() ) ) ) {
				continue;
			}

			// Get merge field.
			$merge_field = $this->get_list_merge_field( rgars( $feed, 'meta/mailchimpList' ), $name );

			// Format date field.
			if ( ! empty( $field_value ) && ! empty( $merge_field ) && in_array( $merge_field['type'], array(
					'date',
					'birthday',
				) ) ) {

				// Get date format.
				$date_format = $merge_field['options']['date_format'];

				// Convert field value to timestamp.
				$field_value_timestamp = strtotime( $field_value );

				// Format date.
				switch ( $date_format ) {

					case 'DD/MM':
					case 'MM/DD':
						$field_value = date( 'm/d', $field_value_timestamp );
						break;

					case 'DD/MM/YYYY':
					case 'MM/DD/YYYY':
						$field_value = date( 'm/d/Y', $field_value_timestamp );
						break;

				}

			}

			$merge_vars[ $name ] = $field_value;

		}

		return $merge_vars;
	}

	/**
	 * Prepares the interests data for the member.
	 *
	 * @since 5.5
	 *
	 * @param false|array $member False or the existing member properties.
	 * @param array       $feed   The feed currently being processed.
	 * @param array       $entry  The entry currently being processed.
	 * @param array       $form   The form currently being processed.
	 *
	 * @return array
	 */
	public function get_subscription_interests( $member, $feed, $entry, $form ) {
		/**
		 * Modify whether a user that is already subscribed to your list/audience has their groups replaced when submitting the form a second time.
		 *
		 * @since 1.9
		 *
		 * @param bool  $keep_existing_interests Should user keep existing interest categories?
		 * @param array $form                    The form object.
		 * @param array $entry                   The entry object.
		 * @param array $feed                    The feed object.
		 */
		$keep_existing_interests = gf_apply_filters( array( 'gform_mailchimp_keep_existing_groups', $form['id'], ), true, $form, $entry, $feed );


		$interests_to_keep      = array();
		$existing_interests     = rgar( $member, 'interests', array() );
		$subscription_interests = $existing_interests;

		// If member was found, has existing interests and we are not keeping existing interest categories, remove them.
		if ( ! empty( $existing_interests ) ) {

			// Loop through existing interests.
			foreach ( $existing_interests as $interest_id => $interest_enabled ) {

				// If interest is not enabled, skip it.
				if ( ! $interest_enabled ) {
					continue;
				}

				// If we are keeping existing interests, add to array.
				if ( $keep_existing_interests ) {

					$interests_to_keep[] = $interest_id;
					continue;

				} else {

					// Disable interest in new subscription.
					$subscription_interests[ $interest_id ] = false;

				}

			}

		}

		// Get interest categories.
		$categories = $this->get_feed_setting_conditions( $feed );

		// Loop through categories.
		foreach ( $categories as $category_id => $category_meta ) {

			// If category is not enabled or the category is one we are keeping, skip it.
			if ( ! rgar( $category_meta, 'enabled' ) || in_array( $category_id, $interests_to_keep ) ) {
				continue;
			}

			// Log that we are evaluating the category conditions.
			$this->log_debug( __METHOD__ . '(): Evaluating condition for interest category "' . $category_id . '": ' . print_r( $category_meta, true ) );

			// Get condition evaluation.
			$condition_evaluation = $this->is_category_condition_met( $category_meta, $form, $entry );

			// Set interest category based on evaluation.
			$subscription_interests[ $category_id ] = $condition_evaluation;

		}

		return $subscription_interests;
	}

	/**
	 * Determines if the member is a VIP.
	 *
	 * @since 5.5
	 *
	 * @param false|array $member False or the existing member properties.
	 * @param array       $feed   The feed currently being processed.
	 *
	 * @return bool
	 */
	public function is_vip( $member, $feed ) {
		if ( ! empty( $member['vip'] ) ) {
			return true;
		}

		return (bool) rgars( $feed, 'meta/markAsVIP' );
	}

	/**
	 * Prepares the marketing permissions data for the member.
	 *
	 * @since 5.5
	 *
	 * @param false|array $member False or the existing member properties.
	 * @param array       $feed   The feed currently being processed.
	 * @param array       $entry  The entry currently being processed.
	 * @param array       $form   The form currently being processed.
	 *
	 * @return array
	 */
	public function get_subscription_marketing_permissions( $member, $feed, $entry, $form ) {
		$feed_permissions = $this->get_feed_setting_conditions( $feed, 'marketingPermissions' );

		if ( empty( $feed_permissions ) ) {
			return array();
		}

		$permissions = array();

		// If member already exists, only update newly enabled permissions.
		if ( ! empty( $member['marketing_permissions'] ) ) {

			// Loop through existing Marketing Permissions, check condition.
			foreach ( $member['marketing_permissions'] as $existing_permission ) {

				// If permission is already enabled, keep it that way.
				if ( $existing_permission['enabled'] ) {
					$permissions[] = $existing_permission;
					continue;
				}

				// If this permission is not configured, skip.
				if ( ! rgar( $feed_permissions, $existing_permission['marketing_permission_id'] ) ) {
					continue;
				}

				// Check condition and add to subscription.
				$permissions[] = array(
					'marketing_permission_id' => (string) $existing_permission['marketing_permission_id'],
					'enabled'                 => $this->is_marketing_permission_condition_met( $permissions[ $existing_permission['marketing_permission_id'] ], $form, $entry ),
				);

			}

		} else {

			// Loop through permissions, add if enabled.
			foreach ( $feed_permissions as $permission_id => $permission ) {

				// Add to subscription.
				$permissions[] = array(
					'marketing_permission_id' => (string) $permission_id,
					'enabled'                 => $this->is_marketing_permission_condition_met( $permission, $form, $entry ),
				);

			}

		}

		return $permissions;
	}

	/**
	 * Prepares the tags to be assigned to the member.
	 *
	 * @since 5.5
	 *
	 * @param false|array $member False or the existing member properties.
	 * @param array       $feed   The feed currently being processed.
	 * @param array       $entry  The entry currently being processed.
	 * @param array       $form   The form currently being processed.
	 *
	 * @return array
	 */
	public function get_subscription_tags( $member, $feed, $entry, $form ) {
		$tags = explode( ',', rgars( $feed, 'meta/tags' ) );
		$tags = array_map( 'trim', $tags );

		// Prepare tags.
		if ( ! empty( $tags ) ) {

			// Loop through tags, replace merge tags.
			foreach ( $tags as &$tag ) {
				$tag = GFCommon::replace_variables( $tag, $form, $entry, false, false, false, 'text' );
				$tag = trim( $tag );
			}

			// Remove empty tags.
			$tags = array_filter( $tags );

		}

		// Get existing tags.
		$existing_tags = $member ? wp_list_pluck( $member['tags'], 'name' ) : array();

		if ( empty( $existing_tags ) ) {
			return array_unique( $tags );
		}

		$tags = empty( $tags ) ? $existing_tags : array_merge( $existing_tags, $tags );

		return array_unique( $tags );
	}

	/**
	 * Allows the subscription to be filtered and cleans-up some properties.
	 *
	 * @since 5.5
	 *
	 * @param array       $subscription Subscription arguments.
	 * @param string      $list_id      Mailchimp list/audience ID.
	 * @param false|array $member       False or the existing member properties.
	 * @param array       $feed         The feed currently being processed.
	 * @param array       $entry        The entry currently being processed.
	 * @param array       $form         The form currently being processed.
	 *
	 * @return array
	 */
	public function filter_subscription( $subscription, $list_id, $member, $feed, $entry, $form ) {

		/**
		 * Modify the subscription object before it is executed.
		 *
		 * @since 4.1.9 Added existing member object as $member parameter.
		 *
		 * @param array       $subscription Subscription arguments.
		 * @param string      $list_id      Mailchimp list/audience ID.
		 * @param array       $form         The form object.
		 * @param array       $entry        The entry object.
		 * @param array       $feed         The feed object.
		 * @param array|false $member       The existing member object. (False if member does not currently exist in Mailchimp.)
		 */
		$subscription = gf_apply_filters( array( 'gform_mailchimp_subscription', $form['id'] ), $subscription, $list_id, $form, $entry, $feed, $member );

		// Remove merge_fields if none are defined, otherwise allows merge_fields to be decoded.
		if ( empty( $subscription['merge_fields'] ) ) {
			unset( $subscription['merge_fields'] );
		} else {
			foreach ( $subscription['merge_fields'] as $key => $value ) {
				if ( is_string( $value ) ) {
					$subscription['merge_fields'][ $key ] = html_entity_decode( $value );
				}
			}
		}

		// Remove interests if none are defined.
		if ( empty( $subscription['interests'] ) ) {
			unset( $subscription['interests'] );
		}

		// Remove VIP if not enabled.
		if ( ! $subscription['vip'] ) {
			unset( $subscription['vip'] );
		}

		// Remove or reindex the tags.
		if ( empty( $subscription['tags'] ) ) {
			unset( $subscription['tags'] );
		} else {
			$subscription['tags'] = array_values( $subscription['tags'] );
		}

		return $subscription;
	}

	/**
	 * Returns the value of the selected field.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param array  $form     The form object currently being processed.
	 * @param array  $entry    The entry object currently being processed.
	 * @param string $field_id The ID of the field being processed.
	 *
	 * @uses GFAddOn::get_full_name()
	 * @uses GF_Field::get_value_export()
	 * @uses GFFormsModel::get_field()
	 * @uses GFFormsModel::get_input_type()
	 * @uses GFMailChimp::get_full_address()
	 * @uses GFMailChimp::maybe_override_field_value()
	 *
	 * @return array|string
	 */
	public function get_field_value( $form, $entry, $field_id ) {

		// Set initial field value.
		$field_value = '';

		// Set field value based on field ID.
		switch ( strtolower( $field_id ) ) {

			// Form title.
			case 'form_title':
				$field_value = rgar( $form, 'title' );
				break;

			// Entry creation date.
			case 'date_created':

				// Get entry creation date from entry.
				$date_created = rgar( $entry, strtolower( $field_id ) );

				// If date is not populated, get current date.
				$field_value = empty( $date_created ) ? gmdate( 'Y-m-d H:i:s' ) : $date_created;
				break;

			// Entry IP and source URL.
			case 'ip':
			case 'source_url':
				$field_value = rgar( $entry, strtolower( $field_id ) );
				break;

			default:

				// Get field object.
				$field = GFFormsModel::get_field( $form, $field_id );

				if ( is_object( $field ) ) {

					// Check if field ID is integer to ensure field does not have child inputs.
					$is_integer = $field_id == intval( $field_id );

					// Get field input type.
					$input_type = GFFormsModel::get_input_type( $field );

					if ( $is_integer && 'address' === $input_type ) {

						// Get full address for field value.
						$field_value = $this->get_full_address( $entry, $field_id );

					} else if ( $is_integer && 'name' === $input_type ) {

						// Get full name for field value.
						$field_value = $this->get_full_name( $entry, $field_id );

					} else if ( $is_integer && 'checkbox' === $input_type ) {

						// Initialize selected options array.
						$selected = array();

						// Loop through checkbox inputs.
						foreach ( $field->inputs as $input ) {
							$index = (string) $input['id'];
							if ( ! rgempty( $index, $entry ) ) {
								$selected[] = $this->maybe_override_field_value( rgar( $entry, $index ), $form, $entry, $index );
							}
						}

						// Convert selected options array to comma separated string.
						$field_value = implode( ', ', $selected );

					} else if ( 'phone' === $input_type && $field->phoneFormat == 'standard' ) {

						// Get field value.
						$field_value = rgar( $entry, $field_id );

						// Reformat standard format phone to match Mailchimp format.
						// Format: NPA-NXX-LINE (404-555-1212) when US/CAN.
						if ( ! empty( $field_value ) && preg_match( '/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/', $field_value, $matches ) ) {
							$field_value = sprintf( '%s-%s-%s', $matches[1], $matches[2], $matches[3] );
						}

					} else {

						// Retrieve the value of the field in a format suitable for export
						$field_value = $field->get_value_export( $entry, $field_id );

					}

				} else {

					// Get field value from entry.
					$field_value = rgar( $entry, $field_id );

				}

		}

		return $this->maybe_override_field_value( $field_value, $form, $entry, $field_id );

	}

	/**
	 * Use the legacy gform_mailchimp_field_value filter instead of the framework gform_SLUG_field_value filter.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param string $field_value The field value.
	 * @param array  $form        The form object currently being processed.
	 * @param array  $entry       The entry object currently being processed.
	 * @param string $field_id    The ID of the field being processed.
	 *
	 * @return string
	 */
	public function maybe_override_field_value( $field_value, $form, $entry, $field_id ) {

		return gf_apply_filters( 'gform_mailchimp_field_value', array( $form['id'], $field_id ), $field_value, $form['id'], $field_id, $entry, $this->merge_var_name );

	}


	// # HELPERS -------------------------------------------------------------------------------------------------------

	/**
	 * Returns the currently saved plugin settings
	 *
	 * @since Unknown
	 *
	 * @return array|false
	 */
	public function get_plugin_settings() {
		$settings = get_option( 'gravityformsaddon_' . $this->_slug . '_settings' );

		if ( $this->is_connection_legacy() ) {
			$settings['access_token']  = $settings['apiKey'];
			$exploded_key              = explode( '-', $settings['apiKey'] );
			$settings['server_prefix'] = isset( $exploded_key[1] ) ? $exploded_key[1] : 'us1';
		}

		return $settings;
	}

	/**
	 * Determine whether a currently-existing connection to Mailchimp is using the legacy
	 * API Key paradigm.
	 *
	 * @since 4.10
	 *
	 * @return bool
	 */
	private function is_connection_legacy() {
		$settings = get_option( 'gravityformsaddon_' . $this->_slug . '_settings' );

		return ( ! isset( $settings['access_token'] ) && isset( $settings['apiKey'] ) );
	}

	/**
	 * Determine if the current connection to Mailchimp is valid (it connects without error and
	 * uses OAuth instead of an API Key)
	 *
	 * @since 4.10
	 *
	 * @return bool
	 */
	private function is_valid_connection() {
		return $this->initialize_api() && ! $this->is_connection_legacy();
	}

	/**
	 * Initializes Mailchimp API if credentials are valid.
	 *
	 * @since  4.0
	 * @since  4.10 - Deprecated API Key param.
	 *
	 * @access public
	 *
	 * @uses GFAddOn::get_plugin_setting()
	 * @uses GFAddOn::log_debug()
	 * @uses GFAddOn::log_error()
	 * @uses GF_MailChimp_API::account_details()
	 *
	 * @return bool|null
	 */
	public function initialize_api( $deprecated = null ) {

		if ( ! empty( $deprecated ) ) {
			_deprecated_argument( __METHOD__, '4.10' );
		}

		// If API is already initialized, return true.
		if ( ! is_null( $this->api ) ) {
			return is_object( $this->api );
		}

		// Log validation step.
		$this->log_debug( __METHOD__ . '(): Validating API Info.' );

		$this->maybe_update_auth_creds();

		$settings = $this->get_plugin_settings();

		if ( ! isset( $settings['access_token'] ) || ! isset( $settings['server_prefix'] ) ) {
			return false;
		}

		// Setup a new Mailchimp object with the API credentials.
		$mc = new GF_MailChimp_API( $settings['access_token'], $settings['server_prefix'] );

		$result = $mc->account_details();

		if ( is_wp_error( $result ) ) {
			$this->api = false;
			$this->log_error( __METHOD__ . '(): Unable to authenticate with Mailchimp; ' . $result->get_error_message() );

			return false;
		}

		$this->api = $mc;
		$this->log_debug( __METHOD__ . '(): Mailchimp successfully authenticated.' );

		return true;
	}

	/**
	 * Retrieve the interest groups for the list/audience.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @param string $list_id Mailchimp list/audience ID.
	 *
	 * @return array|bool
	 */
	private function get_interest_categories( $list_id = null ) {

		// If API is not initialized, return false.
		if ( ! $this->initialize_api() ) {
			return false;
		}

		// Get Mailchimp list/audience ID.
		if ( rgblank( $list_id ) ) {
			$list_id = $this->get_setting( 'mailchimpList' );
		}

		// If Mailchimp list/audience ID is not defined, return.
		if ( rgblank( $list_id ) ) {

			// Log that list/audience ID was not defined.
			$this->log_error( __METHOD__ . '(): Could not get Mailchimp interest categories because audience ID was not defined.' );

			return false;

		}

		$categories = $this->api->get_list_interest_categories( $list_id );

		if ( is_wp_error( $categories ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get interest categories for audience "' . $list_id . '"; ' . $categories->get_error_message() );

			return array();
		}

		return $categories;

	}

	/**
	 * Get available marketing permissions for a list/audience.
	 *
	 * @since  4.6
	 * @access public
	 *
	 * @param string $list_id Mailchimp List/Audience ID.
	 *
	 * @return array|bool
	 */
	private function get_marketing_permissions( $list_id ) {

		$cache_key = 'gravityformsmailchimp_permissions_' . $list_id;

		// Check cache for permissions.
		if ( $permissions = GFCache::get( $cache_key ) ) {
			return $permissions;
		}

		$list = $this->api->get_list( $list_id );

		if ( is_wp_error( $list ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get marketing permissions because audience could not be retrieved; ' . $list->get_error_message() );

			return false;
		}

		// If marketing permissions are disabled, return.
		if ( ! rgar( $list, 'marketing_permissions' ) ) {
			return false;
		}

		$members = $this->api->get_list_members( $list_id, array( 'count' => 1 ) );

		if ( is_wp_error( $members ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get marketing permissions because audience members could not be retrieved; ' . $members->get_error_message() );

			return false;
		}

		$member = rgar( $members, 'members' ) ? $members['members'][0] : false;

		// If list/audience has no members, create one.
		if ( ! $member ) {

			// Prepare member parameters.
			$member_params = array(
				'email_address' => 'mailchimp@gravityforms.com',
				'status'        => 'subscribed',
			);

			// Add member to list/audience.
			$member = $this->api->update_list_member( $list_id, $member_params['email_address'], $member_params );

			if ( is_wp_error( $member ) ) {
				$this->log_error( __METHOD__ . '(): Unable to create test audience member to retrieve marketing permissions; ' . $member->get_error_message() );

				return false;
			}

			$this->api->delete_list_member( $list_id, $member_params['email_address'] );

		}

		// Get marketing permissions from first member.
		$permissions = $member['marketing_permissions'];

		// Loop through permissions, remove enabled flag.
		foreach ( $permissions as $i => $permission ) {
			unset( $permissions[ $i ]['enabled'] );
		}

		// Cache permissions.
		GFCache::set( $cache_key, $permissions, true, 5 * MINUTE_IN_SECONDS );

		return $permissions;

	}

	/**
	 * Determines if Mailchimp list/audience has any defined interest categories.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @return bool
	 */
	public function has_interest_categories() {

		// Get interest categories.
		$categories = $this->get_interest_categories();

		return ! empty( $categories );

	}

	/**
	 * Retrieve the enabled conditions for a feed.
	 *
	 * @since  4.6 Update to be more generic to support marketing permissions.
	 * @since  4.0
	 *
	 * @param array  $feed    The feed object.
	 * @param string $name    The feed setting to get conditions for.
	 * @param bool   $enabled Return only enabled categories. Defaults to true.
	 *
	 * @return array
	 */
	public function get_feed_setting_conditions( $feed, $name = 'interestCategory', $enabled = true ) {

		// Initialize conditions array.
		$conditions = array();

		// Loop through feed meta.
		foreach ( $feed['meta'] as $key => $value ) {

			// If this is not the setting we're looking for, skip.
			if ( 0 !== strpos( $key, $name . '_' ) ) {
				continue;
			}

			// Explode the meta key.
			$key = explode( '_', $key );

			// Add value to conditions array.
			$conditions[ $key[1] ][ $key[2] ] = $value;

		}

		// If we are only returning enabled conditions, remove disabled conditions.
		if ( $enabled ) {

			// Loop through conditions.
			foreach ( $conditions as $condition_id => $condition_meta ) {

				// If condition is enabled, skip it.
				if ( '1' == $condition_meta['enabled'] ) {
					continue;
				}

				// Remove condition.
				unset( $conditions[ $condition_id ] );

			}

		}

		return $conditions;

	}

	/**
	 * Determine if the user should be subscribed to the interest category.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @param array $category The interest category properties.
	 * @param array $form     The form currently being processed.
	 * @param array $entry    The entry currently being processed.
	 *
	 * @uses GFFormsModel::get_field()
	 * @uses GFFormsModel::is_value_match()
	 * @uses GFMailChimp::get_field_value()
	 *
	 * @return bool
	 */
	public function is_category_condition_met( $category, $form, $entry ) {
		if ( ! rgar( $category, 'enabled' ) ) {
			$this->log_debug( __METHOD__ . '(): Interest category not enabled. Returning false.' );

			return false;
		}

		if ( rgar( $category, 'decision' ) == 'always' ) {
			$this->log_debug( __METHOD__ . '(): Interest category decision is always. Returning true.' );

			return true;
		}

		$category_field = rgar( $category, 'field' );
		$field          = GFFormsModel::get_field( $form, $category_field );

		if ( ! is_object( $field ) ) {
			$this->log_debug( __METHOD__ . "(): Field #{$category_field} not found. Returning true." );

			return true;
		}

		// Prepare values for field matching and log output.
		$category_value    = rgar( $category, 'value' );
		$category_operator = rgar( $category, 'operator' );
		$rule              = array_merge( $category, array( 'fieldId' => $field->id ) );

		// Check for the value match.
		$is_value_match = GFFormsModel::is_value_match(
			GFFormsModel::get_lead_field_value( $entry, $field ),
			$category_value,
			$category_operator,
			$field,
			$rule
		);

		$this->log_debug( __METHOD__ . "(): Add to interest category if field #{$category_field} value {$category_operator} '{$category_value}'. Is value match? " . var_export( $is_value_match, 1 ) );

		return $is_value_match;
	}


	/**
	 * Determine if the Marketing Permission should be enabled for user.
	 *
	 * @since  4.6
	 * @access public
	 *
	 * @param array $permission The Marketing Permission properties.
	 * @param array $form       The form currently being processed.
	 * @param array $entry      The entry currently being processed.
	 *
	 * @return bool
	 */
	public function is_marketing_permission_condition_met( $permission, $form, $entry ) {

		if ( ! $permission['enabled'] ) {
			$this->log_debug( __METHOD__ . '(): Marketing Permission not enabled. Returning false.' );

			return false;
		}

		// Get field.
		$field = GFFormsModel::get_field( $form, $permission['field'] );

		if ( ! is_object( $field ) ) {

			$this->log_debug( __METHOD__ . "(): Field #{$permission['field']} not found. Returning true." );

			return true;

		} else {

			$field_value    = GFFormsModel::get_lead_field_value( $entry, $field );
			$is_value_match = GFFormsModel::is_value_match( $field_value, $permission['value'], $permission['operator'] );

			$this->log_debug( __METHOD__ . "(): Enable Marketing Permission if field #{$permission['field']} value {$permission['operator']} '{$permission['value']}'. Is value match? " . var_export( $is_value_match, 1 ) );

			return $is_value_match;

		}

	}

	/**
	 * Returns the combined value of the specified Address field.
	 * Street 2 and Country are the only inputs not required by Mailchimp.
	 * If other inputs are missing Mailchimp will not store the field value, we will pass a hyphen when an input is empty.
	 * Mailchimp requires the inputs be delimited by 2 spaces.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param array  $entry    The entry currently being processed.
	 * @param string $field_id The ID of the field to retrieve the value for.
	 *
	 * @return array|null
	 */
	public function get_full_address( $entry, $field_id ) {

		// Initialize address array.
		$address = array(
			'addr1'   => str_replace( '  ', ' ', trim( rgar( $entry, $field_id . '.1' ) ) ),
			'addr2'   => str_replace( '  ', ' ', trim( rgar( $entry, $field_id . '.2' ) ) ),
			'city'    => str_replace( '  ', ' ', trim( rgar( $entry, $field_id . '.3' ) ) ),
			'state'   => str_replace( '  ', ' ', trim( rgar( $entry, $field_id . '.4' ) ) ),
			'zip'     => trim( rgar( $entry, $field_id . '.5' ) ),
			'country' => trim( rgar( $entry, $field_id . '.6' ) ),
		);

		// Get address parts.
		$address_parts = array_values( $address );

		// Remove empty address parts.
		$address_parts = array_filter( $address_parts );

		// If no address parts exist, return null.
		if ( empty( $address_parts ) ) {
			return null;
		}

		// Replace country with country code.
		if ( ! empty( $address['country'] ) ) {
			$address['country'] = GF_Fields::get( 'address' )->get_country_code( $address['country'] );
		}

		return $address;

	}

	/**
	 * Get Mailchimp merge fields for list/audience.
	 *
	 * @since  4.2.4
	 * @access public
	 *
	 * @param string $list_id List/Audience ID to get merge fields for.
	 *
	 * @uses GFMailChimp::initialize_api()
	 * @uses GF_MailChimp_API::get_list_merge_fields()
	 *
	 * @return array
	 */
	public function get_list_merge_fields( $list_id = '' ) {

		// If no list/audience ID was provided or if API cannot be initialized, return.
		if ( rgblank( $list_id ) || ! $this->initialize_api() ) {
			return array();
		}

		// If merge fields have already been retrieved, return.
		if ( isset( $this->merge_fields[ $list_id ] ) ) {
			return $this->merge_fields[ $list_id ];
		}

		$result = $this->api->get_list_merge_fields( $list_id );

		if ( is_wp_error( $result ) ) {
			$this->log_error( __METHOD__ . '(): Unable to get merge fields for Mailchimp audience; ' . $result->get_error_message() );

			$this->merge_fields[ $list_id ] = array();

			return array();
		}

		$this->merge_fields[ $list_id ] = $result;

		return $this->merge_fields[ $list_id ];

	}

	/**
	 * Get specific Mailchimp merge field by tag.
	 *
	 * @since  4.2.4
	 * @access public
	 *
	 * @param string $list_id List/Audience ID to get merge fields for.
	 * @param string $tag     Merge field tag.
	 *
	 * @uses GFMailChimp::get_list_merge_fields()
	 *
	 * @return array
	 */
	public function get_list_merge_field( $list_id = '', $tag = '' ) {

		// Get the merge fields for list/audience.
		$merge_fields = $this->get_list_merge_fields( $list_id );

		// If no merge fields were provided, return.
		if ( empty( $merge_fields ) || ! isset( $merge_fields['merge_fields'] ) ) {
			return;
		}

		// Loop through merge fields.
		foreach ( $merge_fields['merge_fields'] as $merge_field ) {

			// If this is not the merge field we are looking for, skip.
			if ( $tag !== $merge_field['tag'] ) {
				continue;
			}

			return $merge_field;

		}

		return array();

	}





	// # UPGRADES ------------------------------------------------------------------------------------------------------

	/**
	 * Checks if a previous version was installed and if the feeds need migrating to the framework structure.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param string $previous_version The version number of the previously installed version.
	 */
	public function upgrade( $previous_version ) {

		// If previous version is not defined, set it to the version stored in the options table.
		if ( empty( $previous_version ) ) {
			$previous_version = get_option( 'gf_mailchimp_version' );
		}

		// Run upgrade routine checks.
		$previous_is_pre_40              = ! empty( $previous_version ) && version_compare( $previous_version, '4.0', '<' );
		$previous_is_pre_addon_framework = ! empty( $previous_version ) && version_compare( $previous_version, '3.0.dev1', '<' );

		if ( $previous_is_pre_addon_framework ) {
			$this->upgrade_to_addon_framework();
		}

		if ( $previous_is_pre_40 ) {
			$this->convert_groups_to_categories();
		}

	}

	/**
	 * Convert groups in feed meta to interest categories.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @uses GFAddOn::log_error()
	 * @uses GFAddOn::get_plugin_settings()
	 * @uses GFAddOn::update_plugin_settings()
	 * @uses GFCache::delete()
	 * @uses GFFeedAddOn::get_feeds()
	 * @uses GFFeedAddOn::update_feed_meta()
	 * @uses GFMailChimp::initialize_api()
	 * @uses GF_MailChimp_API::get_interest_category_interests()
	 * @uses GF_MailChimp_API::get_list_interest_categories()
	 */
	public function convert_groups_to_categories() {

		// If API cannot be initialized, exit.
		if ( ! $this->initialize_api() ) {
			$this->log_error( __METHOD__ . '(): Unable to convert Mailchimp groups to interest categories because API could not be initialized.' );

			return;
		}

		// Get plugin settings.
		$settings = $this->get_plugin_settings();

		// Get Mailchimp feeds.
		$feeds = $this->get_feeds();

		$list_interest_categories    = array();
		$interest_category_interests = array();

		// Loop through Mailchimp feeds.
		foreach ( $feeds as $feed ) {

			// If no list/audience ID is set, skip it.
			if ( ! rgars( $feed, 'meta/mailchimpList' ) ) {
				continue;
			}

			// Initialize categories array.
			$categories = array();

			$list_id = $feed['meta']['mailchimpList'];

			if ( ! isset( $list_interest_categories[ $list_id ] ) ) {
				// Get interest categories for list/audience.
				$result = $this->api->get_list_interest_categories( $list_id );
				if ( is_wp_error( $result ) ) {
					$this->log_error( __METHOD__ . '(): Unable to updated feed #' . $feed['id'] . ' because interest categories could not be retrieved for Mailchimp audience ' . $feed['meta']['mailchimpList'] );

					continue;
				}

				$list_interest_categories[ $list_id ] = $result;
			}

			$interest_categories = rgar( $list_interest_categories, $list_id, array() );

			// Loop through interest categories.
			foreach ( $interest_categories as $interest_category ) {

				$category_id = $interest_category['id'];

				if ( ! isset( $interest_category_interests[ $category_id ] ) ) {
					// Get interests for interest category.
					$interest_category_interests[ $category_id ] = $this->api->get_interest_category_interests( $list_id, $category_id );
				}

				$interests = rgar( $list_interest_categories, $category_id, array() );

				// Loop through interests.
				foreach ( $interests as $interest ) {

					// Add interest to categories array using sanitized name.
					$categories[ $interest['id'] ] = sanitize_title_with_dashes( $interest['name'] );

				}

			}

			// Loop through feed meta.
			foreach ( $feed['meta'] as $key => $value ) {

				// If this is not a Mailchimp group key, skip it.
				if ( 0 !== strpos( $key, 'mc_group_' ) ) {
					continue;
				}

				// Explode meta key.
				$exploded_key = explode( '_', $key );

				// Get Mailchimp group key.
				$mc_key = $exploded_key[0] . '_' . $exploded_key[1] . '_' . $exploded_key[2];
				unset( $exploded_key[0], $exploded_key[1], $exploded_key[2] );

				// Get meta key without group name.
				$meta_key = implode( '_', $exploded_key );

				// Get settings key for Mailchimp group key.
				$settings_key = array_search( $mc_key, $settings );

				// Get sanitized group name.
				$sanitized_group_name = substr( $settings_key, strrpos( $settings_key, '_' ) + 1 );

				// Get new category ID.
				$category_id = array_search( $sanitized_group_name, $categories );

				// If category ID exists, migrate group setting.
				if ( $category_id ) {
					$feed['meta'][ 'interestCategory_' . $category_id . '_' . $meta_key ] = $value;
					unset( $feed['meta'][ $key ] );
				}

			}

			// Save feed.
			$this->update_feed_meta( $feed['id'], $feed['meta'] );

		}

		// Reset plugin settings to just API key.
		$settings = array( 'apiKey' => $settings['apiKey'] );

		// Save plugin settings.
		$this->update_plugin_settings( $settings );

		// Delete cache.
		GFCache::delete( 'mailchimp_plugin_settings' );

	}

	/**
	 * Upgrade versions of Mailchimp Add-On before 3.0 to the Add-On Framework.
	 *
	 * @since  4.0
	 * @access public
	 */
	public function upgrade_to_addon_framework() {

		//get old plugin settings
		$old_settings = get_option( 'gf_mailchimp_settings' );
		//remove username and password from the old settings; these were very old legacy api settings that we do not support anymore

		if ( is_array( $old_settings ) ) {

			foreach ( $old_settings as $id => $setting ) {
				if ( $id != 'username' && $id != 'password' ) {
					if ( $id == 'apikey' ) {
						$id = 'apiKey';
					}
					$new_settings[ $id ] = $setting;
				}
			}
			$this->update_plugin_settings( $new_settings );

		}

		//get old feeds
		$old_feeds = $this->get_old_feeds();

		if ( $old_feeds ) {

			$counter = 1;
			foreach ( $old_feeds as $old_feed ) {
				$feed_name  = 'Feed ' . $counter;
				$form_id    = $old_feed['form_id'];
				$is_active  = rgar( $old_feed, 'is_active' ) ? '1' : '0';
				$field_maps = rgar( $old_feed['meta'], 'field_map' );
				$groups     = rgar( $old_feed['meta'], 'groups' );
				$list_id    = rgar( $old_feed['meta'], 'contact_list_id' );

				$new_meta = array(
					'feedName'         => $feed_name,
					'mailchimpList'    => $list_id,
					'double_optin'     => rgar( $old_feed['meta'], 'double_optin' ) ? '1' : '0',
					'sendWelcomeEmail' => rgar( $old_feed['meta'], 'welcome_email' ) ? '1' : '0',
				);

				//add mappings
				foreach ( $field_maps as $key => $mapping ) {
					$new_meta[ 'mappedFields_' . $key ] = $mapping;
				}

				if ( ! empty( $groups ) ) {
					$group_id = 0;
					//add groups to meta
					//get the groups from mailchimp because we need to use the main group id to build the key used to map the fields
					//old data only has the text, use the text to get the id
					$mailchimp_groupings = $this->get_interest_categories( $list_id );

					//loop through the existing feed data to create mappings for new tables
					foreach ( $groups as $key => $group ) {
						//get the name of the top level group so the id can be retrieved from the mailchimp data
						foreach ( $mailchimp_groupings as $mailchimp_group ) {
							if ( str_replace( '%', '', sanitize_title_with_dashes( $mailchimp_group['name'] ) ) == $key ) {
								$group_id = $mailchimp_group['id'];
								break;
							}
						}

						if ( is_array( $group ) ) {
							foreach ( $group as $subkey => $subgroup ) {
								$setting_key_root                            = $this->get_group_setting_key( $group_id, $subgroup['group_label'] );
								$new_meta[ $setting_key_root . '_enabled' ]  = rgar( $subgroup, 'enabled' ) ? '1' : '0';
								$new_meta[ $setting_key_root . '_decision' ] = rgar( $subgroup, 'decision' );
								$new_meta[ $setting_key_root . '_field_id' ] = rgar( $subgroup, 'field_id' );
								$new_meta[ $setting_key_root . '_operator' ] = rgar( $subgroup, 'operator' );
								$new_meta[ $setting_key_root . '_value' ]    = rgar( $subgroup, 'value' );

							}
						}
					}
				}

				//add conditional logic, legacy only allowed one condition
				$conditional_enabled = rgar( $old_feed['meta'], 'optin_enabled' );
				if ( $conditional_enabled ) {
					$new_meta['feed_condition_conditional_logic']        = 1;
					$new_meta['feed_condition_conditional_logic_object'] = array(
						'conditionalLogic' =>
							array(
								'actionType' => 'show',
								'logicType'  => 'all',
								'rules'      => array(
									array(
										'fieldId'  => rgar( $old_feed['meta'], 'optin_field_id' ),
										'operator' => rgar( $old_feed['meta'], 'optin_operator' ),
										'value'    => rgar( $old_feed['meta'], 'optin_value' )
									),
								)
							)
					);
				} else {
					$new_meta['feed_condition_conditional_logic'] = 0;
				}

				$this->insert_feed( $form_id, $is_active, $new_meta );
				$counter ++;

			}

			//set paypal delay setting
			$this->update_paypal_delay_settings( 'delay_mailchimp_subscription' );
		}

		// Delete old options.
		delete_option( 'gf_mailchimp_settings' );
		delete_option( 'gf_mailchimp_version' );

	}

	/**
	 * Migrate the delayed payment setting for the PayPal add-on integration.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @param string $old_delay_setting_name Old PayPal delay settings name.
	 *
	 * @uses GFAddon::log_debug()
	 * @uses GFFeedAddOn::get_feeds_by_slug()
	 * @uses GFFeedAddOn::update_feed_meta()
	 * @uses GFMailChimp::get_old_paypal_feeds()
	 * @uses wpdb::update()
	 */
	public function update_paypal_delay_settings( $old_delay_setting_name ) {

		global $wpdb;

		// Log that we are checking for delay settings for migration.
		$this->log_debug( __METHOD__ . '(): Checking to see if there are any delay settings that need to be migrated for PayPal Standard.' );

		$new_delay_setting_name = 'delay_' . $this->_slug;

		// Get paypal feeds from old table.
		$paypal_feeds_old = $this->get_old_paypal_feeds();

		// Loop through feeds and look for delay setting and create duplicate with new delay setting for the framework version of PayPal Standard
		if ( ! empty( $paypal_feeds_old ) ) {
			$this->log_debug( __METHOD__ . '(): Old feeds found for ' . $this->_slug . ' - copying over delay settings.' );
			foreach ( $paypal_feeds_old as $old_feed ) {
				$meta = $old_feed['meta'];
				if ( ! rgempty( $old_delay_setting_name, $meta ) ) {
					$meta[ $new_delay_setting_name ] = $meta[ $old_delay_setting_name ];
					//Update paypal meta to have new setting
					$meta = maybe_serialize( $meta );
					$wpdb->update( "{$wpdb->prefix}rg_paypal", array( 'meta' => $meta ), array( 'id' => $old_feed['id'] ), array( '%s' ), array( '%d' ) );
				}
			}
		}

		// Get paypal feeds from new framework table.
		$paypal_feeds = $this->get_feeds_by_slug( 'gravityformspaypal' );
		if ( ! empty( $paypal_feeds ) ) {
			$this->log_debug( __METHOD__ . '(): New feeds found for ' . $this->_slug . ' - copying over delay settings.' );
			foreach ( $paypal_feeds as $feed ) {
				$meta = $feed['meta'];
				if ( ! rgempty( $old_delay_setting_name, $meta ) ) {
					$meta[ $new_delay_setting_name ] = $meta[ $old_delay_setting_name ];
					$this->update_feed_meta( $feed['id'], $meta );
				}
			}
		}

	}

	/**
	 * Retrieve any old PayPal feeds.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @uses GFAddOn::log_debug()
	 * @uses GFAddOn::table_exists()
	 * @uses GFFormsModel::get_form_table_name()
	 * @uses wpdb::get_results()
	 *
	 * @return bool|array
	 */
	public function get_old_paypal_feeds() {

		global $wpdb;

		// Get old PayPal Add-On table name.
		$table_name = $wpdb->prefix . 'rg_paypal';

		// If the table does not exist, exit.
		if ( ! $this->table_exists( $table_name ) ) {
			return false;
		}

		$form_table_name = GFFormsModel::get_form_table_name();
		$sql             = "SELECT s.id, s.is_active, s.form_id, s.meta, f.title as form_title
				FROM {$table_name} s
				INNER JOIN {$form_table_name} f ON s.form_id = f.id";

		$this->log_debug( __METHOD__ . "(): getting old paypal feeds: {$sql}" );

		$results = $wpdb->get_results( $sql, ARRAY_A );

		$this->log_debug( __METHOD__ . "(): error?: {$wpdb->last_error}" );

		$count = count( $results );

		$this->log_debug( __METHOD__ . "(): count: {$count}" );

		for ( $i = 0; $i < $count; $i ++ ) {
			$results[ $i ]['meta'] = maybe_unserialize( $results[ $i ]['meta'] );
		}

		return $results;

	}

	/**
	 * Retrieve any old feeds which need migrating to the Feed Add-On Framework.
	 *
	 * @since  3.0
	 * @access public
	 *
	 * @uses GFAddOn::table_exists()
	 * @uses GFFormsModel::get_form_table_name()
	 * @uses wpdb::get_results()
	 *
	 * @return bool|array
	 */
	public function get_old_feeds() {

		global $wpdb;

		// Get pre-3.0 table name.
		$table_name = $wpdb->prefix . 'rg_mailchimp';

		// If the table does not exist, exit.
		if ( ! $this->table_exists( $table_name ) ) {
			return false;
		}

		$form_table_name = GFFormsModel::get_form_table_name();
		$sql             = "SELECT s.id, s.is_active, s.form_id, s.meta, f.title as form_title
					FROM $table_name s
					INNER JOIN $form_table_name f ON s.form_id = f.id";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		$count = count( $results );
		for ( $i = 0; $i < $count; $i ++ ) {
			$results[ $i ]['meta'] = maybe_unserialize( $results[ $i ]['meta'] );
		}

		return $results;

	}

	/**
	 * Retrieve the group setting key.
	 *
	 * @param string $grouping_id The group ID.
	 * @param string $group_name  The group name.
	 *
	 * @return string
	 */
	public function get_group_setting_key( $grouping_id, $group_name ) {

		$plugin_settings = GFCache::get( 'mailchimp_plugin_settings' );
		if ( empty( $plugin_settings ) ) {
			$plugin_settings = $this->get_plugin_settings();
			GFCache::set( 'mailchimp_plugin_settings', $plugin_settings );
		}

		$key = 'group_key_' . $grouping_id . '_' . str_replace( '%', '', sanitize_title_with_dashes( $group_name ) );

		if ( ! isset( $plugin_settings[ $key ] ) ) {
			$group_key               = sanitize_key( uniqid( 'mc_group_', true ) );
			$plugin_settings[ $key ] = $group_key;
			$this->update_plugin_settings( $plugin_settings );
			GFCache::set( 'mailchimp_plugin_settings', $plugin_settings );
		}

		return $plugin_settings[ $key ];
	}

	/**
	 * Add a warning if the current connection uses the (deprecated) API Key connection method.
	 *
	 * @since 4.10
	 *
	 * @return void
	 */
	public function warn_for_deprecated_key() {
		$api_key = $this->get_plugin_setting( 'apiKey' );
		if ( empty( $api_key ) ) {
			return;
		}

		$initialized = $this->initialize_api();

		if ( ! $initialized ) {
			return;
		}

		add_action(
			'admin_notices',
			function () {
				$settings_url = admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug );

				// translators: %1 is an opening <a> tag, and %2 is a closing </a> tag.
				$message = sprintf( __( 'It looks like you\'re using an API Key to connect to Mailchimp. Please visit the %1$sMailchimp settings page%2$s in order to connect to the Mailchimp API.', 'gravityformsmailchimp' ), "<a href='{$settings_url}'>", '</a>' );

				printf( '<div class="notice below-h1 notice-error gf-notice"><p>%1$s</p></div>', $message );
			}
		);

		$this->log_error( __METHOD__ . ': user has API Key but has not connected to oAuth.' );
	}

	/**
	 * Removes the stored API settings when disconnecting.
	 *
	 * @since  4.10
	 *
	 * @action admin_post_{self::POST_ACTION}
	 *
	 * @return void
	 */
	public function handle_disconnection() {
		delete_option( 'gravityformsaddon_' . $this->_slug . '_settings' );
		$redirect_url = admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug );
		wp_safe_redirect( $redirect_url );
	}

}
