<?php
/**
 *
 * Plugin Name: Raw Core
 * Plugin URI: http://www.rawsta.de
 * Description: Schaltet nicht benötigte WordPress Funktionen ab und bildet eine Basis für unsere Themes.
 * Version: 0.3.0
 *
 * Author: Sebastian Fiele
 * Author URI: http://www.rawsta.de
 * License:           GPL-3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package    rawcore
 * @since      0.3.0
 * @copyright  Copyright (c) 2020, rawsta
 * @license    GPL-3
 *
 * Text Domain: raw_core
 */

/* current functions:
    - Versionsinfo abschalten
    - Login Fehler begrenzen
    - Login Logo setzen
    - Login Logo URL setzen
    - Login Logolink titel setzen
    - seitensprung bei -read more- abschalten
    - Shortcodes in Text-Widgets
    - WordPress Emojis entfernen
    - Weitere Media Formate freigeben
    - RSS-Feeds abschalten
    - Bilder in RSS Feeds anzeigen
    - Dashboard Widgets abschalten
    - Eigenes Dashboard Widget anlegen
    - Dashboard Logo setzen
    - Admin Footer Text setzen
    - Dashicons aktivieren
    - Self-Pingbacks abschalten
    - Trackbacks abschalten
    - Böse URL anfragen sperren
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin directory
define( 'RAW_DIR' , plugin_dir_path( __FILE__ ) );

// Current plugin version, manually defined for performance reasons.
define( 'RAWCORE_VERSION', '0.3.3' );


//include sections
require_once( RAW_DIR . '/inc/general.php' );
require_once( RAW_DIR . '/inc/wp-cleanup.php' );
require_once( RAW_DIR . '/inc/backend-branding.php' );
require_once( RAW_DIR . '/inc/rss-feeds.php' );
require_once( RAW_DIR . '/inc/kill-trackbacks.php' );


?>
