<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( function_exists( 'vc_add_shortcode_param' ) ) {

	function movedo_ext_vce_multi_checkbox_settings_field( $param, $param_value ) {

		$param_line = '';
		$current_value = explode(",", $param_value);
		$values = is_array($param['value']) ? $param['value'] : array();

		foreach ( $values as $label => $v ) {
			$checked = in_array($v, $current_value) ? ' checked="checked"' : '';
			$checkbox_input_class = 'grve-checkbox-input-item';
			$checkbox_class = 'grve-checkbox-item';
			if ( '' == $v ) {
				$checkbox_input_class = 'grve-checkbox-input-item-all';
				$checkbox_class = 'grve-checkbox-item grve-checkbox-item-all';
			}
			$param_line .= '<div class="' . esc_attr( $checkbox_class ) . '"><input id="'. esc_attr( $param['param_name'] ) . '-' . esc_attr( $v ) .'" value="' . esc_attr( $v ) . '" class="'. esc_attr( $checkbox_input_class ) . '" type="checkbox" '.$checked.'> ' . __($label, "js_composer") . '</div>';
		}

		return '<div class="grve-multi-checkbox-container">' .
			   '  <input class="wpb_vc_param_value wpb-checkboxes '. esc_attr( $param['param_name'] ) . ' ' . esc_attr( $param['type'] ) . '_field" type="hidden" value="' . esc_attr( $param_value ) . '" name="' . esc_attr( $param['param_name'] ) . '"/>'
				. $param_line .
				'</div>';

	}
	vc_add_shortcode_param( 'movedo_ext_multi_checkbox', 'movedo_ext_vce_multi_checkbox_settings_field', MOVEDO_EXT_PLUGIN_DIR_URL . '/assets/js/movedo-ext-vc-multi-checkbox.js' );

	function movedo_ext_vce_taxonomy_tree_settings_field( $param, $param_value ) {

		$param_line = '';
		$current_value = explode(",", $param_value);
		$values = is_array($param['value']) ? $param['value'] : array();
		$taxonomy = isset( $param['taxonomy'] ) ? $param['taxonomy'] : 'category';

		$checked = in_array('', $current_value) ? ' checked="checked"' : '';
		$param_line .= '<div class="grve-taxonomy-tree-all"><input value="" class="grve-tree-input-item-all" type="checkbox" '.$checked.'> ' . esc_html( 'All Categories', "movedo-extension" ) . '</div>';

		$args = array(
			'descendants_and_self' => 0,
			'selected_cats' => $current_value,
			'popular_cats' => false,
			'walker' => null,
			'taxonomy' => $taxonomy,
			'checked_ontop' => false,
			'echo' => false,
		);

		return  '<div class="grve-taxonomy-tree-container">' .
			    '<input class="wpb_vc_param_value wpb-checkboxes '. esc_attr( $param['param_name'] ) . ' ' . esc_attr( $param['type'] ) . '_field" type="hidden" value="' . esc_attr( $param_value ) . '" name="' . esc_attr( $param['param_name'] ) . '"/>' .
				$param_line .
				'<ul class="grve-taxonomy-tree-checklist">'
				. wp_terms_checklist( '' , $args ) .
				'</ul>' .
				'</div>';

	}
	vc_add_shortcode_param( 'movedo_ext_taxonomy_tree', 'movedo_ext_vce_taxonomy_tree_settings_field', MOVEDO_EXT_PLUGIN_DIR_URL . '/assets/js/movedo-ext-vc-taxonomy-tree.js' );

}

