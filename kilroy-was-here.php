<?php
/**
 * Plugin Name: Kilroy was here
 * Plugin URI: http://wordpress.org/extend/plugins/kilroy-was-here/
 * Description: Adds a text tag to the footer of posts & pages
 * Version: 1.5.4
 * Author: Walter Ebert
 * Author URI: http://walterebert.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kilroy-was-here
 * Domain Path: /languages
 *
 * @package Kilroy_Was_Here
 */

// Deny direct access.
if ( ! function_exists( 'add_filter' ) ) {
	http_response_code( 403 );
	die( 'Access denied' );
}

define( 'KILROYWASHERE_BASENAME', plugin_basename( __FILE__ ) );
define( 'KILROYWASHERE_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'KILROYWASHERE_DIR_PATH_BASENAME', basename( KILROYWASHERE_DIR_PATH ) );

require_once __DIR__ . '/includes/class-kilroy-was-here.php';

add_action( 'plugins_loaded', 'Kilroy_Was_Here::init' );
register_activation_hook( __FILE__, 'Kilroy_Was_Here::install' );
