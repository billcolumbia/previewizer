<?php
/*
Plugin Name: Previewizer
Plugin URI:  null
Description: This plugin adds a split pane view for previewing posts as you add content or design them.
Version:     0.0.1
Author:      Bill Columbia
Author URI:  http://billcolumbia.com
License:     MIT
License URI: http://opensource.org/licenses/MIT
*/


/**
*
*/
class Previewizer {

  /**
   *  Adds actions (Previewizer.init) to WordPress life cycle
   *
   * @return true
   */
  function __construct()
  {
    add_action( 'admin_enqueue_scripts', array( $this, 'setup_assets' ) );
  }

  public function not_post_context( $hook )
  {
    if ( 'post-new.php' != $hook && 'post.php' != $hook )
    {
      return true;
    }
  }

  public $meow;

  /**
   * Intializes plugin
   *
   * @return true
   */
   public function setup_assets( $hook )
  {
    if ( $this->not_post_context( $hook ) )
    {
      return;
    }
    // Add Previewizer Script to WordPress Admin
    wp_enqueue_script(
      'previewizer', // handle
      plugins_url( '../previewizer/previewizer.js', __FILE__ ),  // src
      array( 'jquery', 'jquery-ui-resizable' ), // dependencies
      '0.0.1', // version
      true
    );
    // Add Previewizer Styles to WordPress Admin
    wp_enqueue_style(
      'previewizer', // handle
      plugins_url( '../previewizer/previewizer.css', __FILE__ ), // src
      false,// dependencies
      '0.0.1',// version
      'all'
    );
    $this->meow = $hook;
    add_action( 'admin_footer', array( $this, 'append_markup' ) );
  }

   public function append_markup()
  {
    echo '<div class="previewizer-panel"></div>';
    echo '<pre>' . $this->meow . '</pre>';
  }

}

$previewizer = new Previewizer();
