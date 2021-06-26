<?php
/**
 * General
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

// enable shortcodes in text-widgets
add_filter('widget_text','do_shortcode');

// remove jump when clicking on "read more"
function rawcore_no_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'rawcore_no_jump_link');

// Disable self pingbacks
function rawcore_no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, $home ) )
			unset($links[$l]);
}
add_action( 'pre_ping', 'rawcore_no_self_ping' );

/**
 * add more mime-types for upload
 */
function add_custom_mime_types($mimes){

	$new_file_types = array (
		'zip' => 'application/zip',
		'mobi' => 'application/x-mobipocket-ebook',
		'pdf' => 'application/pdf',
		'epub' => 'application/epub+zip'
	);

	return array_merge($mimes,$new_file_types);
}
add_filter('upload_mimes','add_custom_mime_types');

/**
 * Block potential harmful requests
 */
global $user_ID; if($user_ID) {
	if(!current_user_can('administrator')) {
		if (strlen($_SERVER['REQUEST_URI']) > 255 ||
			stripos($_SERVER['REQUEST_URI'], "eval(") ||
			stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
			stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
			stripos($_SERVER['REQUEST_URI'], "base64")) {
				@header("HTTP/1.1 414 Request-URI Too Long");
				@header("Status: 414 Request-URI Too Long");
				@header("Connection: Close");
				@exit;
		}
	}
}