function movedo_ext_vce_iconpicker_type_simplelineicons( $icons ) {
	$simplelineicons_icons = array(
		array( 'smp-icon-user' => 'smp-icon-user' ),
		array( 'smp-icon-people' => 'smp-icon-people' ),
		array( 'smp-icon-user-female' => 'smp-icon-user-female' ),
		array( 'smp-icon-user-follow' => 'smp-icon-user-follow' ),
		array( 'smp-icon-user-following' => 'smp-icon-user-following' ),
		array( 'smp-icon-user-unfollow' => 'smp-icon-user-unfollow' ),
		array( 'smp-icon-login' => 'smp-icon-login' ),
		array( 'smp-icon-logout' => 'smp-icon-logout' ),
		array( 'smp-icon-emotsmile' => 'smp-icon-emotsmile' ),
		array( 'smp-icon-phone' => 'smp-icon-phone' ),
		array( 'smp-icon-call-end' => 'smp-icon-call-end' ),
		array( 'smp-icon-call-in' => 'smp-icon-call-in' ),
		array( 'smp-icon-call-out' => 'smp-icon-call-out' ),
		array( 'smp-icon-map' => 'smp-icon-map' ),
		array( 'smp-icon-location-pin' => 'smp-icon-location-pin' ),
		array( 'smp-icon-direction' => 'smp-icon-direction' ),
		array( 'smp-icon-directions' => 'smp-icon-directions' ),
		array( 'smp-icon-compass' => 'smp-icon-compass' ),
		array( 'smp-icon-layers' => 'smp-icon-layers' ),
		array( 'smp-icon-menu' => 'smp-icon-menu' ),
		array( 'smp-icon-list' => 'smp-icon-list' ),
		array( 'smp-icon-options-vertical' => 'smp-icon-options-vertical' ),
		array( 'smp-icon-options' => 'smp-icon-options' ),
		array( 'smp-icon-arrow-down' => 'smp-icon-arrow-down' ),
		array( 'smp-icon-arrow-left' => 'smp-icon-arrow-left' ),
		array( 'smp-icon-arrow-right' => 'smp-icon-arrow-right' ),
		array( 'smp-icon-arrow-up' => 'smp-icon-arrow-up' ),
		array( 'smp-icon-arrow-up-circle' => 'smp-icon-up-circle' ),
		array( 'smp-icon-arrow-left-circle' => 'smp-icon-left-circle' ),
		array( 'smp-icon-arrow-right-circle' => 'smp-icon-right-circle' ),
		array( 'smp-icon-arrow-down-circle' => 'smp-icon-down-circle' ),
		array( 'smp-icon-check' => 'smp-icon-check' ),
		array( 'smp-icon-clock' => 'smp-icon-clock' ),
		array( 'smp-icon-plus' => 'smp-icon-plus' ),
		array( 'smp-icon-close' => 'smp-icon-close' ),
		array( 'smp-icon-trophy' => 'smp-icon-trophy' ),
		array( 'smp-icon-screen-smartphone' => 'smp-icon-screen-smartphone' ),
		array( 'smp-icon-screen-desktop' => 'smp-icon-screen-desktop' ),
		array( 'smp-icon-plane' => 'smp-icon-plane' ),
		array( 'smp-icon-notebook' => 'smp-icon-notebook' ),
		array( 'smp-icon-mustache' => 'smp-icon-mustache' ),
		array( 'smp-icon-mouse' => 'smp-icon-mouse' ),
		array( 'smp-icon-magnet' => 'smp-icon-magnet' ),
		array( 'smp-icon-energy' => 'smp-icon-energy' ),
		array( 'smp-icon-disc' => 'smp-icon-disc' ),
		array( 'smp-icon-cursor' => 'smp-icon-cursor' ),
		array( 'smp-icon-cursor-move' => 'smp-icon-cursor-move' ),
		array( 'smp-icon-crop' => 'smp-icon-crop' ),
		array( 'smp-icon-chemistry' => 'smp-icon-chemistry' ),
		array( 'smp-icon-speedometer' => 'smp-icon-speedometer' ),
		array( 'smp-icon-shield' => 'smp-icon-shield' ),
		array( 'smp-icon-screen-tablet' => 'smp-icon-screen-tablet' ),
		array( 'smp-icon-magic-wand' => 'smp-icon-magic-wand' ),
		array( 'smp-icon-hourglass' => 'smp-icon-hourglass' ),
		array( 'smp-icon-graduation' => 'smp-icon-graduation' ),
		array( 'smp-icon-ghost' => 'smp-icon-ghost' ),
		array( 'smp-icon-game-controller' => 'smp-icon-game-controller' ),
		array( 'smp-icon-fire' => 'smp-icon-fire' ),
		array( 'smp-icon-eyeglass' => 'smp-icon-eyeglass' ),
		array( 'smp-icon-envelope-open' => 'smp-icon-envelope-open' ),
		array( 'smp-icon-envelope-letter' => 'smp-icon-envelope-letter' ),
		array( 'smp-icon-bell' => 'smp-icon-bell' ),
		array( 'smp-icon-badge' => 'smp-icon-badge' ),
		array( 'smp-icon-anchor' => 'smp-icon-anchor' ),
		array( 'smp-icon-wallet' => 'smp-icon-wallet' ),
		array( 'smp-icon-vector' => 'smp-icon-vector' ),
		array( 'smp-icon-speech' => 'smp-icon-speech' ),
		array( 'smp-icon-puzzle' => 'smp-icon-puzzle' ),
		array( 'smp-icon-printer' => 'smp-icon-printer' ),
		array( 'smp-icon-present' => 'smp-icon-present' ),
		array( 'smp-icon-playlist' => 'smp-icon-playlist' ),
		array( 'smp-icon-pin' => 'smp-icon-pin' ),
		array( 'smp-icon-picture' => 'smp-icon-picture' ),
		array( 'smp-icon-handbag' => 'smp-icon-handbag' ),
		array( 'smp-icon-globe-alt' => 'smp-icon-globe-alt' ),
		array( 'smp-icon-globe' => 'smp-icon-globe' ),
		array( 'smp-icon-folder-alt' => 'smp-icon-folder-alt' ),
		array( 'smp-icon-folder' => 'smp-icon-folder' ),
		array( 'smp-icon-film' => 'smp-icon-film' ),
		array( 'smp-icon-feed' => 'smp-icon-feed' ),
		array( 'smp-icon-drop' => 'smp-icon-drop' ),
		array( 'smp-icon-drawar' => 'smp-icon-drawar' ),
		array( 'smp-icon-docs' => 'smp-icon-docs' ),
		array( 'smp-icon-doc' => 'smp-icon-doc' ),
		array( 'smp-icon-diamond' => 'smp-icon-diamond' ),
		array( 'smp-icon-cup' => 'smp-icon-cup' ),
		array( 'smp-icon-calculator' => 'smp-icon-calculator' ),
		array( 'smp-icon-bubbles' => 'smp-icon-bubbles' ),
		array( 'smp-icon-briefcase' => 'smp-icon-briefcase' ),
		array( 'smp-icon-book-open' => 'smp-icon-book-open' ),
		array( 'smp-icon-basket-loaded' => 'smp-icon-basket-loaded' ),
		array( 'smp-icon-basket' => 'smp-icon-basket' ),
		array( 'smp-icon-bag' => 'smp-icon-bag' ),
		array( 'smp-icon-action-undo' => 'smp-icon-action-undo' ),
		array( 'smp-icon-action-redo' => 'smp-icon-user' ),
		array( 'smp-icon-wrench' => 'smp-icon-action-redo' ),
		array( 'smp-icon-umbrella' => 'smp-icon-umbrella' ),
		array( 'smp-icon-trash' => 'smp-icon-trash' ),
		array( 'smp-icon-tag' => 'smp-icon-tag' ),
		array( 'smp-icon-support' => 'smp-icon-support' ),
		array( 'smp-icon-frame' => 'smp-icon-frame' ),
		array( 'smp-icon-size-fullscreen' => 'smp-icon-size-fullscreen' ),
		array( 'smp-icon-size-actual' => 'smp-icon-size-actual' ),
		array( 'smp-icon-shuffle' => 'smp-icon-shuffle' ),
		array( 'smp-icon-share-alt' => 'smp-icon-share-alt' ),
		array( 'smp-icon-share' => 'smp-icon-share' ),
		array( 'smp-icon-rocket' => 'smp-icon-rocket' ),
		array( 'smp-icon-question' => 'smp-icon-question' ),
		array( 'smp-icon-pie-chart' => 'smp-icon-pie-chart' ),
		array( 'smp-icon-pencil' => 'smp-icon-pencil' ),
		array( 'smp-icon-note' => 'smp-icon-note' ),
		array( 'smp-icon-loop' => 'smp-icon-loop' ),
		array( 'smp-icon-home' => 'smp-icon-home' ),
		array( 'smp-icon-grid' => 'smp-icon-grid' ),
		array( 'smp-icon-graph' => 'smp-icon-graph' ),
		array( 'smp-icon-microphone' => 'smp-icon-microphone' ),
		array( 'smp-icon-music-tone-alt' => 'smp-icon-music-tone-alt' ),
		array( 'smp-icon-music-tone' => 'smp-icon-music-tone' ),
		array( 'smp-icon-earphones-alt' => 'smp-icon-earphones-alt' ),
		array( 'smp-icon-earphones' => 'smp-icon-earphones' ),
		array( 'smp-icon-equalizer' => 'smp-icon-equalizer' ),
		array( 'smp-icon-like' => 'smp-icon-like' ),
		array( 'smp-icon-dislike' => 'smp-icon-dislike' ),
		array( 'smp-icon-control-start' => 'smp-icon-control-start' ),
		array( 'smp-icon-control-rewind' => 'smp-icon-control-rewind' ),
		array( 'smp-icon-control-play' => 'smp-icon-control-play' ),
		array( 'smp-icon-control-pause' => 'smp-icon-control-pause' ),
		array( 'smp-icon-control-forward' => 'smp-icon-control-forward' ),
		array( 'smp-icon-control-end' => 'smp-icon-control-end' ),
		array( 'smp-icon-volume-1' => 'smp-icon-volume-1' ),
		array( 'smp-icon-volume-2' => 'smp-icon-volume-2' ),
		array( 'smp-icon-volume-off' => 'smp-icon-volume-off' ),
		array( 'smp-icon-calendar' => 'smp-icon-calendar' ),
		array( 'smp-icon-bulb' => 'smp-icon-bulb' ),
		array( 'smp-icon-chart' => 'smp-icon-chart' ),
		array( 'smp-icon-ban' => 'smp-icon-ban' ),
		array( 'smp-icon-bubble' => 'smp-icon-bubble' ),
		array( 'smp-icon-camrecorder' => 'smp-icon-camrecorder' ),
		array( 'smp-icon-camera' => 'smp-icon-camera' ),
		array( 'smp-icon-cloud-download' => 'smp-icon-cloud-download' ),
		array( 'smp-icon-cloud-upload' => 'smp-icon-cloud-upload' ),
		array( 'smp-icon-envelope' => 'smp-icon-envelope' ),
		array( 'smp-icon-eye' => 'smp-icon-eye' ),
		array( 'smp-icon-flag' => 'smp-icon-flag' ),
		array( 'smp-icon-heart' => 'smp-icon-heart' ),
		array( 'smp-icon-info' => 'smp-icon-info' ),
		array( 'smp-icon-key' => 'smp-icon-key' ),
		array( 'smp-icon-link' => 'smp-icon-link' ),
		array( 'smp-icon-lock' => 'smp-icon-lock' ),
		array( 'smp-icon-lock-open' => 'smp-icon-lock-open' ),
		array( 'smp-icon-magnifier' => 'smp-icon-magnifier' ),
		array( 'smp-icon-magnifier-add' => 'smp-icon-magnifier-add' ),
		array( 'smp-icon-magnifier-remove' => 'smp-icon-magnifier-remove' ),
		array( 'smp-icon-paper-clip' => 'smp-icon-paper-clip' ),
		array( 'smp-icon-paper-plane' => 'smp-icon-paper-plane' ),
		array( 'smp-icon-power' => 'smp-icon-power' ),
		array( 'smp-icon-refresh' => 'smp-icon-refresh' ),
		array( 'smp-icon-reload' => 'smp-icon-reload' ),
		array( 'smp-icon-settings' => 'smp-icon-settings' ),
		array( 'smp-icon-star' => 'smp-icon-star' ),
		array( 'smp-icon-symble-female' => 'smp-icon-symble-female' ),
		array( 'smp-icon-symbol-male' => 'smp-icon-symbol-male' ),
		array( 'smp-icon-target' => 'smp-icon-target' ),
		array( 'smp-icon-credit-card' => 'smp-icon-credit-card' ),
		array( 'smp-icon-paypal' => 'smp-icon-paypal' ),
		array( 'smp-icon-social-tumblr' => 'smp-icon-social-tumblr' ),
		array( 'smp-icon-social-twitter' => 'smp-icon-social-twitter' ),
		array( 'smp-icon-social-facebook' => 'smp-icon-social-facebook' ),
		array( 'smp-icon-social-instagram' => 'smp-icon-social-instagram' ),
		array( 'smp-icon-social-linkedin' => 'smp-icon-social-linkedin' ),
		array( 'smp-icon-social-pinterest' => 'smp-icon-social-pinterest' ),
		array( 'smp-icon-social-github' => 'smp-icon-social-github' ),
		array( 'smp-icon-social-gplus' => 'smp-icon-social-gplus' ),
		array( 'smp-icon-social-reddit' => 'smp-icon-social-reddit' ),
		array( 'smp-icon-social-skype' => 'smp-icon-social-skype' ),
		array( 'smp-icon-social-dribbble' => 'smp-icon-social-dribbble' ),
		array( 'smp-icon-social-behance' => 'smp-icon-social-behance' ),
		array( 'smp-icon-social-foursqare' => 'smp-icon-social-foursqare' ),
		array( 'smp-icon-social-soundcloud' => 'smp-icon-social-soundcloud' ),
		array( 'smp-icon-social-spotify' => 'smp-icon-social-spotify' ),
		array( 'smp-icon-social-stumbleupon' => 'smp-icon-social-stumbleupon' ),
		array( 'smp-icon-social-youtube' => 'smp-icon-social-youtube' ),
		array( 'smp-icon-social-dropbox' => 'smp-icon-social-dropbox' ),
	);

	return array_merge( $icons, $simplelineicons_icons );
}

