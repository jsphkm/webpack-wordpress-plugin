<?php
/**
 * Plugin Name: Example Plugin
 * Description: A description of this plugin
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
};

function exampleplugin_register() {
	wp_register_script(
		'exampleplugin-script',
    plugins_url('/build/index_bundle.js', __FILE__ ),
    array('wp-blocks', 'wp-components', 'wp-element', 'wp-editor', 'wp-i18n')
  );

  wp_register_style(
    'exampleplugin-globalstyle',
    plugins_url( '/build/global-style.css', __FILE__ ),
    array( 'wp-edit-blocks' ),
    // TODO: Remove the line below to use caching
    filemtime( plugin_dir_path( __FILE__ ) . '/blocks/global-style.css' )
  );

  wp_register_style(
    'exampleplugin-editorstyle',
    plugins_url( '/build/editor-style.css', __FILE__ ),
    array( 'wp-edit-blocks' ),
    // TODO: Remove the line below to use caching
    filemtime( plugin_dir_path( __FILE__ ) . '/blocks/editor-style.css' )
  );

  register_block_type( 'exampleplugin/containerblock', array(
    'editor_script' => 'exampleplugin-script',
    'editor_style' => 'exampleplugin-editorstyle',
    'style' => 'exampleplugin-globalstyle',
  ));

  wp_enqueue_script('exampleplugin-script');
}

add_action( 'enqueue_block_editor_assets', 'exampleplugin_register' );