<?php
/**
 * WordPress CleanUp
 *
 * @package      RawCore
 * @author       Trisinus
 * @since        0.9.2
 * @license      GPL-2.0+
 **/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// WP version info aus head und feeds entfernen
function rawcore_no_version() {
    return '';
}
add_filter('the_generator', 'rawcore_no_version');

// Head Bereich aufräumen
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'start_post_rel_link');
remove_action( 'wp_head', 'parent_post_rel_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

// disable XMLRPC
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
* Disable the emoji's
*/
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
* Filter function used to remove the tinymce emoji plugin.
*
* @param array $plugins
* @return array Difference betwen the two arrays
*/
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

/**
* Remove emoji CDN hostname from DNS prefetching hints.
*
* @param array $urls URLs to print for resource hints.
* @param string $relation_type The relation type the URLs are printed for.
* @return array Difference betwen the two arrays.
*/
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }

    return $urls;
}

//Exclude No-index content from search
function rawcore_exclude_noindex_from_search( $query ) {
	if( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
		$meta_query = empty( $query->query_vars['meta_query'] ) ? array() : $query->query_vars['meta_query'];
		$meta_query[] = array(
			'key' => '_yoast_wpseo_meta-robots-noindex',
			'compare' => 'NOT EXISTS',
		);
		$query->set( 'meta_query', $meta_query );
	}
}
add_action( 'pre_get_posts', 'rawcore_exclude_noindex_from_search' );

// Default Image Link is None
function rawcore_default_image_link() {
	$link = get_option( 'image_default_link_type' );
	if( 'none' !== $link )
		update_option( 'image_default_link_type', 'none' );
}
add_action( 'init', 'rawcore_default_image_link' );

/**
 * Attachment ID on Images
 * @since  0.9.0
 */
function rawcore_attachment_id_on_images( $attr, $attachment ) {
	if( !strpos( $attr['class'], 'wp-image-' . $attachment->ID ) ) {
		$attr['class'] .= ' wp-image-' . $attachment->ID;
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'rawcore_attachment_id_on_images', 10, 2 );

/**
 * Remove ancient Custom Fields Metabox because it's slow and most often useless anymore
 * ref: https://core.trac.wordpress.org/ticket/33885
 */
function rawcore_remove_post_custom_fields_now() {
	foreach ( get_post_types( '', 'names' ) as $post_type ) {
		remove_meta_box( 'postcustom' , $post_type , 'normal' );
	}
}
add_action( 'admin_menu' , 'rawcore_remove_post_custom_fields_now' );
