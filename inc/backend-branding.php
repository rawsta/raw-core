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

// Login Logo -logo.jpg
function rawcore_login_logo() {
    echo '<style type="text/css">
    body.login{
        background-image:url('. plugins_url( '../img/login-bg.png',__FILE__) .');
        background-position: center;
    }
    body.login div#login h1 a {
        background-image:url('. plugins_url( '../img/login-logo.png',__FILE__) .');
        width: 200px;
        background-size: contain;
    }
    form#loginform {
        border-radius: 5px;
        background-color: rgba(255,255,255,0.7);
        box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
    }
    </style>';
}
add_action('login_head', 'rawcore_login_logo');

// Login Logo URL
function rawcore_login_url($login_header_url) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'rawcore_login_url' );

// Login Logo Link-title
function rawcore_login_text($login_header_text) {
    return get_bloginfo('title');
}
add_filter( 'login_headertext', 'rawcore_login_text' );

// Login Fehlerausgabe begrenzen
function rawcore_no_login_error(){
    return 'Da ist etwas schiefgelaufen!';
}
add_filter( 'login_errors', 'rawcore_no_login_error' );

// ---------- Dashboard ---------- //

// // Abschalten der Dashboard-Widgets
// function rawcore_no_dash_widgets() {
//     global $wp_meta_boxes;
//     unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
//     unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
//     // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//     unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
//     unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
//     // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
//     unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
//     unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
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
    echo 'Gestaltet mit Herz für <a href="https://www.rawsta.de" target="_blank">TheCats</a></p>';
}
add_filter('admin_footer_text', 'rawcore_footer_admin');


// enqueue Dashicons
function rawcore_enqueue_dashicons() {
    wp_enqueue_style( 't3s-dashicons-font', get_stylesheet_directory_uri(), array('dashicons'), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'rawcore_enqueue_dashicons' );
