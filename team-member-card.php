<?php
/**
 * Plugin Name: Team Member Card Widget for Elementor
 * Description: Adds a custom Elementor widget to display team member cards with Name, Bio, Role, Photo and Linkedin Url.
 * Version: 1.0
 * Author: Chanchal Tayal
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'TMC_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'TMC_PLUGIN_URL', plugin_dir_url(__FILE__) );

// Register widget category (optional)
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'custom-widgets',
        [ 'title' => __( 'Custom Widgets', 'tmc' ), 'icon' => 'fa fa-user' ]
    );
});

// Load widget
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once TMC_PLUGIN_PATH . 'widgets/class-team-member-card-widget.php';
    $widgets_manager->register( new \Team_Member_Card_Widget() );
});
