<?php /*
Plugin Name: Minifyer
Plugin URI: http://www.jmilanes.com.br/
Description: This plugin is a wrapper for the php minify lib creatd by Steve Clay, it compresses sources of content (usually files), combines the result and serves it with appropriate HTTP headers.
Version: 1.0
Author: Jair Milanes Junior
Author URI: http://www.jmilanes.com.br/
Short Name: minifyer
Plugin update URI: http://www.jmilanes.com.br/
*/
/**
 * Minifify all the scripts and styles currently i the queue
 */
function minify(){
	$enabled = osc_get_preference('minify_enabled', 'minify');
	if( $enabled > 0 ){
		minify_styles();
		minify_scripts();
	}
}

/**
 * Gets a minify url with all the styles in the queue
 * @return string Url
 */
function minify_styles(){
	$styles = Styles::newInstance()->getStyles();
	Styles::newInstance()->styles = array();
	osc_enqueue_style('minify_styles', osc_route_url('minify_styles', array( 'minify_files' => implode( ',', minify_clean_url( $styles ) ) ) ) );
	return;
}

/**
 * Gets a minify url with all the scripts in the queue
 * @return string Url
 */
function minify_scripts(){
	$scripts = Scripts::newInstance()->getScripts();
	Scripts::newInstance()->queue = array();
	osc_register_script('minify_scripts', osc_route_url('minify_scripts', array( 'minify_files' => implode( ',', minify_clean_url( $scripts ) ) ) ) );
	osc_enqueue_script('minify_scripts');
	return;
}

/**
 * Sanitize the file url removing the base url
 * @param array $urls
 * @return array Urls
 */
function minify_clean_url( array $urls ){
	foreach( $urls as &$url ){
		$url = str_replace(osc_base_url(),'/', $url );
	}
	return $urls;
}

/**
 * Process minify requests
 */
function minify_init(){
	$_GET['f'] = Params::getParam('minify_files');
	require_once dirname(__FILE__).'/minify.php';
	return;
}

/**
 * Renders admin settings page
 */
function minify_admin(){
	osc_admin_render_plugin( osc_plugin_path( dirname(__FILE__) ) . '/admin/conf.php' );
}

/**
 * creates the plugins preference key
 */
function minify_install(){
	osc_set_preference('minify_enabled', 0, 'minify');
}

/**
 * Remove the plugins preference key
 */
function minify_uninstall(){
	osc_delete_preference('minify_enabled', 'minify');
}

osc_add_hook( 'header', 'minify', 9 );
osc_add_hook( 'custom_controller', 'minify_init' );
osc_add_route('minify_styles', 'styles/f=(.*)', 'styles/f={minify_files}', 'minifyer/minify.php' );
osc_add_route('minify_scripts', 'scripts/f=(.*)', 'scripts/f={minify_files}', 'minifyer/minify.php' );
osc_register_plugin( osc_plugin_path( __FILE__ ), '' );
osc_add_hook( osc_plugin_path( __FILE__ ) . '_uninstall', 'minify_uninstall' );
osc_add_hook( osc_plugin_path( __FILE__ ) . '_configure', 'minify_admin' );