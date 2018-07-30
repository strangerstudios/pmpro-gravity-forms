<?php
/*
 Plugin Name: Paid Memberships Pro - Gravity Forms Add On
 Plugin URI: https://www.paidmembershipspro.com/add-ons/gravity-forms-integration/
 Description: Integrate Gravity Forms with Paid Memberships profiles
 Version: 1.0
 Author: Paid Memberships Pro
 Author URI: https://www.paidmembershipspro.com
 Text Domain: pmpro-gravity-forms
 */
/*
    includes
*/
define( 'PMPROGF_DIR', dirname( __FILE__ ) );
define( 'PMPROGF_BASENAME', plugin_basename( __FILE__ ) );

require_once( PMPROGF_DIR . '/includes/admin.php' );

/*
	After a form is submitted, move users into a specified membership level.

	Notes:
	- example here: https://www.paidmembershipspro.com/assign-change-users-membership-level-gravity-form-submission/
	- option to exclude users who already have a level or specific levels
*/

/*
	Restrict forms for specified membership levels.

	Notes:
	- similar to how we restrict CPTs here: https://github.com/strangerstudios/pmpro-cpt/blob/master/pmpro-cpt.php#L21
	- ideally hide the form with a message/link to purchase membership
	- or just redirect away from the page with the form to the pmpro levels page
*/