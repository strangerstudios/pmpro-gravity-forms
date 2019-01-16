<?php
/**
 * Contains the GFPMPro class.
 *
 * @package PMPro_Gravity_Forms
 */

GFForms::include_feed_addon_framework();

/**
 * Main Gravity Forms feed class.
 */
class GFPMProAddOn extends GFFeedAddOn {

	/**
	 * The add-on version.
	 *
	 * @var string
	 */
	protected $_version = PMPROGF_VERSION;

	/**
	 * The minimum required Gravity Forms version.
	 *
	 * @var string
	 */
	protected $_min_gravityforms_version = '2.4';

	/**
	 * The add-on slug.
	 *
	 * @var string
	 */
	protected $_slug = 'gfpmpro';

	/**
	 * The add-on path, relative to the plugins directory.
	 *
	 * @var string
	 */
	protected $_path = 'pmpro-gravity-forms/pmpro-gravity-forms.php';

	/**
	 * The full path to this add-on file.
	 *
	 * @var string
	 */
	protected $_full_path = __FILE__;

	/**
	 * The full title of the add-on.
	 *
	 * @var string
	 */
	protected $_title = 'Gravity Forms Paid Memberships Pro Add-On';

	/**
	 * The short title of the add-on.
	 *
	 * @var string
	 */
	protected $_short_title = 'Paid Memberships Pro';

	/**
	 * @var object|null $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @return object $_instance An instance of this class.
	 */
	public static function get_instance() {
		if ( self::$_instance === null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Set the minimum add-on requirements.
	 *
	 * @return array
	 */
	public function minimum_requirements() {
		return array(
			'plugins' => array(
				'paid-memberships-pro/paid-memberships-pro.php',
			),
		);
	}

	/**
	 * Sets the Gravity Forms feed settings fields.
	 *
	 * @return array
	 */
	public function feed_settings_fields() {
		$membership_levels = pmpro_getAllLevels( true, true );

		return array(
			array(
				'title' => 'Paid Memberships Pro Settings',
				'fields' => array(
					array(
						'label' => 'Enabled',
						'type'  => 'checkbox',
						'name'  => 'enabled',
						'tooltip' => 'Enable form submissions to be processed by Paid Memberships Pro',
						'choices' => array(
							array(
								'label' => 'Enabled',
								'name'  => 'enabled',
							),
						),
					),
					array(
						'label'   => 'Name',
						'type'    => 'text',
						'name'    => 'name',
						'tooltip' => 'An identifier for this feed.',
						'class'   => 'medium',
					),
					array(
						'label'   => 'Change Membership Level',
						'type'    => 'select',
						'name'    => 'membership_level',
						'tooltip' => 'Sets the membership level when the form is submitted.',
						'choices' => $this->membership_level_setting_choices(),
					),
				),
			),
		);
	}

	/**
	 * Display details on the feed list.
	 *
	 * @return array
	 */
	public function feed_list_columns() {
		return array(
			'name'             => __( 'Name', 'pmpro-gravity-forms' ),
			'membership_level' => __( 'Membership Level', 'pmpro-gravity-forms' ),
		);
	}

/**
 * Gets available membership levels, formatted for Gravity Forms settings fields.
 *
 * @return array
 */
	public function membership_level_setting_choices() {
		$options           = array();
		$membership_levels = pmpro_getAllLevels( true, true );

		foreach ( $membership_levels as $membership_level ) {
			$options[] = array(
				'label' => $membership_level->name,
				'value' => $membership_level->id,
			);
		}

		return $options;
	}

	/**
	 * Check if the current user can be modified.
	 *
	 * @return bool
	 */
	public function can_modify_pmpro_user() {
		$current_user = wp_get_current_user();

		if ( function_exists( 'pmpro_changeMembershipLevel' ) && $current_user->ID !== 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Processes the Gravity Forms feed.
	 *
	 * @param array $feed  The Gravity Forms feed.
	 * @param array $entry The Gravity Forms entry.
	 * @param array $form  The Gravity Forms form.
	 *
	 * @return void
	 */
	public function process_feed( $feed, $entry, $form ) {
		if ( ! array_key_exists( 'enabled', $feed['meta'] ) || $feed['meta']['enabled'] !== '1' ) {
			return;
		}

		$current_user = wp_get_current_user();

		if ( ! $this->can_modify_pmpro_user() ) {
			return;
		}

		pmpro_changeMembershipLevel( intval( $feed['meta']['membership_level'] ), $current_user->ID );
	}

}
