<?php

/*
 *	Excerpt functions
 *
 * 	@version	1.0
 * 	@author		Greatives Team
 * 	@URI		http://greatives.eu
 */


 /**
 * Custom excerpt
 */
if ( !function_exists('movedo_grve_excerpt') ) {
	function movedo_grve_excerpt( $limit, $more = '0' ) {
		global $post;
		$post_id = $post->ID;
		$excerpt = "";

		if ( has_excerpt( $post_id ) ) {
			if ( 0 != $limit ) {
				$excerpt = $post->post_excerpt;
				$excerpt = apply_filters('the_excerpt', $excerpt);
			}
			if ( '1' == $more ) {
				$excerpt .= movedo_grve_read_more( $post_id );
			}
		} else {
			$content = get_the_content('');
			$content = apply_filters('movedo_grve_the_content', $content);
			$content = str_replace(']]>', ']]>', $content);
			if ( 0 != $limit ) {
				$excerpt = '<p>' . wp_trim_words( $content, $limit ) . '</p>';
			}
			if ( '1' == $more ) {
				$excerpt .= movedo_grve_read_more( $post_id );
			}
		}
		return	$excerpt;
	}
}

if ( !function_exists('movedo_grve_quote_excerpt') ) {
	function movedo_grve_quote_excerpt( $limit ) {
		$excerpt = "";

		$content = movedo_grve_post_meta( '_movedo_grve_post_quote_text' );
		if( is_single() ){
			$excerpt = '<p>' . wp_kses_post( $content ) . '</p>';
		} else {
			if ( 0 != $limit ) {
				$excerpt = '<p>' . wp_trim_words( $content, $limit ) . '</p>';
			}
		}

		return	$excerpt;
	}
}

 /**
 * Custom more
 */
if ( !function_exists('movedo_grve_read_more') ) {
	function movedo_grve_read_more( $post_id = '') {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}
		$more_button = '<a class="grve-read-more grve-link-text grve-heading-color grve-text-hover-primary-1" href="' . esc_url( get_permalink( $post_id ) ) . '"><span>' . esc_html__( 'read more', 'movedo' ) . '</span></a>';
		return $more_button;
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