add_filter( 'vc_iconpicker-type-simplelineicons', 'movedo_ext_vce_iconpicker_type_simplelineicons' );

function movedo_ext_vce_iconpicker_type_etlineicons( $icons ) {
	$etlineicons_icons = array(
		array( 'et-icon-mobile' => 'et-icon-mobile' ),
		array( 'et-icon-laptop' => 'et-icon-laptop' ),
		array( 'et-icon-desktop' => 'et-icon-desktop' ),
		array( 'et-icon-tablet' => 'et-icon-tablet' ),
		array( 'et-icon-phone' => 'et-icon-phone' ),
		array( 'et-icon-document' => 'et-icon-document' ),
		array( 'et-icon-documents' => 'et-icon-documents' ),
		array( 'et-icon-search' => 'et-icon-search' ),
		array( 'et-icon-clipboard' => 'et-icon-clipboard' ),
		array( 'et-icon-newspaper' => 'et-icon-newspaper' ),
		array( 'et-icon-notebook' => 'et-icon-notebook' ),
		array( 'et-icon-book-open' => 'et-icon-book-open' ),
		array( 'et-icon-browser' => 'et-icon-browser' ),
		array( 'et-icon-calendar' => 'et-icon-calendar' ),
		array( 'et-icon-presentation' => 'et-icon-presentation' ),
		array( 'et-icon-picture' => 'et-icon-picture' ),
		array( 'et-icon-pictures' => 'et-icon-pictures' ),
		array( 'et-icon-video' => 'et-icon-video' ),
		array( 'et-icon-camera' => 'et-icon-camera' ),
		array( 'et-icon-printer' => 'et-icon-printer' ),
		array( 'et-icon-toolbox' => 'et-icon-toolbox' ),
		array( 'et-icon-briefcase' => 'et-icon-briefcase' ),
		array( 'et-icon-wallet' => 'et-icon-wallet' ),
		array( 'et-icon-gift' => 'et-icon-gift' ),
		array( 'et-icon-bargraph' => 'et-icon-bargraph' ),
		array( 'et-icon-grid' => 'et-icon-grid' ),
		array( 'et-icon-expand' => 'et-icon-expand' ),
		array( 'et-icon-focus' => 'et-icon-focus' ),
		array( 'et-icon-edit' => 'et-icon-edit' ),
		array( 'et-icon-adjustments' => 'et-icon-adjustments' ),
		array( 'et-icon-ribbon' => 'et-icon-ribbon' ),
		array( 'et-icon-hourglass' => 'et-icon-hourglass' ),
		array( 'et-icon-lock' => 'et-icon-lock' ),
		array( 'et-icon-megaphone' => 'et-icon-megaphone' ),
		array( 'et-icon-shield' => 'et-icon-shield' ),
		array( 'et-icon-trophy' => 'et-icon-trophy' ),
		array( 'et-icon-flag' => 'et-icon-flag' ),
		array( 'et-icon-map' => 'et-icon-map' ),
		array( 'et-icon-puzzle' => 'et-icon-puzzle' ),
		array( 'et-icon-basket' => 'et-icon-basket' ),
		array( 'et-icon-envelope' => 'et-icon-envelope' ),
		array( 'et-icon-streetsign' => 'et-icon-streetsign' ),
		array( 'et-icon-telescope' => 'et-icon-telescope' ),
		array( 'et-icon-gears' => 'et-icon-gears' ),
		array( 'et-icon-key' => 'et-icon-key' ),
		array( 'et-icon-paperclip' => 'et-icon-paperclip' ),
		array( 'et-icon-attachment' => 'et-icon-attachment' ),
		array( 'et-icon-pricetags' => 'et-icon-pricetags' ),
		array( 'et-icon-lightbulb' => 'et-icon-lightbulb' ),
		array( 'et-icon-layers' => 'et-icon-layers' ),
		array( 'et-icon-pencil' => 'et-icon-pencil' ),
		array( 'et-icon-tools' => 'et-icon-tools' ),
		array( 'et-icon-tools-2' => 'et-icon-tools-2' ),
		array( 'et-icon-scissors' => 'et-icon-scissors' ),
		array( 'et-icon-paintbrush' => 'et-icon-paintbrush' ),
		array( 'et-icon-magnifying-glass' => 'et-icon-magnifying-glass' ),
		array( 'et-icon-circle-compass' => 'et-icon-circle-compass' ),
		array( 'et-icon-linegraph' => 'et-icon-linegraph' ),
		array( 'et-icon-mic' => 'et-icon-mic' ),
		array( 'et-icon-strategy' => 'et-icon-strategy' ),
		array( 'et-icon-beaker' => 'et-icon-beaker' ),
		array( 'et-icon-caution' => 'et-icon-caution' ),
		array( 'et-icon-recycle' => 'et-icon-recycle' ),
		array( 'et-icon-anchor' => 'et-icon-anchor' ),
		array( 'et-icon-profile-male' => 'et-icon-profile-male' ),
		array( 'et-icon-profile-female' => 'et-icon-profile-female' ),
		array( 'et-icon-bike' => 'et-icon-bike' ),
		array( 'et-icon-wine' => 'et-icon-wine' ),
		array( 'et-icon-hotairballoon' => 'et-icon-hotairballoon' ),
		array( 'et-icon-globe' => 'et-icon-globe' ),
		array( 'et-icon-genius' => 'et-icon-genius' ),
		array( 'et-icon-map-pin' => 'et-icon-map-pin' ),
		array( 'et-icon-dial' => 'et-icon-dial' ),
		array( 'et-icon-chat' => 'et-icon-chat' ),
		array( 'et-icon-heart' => 'et-icon-heart' ),
		array( 'et-icon-cloud' => 'et-icon-cloud' ),
		array( 'et-icon-upload' => 'et-icon-upload' ),
		array( 'et-icon-download' => 'et-icon-download' ),
		array( 'et-icon-target' => 'et-icon-target' ),
		array( 'et-icon-hazardous' => 'et-icon-hazardous' ),
		array( 'et-icon-piechart' => 'et-icon-piechart' ),
		array( 'et-icon-speedometer' => 'et-icon-speedometer' ),
		array( 'et-icon-global' => 'et-icon-global' ),
		array( 'et-icon-compass' => 'et-icon-compass' ),
		array( 'et-icon-lifesaver' => 'et-icon-lifesaver' ),
		array( 'et-icon-clock' => 'et-icon-clock' ),
		array( 'et-icon-aperture' => 'et-icon-aperture' ),
		array( 'et-icon-quote' => 'et-icon-quote' ),
		array( 'et-icon-scope' => 'et-icon-scope' ),
		array( 'et-icon-alarmclock' => 'et-icon-alarmclock' ),
		array( 'et-icon-refresh' => 'et-icon-refresh' ),
		array( 'et-icon-happy' => 'et-icon-happy' ),
		array( 'et-icon-sad' => 'et-icon-sad' ),
		array( 'et-icon-facebook' => 'et-icon-facebook' ),
		array( 'et-icon-twitter' => 'et-icon-twitter' ),
		array( 'et-icon-googleplus' => 'et-icon-googleplus' ),
		array( 'et-icon-rss' => 'et-icon-rss' ),
		array( 'et-icon-tumblr' => 'et-icon-tumblr' ),
		array( 'et-icon-linkedin' => 'et-icon-linkedin' ),
		array( 'et-icon-dribbble' => 'et-icon-dribbble' ),
	);

	return array_merge( $icons, $etlineicons_icons );
}

add_filter( 'vc_iconpicker-type-etlineicons', 'movedo_ext_vce_iconpicker_type_etlineicons' );


function movedo_ext_vce_icon_element_fonts_enqueue( $font ) {
	switch ( $font ) {
		case 'simplelineicons':
			wp_enqueue_style( 'movedo-ext-vc-simple-line-icons' );
		break;
		case 'etlineicons':
			wp_enqueue_style( 'movedo-ext-vc-elegant-line-icons' );
		break;
		default:
		break;
	}
}
add_action( 'vc_enqueue_font_icon_element', 'movedo_ext_vce_icon_element_fonts_enqueue' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
