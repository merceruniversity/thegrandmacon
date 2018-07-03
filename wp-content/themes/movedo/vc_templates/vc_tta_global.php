<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $this WPBakeryShortCode_VC_Tta_Accordion|WPBakeryShortCode_VC_Tta_Tabs|WPBakeryShortCode_VC_Tta_Tour|WPBakeryShortCode_VC_Tta_Pageable
 */
$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

if ( 'vc_tta_tabs' == $this->shortcode || 'vc_tta_tour' == $this->shortcode ) {

	$this->setGlobalTtaInfo();
	$prepareContent = $this->getTemplateVariable( 'content' );
	$class_to_filter = '';
	$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
	$active_section = $this->getActiveSection( $atts, false );
	$isPageEditable = vc_is_page_editable();

	$heading = movedo_grve_array_value( $atts, 'heading', 'h3' );
	$heading_tag = movedo_grve_array_value( $atts, 'heading_tag', 'h6' );
	$custom_font_family = movedo_grve_array_value( $atts, 'custom_font_family' );
	$el_id = movedo_grve_array_value( $atts, 'el_id' );

	$wrapper_attributes = array();
	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}
	if ( 'vc_tta_tabs' == $this->shortcode ) {
		$wrapper_attributes[] = 'class="grve-element grve-tab grve-horizontal-tab ' . esc_attr( $css_class ) . '"';
	} else {
		$wrapper_attributes[] = 'class="grve-element grve-tab grve-vertical-tab ' . esc_attr( $css_class ) . '"';
	}

	$output = '<div ' . implode( ' ', $wrapper_attributes ) . '>';

	$title_classes = array( 'grve-title' );
	if ( !empty( $custom_font_family ) ) {
		$title_classes[] ='grve-' . $custom_font_family;
	}
	$title_classes[] ='grve-' . $heading;
	$title_class_string = implode( ' ', $title_classes );

	$tabs_title_classes = array( 'grve-tabs-title' );
	$tabs_title_classes[] = "grve-align-" . $alignment;
	if ( 'vc_tta_tour' == $this->shortcode ) {
		if( empty( $controls_size ) ) {
			$controls_size = "md";
		}
		$tabs_title_classes[] = "grve-width-" . $controls_size ;
		if( empty( $tab_position ) ) {
			$tab_position = "left";
		}
		$tabs_title_classes[] = "grve-position-" . $tab_position ;
	}
	$tabs_title_class_string = implode( ' ', $tabs_title_classes );

	//Tabs Top Title Wrapper
	$output .= '<div class="' . esc_attr( $tabs_title_class_string ) . '">';
	foreach ( WPBakeryShortCode_VC_Tta_Section::$section_info as $nth => $section ) {
		$classes = array( 'grve-tab-title', 'grve-tab-link' );
		if ( ( $nth + 1 ) === $active_section ) {
			$classes[] = 'active';
		}
		$icon_html = '';
		if ( 'true' === $section['add_icon'] ) {
			if ( 'left' === $section['i_position'] ) {
				$icon_html = '<span class="grve-tab-icon grve-position-left">';
				$icon_html .= $this->constructIcon( $section );
				$icon_html .= '</span>';
			} else {
				$icon_html = '<span class="grve-tab-icon grve-position-right">';
				$icon_html .= $this->constructIcon( $section );
				$icon_html .= '</span>';
			}
		}
		$title = '<' . tag_escape( $heading_tag ) .' class="' . esc_attr( $title_class_string ) . '">' . $icon_html . $section['title'] . '</' . tag_escape( $heading_tag ) .'>';
		$output .= '<div class="' . implode( ' ', $classes ) . '" data-rel="#' . $section['tab_id'] . '">' . $title . '</div>';
	}
	$output .= '</div>';


	//Tabs Wrapper
	$output .= '<div class="grve-tabs-wrapper">';

	foreach ( WPBakeryShortCode_VC_Tta_Section::$section_info as $nth => $section ) {

		$content_classes = array( 'grve-tab-content' );
		if ( ( $nth + 1 ) === $active_section ) {
			$content_classes[] = 'active';
		}
		if ( isset( $section['el_class'] ) ) {
			$content_classes[] = $section['el_class'];
		}
		$content_classes_string = implode( ' ', array_filter( $content_classes ) );

		$output .= '<div class="grve-tab-section">';

		$classes = array( 'grve-tab-title', 'grve-tab-link' );
		if ( ( $nth + 1 ) === $active_section ) {
			$classes[] = 'active';
		}
		$icon_html = '';
		if ( 'true' === $section['add_icon'] ) {
			if ( 'left' === $section['i_position'] ) {
				$icon_html = '<span class="grve-tab-icon grve-position-left">';
				$icon_html .= $this->constructIcon( $section );
				$icon_html .= '</span>';
			} else {
				$icon_html = '<span class="grve-tab-icon grve-position-right">';
				$icon_html .= $this->constructIcon( $section );
				$icon_html .= '</span>';
			}
		}
		$title = '<' . tag_escape( $heading_tag ) .' class="' . esc_attr( $title_class_string ) . '">' . $icon_html . $section['title'] . '</' . tag_escape( $heading_tag ) .'>';
		$output .= '<div class="' . implode( ' ', $classes ) . '" data-rel="#' . $section['tab_id'] . '">' . $title . '</div>';


		$output .= '<div class="' . esc_attr( $content_classes_string ) . '" id="' . esc_attr( $section['tab_id'] ) . '">';
		if ( $isPageEditable ) {
			$output .= '<div data-js-panel-body>';
		}
		$output .= do_shortcode( $section['content'] );
		if ( $isPageEditable ) {
			$output .= '</div>';
		}
		$output .= '</div>';

		$output .= '</div>'; // End Tab Section

	}

	$output .= '</div>';
	$output .= '</div>';

} elseif ( 'vc_tta_accordion' == $this->shortcode ) {

	$this->setGlobalTtaInfo();
	$prepareContent = $this->getTemplateVariable( 'content' );
	$class_to_filter = '';
	$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
	$active_section = $this->getActiveSection( $atts, false );
	$heading = movedo_grve_array_value( $atts, 'heading', 'h3' );
	$heading_tag = movedo_grve_array_value( $atts, 'heading_tag', 'h6' );
	$custom_font_family = movedo_grve_array_value( $atts, 'custom_font_family' );
	$accordion_style = movedo_grve_array_value( $atts, 'accordion_style', 'style-1' );
	$el_id = movedo_grve_array_value( $atts, 'el_id' );

	$title_classes = array( 'grve-title' );
	if ( !empty( $custom_font_family ) ) {
		$title_classes[] ='grve-' . $custom_font_family;
	}
	$title_classes[] ='grve-' . $heading;
	$title_class_string = implode( ' ', $title_classes );

	$css_accordion_class = array( 'grve-accordion-wrapper' );

	if ( isset( $atts['collapsible_all'] ) && 'true' === $atts['collapsible_all'] ) {
		$css_accordion_class[] = "grve-action-toggle";
	} else {
		$css_accordion_class[] = "grve-action-accordion";
	}

	$css_accordion_class[] = "grve-" . $accordion_style;

	$css_accordion_class_string = implode( ' ', $css_accordion_class );

	if ( !isset( $atts['c_align'] ) || empty( $atts['c_align'] ) ) {
		$atts['c_align'] = "left";
	}

	$wrapper_attributes = array();
	$wrapper_attributes[] = 'class="grve-element grve-accordion ' . esc_attr( $css_class ) . '"';

	if ( ! empty( $el_id ) ) {
		$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
	}

	$output = '<div ' . implode( ' ', $wrapper_attributes ) . '>';
	$output .= '<ul class="' . esc_attr( $css_accordion_class_string ) . '">';
	foreach ( WPBakeryShortCode_VC_Tta_Section::$section_info as $nth => $section ) {
		$classesTitle = array( 'grve-title-wrapper', 'grve-tab-link' );
		$classesTitle[] = "grve-align-" . $atts['c_align'];
		$classesContent = array( 'grve-accordion-content' );
		if ( ( $nth + 1 ) === $active_section ) {
			$classesTitle[] = 'active';
			$classesContent[] = 'active';
		}
		$title_wrapper = '';
		$title_wrapper .= '<div class="' . implode( ' ', $classesTitle ) . '" data-rel="#' . esc_attr( $section['tab_id'] ) . '">';
		if ( isset( $atts['c_icon'] ) && strlen( $atts['c_icon'] ) > 0 ) {

			if ( !isset( $atts['c_position'] ) || empty( $atts['c_position'] ) ) {
				$atts['c_position'] = "left";
			}

			if( 'triangle' == $atts['c_icon'] ) {
				$title_wrapper .= '<div class="grve-accordion-arrow grve-accordion-triangle grve-position-' . esc_attr( $atts['c_position'] ) . '"><i class="fa fa-caret-right"></i></div>';
			} elseif( 'chevron' == $atts['c_icon'] ) {
				$title_wrapper .= '<div class="grve-accordion-arrow grve-accordion-chevron grve-position-' . esc_attr( $atts['c_position'] ) . '"><i class="fa fa-chevron-down"></i></div>';
			} else {
				$title_wrapper .= '<div class="grve-accordion-arrow grve-accordion-plus grve-position-' . esc_attr( $atts['c_position'] ) . '"><i class="fa fa-plus"></i></div>';
			}
		}

		$icon_html = '';
		if ( 'true' === $section['add_icon'] ) {
			$iconClass = '';
			if ( isset( $section[ 'i_icon_' . $section['i_type'] ] ) ) {
				$iconClass = $section[ 'i_icon_' . $section['i_type'] ];
			}
			vc_icon_element_fonts_enqueue( $section['i_type'] );
			if ( 'left' === $section['i_position'] ) {
				$icon_html = '<span class="grve-accordion-icon grve-position-left">';
				$icon_html .= '<i class="' . esc_attr( $iconClass ) . '"></i>';
				$icon_html .= '</span>';
			} else {
				$icon_html = '<span class="grve-accordion-icon grve-position-right">';
				$icon_html .= '<i class="' . esc_attr( $iconClass ) . '"></i>';
				$icon_html .= '</span>';
			}
		}
		$title = '<' . tag_escape( $heading_tag ) .' class="' . esc_attr( $title_class_string ) . '">' . $icon_html . $section['title'] . '</' . tag_escape( $heading_tag ) .'>';
		$title_wrapper .= $title ;
		$title_wrapper .= '</div>';

		$content = '';
		$content .= '<div class="' . implode( ' ', $classesContent ) . '" id="' . esc_attr( $section['tab_id'] ) . '">';
		$content .= do_shortcode( $section['content'] );
		$content .= '</div>';

		$a_html = '';
		$a_html .= $title_wrapper;
		$a_html .= $content;
		$output .= '<li>' . $a_html . '</li>';

	}
	$output .= '</ul>';
	$output .= '</div>';

} else {

	$this->setGlobalTtaInfo();

	$this->enqueueTtaStyles();
	$this->enqueueTtaScript();

	// It is required to be before tabs-list-top/left/bottom/right for tabs/tours
	$prepareContent = $this->getTemplateVariable( 'content' );

	$class_to_filter = $this->getTtaGeneralClasses();
	$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

	$output = '<div ' . $this->getWrapperAttributes() . '>';
	$output .= $this->getTemplateVariable( 'title' );
	$output .= '<div class="' . esc_attr( $css_class ) . '">';
	$output .= $this->getTemplateVariable( 'tabs-list-top' );
	$output .= $this->getTemplateVariable( 'tabs-list-left' );
	$output .= '<div class="vc_tta-panels-container">';
	$output .= $this->getTemplateVariable( 'pagination-top' );
	$output .= '<div class="vc_tta-panels">';
	$output .= $prepareContent;
	$output .= '</div>';
	$output .= $this->getTemplateVariable( 'pagination-bottom' );
	$output .= '</div>';
	$output .= $this->getTemplateVariable( 'tabs-list-bottom' );
	$output .= $this->getTemplateVariable( 'tabs-list-right' );
	$output .= '</div>';
	$output .= '</div>';

}



echo $output;
