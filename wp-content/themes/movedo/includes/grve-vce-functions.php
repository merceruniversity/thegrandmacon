<?php

/*
*	Visual Composer Extension Plugin Hooks
*
* 	@version	1.0
* 	@author		Greatives Team
* 	@URI		http://greatives.eu
*/

/**
 * Translation function returning the theme translations
 */

/* All */
function movedo_grve_theme_vce_get_string_all() {
    return esc_html__( 'All', 'movedo' );
}
/* Read more */
function movedo_grve_theme_vce_get_string_read_more() {
    return esc_html__( 'read more', 'movedo' );
}
/* In Categories */
function movedo_grve_theme_vce_get_string_categories_in() {
    return esc_html__( 'in', 'movedo' );
}

/* Author By */
function movedo_grve_theme_vce_get_string_by_author() {
    return esc_html__( 'By:', 'movedo' );
}

/* E-mail */
function movedo_grve_theme_vce_get_string_email() {
    return esc_html__( 'E-mail', 'movedo' );
}

/**
 * Hooks for portfolio translations
 */

add_filter( 'movedo_grve_vce_portfolio_string_all_categories', 'movedo_grve_theme_vce_get_string_all' );

 /**
 * Hooks for blog translations
 */

add_filter( 'movedo_grve_vce_string_read_more', 'movedo_grve_theme_vce_get_string_read_more' );
add_filter( 'movedo_grve_vce_blog_string_all_categories', 'movedo_grve_theme_vce_get_string_all' );
add_filter( 'movedo_grve_vce_blog_string_categories_in', 'movedo_grve_theme_vce_get_string_categories_in' );
add_filter( 'movedo_grve_vce_blog_string_by_author', 'movedo_grve_theme_vce_get_string_by_author' );

 /**
 * Hooks for general translations
 */

add_filter( 'movedo_grve_vce_gallery_string_all_categories', 'movedo_grve_theme_vce_get_string_all' );
add_filter( 'movedo_grve_vce_product_string_all_categories', 'movedo_grve_theme_vce_get_string_all' );
add_filter( 'movedo_grve_vce_event_string_all_categories', 'movedo_grve_theme_vce_get_string_all' );
add_filter( 'movedo_grve_vce_string_email', 'movedo_grve_theme_vce_get_string_email' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
