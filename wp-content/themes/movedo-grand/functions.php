<?php

/**
 * Grand Opera House Child Theme
 * for Movedo
 */

function movedo_child_theme_setup() {

}
add_action( 'after_setup_theme', 'movedo_child_theme_setup' );

/*

███████╗████████╗██╗   ██╗██╗     ███████╗███████╗
██╔════╝╚══██╔══╝╚██╗ ██╔╝██║     ██╔════╝██╔════╝
███████╗   ██║    ╚████╔╝ ██║     █████╗  ███████╗
╚════██║   ██║     ╚██╔╝  ██║     ██╔══╝  ╚════██║
███████║   ██║      ██║   ███████╗███████╗███████║
╚══════╝   ╚═╝      ╚═╝   ╚══════╝╚══════╝╚══════╝

*/

function movedo_child_theme_enqueue_styles() {
    $parent_style = 'movedo-grve-style';
    $child_style = 'movedo-grand';

    // This is the right way to do it, but it doesn't seem to work
    // here with defining a child theme
    // wp_register_style( $parent_style, get_template_directory_uri() . '/style.css', array());
    // wp_register_style( $child_style, get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array() );
    wp_enqueue_style( $child_style, get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
}
add_action( 'wp_enqueue_scripts', 'movedo_child_theme_enqueue_styles' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
