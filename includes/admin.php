<?php
/**
 * Runs only when the plugin is activated.
 *
 * @since 0.1.0
 */
function pmpro_gf_admin_notice_activation_hook() {
	// Create transient data.
	set_transient( 'pmpro-gf-admin-notice', true, 5 );
}
register_activation_hook( PMPROGF_BASENAME, 'pmpro_gf_admin_notice_activation_hook' );

/**
 * Admin Notice on Activation.
 *
 * @since 0.1.0
 */
function pmpro_gf_admin_notice() {
	// Check transient, if available display notice.
	if ( get_transient( 'pmpro-gf-admin-notice' ) ) { ?>
		<div class="updated notice is-dismissible">
			<p><?php printf( __( 'Thank you for activating. Edit a form to get started with the PMPro Gravity Forms Add On.', 'pmpro-gravity-forms' ), get_admin_url( null, 'admin.php?page=pmpro-gravity-forms' ) ); ?></p>
		</div>
		<?php
		// Delete transient, only display this notice once.
		delete_transient( 'pmpro-gf-admin-notice' );
	}
}
add_action( 'admin_notices', 'pmpro_gf_admin_notice' );

/**
 * Function to add links to the plugin action links
 *
 * @param array $links Array of links to be shown in plugin action links.
 */
function pmpro_gf_plugin_action_links( $links ) {
	if ( current_user_can( 'manage_options' ) ) {
		$new_links = array(
			'<a href="' . get_admin_url( null, 'admin.php?page=pmpro-gravity-forms' ) . '">' . __( 'Settings', 'pmpro-gravity-forms' ) . '</a>',
		);
	}
	return array_merge( $new_links, $links );
}
add_filter( 'plugin_action_links_' . PMPROGF_BASENAME, 'pmpro_gf_plugin_action_links' );

/**
 * Function to add links to the plugin row meta
 *
 * @param array  $links Array of links to be shown in plugin meta.
 * @param string $file Filename of the plugin meta is being shown for.
 */
function pmpro_gf_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'pmpro-gravity-forms.php' ) !== false ) {
		$new_links = array(
			'<a href="' . esc_url( 'https://www.paidmembershipspro.com/add-ons/gravity-forms-integration/' ) . '" title="' . esc_attr( __( 'View Documentation', 'pmpro' ) ) . '">' . __( 'Docs', 'pmpro-gravity-forms' ) . '</a>',
			'<a href="' . esc_url( 'https://www.paidmembershipspro.com/support/' ) . '" title="' . esc_attr( __( 'Visit Customer Support Forum', 'pmpro' ) ) . '">' . __( 'Support', 'pmpro-gravity-forms' ) . '</a>',
		);
		$links = array_merge( $links, $new_links );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'pmpro_gf_plugin_row_meta', 10, 2 );