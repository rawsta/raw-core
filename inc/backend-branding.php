<?php
/**
 * Backend Branding
 *
 * @package      RawCore
 * @author       rawsta
 * @since        0.9.2
 * @license      GPL-2.0+
**/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------- Login Page ----------- //

add_action('login_head', 'rawcore_login_logo');
// Login Logo -logo.jpg
function rawcore_login_logo() {
	// $logo_path = '/assets/images/logo.svg';
	$logo_path = plugins_url( '../img/login-logo.png',__FILE__);
	if( ! file_exists( plugins_url() . $logo_path ) )
		return;

	$logo = plugins_url() . $logo_path;

	// $logo_path = '/assets/images/logo.svg';
	$bg_path = plugins_url( '../img/login-bg.png',__FILE__);
	if( ! file_exists( plugins_url() . $bg_path ) )
		return;

	$bg = plugins_url() . $bg_path;
	?>
	<style type="text/css">
		body.login{
			background-image:url(<?php echo $bg;?>);
			background-position: center;
		}
		body.login div#login h1 a {
			background-image:url(<?php echo $logo;?>);
			width: 180px;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center center;
		}
		form#loginform {
			border-radius: 5px;
			background-color: rgba(255,255,255,0.7);
			box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
		}
		.login label {
			color: #454545;
			display: block;
			margin-bottom: 1em;
			font-weight: bold;
		}

		.login form .input {
			font-weight: normal;
		}

		.login #backtoblog a,
		.login #nav a {
			color: #830000;
		}

		.wp-core-ui .button-primary {
			background-color: #830000;
			color: #fff;
		}
		.wp-core-ui .button-primary:hover,
		.wp-core-ui .button-primary:focus,
		.wp-core-ui .button-primary:active {
			background-color: #550000;
		}
	</style>
	<?php
}

add_filter( 'login_headerurl', 'ea_login_header_url' );
add_filter( 'login_headertext', '__return_empty_string' );
// Login Logo URL
function ea_login_header_url( $url ) {
	return esc_url( home_url() );
}

// Login Logo Title
function rawcore_login_headertext() {
	$logotitle = get_bloginfo($show = 'name', $filter = 'raw' );
	return $logotitle;
}
add_filter( 'login_headertext', 'rawcore_login_headertext' );

// Login Fehlerausgabe begrenzen
function rawcore_no_login_error(){
	return 'Oops, that\'s not correct!';
}
add_filter( 'login_errors', 'rawcore_no_login_error' );

// Remember Me always
add_action( 'init', 'rawcore_remember_me' );
function rawcore_remember_me() {
    echo "<script>document.getElementById('rememberme').checked = true;</script>";
}
add_filter( 'login_footer', 'rawcore_remember_me' );

// ---------- Dashboard ---------- //

// Abschalten der Dashboard-Widgets
// function rawcore_no_dash_widgets() {
//		global $wp_meta_boxes;
//		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
//		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
//		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
//		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
//		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
//		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
//		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
// }
// add_action('wp_dashboard_setup', 'rawcore_no_widgets' );


// Eigenes Logo für das Dashboard
function rawcore_dash_logo() {
	echo '<style type="text/css">
	#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
		background-image: url('. plugins_url( '../img/dash-logo.png',__FILE__) .') !important;
		background-size: cover;
		background-position: 0 0;
		color:rgba(0, 0, 0, 0);
	}
	#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
	background-position: 0 0;
	}</style>';
}
add_action('wp_before_admin_bar_render', 'rawcore_dash_logo');

// Dashboard Footer Text anpassen
function rawcore_footer_admin () {
	echo 'Made with Coffee and Love by <a href="https://www.rawsta.de" target="_blank">Rawsta</a></p>';
}
add_filter('admin_footer_text', 'rawcore_footer_admin');


// enqueue Dashicons
function rawcore_enqueue_dashicons() {
	wp_enqueue_style( 'raw-dashicons-font', get_stylesheet_directory_uri(), array('dashicons'), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'rawcore_enqueue_dashicons' );
