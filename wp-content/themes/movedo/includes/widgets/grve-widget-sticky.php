<?php
/**
 * Plugin Name: Greatives Sticky
 * Description: A widget that displays a sticky divider.
 * @author		Greatives Team
 * @URI			http://greatives.eu
 */

add_action( 'widgets_init', 'movedo_grve_widget_sticky' );

function movedo_grve_widget_sticky() {
	register_widget( 'Movedo_GRVE_Widget_Sticky' );
}

class Movedo_GRVE_Widget_Sticky extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'grve-sticky-widget',
			'description' => esc_html__( 'Place this widget into any sidebar area, just above the widget which you want to be the first sticky widget element.', 'movedo'),
		);
		$control_ops = array(
			'width' => 300,
			'height' => 400,
			'id_base' => 'grve-sticky-widget',
		);
		parent::__construct( 'grve-sticky-widget', '(Greatives) ' . esc_html__( 'Sticky Widget', 'movedo' ), $widget_ops, $control_ops );
	}

	function Movedo_GRVE_Widget_Latest_Posts() {
		$this->__construct();
	}

	function widget( $args, $instance ) {
		echo '<div class="grve-widget widget grve-sticky-widget"></div>';
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		return $instance;
	}
}

//Omit closing PHP tag to avoid accidental whitespace output errors.
