<?php
/**
 * Managing RSS Feeds
 *
 * @package      RawCore
 * @author       rawsta
 * @since        0.9.8
 * @license      GPL-2.0+
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Put post thumbnails into rss feed
function rawcore_feed_post_thumbnail($content) {
global $post;
if(has_post_thumbnail($post->ID)) {
$content = '' . $content;
}
return $content;
}
add_filter('the_excerpt_rss', 'rawcore_feed_post_thumbnail');
add_filter('the_content_feed', 'rawcore_feed_post_thumbnail');

function rawcore_postrss($content) {
if(is_feed()){
    $content = ' '.$content.'Bitte besuchen Sie unsere <a href="'. get_bloginfo('url') .'">Startseite</a>!';
}
return $content;
}
add_filter('the_excerpt_rss', 'rawcore_postrss');
add_filter('the_content', 'rawcore_postrss');

// RSS Feeds aus dem Header entfernen
// remove_action( 'wp_head', 'feed_links', 2 );
// remove_action( 'wp_head', 'feed_links_extra', 3 );

// Die totale Abschaltung der RSS-Feeds
// function rawcore_no_feed() {
// wp_die( __('Kein Feed verfügbar. Bitte besuchen Sie unsere <a href="'. get_bloginfo('url') .'">Startseite</a>!') );
// }

// add_action('do_feed', 'rawcore_no_feed', 1);
// add_action('do_feed_rdf', 'rawcore_no_feed', 1);
// add_action('do_feed_rss', 'rawcore_no_feed', 1);
// add_action('do_feed_rss2', 'rawcore_no_feed', 1);
// add_action('do_feed_atom', 'rawcore_no_feed', 1);
