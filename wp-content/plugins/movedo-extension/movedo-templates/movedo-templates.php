<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class Movedo_Vc_Templates
 */
class Movedo_Vc_Templates {
	/**
	 * @var bool
	 */
	protected $initialized = false;

	/**
	 *
	 */
	public function init() {
		if ( $this->initialized ) {
			return;
		}
		$this->initialized = true;

		add_filter( 'vc_templates_render_category', array(
			$this,
			'renderTemplateBlock',
		), 10 );

		add_filter( 'vc_get_all_templates', array(
			$this,
			'addTemplatesTab',
		) );
		add_filter( 'vc_templates_render_frontend_template', array(
			$this,
			'renderFrontendTemplate',
		), 10, 2 );
		add_filter( 'vc_templates_render_backend_template', array(
			$this,
			'renderBackendTemplate',
		), 10, 2 );
		add_filter( 'vc_templates_render_backend_template_preview', array(
			$this,
			'renderBackendTemplate',
		), 10, 2 );

	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function addTemplatesTab( $data ) {
		$newCategory = array(
			'category' => 'movedo_templates',
			'category_name' => esc_html__( 'Content Manager', 'movedo-extension' ),
			'category_weight' => 9,
			'templates' => $this->getTemplates(),
		);
		$data[] = $newCategory;

		return $data;
	}

	/**
	 * @param $category
	 *
	 * @return mixed
	 */
	public function renderTemplateBlock( $category ) {
		if ( 'movedo_templates' === $category['category'] ) {
			$category['output'] = $this->getTemplateBlockTemplate();
		}
		return $category;
	}

	/**
	 * @return string
	 */
	private function getTemplateBlockTemplate() {
		ob_start();
		$this->movedo_vc_include_template( 'movedo-templates/category.tpl.php', array(
			'controller' => $this,
			'templates' => $this->getTemplates(),
			'filters' => $this->getFilters(),
		) );

		return ob_get_clean();
	}

	public function movedo_vc_include_template( $template, $variables = array(), $once = false ) {
		is_array( $variables ) && extract( $variables );
		if ( $once ) {
			return require_once MOVEDO_EXT_PLUGIN_DIR_PATH . $template;
		} else {
			return require MOVEDO_EXT_PLUGIN_DIR_PATH . $template;
		}
	}

	public function renderBackendTemplate( $templateId, $templateType ) {
		if ( 'movedo_templates' === $templateType ) {
			$templates = $this->getTemplates();
			if ( ! is_numeric( $templateId ) || ! is_array( $templates ) || ! isset( $templates[ $templateId ] ) ) {
				wp_send_json_error( array(
					'code' => 'Wrong ID or no Template found',
				) );
			} else {
				$data =  $templates[ $templateId ];
				return trim( $data['content'] );
			}
		}
		return $templateId;
	}

	public function renderFrontendTemplate( $templateId, $templateType ) {
		if ( 'movedo_templates' === $templateType ) {
			$templates = $this->getTemplates();
			if ( ! is_numeric( $templateId ) || ! is_array( $templates ) || ! isset( $templates[ $templateId ] ) ) {
				wp_send_json_error( array(
					'code' => 'Wrong ID or no Template found',
				) );
			} else {
				$data = $templates[ $templateId ];
				vc_frontend_editor()->setTemplateContent( trim( $data['content'] ) );
				vc_frontend_editor()->enqueueRequired();
				vc_include_template( 'editors/frontend_template.tpl.php', array(
					'editor' => vc_frontend_editor(),
				) );
				die();
			}
		}

		return $templateId;
	}

	public function getFilters() {
		return array(
			'*' => esc_html__( 'All', 'movedo-extension' ),
			'homepage' => esc_html__( 'Homepage', 'movedo-extension' ),
			'demo-corporate' => esc_html__( 'Corporate Demo', 'movedo-extension' ),
			'demo-creative-agency' => esc_html__( 'Creative Agency Demo', 'movedo-extension' ),
			'demo-modern-corporate' => esc_html__( 'Modern Corporate Demo', 'movedo-extension' ),
			'demo-construction' => esc_html__( 'Construction Demo', 'movedo-extension' ),
			'demo-landing' => esc_html__( 'Landing Demo', 'movedo-extension' ),
			'demo-travel' => esc_html__( 'Travel Demo', 'movedo-extension' ),
			'demo-restaurant' => esc_html__( 'Restaurant Demo', 'movedo-extension' ),
			'demo-lawyer' => esc_html__( 'Lawyer Demo', 'movedo-extension' ),
			'page' => esc_html__( 'Page', 'movedo-extension' ),
			'parallax' => esc_html__( 'Parallax', 'movedo-extension' ),
			'counters' => esc_html__( 'Counters', 'movedo-extension' ),
			'steps' => esc_html__( 'Steps', 'movedo-extension' ),
			'iconbox' => esc_html__( 'Icon Box', 'movedo-extension' ),
			'call-action' => esc_html__( 'Call to Action', 'movedo-extension' ),
			'pricing' => esc_html__( 'Pricing', 'movedo-extension' ),
			'typography' => esc_html__( 'Typography', 'movedo-extension' ),
			'split' => esc_html__( 'Split Content', 'movedo-extension' ),
		);
	}

	public function getTemplates() {

		$templates = array();

// Demo Modern Corporate
$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-01.jpg');
$data['custom_class'] = 'demo-modern-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row section_full_height="fullheight" padding_top_multiplier="custom" padding_bottom_multiplier="custom" padding_top="12%" padding_bottom="12%"][vc_column width="5/12" tablet_sm_width="1-2" heading_color="primary-1" z_index="3"][movedo_empty_space height_multiplier="2x"][movedo_title heading_tag="h1" heading="h1" increase_heading="160" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" animation_delay="600" margin_bottom="0"]We design +[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="160" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" animation_delay="800" margin_bottom="0"]build digital[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="160" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" animation_delay="1000" margin_bottom="0"]experiences.[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="2000" animation_duration="very-slow"]The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question.[/vc_column_text][movedo_empty_space][movedo_button animation="grve-fade-in-up" animation_delay="2200" animation_duration="very-slow" button_text="Decent Success" button_color="black" button_hover_color="primary-1" button_shape="round" button_link="url:%23|||"][/vc_column][vc_column width="7/12" tablet_sm_width="1-2"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" image_column_space="125" align="right" animation="grve-clipping-animation" clipping_animation="grve-clipping-right"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-02.jpg');
$data['custom_class'] = 'demo-modern-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" bg_color="#e6ecf1"][vc_column width="2/3" tablet_sm_width="1" heading_color="light" clipping_animation="colored-clipping-left" animation_delay="600" css=".vc_custom_1518337321399{padding-top: 12% !important;padding-right: 17% !important;padding-bottom: 12% !important;padding-left: 17% !important;background-color: #f9224b !important;}" font_color="#ffffff"][movedo_title heading_tag="h2" heading="h1" increase_heading="180" margin_bottom="0"]Your moment[/movedo_title][movedo_title heading_tag="h2" heading="h1" increase_heading="180" margin_bottom="0"]to shine has arrived.[/movedo_title][/vc_column][vc_column column_effect="mouse-move-x-y" column_effect_limit="3x" column_effect_invert="true" column_custom_position="yes" position_top="minus-3x" position_left="minus-3x" width="1/3" tablet_sm_width="1" tablet_portrait_column_positions="none" mobile_column_positions="none" shadow="large" clipping_animation="colored-clipping-left" clipping_animation_colors="primary-1" animation_delay="800" css=".vc_custom_1518337326879{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #ffffff !important;border-radius: 10px !important;}"][movedo_title]Let’s work together[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.[/vc_column_text][movedo_empty_space][movedo_button button_text="Stay Connected" button_shape="round" button_shadow="medium" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-corporate-ii%2Fcontact%2F|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-03.jpg');
$data['custom_class'] = 'demo-modern-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x"][vc_column][movedo_single_image image_mode="large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" animation_delay="600"][/vc_column][vc_column mobile_width="hide"][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="7/12" tablet_sm_width="1-2"][movedo_title heading="leader-text" increase_heading="200" animation="grve-fade-in" animation_delay="1000"]<span style="color: #f9224b;">It literally sets in motion a series of new features.</span>[/movedo_title][movedo_empty_space][movedo_title heading="h6" animation="grve-fade-in" animation_delay="1200"]<span style="color: #f9224b;">01.</span> Because beauty has multiple paths[/movedo_title][movedo_title heading="h6" animation="grve-fade-in" animation_delay="1400"]<span style="color: #f9224b;">02.</span> Support all the way through[/movedo_title][/vc_column][vc_column width="1/12" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column column_custom_position="yes" position_top="minus-6x" position_left="3x" width="1/3" tablet_sm_width="1-2" tablet_landscape_column_positions="none" tablet_portrait_column_positions="none" mobile_column_positions="none" heading_color="light" clipping_animation="colored-clipping-up" clipping_animation_colors="primary-1" animation_delay="800" css=".vc_custom_1518337341729{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #000000 !important;border-radius: 10px !important;}" font_color="#ffffff"][movedo_single_image image="" retina_image=""][movedo_empty_space][movedo_title heading="h5" align="center"]We guarantee you support for every buyer of Movedo.[/movedo_title][movedo_empty_space][movedo_title heading="link-text" align="center"]Passion is key[/movedo_title][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-04.jpg');
$data['custom_class'] = 'demo-modern-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column"][vc_column vertical_content_position="middle" width="1/2" tablet_width="hide" tablet_sm_width="hide" mobile_width="hide" css=".vc_custom_1518253469579{padding-right: 25% !important;padding-left: 25% !important;}"][movedo_empty_space height_multiplier="2x"][movedo_title heading="h2"]Movedo WP theme masterfully handcrafted for awesomeness.[/movedo_title][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/4" tablet_width="1-2" tablet_sm_width="1-2" mobile_width="1-2" css=".vc_custom_1518337425544{background-color: #161616 !important;}"][movedo_single_image image_mode="medium" image="" image_full_column="yes" animation="grve-clipping-animation" animation_delay="800"][/vc_column][vc_column width="1/4" tablet_width="1-2" tablet_sm_width="1-2" mobile_width="1-2" css=".vc_custom_1518337430089{background-color: #000000 !important;}"][movedo_single_image image_mode="medium" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-clipping-down" animation_delay="800"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-05.jpg');
$data['custom_class'] = 'demo-modern-corporate page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="custom" padding_bottom_multiplier="" padding_top="12%"][vc_column][movedo_single_image image_mode="large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-clipping-down" animation_delay="600"][/vc_column][vc_column column_custom_position="yes" position_top="minus-3x" position_left="minus-3x" width="1/3" tablet_width="1-2" tablet_sm_width="1-2" tablet_landscape_column_positions="none" tablet_portrait_column_positions="none" mobile_column_positions="none" heading_color="light" clipping_animation="colored-clipping-up" animation_delay="1000" css=".vc_custom_1518337846293{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #f9224b !important;}" font_color="rgba(255,255,255,0.91)"][movedo_slogan title="Our Vision" heading_tag="h1" heading="h3" subtitle="Passion is key" button_text="Read More" button_color="white" button_shape="round" button_shadow="medium" button_link="url:%23|||" button2_text=""]When she reached the first hills of the Italic Mountains she had a last view back on the skyline[/movedo_slogan][/vc_column][vc_column width="1/4" tablet_width="hide" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="5/12" tablet_sm_width="1-2"][vc_row_inner][vc_column_inner width="1/2" tablet_sm_width="1"][movedo_empty_space height_multiplier="3x"][movedo_title heading="h6" animation="grve-fade-in-up" animation_delay="2000" animation_duration="very-slow"]Keep it simple[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="2100" animation_duration="very-slow"]Even the all-powerful Pointing has no control about the blind texts it is an almost.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2" tablet_sm_width="1"][movedo_empty_space height_multiplier="3x"][movedo_title heading="h6" animation="grve-fade-in-up" animation_delay="2200" animation_duration="very-slow"]Enjoy your days[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="2300" animation_duration="very-slow"]Even the all-powerful Pointing has no control about the blind texts it is an almost.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-06.jpg');
$data['custom_class'] = 'demo-modern-corporate page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" equal_column_height="middle-content" tablet_portrait_equal_column_height="false" mobile_equal_column_height="false"][vc_column width="1/3" tablet_sm_width="1-2" clipping_animation="clipping-down" animation_delay="600"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation_delay="600"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2" clipping_animation="clipping-down" animation_delay="800"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation_delay="800"][/vc_column][vc_column width="1/3" tablet_sm_width="1" heading_color="light" clipping_animation="clipping-down" animation_delay="1000" css=".vc_custom_1518337743151{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #000000 !important;}" font_color="rgba(255,255,255,0.91)"][movedo_slogan title="Fresh Ideas" heading_tag="h1" heading="h3" subtitle="Enjoy your days" button_text="Read More" button_hover_color="white" button_shape="round" button_link="url:%23|||" button2_text=""]When she reached the first hills of the Italic Mountains she had a last view back on the skyline. [/movedo_slogan][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-7';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 7', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-07.jpg');
$data['custom_class'] = 'demo-modern-corporate page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="custom" padding_bottom_multiplier="" padding_top="8%"][vc_column column_custom_position="yes" position_top="4x" width="5/12" tablet_width="7-12" tablet_sm_width="2-3" heading_color="light" clipping_animation="colored-clipping-up" clipping_animation_colors="primary-1" animation_delay="600" css=".vc_custom_1518338125231{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #000000 !important;}" font_color="rgba(255,255,255,0.9)"][movedo_title heading="h6" margin_bottom="12"]Our Services[/movedo_title][movedo_title heading_tag="h1" heading="h2"]We are a team of creatives.[/movedo_title][vc_column_text]The Movedo Generation of multi-purpose themes is here. In a marketplace volatile you need to build confident themes.[/vc_column_text][movedo_empty_space][movedo_title heading="h6" margin_bottom="6"]<span style="color: #f9224b;">01.</span> Your site will look sharp[/movedo_title][movedo_title heading="h6" margin_bottom="6"]<span style="color: #f9224b;">02.</span> Support all the way through[/movedo_title][movedo_title heading="h6"]<span style="color: #f9224b;">03.</span> We give you digital solutions[/movedo_title][/vc_column][vc_column width="7/12" tablet_width="5-12" tablet_sm_width="1-3"][/vc_column][/vc_row][vc_row bg_type="image" bg_image="" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none"][vc_column animation_delay="1000" css=".vc_custom_1518338196247{background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_empty_space height_multiplier="6x"][movedo_empty_space height_multiplier="6x"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-8';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 8', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-08.jpg');
$data['custom_class'] = 'demo-modern-corporate page split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="none" font_color="#ffffff"][vc_column column_custom_position="yes" position_top="minus-3x" width="1/2" tablet_sm_width="1" tablet_portrait_column_positions="none" mobile_column_positions="none" clipping_animation="colored-clipping-right" clipping_animation_colors="primary-1" animation_delay="600" css=".vc_custom_1518338262348{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-corporate-ii/wp-content/uploads/sites/12/2018/02/movedo-corporate-bg-02.jpg?id=135) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_title heading="h2"]Support all the way through[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.[/vc_column_text][movedo_empty_space][movedo_button button_text="Read more about" button_type="outline" button_color="white" button_hover_color="white" button_shape="round" button_link="url:%23|||"][/vc_column][vc_column column_custom_position="yes" position_top="2x" width="1/2" tablet_sm_width="1" tablet_portrait_column_positions="none" mobile_column_positions="none" clipping_animation="colored-clipping-left" animation_delay="600" css=".vc_custom_1518338270729{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #f9224b !important;}"][movedo_title heading="h2"]What we</p>
<p>can do for you?[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.[/vc_column_text][movedo_empty_space][movedo_button button_text="Stay Connected" button_color="white" button_shape="round" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-9';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Section 9', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-09.jpg');
$data['custom_class'] = 'demo-modern-corporate page split';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="custom" padding_bottom_multiplier="3x" padding_top="12%"][vc_column width="1/2"][movedo_title heading_tag="h1" heading="h1" increase_heading="160" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" clipping_animation_colors="light" animation_delay="400" margin_bottom="0"]Don’t be shy,[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="160" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" clipping_animation_colors="primary-1" animation_delay="600" margin_bottom="0"]say hello![/movedo_title][/vc_column][vc_column width="1/2"][/vc_column][/vc_row][vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="middle-content" bg_color="#f4f6fb"][vc_column width="2/3" tablet_width="1-2" tablet_sm_width="1" clipping_animation="colored-clipping-left" animation_delay="800"][movedo_gmap map_zoom="14" map_height="500" map_mode="multiple" map_marker_type="pulse-dot" map_marker_bg_color="white" map_points="%5B%7B%22title%22%3A%22Main%20Office%22%2C%22lat%22%3A%2251.516221%22%2C%22lng%22%3A%22-0.136986%22%2C%22infotext%22%3A%22Do%20not%20hesitate%20to%20contact%20us%22%2C%22infotext_open%22%3A%22no%22%7D%2C%7B%22title%22%3A%22Sales%22%2C%22lat%22%3A%2251.507351%22%2C%22lng%22%3A%22-0.127758%22%2C%22infotext%22%3A%22Cheers!%22%2C%22infotext_open%22%3A%22no%22%7D%5D"][/vc_column][vc_column column_custom_position="yes" position_top="minus-3x" position_left="minus-3x" width="1/3" tablet_width="1-2" tablet_sm_width="1" tablet_portrait_column_positions="none" mobile_column_positions="none" shadow="large" clipping_animation="colored-clipping-right" clipping_animation_colors="primary-1" animation_delay="1200" css=".vc_custom_1518338397373{padding-top: 17% !important;padding-right: 17% !important;padding-bottom: 17% !important;padding-left: 17% !important;background-color: #ffffff !important;border-radius: 10px !important;}"][vc_row_inner][vc_column_inner width="1/2"][movedo_title]Address[/movedo_title][vc_column_text]Movedo Constructions<br />
38 Oatland Avenue<br />
Chicago, Illinois<br />
283020[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][movedo_title]Phone[/movedo_title][vc_column_text]T. 0800 390 9292<br />
F. 0800 390 9292</p>
<p>hello@movedo.com[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-modern-corporate-footer';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Modern Corporate - Footer', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-modern-corporate-footer.jpg');
$data['custom_class'] = 'demo-modern-corporate';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="" padding_bottom_multiplier=""][vc_column][movedo_modal modal_id="newsletter"][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][movedo_title heading="h1" increase_heading="140"]Subscribe for free resources and news updates.[/movedo_title][movedo_empty_space height_multiplier="2x"][contact-form-7 id=""][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/movedo_modal][/vc_column][/vc_row][vc_row section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none"][vc_column column_custom_position="yes" position_top="2x" width="2/3" tablet_landscape_column_positions="none" tablet_portrait_column_positions="none" mobile_column_positions="none" heading_color="light" clipping_animation="clipping-left" css=".vc_custom_1518337128838{margin-top: 0px !important;margin-bottom: 0px !important;padding-top: 30px !important;padding-right: 60px !important;padding-bottom: 30px !important;padding-left: 60px !important;background-color: #f9224b !important;}" font_color="#ffffff"][vc_row_inner][vc_column_inner width="1/2" tablet_width="hide" tablet_sm_width="hide" mobile_width="hide" css=".vc_custom_1518261848902{margin-top: 0px !important;margin-bottom: 0px !important;}"][/vc_column_inner][vc_column_inner width="1/2" tablet_width="1" tablet_sm_width="1" css=".vc_custom_1518261853593{margin-top: 0px !important;margin-bottom: 0px !important;}"][movedo_callout title="Joing our Newsletter" heading="h5" animation="grve-fade-in" button_text="Sign up now" button_color="white" button_shape="round" button_link="url:%23newsletter|||" button_class="grve-modal-popup"][/movedo_callout][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/3" css=".vc_custom_1518261858127{margin-top: 0px !important;margin-bottom: 0px !important;}"][/vc_column][/vc_row][vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" font_color="#e0e0e0" bg_color="#161616"][vc_column tablet_width="hide" tablet_sm_width="hide" mobile_width="hide"][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column][movedo_title heading_tag="div" heading="link-text" margin_bottom="0"]Starting a project?[/movedo_title][movedo_title heading="h2"]Contact Us[/movedo_title][/vc_column][vc_column tablet_width="hide" tablet_sm_width="hide" mobile_width="hide"][movedo_empty_space][/vc_column][vc_column width="1/3" css=".vc_custom_1518259929002{border-top-width: 1px !important;border-top-color: rgba(255,255,255,0.25) !important;border-top-style: solid !important;}"][movedo_empty_space][vc_column_text]Address:
38 Oatland Avenue Chicago, Illinois 283020[/vc_column_text][/vc_column][vc_column width="1/3" css=".vc_custom_1518259937136{border-top-width: 1px !important;border-top-color: rgba(255,255,255,0.25) !important;border-top-style: solid !important;}"][movedo_empty_space][vc_column_text]Tel: 0800 390 9292
E-mail: hello@movedo.com[/vc_column_text][/vc_column][vc_column width="1/3" css=".vc_custom_1518259946395{border-top-width: 1px !important;border-top-color: rgba(255,255,255,0.25) !important;border-top-style: solid !important;}"][movedo_empty_space][vc_row_inner][vc_column_inner width="1/2"][vc_column_text]<span style="color: #ffffff;"><a style="color: #ffffff;" href="#">Behance</a></span>
<span style="color: #ffffff;"><a style="color: #ffffff;" href="#">Dribbble</a></span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text]<span style="color: #ffffff;"><a style="color: #ffffff;" href="#">Facebook</a></span>
<span style="color: #ffffff;"><a style="color: #ffffff;" href="#">Instagram</a></span>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bg_type="color" font_color="rgba(255,255,255,0.47)" bg_color="#000000"][vc_column][vc_column_text]<span style="font-size: 12px;">All Rights Reserved ® Movedo 2018</span>[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


// Demo Creative Agency
$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-01.jpg');
$data['custom_class'] = 'demo-creative-agency homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="none" bg_color="#000000" font_color="#ffffff"][vc_column width="5/12"][movedo_title animation="grve-fade-in-left"]After a trustworthy and everlasting interaction with you, we bring Movedo![/movedo_title][movedo_empty_space][/vc_column][vc_column width="1/12"][/vc_column][vc_column width="1/2"][vc_column_text animation="grve-fade-in-right"]Eos solum doming ornatus cu, ne quem sed ei bonorum voluptua his. Mea ei hinc eius, duis debet bonorum admodum. Ullamcorper tempus, Donec placerat amet, non ornare. Ultrices augue eu dui at tempor euismod vehicula id neque, id aliquam nisi nec nisl morbi at feugiat eos solum doming ornatus.[/vc_column_text][movedo_empty_space][movedo_button animation="grve-fade-in-up" animation_delay="600" button_text="Learn More About" button_type="underline" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-02.jpg');
$data['custom_class'] = 'demo-creative-agency homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column width="1/3"][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-trophy" title="Unique Design" heading="h6"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][vc_column width="1/3"][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-rocket" title="Fresh Ideas" heading="h6"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][vc_column width="1/3"][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-pie-chart" title="High Performance" heading="h6"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-03.jpg');
$data['custom_class'] = 'demo-creative-agency homepage split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column" font_color="#ffffff" bg_color="#000000"][vc_column width="1/2" tablet_width="2-3" tablet_sm_width="1" css=".vc_custom_1509092308439{padding-top: 14% !important;padding-right: 14% !important;padding-bottom: 14% !important;padding-left: 14% !important;}"][vc_row_inner][vc_column_inner width="1/3" css=".vc_custom_1507881094400{padding-right: 15px !important;padding-left: 15px !important;}"][movedo_empty_space][movedo_slogan title="Passion" heading="h6" button_text="" button2_text=""]Eos solum doming ornatus cu ne quem ei bonorum voluptua.[/movedo_slogan][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1507881100644{padding-right: 15px !important;padding-left: 15px !important;}"][movedo_empty_space][movedo_slogan title="Philosophy" heading="h6" button_text="" button2_text=""]Eos solum doming ornatus cu ne quem ei bonorum voluptua.[/movedo_slogan][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1507881107270{padding-right: 15px !important;padding-left: 15px !important;}"][movedo_empty_space][movedo_slogan title="Design" heading="h6" button_text="" button2_text=""]Eos solum doming ornatus cu ne quem ei bonorum voluptua.[/movedo_slogan][movedo_empty_space][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3" css=".vc_custom_1507881094400{padding-right: 15px !important;padding-left: 15px !important;}"][movedo_empty_space][movedo_slogan title="Ideas" heading="h6" button_text="" button2_text=""]Eos solum doming ornatus cu ne quem ei bonorum voluptua.[/movedo_slogan][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1507881100644{padding-right: 15px !important;padding-left: 15px !important;}"][movedo_empty_space][movedo_slogan title="Scope" heading="h6" button_text="" button2_text=""]Eos solum doming ornatus cu ne quem ei bonorum voluptua.[/movedo_slogan][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1507881107270{padding-right: 15px !important;padding-left: 15px !important;}"][movedo_empty_space][movedo_slogan title="People" heading="h6" button_text="" button2_text=""]Eos solum doming ornatus cu ne quem ei bonorum voluptua.[/movedo_slogan][movedo_empty_space][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" tablet_width="1-3" tablet_sm_width="hide" mobile_width="hide" css=".vc_custom_1509094210541{padding-bottom: 30% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-creative-agency/wp-content/uploads/sites/3/2017/10/movedo-img-01.jpg?id=88) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-04.jpg');
$data['custom_class'] = 'demo-creative-agency homepage split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column" font_color="#ffffff" bg_color="#000000"][vc_column width="1/2" tablet_width="1-3" tablet_sm_width="1" css=".vc_custom_1509092339602{padding-bottom: 30% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-creative-agency/wp-content/uploads/sites/3/2017/10/movedo-img-02.jpg?id=90) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" tablet_width="2-3" tablet_sm_width="1" css=".vc_custom_1509092332244{padding-top: 14% !important;padding-right: 14% !important;padding-bottom: 14% !important;padding-left: 14% !important;}"][movedo_title margin_bottom="0"]Our products simply provide the quality of being clear.[/movedo_title][movedo_empty_space][vc_column_text]Ullamcorper tempus, Donec placerat amet, non ornare. Ultrices augue eu dui at tempor euismod vehicula id neque, id aliquam nisi nec nisl morbi at feugiat eos solum doming ornatus cu, ne quem numquam sed.[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_button button_text="Purchase Movedo" button_hover_color="white" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-05.jpg');
$data['custom_class'] = 'demo-creative-agency homepage typography';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="4x"][vc_column width="1/2" css=".vc_custom_1507882605560{padding: 15% !important;}"][movedo_title heading="small-text"]<span class="grve-text-primary-1">Situation extremely</span>[/movedo_title][movedo_title heading="h5"]Eos solum doming ornatus.[/movedo_title][vc_column_text]You one delay nor begin our folly abode. By disposed replying mr me unpacked no. As moonlight of my resolving unwilling. [/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1507882612310{padding: 15% !important;}"][movedo_title heading="small-text"]<span class="grve-text-primary-1">Situation extremely</span>[/movedo_title][movedo_title heading="h5"]Eos solum doming ornatus.[/movedo_title][vc_column_text]You one delay nor begin our folly abode. By disposed replying mr me unpacked no. As moonlight of my resolving unwilling. [/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1507882618790{padding: 15% !important;}"][movedo_title heading="small-text"]<span class="grve-text-primary-1">Situation extremely</span>[/movedo_title][movedo_title heading="h5"]Eos solum doming ornatus.[/movedo_title][vc_column_text]You one delay nor begin our folly abode. By disposed replying mr me unpacked no. As moonlight of my resolving unwilling. [/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1507882625169{padding: 15% !important;}"][movedo_title heading="small-text"]<span class="grve-text-primary-1">Situation extremely</span>[/movedo_title][movedo_title heading="h5"]Eos solum doming ornatus.[/movedo_title][vc_column_text]You one delay nor begin our folly abode. By disposed replying mr me unpacked no. As moonlight of my resolving unwilling. [/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-06.jpg');
$data['custom_class'] = 'demo-creative-agency page split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="middle-content" bg_color="#020202"][vc_column width="1/2" tablet_width="1" css=".vc_custom_1509092099739{background-image: url(https://greatives.eu/themes/movedo/movedo-creative-agency/wp-content/uploads/sites/3/2017/10/movedo-img-04.jpg?id=28) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" tablet_width="1" heading_color="light" css=".vc_custom_1509092105588{padding-top: 14% !important;padding-right: 14% !important;padding-bottom: 14% !important;padding-left: 14% !important;}" font_color="#ffffff"][movedo_title heading_tag="h1" heading="h1" increase_heading="160" margin_bottom="0"]User is[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="160" margin_bottom="0"]Our priority[/movedo_title][movedo_empty_space][vc_column_text text_style="leader-text"]Your moment to shine has arrived. Movedo is a creative and multi-purpose WP theme masterfully handcrafted for nothing less than awesomeness.[/vc_column_text][movedo_empty_space][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-7';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 7', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-07.jpg');
$data['custom_class'] = 'demo-creative-agency page split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column" mobile_equal_column_height="false"][vc_column width="1/2" tablet_sm_width="1" css=".vc_custom_1509092158306{padding-top: 14% !important;padding-right: 14% !important;padding-bottom: 14% !important;padding-left: 14% !important;}"][vc_row_inner][vc_column_inner width="1/2"][movedo_title heading_tag="h2" heading="h1" increase_heading="160" animation="grve-fade-in-left"]59<span class="grve-text-primary-1">*</span>[/movedo_title][vc_column_text animation="grve-fade-in-left" animation_delay="400"]Graeci vivendum senserit te sit, sit cu diam iusto putant duo doctus erroribus.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][/vc_column_inner][/vc_row_inner][movedo_empty_space][vc_column_text text_style="leader-text" animation="grve-fade-in-up" animation_delay="600"]<span class="grve-text-primary-1">It literally sets in motion a series of new features, such as ultra-dynamics parallax, radical safe button, super-crispy moldable typography, and immaculate future-proof device style.</span>[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_button animation="grve-fade-in-up" animation_delay="800" animation_duration="slow" button_text="Purchase Movedo Now" button_type="underline" button_color="black" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][vc_column width="1/2" tablet_sm_width="1" css=".vc_custom_1509092163267{background-color: #000000 !important;}"][vc_row_inner css=".vc_custom_1507880931079{background-image: url(https://greatives.eu/themes/movedo/movedo-creative-agency/wp-content/uploads/sites/3/2017/10/movedo-img-07.jpg?id=48) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column_inner css=".vc_custom_1507878904482{padding-top: 37% !important;}"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1507878601014{background-color: #ff8a65 !important;}"][vc_column_inner css=".vc_custom_1507878867941{padding-top: 15% !important;padding-bottom: 15% !important;}"][movedo_social_links icon_size="small" icon_color="white" icon_shape="circle" shape_color="white" shape_type="outline" align="center" animation="grve-fade-in-up" twitter_url="#" facebook_url="#" googleplus_url="#" behance_url="#"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-8';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 8', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-08.jpg');
$data['custom_class'] = 'demo-creative-agency page typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_full_height="fullheight" bg_type="image" bg_image="" bg_image_type="parallax" color_overlay="gradient" gradient_overlay_custom_1="rgba(0,0,0,0.3)" gradient_overlay_custom_2="#000000" gradient_overlay_direction="180" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60" equal_column_height="middle-content" font_color="#ffffff"][vc_column][movedo_title heading_tag="h1" heading="h1" animation="grve-fade-in-up" margin_bottom="0"]Design with the user[/movedo_title][movedo_title heading_tag="h1" heading="h1" animation="grve-fade-in-up" animation_delay="400" margin_bottom="0"]in mind to enjoy the clean look.[/movedo_title][movedo_empty_space height_multiplier="2x"][vc_row_inner][vc_column_inner width="1/3"][movedo_title heading="h6" animation="grve-fade-in-up" animation_delay="600"]<span class="grve-text-primary-1">01. </span>Page Builder[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="500"]Cras rhoncus aliquam leo, non fusce nibh rutrum, quis, a porttitor ac donec egestas, himenaeos turpis at donec vitae ac laoreet.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h6" animation="grve-fade-in-up" animation_delay="800"]<span class="grve-text-primary-1">02. </span>Import on Demand[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="900"]Cras rhoncus aliquam leo, non fusce nibh rutrum, quis, a porttitor ac donec egestas, himenaeos turpis at donec vitae ac laoreet.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h6" animation="grve-fade-in-up" animation_delay="1000"]<span class="grve-text-primary-1">03. </span>Speed Optimized[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="1100"]Cras rhoncus aliquam leo, non fusce nibh rutrum, quis, a porttitor ac donec egestas, himenaeos turpis at donec vitae ac laoreet.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-9';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 9', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-09.jpg');
$data['custom_class'] = 'demo-creative-agency page split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="middle-content" font_color="#ffffff" bg_color="#000000"][vc_column width="1/2" css=".vc_custom_1507880538947{background-image: url(https://greatives.eu/themes/movedo/movedo-creative-agency/wp-content/uploads/sites/3/2017/10/movedo-img-08.jpg?id=71) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" css=".vc_custom_1507880650483{padding: 14% !important;}"][movedo_title margin_bottom="0"]Creative to all<br />
intents and purposes[/movedo_title][movedo_empty_space][vc_column_text]Ullamcorper tempus, Donec placerat amet, non ornare. Ultrices augue eu dui at tempor euismod vehicula id neque, id aliquam nisi nec nisl morbi at feugiat eos solum doming ornatus cu, ne quem numquam sed.[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_button button_text="Read More About" button_color="primary-2" button_hover_color="white" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-creative-agency-10';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Agency - Section 10', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-creative-agency-10.jpg');
$data['custom_class'] = 'demo-creative-agency page split typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column" bg_color="#b26ff7" font_color="#ffffff"][vc_column width="1/2" css=".vc_custom_1507880751781{padding: 14% !important;}"][movedo_title heading="small-text" margin_bottom="18"]<span style="color: #000000;">Situation extremely</span>[/movedo_title][movedo_title heading="h5"]Eos solum doming ornatus.[/movedo_title][vc_column_text]You one delay nor begin our folly abode. By disposed replying mr me unpacked no. As moonlight of my resolving unwilling. [/vc_column_text][/vc_column][vc_column width="1/2" css=".vc_custom_1507880744671{padding: 14% !important;background-color: #a65bf4 !important;}"][movedo_title heading="small-text" margin_bottom="18"]<span style="color: #000000;">Situation extremely</span>[/movedo_title][movedo_title heading="h5"]Eos solum doming ornatus.[/movedo_title][vc_column_text]You one delay nor begin our folly abode. By disposed replying mr me unpacked no. As moonlight of my resolving unwilling. [/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


// Demo Corporate
$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-01.jpg');
$data['custom_class'] = 'demo-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" color_overlay="dark" opacity_overlay="40" padding_top_multiplier="4x" padding_bottom_multiplier="" separator_bottom="large-triangle-separator" separator_bottom_size="60px" font_color="#ffffff"][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="7/12"][movedo_title heading_tag="h1"]The Movedo Generation<br /><br />
of multi-purpose themes is here.[/movedo_title][vc_column_text]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Vis facete consequuntur id, ne his iuvaret ornatus, usu reque tincidunt philosophia.[/vc_column_text][/vc_column][vc_column width="5/12"][/vc_column][vc_column][movedo_empty_space][/vc_column][vc_column column_custom_position="yes" position_top="3x" width="1/3" tablet_sm_width="1-2" heading_color="dark" css=".vc_custom_1509200202565{border-bottom-width: 1px !important;padding-top: 36px !important;padding-right: 36px !important;padding-bottom: 36px !important;padding-left: 36px !important;background-color: #ffffff !important;border-bottom-color: #38d4db !important;border-bottom-style: solid !important;border-radius: 5px !important;}" font_color="#696969" el_wrapper_class="grve-drop-shadow"][movedo_title heading="h6"]Amazing Interface[/movedo_title][vc_column_text]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur.[/vc_column_text][movedo_empty_space height_multiplier="custom" height="18"][movedo_button button_text="Read more" button_type="underline" button_color="black" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-corporate%2Fabout-us%2F|||"][/vc_column][vc_column column_custom_position="yes" position_top="3x" width="1/3" tablet_sm_width="1-2" heading_color="dark" css=".vc_custom_1509200115581{border-bottom-width: 1px !important;padding-top: 36px !important;padding-right: 36px !important;padding-bottom: 36px !important;padding-left: 36px !important;background-color: #ffffff !important;border-bottom-color: #38d4db !important;border-bottom-style: solid !important;border-radius: 5px !important;}" font_color="#696969" el_wrapper_class="grve-drop-shadow"][movedo_title heading="h6"]Professional Code[/movedo_title][vc_column_text]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur.[/vc_column_text][movedo_empty_space height_multiplier="custom" height="18"][movedo_button button_text="Read more" button_type="underline" button_color="black" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-corporate%2Fabout-us%2F|||"][/vc_column][vc_column column_custom_position="yes" position_top="3x" width="1/3" tablet_sm_width="hide" mobile_width="hide" heading_color="dark" css=".vc_custom_1509200210520{border-bottom-width: 1px !important;padding-top: 36px !important;padding-right: 36px !important;padding-bottom: 36px !important;padding-left: 36px !important;background-color: #ffffff !important;border-bottom-color: #38d4db !important;border-bottom-style: solid !important;border-radius: 5px !important;}" font_color="#696969" el_wrapper_class="grve-drop-shadow"][movedo_title heading="h6"]Dedicated Support[/movedo_title][vc_column_text]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur.[/vc_column_text][movedo_empty_space height_multiplier="custom" height="18"][movedo_button button_text="Read more" button_type="underline" button_color="black" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-corporate%2Fabout-us%2F|||"][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier=""][vc_column][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-02.jpg');
$data['custom_class'] = 'demo-corporate homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="2/3" tablet_sm_width="1"][movedo_empty_space height_multiplier="3x"][movedo_title heading_tag="h2" align="center" animation="grve-fade-in-up"]At The Top of your lifetime investments.[/movedo_title][vc_column_text text_style="leader-text" animation="grve-fade-in-up" animation_delay="400"]
<p style="text-align: center;">Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Vis facete consequuntur id, ne his iuvaret ornatus.</p>
[/vc_column_text][/vc_column][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/3"][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-diamond" icon_color="primary-3" title="Unique Design" heading="h6" animation="grve-fade-in-up"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][vc_column width="1/3"][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-trophy" title="Decent Success" heading="h6" animation="grve-fade-in-up" animation_delay="400"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][vc_column width="1/3"][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-rocket" icon_color="primary-5" title="High Performance" heading="h6" animation="grve-fade-in-up" animation_delay="600"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-03.jpg');
$data['custom_class'] = 'demo-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column width="5/12" tablet_sm_width="1"][movedo_single_image image="" retina_image="48" animation="grve-zoom-in"][/vc_column][vc_column width="7/12" tablet_sm_width="1"][movedo_title animation="grve-fade-in-up" margin_bottom="40"]The design process balance technical functionality &amp; visual elements.[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="400"]Mea admodum quaestio ei, tota nemore postulant et mea. Nec eu quaeque sapientem, mel senserit theophrastus an. Has vero mundi voluptatibus ei, dicit mentitum te mel.[/vc_column_text][movedo_empty_space height_multiplier="2x"][vc_row_inner][vc_column_inner width="1/2"][movedo_title heading_tag="h2" heading="h1" increase_heading="160" animation="grve-fade-in-right" animation_delay="600"]90<span style="color: #38d4db;">%</span>[/movedo_title][vc_column_text animation="grve-fade-in-right" animation_delay="700"]It literally sets in motion a series of new features, such as ultra-dynamics parallax.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][movedo_title heading_tag="h2" heading="h1" increase_heading="160" animation="grve-fade-in-right" animation_delay="800"]59<span style="color: #ff8c69;">*</span>[/movedo_title][vc_column_text animation="grve-fade-in-right" animation_delay="900"]It literally sets in motion a series of new features, such as ultra-dynamics parallax.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-04.jpg');
$data['custom_class'] = 'demo-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="gradient" bg_gradient_color_1="#ff8c68" bg_gradient_color_2="#ff64a8" padding_top_multiplier="4x" padding_bottom_multiplier="3x" columns_gap="60" font_color="#ffffff"][vc_column width="1/3"][movedo_slogan title="Decent Success" heading="h6" align="center" animation="grve-fade-in-up" button_text="" button2_text=""]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Mea admodum ei, tota nemore postulant et mea. Nec eu quaeque mel. Has vero mundi voluptatibus.[/movedo_slogan][/vc_column][vc_column width="1/3"][movedo_slogan title="Premium Designs" heading="h6" align="center" animation="grve-fade-in-up" animation_delay="400" button_text="" button2_text=""]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Mea admodum ei, tota nemore postulant et mea. Nec eu quaeque mel. Has vero mundi voluptatibus.[/movedo_slogan][/vc_column][vc_column width="1/3"][movedo_slogan title="Speed Optimized" heading="h6" align="center" animation="grve-fade-in-up" animation_delay="600" button_text="" button2_text=""]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Mea admodum ei, tota nemore postulant et mea. Nec eu quaeque mel. Has vero mundi voluptatibus.[/movedo_slogan][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column][movedo_button btn_fluid="custom" btn_custom_width="350" align="center" animation="grve-fade-in-up" animation_delay="800" animation_duration="slow" button_text="Choose your perfect plan" button_color="white" button_hover_color="primary-1" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-corporate%2Four-services%2F|||" button_class="grve-drop-shadow"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-05.jpg');
$data['custom_class'] = 'demo-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="4x" columns_gap="60"][vc_column width="1/2" tablet_sm_width="1"][movedo_title heading="h5" animation="grve-fade-in-left"]At The Top of your lifetime investments.[/movedo_title][vc_column_text animation="grve-fade-in-left" animation_delay="400"]The Movedo Generation of multi-purpose themes is here. In a marketplace volatile you need to build confident themes. Mea admodum quaestio ei, tota nemore postulant et mea. Nec eu quaeque sapientem, mel senserit theophrastus an. Has vero mundi voluptatibus ei, dicit mentitum te mel. The Movedo Generation of multi-purpose themes is here.[/vc_column_text][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/2" tablet_sm_width="1"][movedo_progress_bar bar_style="style-2" values="90|Development,75|Design,80|Marketing,60|Support" bar_height="12"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-06.jpg');
$data['custom_class'] = 'demo-corporate homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column][movedo_single_image image_mode="large" image="" image_full_column="yes" animation="grve-fade-in"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3"][movedo_title heading="h6"]Innovative Framework[/movedo_title][vc_column_text]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. [/vc_column_text][movedo_empty_space][movedo_button button_text="Read more" button_type="underline" button_color="primary-2" button_line_color="grey"][/vc_column][vc_column width="1/3"][movedo_title heading="h6"]Translation Ready[/movedo_title][vc_column_text]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. [/vc_column_text][movedo_empty_space][movedo_button button_text="Read more" button_type="underline" button_color="primary-2" button_line_color="grey"][/vc_column][vc_column width="1/3"][movedo_title heading="h6"]Decent Success[/movedo_title][vc_column_text]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. [/vc_column_text][movedo_empty_space][movedo_button button_text="Read more" button_type="underline" button_color="primary-2" button_line_color="grey"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-7';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 7', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-07.jpg');
$data['custom_class'] = 'demo-corporate page steps';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/3"][vc_row_inner][vc_column_inner width="1/3"][movedo_title heading="h1" increase_heading="160"]<span style="color: #4bcf89;">01</span>[/movedo_title][/vc_column_inner][vc_column_inner width="2/3" css=".vc_custom_1509202474613{padding-top: 10px !important;padding-bottom: 10px !important;}"][movedo_title heading="h4"]Responsive Typography[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_empty_space height_multiplier="custom" height="18"][vc_column_text]Mea admodum quaestio ei, tota nemore postulant et mea. Nec eu quaeque sapientem, mel senserit theophrastus an. Has vero mundi voluptatibus ei, dicit mentitum te mel.[/vc_column_text][/vc_column][vc_column width="1/3"][vc_row_inner][vc_column_inner width="1/3"][movedo_title heading="h1" increase_heading="160"]<span style="color: #ff8c69;">02</span>[/movedo_title][/vc_column_inner][vc_column_inner width="2/3" css=".vc_custom_1509202481836{padding-top: 10px !important;padding-bottom: 10px !important;}"][movedo_title heading="h4"]Dedicated Support[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_empty_space height_multiplier="custom" height="18"][vc_column_text]Mea admodum quaestio ei, tota nemore postulant et mea. Nec eu quaeque sapientem, mel senserit theophrastus an. Has vero mundi voluptatibus ei, dicit mentitum te mel.[/vc_column_text][/vc_column][vc_column width="1/3"][vc_row_inner][vc_column_inner width="1/3"][movedo_title heading="h1" increase_heading="160"]<span style="color: #6155e0;">03</span>[/movedo_title][/vc_column_inner][vc_column_inner width="2/3" css=".vc_custom_1509202489003{padding-top: 10px !important;padding-bottom: 10px !important;}"][movedo_title heading="h4"]Translation Ready[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_empty_space height_multiplier="custom" height="18"][vc_column_text]Mea admodum quaestio ei, tota nemore postulant et mea. Nec eu quaeque sapientem, mel senserit theophrastus an. Has vero mundi voluptatibus ei, dicit mentitum te mel.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-8';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 8', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-08.jpg');
$data['custom_class'] = 'demo-corporate page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60" equal_column_height="middle-content"][vc_column width="1/3" tablet_sm_width="1-2"][movedo_single_image image_mode="large" image=""][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_single_image image_mode="large" image=""][/vc_column][vc_column width="1/3" tablet_sm_width="1" css=".vc_custom_1509202852931{padding-top: 17% !important;padding-right: 10% !important;padding-bottom: 17% !important;padding-left: 10% !important;background-color: #f7f7f7 !important;border-radius: 5px !important;}"][movedo_title heading="h6"]We offer you<br />
a panoply of cutting-edge options[/movedo_title][vc_column_text]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Vis facete consequuntur id, ne his iuvaret ornatus, usu reque tincidunt philosophia.[/vc_column_text][movedo_empty_space][movedo_button button_text="Stay Connected" button_color="primary-5" button_shape="round" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-corporate%2Fstay-connected%2F|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-9';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 9', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-09.jpg');
$data['custom_class'] = 'demo-corporate page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#6155e0"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title align="center"]What we can do for you?[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Tincidunt metus quis, egestas, tincidunt nec vitae semper. Augue Morbi rhoncus vestibulum torquent per ac rutrum.</p>
[/vc_column_text][movedo_empty_space height_multiplier="2x"][vc_tta_accordion c_icon="triangle" active_section="1"][vc_tta_section title="About Us" tab_id="1509203262665-7e1bdd59-f1a1"][vc_column_text]Usu inermis gubergren aliquando cu, vide option nonumes at sit, eos ea erat soluta molestiae. Mel an odio prima, no usu verear splendide ad no pro fugit soluta interpretaris, in dico suas delectus pro. Latine mentitum torquatos vel in, in ius posse cotidieque.[/vc_column_text][/vc_tta_section][vc_tta_section title="Our Work" tab_id="1509203262711-4e4019de-2f85"][vc_column_text]Usu inermis gubergren aliquando cu, vide option nonumes at sit, eos ea erat soluta molestiae. Mel an odio prima, no usu verear splendide ad no pro fugit soluta interpretaris, in dico suas delectus pro. Latine mentitum torquatos vel in, in ius posse cotidieque.[/vc_column_text][/vc_tta_section][vc_tta_section title="Our Services" tab_id="1509203283830-ac7f1fbc-8442"][vc_column_text]Usu inermis gubergren aliquando cu, vide option nonumes at sit, eos ea erat soluta molestiae. Mel an odio prima, no usu verear splendide ad no pro fugit soluta interpretaris, in dico suas delectus pro. Latine mentitum torquatos vel in, in ius posse cotidieque.[/vc_column_text][/vc_tta_section][/vc_tta_accordion][/vc_column][vc_column width="1/6"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-10';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 10', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-10.jpg');
$data['custom_class'] = 'demo-corporate page iconbox';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="5x"][vc_column width="1/4" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="1/2" tablet_sm_width="1"][movedo_title heading_tag="h1" align="center" animation="grve-fade-in-up"]An excellent piece of code-work WP like never before[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="400"]
<p style="text-align: center;">Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Vis facete consequuntur id, ne his iuvaret ornatus.</p>
[/vc_column_text][/vc_column][vc_column width="1/4" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/4" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-energy" icon_color="primary-3" title="Innovative Framework" heading="h6" animation="grve-zoom-in" animation_delay="400"][/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/4" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-support" icon_color="primary-3" title="Helpdesk Support" heading="h6" animation="grve-zoom-in" animation_delay="600"][/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/4" tablet_width="1-2"][movedo_empty_space][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-rocket" icon_color="primary-3" title="Seo Optimized" heading="h6" animation="grve-zoom-in" animation_delay="800"][/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/4" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-handbag" icon_color="primary-3" title="Purchase Movedo" heading="h6" animation="grve-zoom-in" animation_delay="1000"][/movedo_icon_box][movedo_empty_space][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-corporate-11';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 11', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-corporate-11.jpg');
$data['custom_class'] = 'demo-corporate page pricing';
$data['content'] = <<<CONTENT
[vc_row bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="5x" columns_gap="60" bg_color="#f7f7f7"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title align="center"]Choose your perfect plan.[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">The Movedo Generation of multi-purpose themes is here. In a marketplace volatile you need to build confident themes.</p>
[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_pricing_table title="Basic" description="For freelancers" price="$120" heading="h1" increase_heading="140" interval="$/month" values="100|Users,8 Gig|Disc Space,Unlimited|Data Transfer" align="center" animation="grve-fade-in-up" button_text="Purchase Now" button_color="primary-5" button_shape="round" button_link="url:%23|||"][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_pricing_table title="Standard" description="For medium sized teams" price="$175" heading="h1" increase_heading="140" interval="$/month" values="100|Users,8 Gig|Disc Space,Unlimited|Data Transfer" price_color="primary-3" align="center" animation="grve-fade-in-up" animation_delay="400" button_text="Purchase Now" button_color="primary-3" button_shape="round" button_link="url:%23|||"][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1"][movedo_empty_space][movedo_pricing_table title="Enterprice" description="For large companies" price="$250" heading="h1" increase_heading="140" interval="$/month" values="100|Users,8 Gig|Disc Space,Unlimited|Data Transfer" align="center" animation="grve-fade-in-up" animation_delay="600" button_text="Purchase Now" button_color="primary-5" button_shape="round" button_link="url:%23|||"][movedo_empty_space][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


// Demo Travel
$data = array();
$data['unique_id'] = $data['id'] = 'demo-travel-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Travel - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-travel-01.jpg');
$data['custom_class'] = 'demo-travel homepage typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#2f2424"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title heading_tag="h2" heading="h2" align="center" margin_bottom="0"]The world is too big<br />
to leave unexplored[/movedo_title][movedo_divider line_type="custom-line" line_width="90" line_height="3" align="center" padding_top="24" padding_bottom="24"][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast.</p>
[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/3"][movedo_title heading="h5"]<span class="grve-text-primary-1">01. </span>Explore the world[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading="h5"]<span class="grve-text-primary-1">02. </span>Adventure is out there[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading="h5"]<span class="grve-text-primary-1">03. </span>Book a ticket[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-travel-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Travel - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-travel-02.jpg');
$data['custom_class'] = 'demo-travel homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="3x" padding_bottom_multiplier="3x"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title align="center" margin_bottom="0"]Book a ticket &amp; Just Leave.[/movedo_title][movedo_divider line_type="custom-line" line_width="90" line_height="3" align="center" padding_top="24" padding_bottom="24"][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][/vc_row][vc_row heading_color="light" section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="" font_color="#ffffff"][vc_column width="1/3" tablet_width="1-2" tablet_sm_width="1" css=".vc_custom_1509268498613{margin-bottom: 30px !important;padding-top: 16% !important;padding-right: 20% !important;padding-bottom: 16% !important;padding-left: 20% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-bg-img-01.jpg?id=158) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_icon_box icon_box_type="side-icon" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="Travel with us" heading="h5"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. [/movedo_icon_box][/vc_column][vc_column width="1/3" tablet_width="1-2" tablet_sm_width="1" css=".vc_custom_1509268504968{margin-bottom: 30px !important;padding-top: 16% !important;padding-right: 20% !important;padding-bottom: 16% !important;padding-left: 20% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-bg-img-02.jpg?id=161) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_icon_box icon_box_type="side-icon" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="Travel with us" heading="h5"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. [/movedo_icon_box][/vc_column][vc_column width="1/3" tablet_width="1-2" tablet_sm_width="1" css=".vc_custom_1509268509760{margin-bottom: 30px !important;padding-top: 16% !important;padding-right: 20% !important;padding-bottom: 16% !important;padding-left: 20% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-bg-img-03.jpg?id=162) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_icon_box icon_box_type="side-icon" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="Travel with us" heading="h5"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. [/movedo_icon_box][/vc_column][vc_column width="1/3" tablet_width="1-2" tablet_sm_width="1" css=".vc_custom_1509268524115{margin-bottom: 30px !important;padding-top: 16% !important;padding-right: 20% !important;padding-bottom: 16% !important;padding-left: 20% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-bg-img-04.jpg?id=186) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_icon_box icon_box_type="side-icon" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="Travel with us" heading="h5"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. [/movedo_icon_box][/vc_column][vc_column width="1/3" tablet_width="1-2" tablet_sm_width="1" css=".vc_custom_1509268519897{margin-bottom: 30px !important;padding-top: 16% !important;padding-right: 20% !important;padding-bottom: 16% !important;padding-left: 20% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-bg-img-05.jpg?id=187) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_icon_box icon_box_type="side-icon" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="Travel with us" heading="h5"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. [/movedo_icon_box][/vc_column][vc_column width="1/3" tablet_width="1-2" tablet_sm_width="1" css=".vc_custom_1509268515318{margin-bottom: 30px !important;padding-top: 16% !important;padding-right: 20% !important;padding-bottom: 16% !important;padding-left: 20% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-bg-img-06.jpg?id=188) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_icon_box icon_box_type="side-icon" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="Travel with us" heading="h5"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. [/movedo_icon_box][/vc_column][/vc_row][vc_row padding_top_multiplier="2x" padding_bottom_multiplier="3x"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_callout title="Take a journey into yourself..." heading="h4" button_text="Read more about" button_link="url:%23|||"][/movedo_callout][/vc_column][vc_column width="1/6"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-travel-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Travel - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-travel-03.jpg');
$data['custom_class'] = 'demo-travel page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" columns_gap="none" equal_column_height="middle-content" font_color="#ffffff" bg_color="#202226"][vc_column width="1/2"][movedo_title heading_tag="h2" heading="h4" margin_bottom="0"]Exploring the world.[/movedo_title][movedo_divider line_type="custom-line" line_width="90" line_height="3" padding_top="24" padding_bottom="24"][vc_column_text]Far far away, behind the word mountains,<br />
far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][/vc_column][vc_column width="1/2"][vc_row_inner][vc_column_inner width="1/2"][movedo_single_image image_mode="medium" image=""][/vc_column_inner][vc_column_inner width="1/2"][movedo_single_image image_mode="medium" image=""][/vc_column_inner][/vc_row_inner][/vc_column][vc_column][vc_row_inner][vc_column_inner width="1/4"][movedo_single_image image_mode="medium" image=""][/vc_column_inner][vc_column_inner width="1/4"][movedo_single_image image_mode="medium" image=""][/vc_column_inner][vc_column_inner width="1/4"][movedo_single_image image_mode="medium" image=""][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/4"][movedo_single_image image_mode="medium" image=""][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-travel-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Travel - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-travel-04.jpg');
$data['custom_class'] = 'demo-travel page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" columns_gap="60" font_color="#ffffff" bg_color="#271c02"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title heading_tag="h2" heading="h2" align="center" margin_bottom="0"]The world is too big<br />
to leave unexplored[/movedo_title][movedo_divider line_type="custom-line" line_width="90" line_height="3" align="center" padding_top="24" padding_bottom="24"][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast.</p>
[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/3"][movedo_single_image image="" retina_image=""][movedo_empty_space][movedo_title heading="h5" align="center"]Barcelona, Spain[/movedo_title][vc_column_text]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right.</p>
[/vc_column_text][movedo_empty_space][movedo_button align="center" button_text="Read More" button_type="underline" button_line_color="white" button_link="url:%23|||"][/vc_column][vc_column width="1/3"][movedo_single_image image="" retina_image=""][movedo_empty_space][movedo_title heading="h5" align="center"]Colorado, USA[/movedo_title][vc_column_text]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right.</p>
[/vc_column_text][movedo_empty_space][movedo_button align="center" button_text="Read More" button_type="underline" button_line_color="white" button_link="url:%23|||"][/vc_column][vc_column width="1/3"][movedo_single_image image="" retina_image=""][movedo_empty_space][movedo_title heading="h5" align="center"]Mykonos, Greece[/movedo_title][vc_column_text]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right.</p>
[/vc_column_text][movedo_empty_space][movedo_button align="center" button_text="Read More" button_type="underline" button_line_color="white" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-travel-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Travel - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-travel-05.jpg');
$data['custom_class'] = 'demo-travel page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" equal_column_height="middle-content" bg_color="#271c02" font_color="#ffffff"][vc_column width="1/2" tablet_sm_width="1" css=".vc_custom_1509268676162{background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-img-06.jpg?id=153) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" tablet_sm_width="1" css=".vc_custom_1509268680515{padding-right: 7.5% !important;padding-left: 7.5% !important;background-color: #2c2c20 !important;}"][movedo_empty_space height_multiplier="6x"][movedo_title heading_tag="h2" align="center" margin_bottom="0"]When she reached the first hills[/movedo_title][movedo_divider line_type="custom-line" line_width="90" line_height="3" align="center" padding_top="24" padding_bottom="24"][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_button align="center" button_text="Read More About" button_hover_color="white" button_link="url:%23|||"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-travel-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Travel - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-travel-06.jpg');
$data['custom_class'] = 'demo-travel page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="5x" padding_bottom_multiplier="3x" separator_top="torn-paper-separator" separator_top_size="60px" separator_top_color="#22282d"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title align="center" margin_bottom="0"]When she reached the first hills[/movedo_title][movedo_divider line_type="custom-line" line_width="90" line_height="3" align="center" padding_top="24" padding_bottom="24"][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][/vc_row][vc_row section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="5x" columns_gap="60"][vc_column width="1/3" tablet_sm_width="1" css=".vc_custom_1509268984741{margin-bottom: 30px !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-img-03.jpg?id=84) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_empty_space height_multiplier="6x"][movedo_button btn_fluid="custom" btn_custom_width="150" align="center" button_text="Mountain" button_color="white" button_hover_color="primary-1" button_link="url:%23|||"][movedo_empty_space height_multiplier="6x"][/vc_column][vc_column width="1/3" tablet_sm_width="1" css=".vc_custom_1509268993394{margin-bottom: 30px !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-img-04.jpg?id=86) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_empty_space height_multiplier="6x"][movedo_button btn_fluid="custom" btn_custom_width="150" align="center" button_text="Extreme" button_color="white" button_hover_color="primary-1" button_link="url:%23|||"][movedo_empty_space height_multiplier="6x"][/vc_column][vc_column width="1/3" tablet_sm_width="1" css=".vc_custom_1509269002471{margin-bottom: 30px !important;background-image: url(https://greatives.eu/themes/movedo/movedo-travel/wp-content/uploads/sites/5/2017/10/movedo-img-05.jpg?id=87) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_empty_space height_multiplier="6x"][movedo_button btn_fluid="custom" btn_custom_width="150" align="center" button_text="Sea" button_color="white" button_hover_color="primary-1" button_link="url:%23|||"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


// Demo Landing
$data = array();
$data['unique_id'] = $data['id'] = 'demo-landing-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-landing-01.jpg');
$data['custom_class'] = 'demo-landing homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="primary-1" section_full_height="fullheight" bg_type="image" bg_image="" padding_top_multiplier="" padding_bottom_multiplier="" equal_column_height="middle-content" section_id="app-design"][vc_column width="1/3"][movedo_title heading_tag="div" heading="link-text" margin_bottom="18"]Quality Code[/movedo_title][movedo_title heading_tag="h1" heading="h1" gradient_color="yes"]Advanced features gives you full control[/movedo_title][vc_column_text]Lorem ipsum commodo eu. Ultrices. Eu arcu eget ipsum Quisque Praesent vestibulum nisl. Dictum eget malesuada Donec velit in leo odio metus, augue lectus.[/vc_column_text][/vc_column][vc_column width="1/4"][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" width="5/12"][movedo_single_image image="" retina_image=""][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-landing-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-landing-02.jpg');
$data['custom_class'] = 'demo-landing homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="5x" columns_gap="none" section_id="features"][vc_column width="1/6"][/vc_column][vc_column width="2/3" heading_color="primary-1"][movedo_title heading_tag="div" heading="link-text" align="center" margin_bottom="18"]It’s time to find your Style[/movedo_title][movedo_title heading_tag="h2" heading="h1" gradient_color="yes" align="center"]Interface Design[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Amazing product. Greatives is the one stop premium wordpress guys. If you want quality and top of the line support you’ve found it here. I highly recommend buying any theme from Greatives.</p>
[/vc_column_text][/vc_column][vc_column width="1/6"][/vc_column][vc_column][movedo_empty_space][/vc_column][vc_column width="1/2" css=".vc_custom_1517828206884{padding-right: 17% !important;padding-left: 17% !important;}" font_color="#939393"][movedo_empty_space][movedo_icon_box icon_top_align="left" icon_size="extra-large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-screen-desktop" title="Speed Optimized" heading="h6"]Lorem ipsum odio. In mollis arcu ultrices. Volutpat, ex, metus purus, In magna rhoncus ac, arcu Praesent nibh quis, aliquet dui vel volutpat, Nunc ac pharetra massa quam.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/2" css=".vc_custom_1517828221926{padding-right: 17% !important;padding-left: 17% !important;}" font_color="#939393"][movedo_empty_space][movedo_icon_box icon_top_align="left" icon_size="extra-large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-chart" title="SEO Optimized" heading="h6"]Lorem ipsum odio. In mollis arcu ultrices. Volutpat, ex, metus purus, In magna rhoncus ac, arcu Praesent nibh quis, aliquet dui vel volutpat, Nunc ac pharetra massa quam.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/2" css=".vc_custom_1517828226392{padding-right: 17% !important;padding-left: 17% !important;}" font_color="#939393"][movedo_empty_space][movedo_icon_box icon_top_align="left" icon_size="extra-large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-speedometer" title="Do it your way" heading="h6"]Lorem ipsum odio. In mollis arcu ultrices. Volutpat, ex, metus purus, In magna rhoncus ac, arcu Praesent nibh quis, aliquet dui vel volutpat, Nunc ac pharetra massa quam.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/2" css=".vc_custom_1517828230971{padding-right: 17% !important;padding-left: 17% !important;}" font_color="#939393"][movedo_empty_space][movedo_icon_box icon_top_align="left" icon_size="extra-large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-vector" title="Translation Ready" heading="h6"]Lorem ipsum odio. In mollis arcu ultrices. Volutpat, ex, metus purus, In magna rhoncus ac, arcu Praesent nibh quis, aliquet dui vel volutpat, Nunc ac pharetra massa quam.[/movedo_icon_box][movedo_empty_space][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-landing-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-landing-03.jpg');
$data['custom_class'] = 'demo-landing homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image="" bg_image_type="parallax" parallax_threshold="0.8" color_overlay="gradient" gradient_overlay_custom_1="rgba(104,15,203,0.91)" gradient_overlay_custom_2="rgba(38,116,252,0.91)" gradient_overlay_direction="135" padding_top_multiplier="6x" padding_bottom_multiplier="6x" equal_column_height="middle-content" font_color="#ffffff" section_id="about"][vc_column width="1/2"][movedo_title heading_tag="div" heading="link-text" margin_bottom="18"]Quality Code[/movedo_title][movedo_title heading_tag="h1" heading="h1"]Advanced features gives you full control[/movedo_title][vc_column_text]Lorem ipsum commodo eu. Ultrices. Eu arcu eget ipsum Quisque Praesent vestibulum nisl. Dictum eget malesuada Donec velit in leo odio metus, augue lectus.[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_button button_text="Learn More About" button_color="white" button_hover_color="primary-2" button_size="small" button_shape="round" button_shadow="large" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][vc_column width="1/2" css=".vc_custom_1517828641528{padding-right: 17% !important;padding-left: 17% !important;}"][movedo_single_image image_mode="medium_large" image="" shadow="large" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-down" clipping_animation_colors="light"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-landing-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-landing-04.jpg');
$data['custom_class'] = 'demo-landing homepage pricing';
$data['content'] = <<<CONTENT
[vc_row bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="none" bg_color="#f5f5f5" section_id="price"][vc_column width="1/4"][/vc_column][vc_column width="1/2" heading_color="primary-1"][movedo_title heading_tag="div" heading="link-text" align="center" margin_bottom="18"]It’s time to find your Style[/movedo_title][movedo_title heading_tag="h2" heading="h1" gradient_color="yes" align="center"]Choose a plan that works for you[/movedo_title][/vc_column][vc_column width="1/4"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3" css=".vc_custom_1517829667361{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][movedo_pricing_table title="Basic" description="For medium sized teams" price="19" heading="h1" increase_heading="160" interval="$ / Month" values="10 presentations|month,Support|at $25 Hour,1 campaign|month" price_color="primary-1" content_bg="none" align="center" button_text="Purchase Now" button_color="white" button_hover_color="primary-1" button_size="small" button_shape="round" button_shadow="large" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][vc_column width="1/3" css=".vc_custom_1517829677702{border-right-width: 1px !important;border-right-color: #e4e4e4 !important;border-right-style: solid !important;}"][movedo_pricing_table title="Standard" description="For medium sized teams" price="25" heading="h1" increase_heading="160" interval="$ / Month" values="10 presentations|month,Support|at $25 Hour,1 campaign|month" price_color="primary-1" content_bg="none" align="center" button_text="Purchase Now" button_color="white" button_hover_color="primary-1" button_size="small" button_shape="round" button_shadow="large" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][vc_column width="1/3"][movedo_pricing_table title="Enterprice" description="For medium sized teams" price="74" heading="h1" increase_heading="160" interval="$ / Month" values="10 presentations|month,Support|at $25 Hour,1 campaign|month" price_color="primary-1" content_bg="none" align="center" button_text="Purchase Now" button_color="white" button_hover_color="primary-1" button_size="small" button_shape="round" button_shadow="large" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-landing-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-landing-05.jpg');
$data['custom_class'] = 'demo-landing homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="gradient" bg_gradient_color_1="#680fcb" bg_gradient_color_2="#2674fc" bg_gradient_direction="135" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="rgba(255,255,255,0.7)" section_id="services"][vc_column width="1/3" css=".vc_custom_1517829985397{padding-top: 30px !important;padding-right: 17% !important;padding-bottom: 30px !important;padding-left: 17% !important;}"][movedo_icon_box icon_top_align="left" icon_library="etlineicons" icon_etlineicons="et-icon-browser" icon_color="white" title="Validated Code" heading_tag="h6" heading="h6"]Nam in ullum delectus. Quo at nusquam tacimates quaerendum tacimates probo.[/movedo_icon_box][/vc_column][vc_column width="1/3" css=".vc_custom_1517829993237{padding-top: 30px !important;padding-right: 17% !important;padding-bottom: 30px !important;padding-left: 17% !important;}"][movedo_icon_box icon_top_align="left" icon_library="etlineicons" icon_etlineicons="et-icon-gears" icon_color="white" title="Fully Customizable" heading_tag="h6" heading="h6"]Nam in ullum delectus. Quo at nusquam tacimates quaerendum tacimates probo.[/movedo_icon_box][/vc_column][vc_column width="1/3" css=".vc_custom_1517830002035{padding-top: 30px !important;padding-right: 17% !important;padding-bottom: 30px !important;padding-left: 17% !important;}"][movedo_icon_box icon_top_align="left" icon_library="etlineicons" icon_etlineicons="et-icon-download" icon_color="white" title="One Click Installation" heading_tag="h6" heading="h6"]Nam in ullum delectus. Quo at nusquam tacimates quaerendum tacimates probo.[/movedo_icon_box][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


// Demo Construction
$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-01.jpg');
$data['custom_class'] = 'demo-construction homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="" padding_bottom_multiplier=""][vc_column column_custom_position="yes" position_top="6x" width="7/12" tablet_sm_width="1" heading_color="light" css=".vc_custom_1509026519890{padding-right: 17% !important;padding-left: 17% !important;background-color: #000000 !important;}" font_color="#ffffff"][movedo_empty_space height_multiplier="6x"][movedo_title heading_tag="h1" heading="h1"]We invest in inovative construction, but our strategy is simple [/movedo_title][movedo_empty_space height_multiplier="3x"][movedo_icon icon_library="simplelineicons" icon_simplelineicons="smp-icon-arrow-down-circle" icon_color="white" link="url:%23experience|||"][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="5/12" tablet_sm_width="hide" mobile_width="hide"][/vc_column][/vc_row][vc_row bg_type="image" bg_image="" bg_image_type="parallax" parallax_threshold="0.5" padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column][movedo_empty_space height_multiplier="6x"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-02.jpg');
$data['custom_class'] = 'demo-construction homepage typography';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="4x" section_id="experience"][vc_column width="1/2"][movedo_title heading_tag="h2" heading="h2" animation="grve-fade-in"]Years of experience<br />
in construction[/movedo_title][/vc_column][vc_column width="1/2"][vc_column_text text_style="leader-text" animation="grve-fade-in-up"]The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar.[/vc_column_text][movedo_empty_space height_multiplier="2x"][vc_column_text text_style="leader-text" animation="grve-fade-in-up"]Their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more words and something else.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-03.jpg');
$data['custom_class'] = 'demo-construction homepage typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="" font_color="#6e6e6e" bg_color="#000000"][vc_column][movedo_title heading_tag="h2" heading="h1" align="center" animation="grve-fade-in-up"]Facts we are proud with[/movedo_title][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_slogan title="330,000 SQ" heading_tag="h3" heading="h1" text_style="leader-text" animation="grve-fade-in-left" button_text="" button2_text=""]This is the approximate area we worked on. One could refuse to pay expensive translators.[/movedo_slogan][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_slogan title="190" heading_tag="h3" heading="h1" text_style="leader-text" animation="grve-fade-in-right" button_text="" button2_text=""]Types of works we are doing. One could refuse to pay expensive translators something else.[/movedo_slogan][/vc_column][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_slogan title="27" heading_tag="h3" heading="h1" text_style="leader-text" animation="grve-fade-in-left" button_text="" button2_text=""]Number of cities we did our job. This is the approximate area we worked on. [/movedo_slogan][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_slogan title="245+" heading_tag="h3" heading="h1" text_style="leader-text" animation="grve-fade-in-right" button_text="" button2_text=""]Professionals that are working within our company. One could refuse to pay expensive translators.[/movedo_slogan][/vc_column][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column][movedo_button btn_fluid="custom" btn_custom_width="770" align="center" animation="grve-fade-in" animation_duration="slow" button_text="Know more about our company" button_color="white" button_hover_color="primary-1" button_link="url:%23|||" margin_bottom="1"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-04.jpg');
$data['custom_class'] = 'demo-construction homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="4x"][vc_column width="5/12"][movedo_empty_space height_multiplier="3x"][movedo_slogan title="Horing &amp; concrete forming" heading_tag="h3" text_style="leader-text" animation="grve-fade-in-left" button_text="" button2_text=""]Their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more words and something else.[/movedo_slogan][/vc_column][vc_column width="7/12" css=".vc_custom_1509011271083{padding-left: 9% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-construction/wp-content/uploads/sites/4/2017/10/movedo-construction-bullets-03.jpg?id=45) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation="grve-zoom-in"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-05.jpg');
$data['custom_class'] = 'demo-construction homepage call-action';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" padding_top_multiplier="custom" padding_bottom_multiplier="custom" columns_gap="60" section_id="testimonials" padding_top="60" padding_bottom="60"][vc_column heading_color="dark" css=".vc_custom_1509028414592{padding-right: 30% !important;padding-left: 30% !important;background-color: #e7a848 !important;}" font_color="#000000"][movedo_empty_space height_multiplier="3x"][movedo_icon icon_size="small" align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-bubbles" icon_color="black" animation="grve-fade-in-up" margin_bottom="20"][movedo_title heading="h6" align="center" animation="grve-fade-in-up" animation_delay="400" margin_bottom="0"]Don’t just take our word for it[/movedo_title][movedo_empty_space][movedo_title heading="h2" align="center" animation="grve-fade-in-up" animation_delay="600"]It would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language.[/movedo_title][movedo_empty_space height_multiplier="2x"][movedo_title heading="link-text" align="center" animation="grve-fade-in-up" animation_delay="800" margin_bottom="0"]<span style="color: #825e28;">- Trancy Dorn, Householder</span>[/movedo_title][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-06.jpg');
$data['custom_class'] = 'demo-construction page';
$data['content'] = <<<CONTENT
[vc_row padding_bottom_multiplier=""][vc_column width="2/3"][movedo_empty_space height_multiplier="6x"][movedo_slogan title="How we are" heading_tag="h1" heading="h1" text_style="leader-text" button_text="" button2_text=""]Europe uses the same vocabulary. The languages only differ in their grammar.[/movedo_slogan][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column column_custom_position="yes" position_top="6x" width="1/3" css=".vc_custom_1509090239860{padding-top: 90px !important;padding-right: 60px !important;padding-bottom: 90px !important;padding-left: 60px !important;background-color: #000000 !important;}" font_color="#ffffff"][vc_column_text text_style="leader-text"]<a href="#history">History</a><br />
<a href="#our-mission">Our Mission</a><br />
<a href="#managements">Managements</a><br />
<a href="#how-we-work">How we work</a><br />
<a href="#testimonials">Testimonials</a>[/vc_column_text][/vc_column][/vc_row][vc_row bg_type="image" bg_image="" bg_image_type="parallax" parallax_threshold="0.5" padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column][movedo_empty_space height_multiplier="6x"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-7';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 7', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-07.jpg');
$data['custom_class'] = 'demo-construction page iconbox';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column"][vc_column width="1/3" tablet_sm_width="hide" css=".vc_custom_1509091904122{background-image: url(https://greatives.eu/themes/movedo/movedo-construction/wp-content/uploads/sites/4/2017/10/movedo-construction-feature-06.jpg?id=259) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][vc_row_inner][vc_column_inner css=".vc_custom_1509014713764{border-right-width: 1px !important;border-bottom-width: 1px !important;padding-top: 19% !important;padding-right: 19% !important;padding-bottom: 19% !important;padding-left: 19% !important;border-right-color: #e9e9e9 !important;border-right-style: solid !important;border-bottom-color: #e9e9e9 !important;border-bottom-style: solid !important;}"][movedo_icon_box icon_library="simplelineicons" icon_simplelineicons="smp-icon-diamond" title="Inovations & evolution " heading="h6" text_style="leader-text" animation="grve-zoom-in"]Seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.[/movedo_icon_box][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner css=".vc_custom_1509014724182{border-right-width: 1px !important;padding-top: 19% !important;padding-right: 19% !important;padding-bottom: 19% !important;padding-left: 19% !important;border-right-color: #e9e9e9 !important;border-right-style: solid !important;}"][movedo_icon_box icon_library="simplelineicons" icon_simplelineicons="smp-icon-emotsmile" title="long lasting partnership" heading="h6" text_style="leader-text" animation="grve-zoom-in"]Seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.[/movedo_icon_box][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][vc_row_inner][vc_column_inner css=".vc_custom_1509014747324{border-bottom-width: 1px !important;padding-top: 19% !important;padding-right: 19% !important;padding-bottom: 19% !important;padding-left: 19% !important;border-bottom-color: #e9e9e9 !important;border-bottom-style: solid !important;}"][movedo_icon_box icon_library="simplelineicons" title="cost / quality balance" heading="h6" text_style="leader-text" animation="grve-zoom-in" animation_delay="400"]Seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.[/movedo_icon_box][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner css=".vc_custom_1509014752836{padding-top: 19% !important;padding-right: 19% !important;padding-bottom: 19% !important;padding-left: 19% !important;}"][movedo_icon_box icon_library="simplelineicons" icon_simplelineicons="smp-icon-fire" title="always new targets" heading="h6" text_style="leader-text" animation="grve-zoom-in" animation_delay="400"]Seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.[/movedo_icon_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-8';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 8', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-08.jpg');
$data['custom_class'] = 'demo-construction page typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" section_id="managements" bg_color="#111111" font_color="#ffffff"][vc_column][movedo_slogan title="Managements" text_style="leader-text" button_text="" button2_text=""]To achieve this, it would be necessary to have uniform[/movedo_slogan][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/2"][movedo_single_image image_mode="large" image_full_column="yes"][/vc_column][vc_column width="1/2"][movedo_empty_space height_multiplier="2x"][vc_column_text text_style="leader-text"]<strong>Like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.</strong>[/vc_column_text][movedo_empty_space height_multiplier="2x"][vc_column_text text_style="leader-text"]Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ in their grammar, their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words. If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. [/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-9';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 9', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-09.jpg');
$data['custom_class'] = 'demo-construction page typography steps';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="4x" section_id="how-we-work"][vc_column][movedo_slogan title="How we work" heading_tag="h3" heading="h1" text_style="leader-text" align="center" button_text="" button2_text=""]To achieve this, it would be necessary to have uniform[/movedo_slogan][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/3"][movedo_title animation="grve-fade-in-up"]<span style="color: #7d7d7d;">1.</span> Identifying Your Needs[/movedo_title][vc_column_text animation="grve-fade-in-up-big" animation_duration="slow"]Their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title animation="grve-fade-in-up" animation_delay="400"]<span style="color: #7d7d7d;">2.</span> Planning Project[/movedo_title][vc_column_text animation="grve-fade-in-up-big" animation_delay="400" animation_duration="slow"]Their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title animation="grve-fade-in-up" animation_delay="600"]<span style="color: #7d7d7d;">3.</span> Developing[/movedo_title][vc_column_text animation="grve-fade-in-up-big" animation_delay="600" animation_duration="slow"]Their pronunciation and their most common words. Everyone realizes why a new common language would be desirable: one could refuse to pay expensive.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-10';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 10', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-10.jpg');
$data['custom_class'] = 'demo-construction page typography';
$data['content'] = <<<CONTENT
[vc_row padding_bottom_multiplier=""][vc_column][movedo_empty_space height_multiplier="6x"][movedo_slogan title="What we do" heading_tag="h1" heading="h1" text_style="leader-text" button_text="" button2_text=""]Uses the same vocabulary. The languages only differ in their grammar.[/movedo_slogan][movedo_empty_space height_multiplier="2x"][/vc_column][/vc_row][vc_row bg_type="image" bg_image_type="parallax" parallax_threshold="0.5" padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column][movedo_empty_space height_multiplier="6x"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="5"][vc_column column_custom_position="yes" position_top="minus-2x"][vc_row_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091430952{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Frame Scaffolding</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">Seem like simplified English</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091438231{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Horing &amp; Concrete Pump Work</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">If several languages coalesce</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091443395{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Frame Scaffolding</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">The new common language</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091451102{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Refurbishment</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">Have uniform grammar</span>[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091456299{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Retrofit</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">Cambridge friend of mine</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091461125{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Plastering &amp; Rendering</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">The new common language</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091466345{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Exterior &amp; interior finishing</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">European languages are members</span>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4" tablet_sm_width="1-2" css=".vc_custom_1509091471386{margin-bottom: 5px !important;padding-top: 23px !important;padding-right: 23px !important;padding-bottom: 23px !important;padding-left: 23px !important;background-color: #f5f5f5 !important;}"][movedo_icon icon_size="small" icon_library="typicons" icon_typicons="typcn typcn-arrow-right" icon_color="black" link="url:%23|||"][movedo_title heading="h6" margin_bottom="0"]<span style="color: #6e6e6e;">Cleaning</span>[/movedo_title][vc_column_text]<span style="color: #a1a1a1;">It would be necessary to have</span>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-construction-11';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Construction - Section 11', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-construction-11.jpg');
$data['custom_class'] = 'demo-construction page';
$data['content'] = <<<CONTENT
[vc_row padding_bottom_multiplier=""][vc_column][movedo_empty_space height_multiplier="6x"][movedo_slogan title="What we do" heading_tag="h1" heading="h1" text_style="leader-text" button_text="" button2_text=""]Uses the same vocabulary. The languages only differ in their grammar.[/movedo_slogan][movedo_empty_space height_multiplier="2x"][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier="4x"][vc_column width="7/12" tablet_sm_width="1"][movedo_gmap map_zoom="14" map_height="700" map_marker_type="pulse-dot"][/vc_column][vc_column column_effect="vertical-parallax" column_custom_position="yes" position_top="5x" position_left="minus-3x" width="5/12" tablet_sm_width="1" tablet_portrait_column_positions="none" mobile_column_positions="none" heading_color="light" css=".vc_custom_1509091567754{padding-top: 90px !important;padding-right: 60px !important;padding-bottom: 90px !important;padding-left: 60px !important;background-color: #000000 !important;}" font_color="#ffffff"][vc_row_inner][vc_column_inner width="1/2"][movedo_title]Address[/movedo_title][vc_column_text text_style="leader-text"]<strong>Movedo Constructions</strong><br />
38 Oatland Avenue<br />
Chicago, Illinois<br />
283020[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][movedo_title]Phone[/movedo_title][vc_column_text text_style="leader-text"]T. 0800 390 9292<br />
F. 0800 390 9292
hello@movedo.com[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

// Demo Restaurant
$data = array();
$data['unique_id'] = $data['id'] = 'demo-restaurant-01';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-restaurant-01.jpg');
$data['custom_class'] = 'demo-restaurant homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="gradient" bg_gradient_color_1="#2e0e63" bg_gradient_color_2="#5319b2" bg_gradient_direction="45" padding_top_multiplier="" padding_bottom_multiplier="" font_color="rgba(255,255,255,0.75)" section_id="welcome"][vc_column width="1/2"][movedo_empty_space height_multiplier="6x"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" image_column_space="125" animation="grve-zoom-in" animation_delay="800"][/vc_column][vc_column width="1/6" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][vc_row_inner][vc_column_inner mobile_width="hide"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" image_column_space="150" animation="grve-fade-in-right-big" animation_delay="500"][/vc_column_inner][/vc_row_inner][movedo_empty_space height_multiplier="3x"][movedo_title heading_tag="h2" heading="h5" align="center" animation="grve-fade-in-up" animation_delay="600"]Welcome<br />
to our restaurant[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="800"]
<p style="text-align: center;">Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique te duo eripuit commune.</p>
[/vc_column_text][movedo_empty_space][movedo_title heading="link-text" align="center" animation="grve-fade-in-up" animation_delay="1000"]Discover New Taste[/movedo_title][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-restaurant-02';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-restaurant-02.jpg');
$data['custom_class'] = 'demo-restaurant homepage';
$data['content'] = <<<CONTENT
[vc_row padding_bottom_multiplier="6x" section_id="discover"][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space height_multiplier="3x"][movedo_title heading="link-text" margin_bottom="30"]<span style="color: #3a127b;">-- Discover New Taste</span>[/movedo_title][movedo_title heading="h5"]Embracing the cultural<br />
diversity of our Cuisine[/movedo_title][vc_column_text]Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique. Te duo eripuit commune singulis, an suas utinam pro.[/vc_column_text][movedo_empty_space][movedo_button button_text="Book a table" button_size="small" button_link="url:%23book|||" button_class="grve-modal-popup"][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column column_custom_position="yes" position_top="3x" width="1/3" tablet_sm_width="1-2" tablet_portrait_column_positions="none" mobile_column_positions="none"][movedo_single_image image_mode="large" image="" image_full_column="yes" shadow="large" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-down" clipping_animation_colors="primary-1" animation_delay="800"][/vc_column][vc_column column_custom_position="yes" position_top="minus-5x" width="1/3" tablet_sm_width="hide" mobile_width="hide" tablet_portrait_column_positions="none"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" shadow="large" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-up" clipping_animation_colors="primary-2" animation_delay="800"][/vc_column][vc_column][movedo_empty_space][/vc_column][vc_column width="1/3" font_color="#000000"][vc_column_text]<strong>Monday – Thursday:</strong> 9:00 am – 10:00 pm[/vc_column_text][movedo_title heading="small-text"]Food service until 9:00 pm[/movedo_title][/vc_column][vc_column width="1/3" font_color="#000000"][vc_column_text]<strong>Friday – Saturday :</strong> 10:00 am – Midnight[/vc_column_text][movedo_title heading="small-text"]Food service until 9:00 pm[/movedo_title][/vc_column][vc_column width="1/3" font_color="#000000"][vc_column_text]<strong>Sunday :</strong> 11:00 am – 10:00 pm[/vc_column_text][movedo_title heading="small-text"]Food service until 9:00 pm[/movedo_title][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-restaurant-03';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-restaurant-03.jpg');
$data['custom_class'] = 'demo-restaurant homepage';
$data['content'] = <<<CONTENT
[vc_row bg_type="image" bg_image="" color_overlay="gradient" gradient_overlay_custom_1="#ffffff" gradient_overlay_custom_2="rgba(255,255,255,0.9)" gradient_overlay_direction="180" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60" section_id="menu"][vc_column width="1/3" tablet_width="hide" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column width="1/3" tablet_width="1"][movedo_title heading="link-text" align="center" margin_bottom="24"]<span style="color: #3a127b;">Special Dishes</span>[/movedo_title][movedo_title heading="h5" align="center"]Reinventing innovation<br />
in the food industry[/movedo_title][/vc_column][vc_column width="1/3" tablet_width="hide" tablet_sm_width="hide" mobile_width="hide"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/2" clipping_animation="colored-clipping-up" clipping_animation_colors="primary-1" animation_delay="600"][vc_row_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][vc_column_inner width="2/3"][movedo_title heading="h6" margin_bottom="12"]Roasted Sunchoke[/movedo_title][vc_column_text]Beluga Lentils, Kabocha Squash, Quince.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1519894971754{padding-top: 12px !important;}"][movedo_title heading="h5"]$14.50[/movedo_title][/vc_column_inner][vc_column_inner][movedo_divider line_type="custom-line" line_width="100%" line_height="1" line_color="custom" line_color_custom="#f0f2f7" padding_top="30"][/vc_column_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][vc_column_inner width="2/3"][movedo_title heading="h6" margin_bottom="12"]Sweet Potato Doughnuts[/movedo_title][vc_column_text]Cranberry Fondant, Warm Macchiato with Milk Foam.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1519894971754{padding-top: 12px !important;}"][movedo_title heading="h5"]$12.50[/movedo_title][/vc_column_inner][vc_column_inner][movedo_divider line_type="custom-line" line_width="100%" line_height="1" line_color="custom" line_color_custom="#f0f2f7" padding_top="30"][/vc_column_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][vc_column_inner width="2/3"][movedo_title heading="h6" margin_bottom="12"]Pear &amp; Parsnip[/movedo_title][vc_column_text]Pickled Asian Pear, Granola, Chanterelles.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1519894971754{padding-top: 12px !important;}"][movedo_title heading="h5"]$15.00[/movedo_title][/vc_column_inner][vc_column_inner][movedo_divider line_type="custom-line" line_width="100%" line_height="1" line_color="custom" line_color_custom="#f0f2f7" padding_top="30"][/vc_column_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" clipping_animation="colored-clipping-up" clipping_animation_colors="primary-2" animation_delay="1000"][vc_row_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][vc_column_inner width="2/3"][movedo_title heading="h6" margin_bottom="12"]Early Fall Squash[/movedo_title][vc_column_text]Roasted Spaghetti Squash, Spiced Cashews.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1519894971754{padding-top: 12px !important;}"][movedo_title heading="h5"]$16.00[/movedo_title][/vc_column_inner][vc_column_inner][movedo_divider line_type="custom-line" line_width="100%" line_height="1" line_color="custom" line_color_custom="#f0f2f7" padding_top="30"][/vc_column_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][vc_column_inner width="2/3"][movedo_title heading="h6" margin_bottom="12"]Pan-roasted Chicken[/movedo_title][vc_column_text]Warm Farro-Brussels Sprout Salad, Pine Nuts.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1519894971754{padding-top: 12px !important;}"][movedo_title heading="h5"]$23.50[/movedo_title][/vc_column_inner][vc_column_inner][movedo_divider line_type="custom-line" line_width="100%" line_height="1" line_color="custom" line_color_custom="#f0f2f7" padding_top="30"][/vc_column_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][vc_column_inner width="2/3"][movedo_title heading="h6" margin_bottom="12"]Roasted Sunchoke[/movedo_title][vc_column_text]Beluga Lentils, Kabocha Squash, Quince.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3" css=".vc_custom_1519894971754{padding-top: 12px !important;}"][movedo_title heading="h5"]$12.50[/movedo_title][/vc_column_inner][vc_column_inner][movedo_divider line_type="custom-line" line_width="100%" line_height="1" line_color="custom" line_color_custom="#f0f2f7" padding_top="30"][/vc_column_inner][vc_column_inner][movedo_empty_space height_multiplier="custom" height="30"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-restaurant-04';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-restaurant-04.jpg');
$data['custom_class'] = 'demo-restaurant homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="gradient" bg_gradient_color_1="#2e0e63" bg_gradient_color_2="#5319b2" bg_gradient_direction="45" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60" font_color="#ffffff" section_id="work"][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h5" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" clipping_animation_colors="light" animation_delay="400"]How we work[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="1000"]Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique te duo eripuit commune.[/vc_column_text][movedo_empty_space][movedo_title heading="link-text" animation="grve-fade-in-up" animation_delay="1200"]— Discover New Taste[/movedo_title][movedo_empty_space][/vc_column][vc_column width="1/12"][/vc_column][vc_column width="7/12"][vc_row_inner][vc_column_inner width="1/2"][movedo_empty_space][vc_column_text animation="grve-fade-in-up" animation_delay="1200"]<strong>Eat and dream</strong><br />
Temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te.[/vc_column_text][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/2"][movedo_empty_space][vc_column_text animation="grve-fade-in-up" animation_delay="1400"]<strong>We serve passion</strong><br />
Temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te.[/vc_column_text][movedo_empty_space][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/2"][movedo_empty_space][vc_column_text animation="grve-fade-in-up" animation_delay="1400"]<strong>Expect the best</strong><br />
Temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te.[/vc_column_text][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/2"][movedo_empty_space][vc_column_text animation="grve-fade-in-up" animation_delay="1600"]<strong>Chefs for passion</strong><br />
Temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te.[/vc_column_text][movedo_empty_space][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-restaurant-05';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-restaurant-05.jpg');
$data['custom_class'] = 'demo-restaurant homepage';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" section_id="gallery"][vc_column width="1/3"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-up" clipping_animation_colors="primary-1" animation_delay="600"][/vc_column][vc_column width="1/3"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" clipping_animation_colors="primary-2" animation_delay="800"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-right" clipping_animation_colors="primary-1" animation_delay="800"][/vc_column][vc_column width="1/3"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-right" clipping_animation_colors="primary-1" animation_delay="800"][movedo_single_image image_mode="medium_large" image="" image_full_column="yes" animation="grve-clipping-animation" clipping_animation="grve-colored-clipping-left" clipping_animation_colors="primary-2" animation_delay="1000"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-restaurant-06';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-restaurant-06.jpg');
$data['custom_class'] = 'demo-restaurant homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="" section_id="contact"][vc_column][movedo_title heading="link-text" align="center" margin_bottom="24"]<span style="color: #3a127b;">Find a table</span>[/movedo_title][movedo_title heading="h5" align="center"]Visit our Restaurant[/movedo_title][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column clipping_animation="colored-clipping-right" clipping_animation_colors="primary-2" animation_delay="600"][movedo_gmap map_zoom="14" map_height="500" map_marker_type="pulse-dot" map_marker_bg_color="white"][/vc_column][vc_column width="1/3" tablet_width="1-4" tablet_sm_width="1-6"][/vc_column][vc_column column_custom_position="yes" position_top="minus-3x" width="1/3" tablet_width="1-2" tablet_sm_width="2-3" shadow="large" clipping_animation="colored-clipping-down" clipping_animation_colors="primary-1" animation_delay="1000" css=".vc_custom_1521020541529{padding-top: 12% !important;padding-right: 12% !important;padding-bottom: 12% !important;padding-left: 12% !important;background-color: #ffffff !important;}"][vc_column_text]
<p style="text-align: center;">44 Oxford Street, London, UK 22004<br />
Phone : +12 533 767 003<br />
Email : gousti@gusti.eu</p>
[/vc_column_text][/vc_column][vc_column width="1/3" tablet_width="1-4" tablet_sm_width="1-6"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


// Demo Lawyer
$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-01';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-01.jpg');
$data['custom_class'] = 'demo-lawyer homepage split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" font_color="rgba(255,255,255,0.8)" bg_color="#121722"][vc_column][movedo_split_content title="consultant" heading_tag="h1" heading="h1" increase_heading="300" split_title="yes" split_title_space="large" min_height="500" read_more_title="read more about" read_more_link="url:%23intro|||" media_type="image" bg_image="" bg_position="center-top" opacity_overlay="0" overlapping_title_color="primary-1"]The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen.[/movedo_split_content][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-02';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-02.jpg');
$data['custom_class'] = 'demo-lawyer homepage';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" bg_color="#f7f7f7"][vc_column width="1/2" clipping_animation="colored-clipping-right" clipping_animation_colors="primary-2" animation_delay="400" css=".vc_custom_1521100060177{padding-right: 25% !important;padding-left: 25% !important;}"][movedo_empty_space height_multiplier="6x"][movedo_title heading="h1"]Integrated Legal<br />
Protection Solutions[/movedo_title][vc_column_text text_style="leader-text"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space height_multiplier="6x"][/vc_column][vc_column width="1/2" heading_color="primary-1" clipping_animation="colored-clipping-left" clipping_animation_colors="primary-1" animation_delay="600" css=".vc_custom_1521100040299{padding-right: 25% !important;padding-left: 25% !important;background-image: url(https://greatives.eu/themes/movedo/movedo-lawyer/wp-content/uploads/sites/15/2018/03/movedo-lawyer-home-bg-img-01.jpg?id=51) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" font_color="#ffffff"][movedo_empty_space height_multiplier="6x"][movedo_title heading="h1"]Integrated Legal<br />
Protection Solutions[/movedo_title][vc_column_text text_style="leader-text"]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier=""][vc_column column_custom_position="yes" position_top="minus-2x" heading_color="light" shadow="large" clipping_animation="clipping-left" animation_delay="800" css=".vc_custom_1521100082835{background-color: #cf9450 !important;}" font_color="#ffffff"][vc_row_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="1700" counter_color="white" counter_heading="h4" title="TRUSTED CLIENTS" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="35" counter_color="white" counter_heading="h4" title="Years in Business" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="1700" counter_color="white" counter_heading="h4" title="TRUSTED CLIENTS" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="12" counter_color="white" counter_heading="h4" title="Lawyers" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-03';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-03.jpg');
$data['custom_class'] = 'demo-lawyer homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column width="1/3"][movedo_title heading_tag="div" heading="small-text" margin_bottom="12"]<span style="color: #cf9450;">Experience</span>[/movedo_title][movedo_title heading="h4"]Personal Injury[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading_tag="div" heading="small-text" margin_bottom="12"]<span style="color: #cf9450;">Professional</span>[/movedo_title][movedo_title heading="h4"]Free consultation[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading_tag="div" heading="small-text" margin_bottom="12"]<span style="color: #cf9450;">Integrity</span>[/movedo_title][movedo_title heading="h4"]Protection Solutions[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-04';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-04.jpg');
$data['custom_class'] = 'demo-lawyer homepage';
$data['content'] = <<<CONTENT
[vc_row bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" bg_color="#cf9450"][vc_column column_custom_position="yes" position_top="3x" heading_color="primary-1" shadow="large" clipping_animation="clipping-up" animation_delay="600" css=".vc_custom_1521100111196{background-image: url(https://greatives.eu/themes/movedo/movedo-lawyer/wp-content/uploads/sites/15/2018/03/movedo-lawyer-bg-img-02.jpg?id=60) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" font_color="#ffffff"][movedo_empty_space height_multiplier="6x"][movedo_title align="center"]Need Legal Help?[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Get in Touch with Our Lawyers!</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="230" align="center" button_text="Get free consultation" button_hover_color="white" button_size="small" button_link="url:https%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fmovedo-lawyer%2Fcontact%2F|||"][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-05';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-05.jpg');
$data['custom_class'] = 'demo-lawyer homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" equal_column_height="equal-column" font_color="#ffffff" bg_color="#121722"][vc_column width="1/3" clipping_animation="colored-clipping-up" clipping_animation_colors="primary-1" animation_delay="600" css=".vc_custom_1521100150538{padding-right: 25% !important;padding-left: 25% !important;background-color: #121722 !important;}"][movedo_empty_space height_multiplier="2x"][movedo_icon align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-shield" margin_bottom="18"][movedo_title heading="h5" align="center"]Personal Injury[/movedo_title][vc_column_text]
<p style="text-align: center;">When she reached the first hills of the Italic Mountains, she had a last view back.</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="125" align="center" button_text="read more" button_type="outline" button_color="white" button_hover_color="white" button_size="small" button_link="url:%23|||"][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3" clipping_animation="colored-clipping-down" clipping_animation_colors="primary-1" animation_delay="800" css=".vc_custom_1521100221347{padding-right: 25% !important;padding-left: 25% !important;background-color: #1c2538 !important;}"][movedo_empty_space height_multiplier="2x"][movedo_icon align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-shield" margin_bottom="18"][movedo_title heading="h5" align="center"]Traffic Accidents[/movedo_title][vc_column_text]
<p style="text-align: center;">When she reached the first hills of the Italic Mountains, she had a last view back.</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="125" align="center" button_text="read more" button_type="outline" button_color="white" button_hover_color="white" button_size="small" button_link="url:%23|||"][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3" clipping_animation="colored-clipping-up" clipping_animation_colors="primary-1" animation_delay="1000" css=".vc_custom_1521100226791{padding-right: 25% !important;padding-left: 25% !important;background-color: #36425b !important;}"][movedo_empty_space height_multiplier="2x"][movedo_icon align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-shield" margin_bottom="18"][movedo_title heading="h5" align="center"]Business Litigation[/movedo_title][vc_column_text]
<p style="text-align: center;">When she reached the first hills of the Italic Mountains, she had a last view back.</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="125" align="center" button_text="read more" button_type="outline" button_color="white" button_hover_color="white" button_size="small" button_link="url:%23|||"][movedo_empty_space height_multiplier="2x"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-06';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-06.jpg');
$data['custom_class'] = 'demo-lawyer page split counters';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" bg_color="#f7f7f7"][vc_column][movedo_split_content title="Services" heading_tag="h1" heading="h1" increase_heading="250" custom_font_family="custom-font-1" split_title="yes" split_title_space="large" split_content_height="large" min_height="500" media_type="image" bg_image="" color_overlay="primary-2" opacity_overlay="80"][/movedo_split_content][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier=""][vc_column column_custom_position="yes" position_top="minus-2x" heading_color="light" shadow="large" clipping_animation="clipping-left" animation_delay="600" css=".vc_custom_1521102283322{background-color: #cf9450 !important;}" font_color="#ffffff"][vc_row_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="1700" counter_color="white" counter_heading="h4" title="TRUSTED CLIENTS" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="35" counter_color="white" counter_heading="h4" title="Years in Business" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="1700" counter_color="white" counter_heading="h4" title="TRUSTED CLIENTS" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/4"][movedo_empty_space][movedo_counter counter_end_val="12" counter_color="white" counter_heading="h4" title="Lawyers" heading="link-text" align="center"][movedo_empty_space][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-07';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 7', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-07.jpg');
$data['custom_class'] = 'demo-lawyer page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column][movedo_title align="center"]Practice Areas[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Top legal services for all citizens</p>
[/vc_column_text][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h6"]01 <span style="color: #cf9450;">Car Accidents</span>[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space][/vc_column][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h6"]02 <span style="color: #cf9450;">Labor Disputes</span>[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space][/vc_column][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h6"]03 <span style="color: #cf9450;">Medical Abuse</span>[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space][/vc_column][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h6"]04 <span style="color: #cf9450;">Business Litigation</span>[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space][/vc_column][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h6"]05 <span style="color: #cf9450;">Criminal Defense</span>[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space][/vc_column][vc_column width="1/3"][movedo_empty_space][movedo_title heading="h6"]06 <span style="color: #cf9450;">Finance Law</span>[/movedo_title][vc_column_text]Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.[/vc_column_text][movedo_empty_space][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-08';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 8', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-08.jpg');
$data['custom_class'] = 'demo-lawyer page iconbox';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60" equal_column_height="equal-column" font_color="#ffffff"][vc_column width="1/3" clipping_animation="clipping-up" animation_delay="600" css=".vc_custom_1521102296991{padding-top: 13% !important;padding-right: 13% !important;padding-bottom: 13% !important;padding-left: 13% !important;background-color: #121722 !important;}"][movedo_icon align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-shield" margin_bottom="18"][movedo_title heading="h5" align="center"]Personal Injury[/movedo_title][vc_column_text]
<p style="text-align: center;">When she reached the first hills of the Italic Mountains, she had a last view back.</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="220" align="center" button_text="Read More" button_hover_color="white" button_size="small" button_link="url:%23|||"][/vc_column][vc_column width="1/3" clipping_animation="clipping-up" animation_delay="800" css=".vc_custom_1521102301974{padding-top: 13% !important;padding-right: 13% !important;padding-bottom: 13% !important;padding-left: 13% !important;background-color: #121722 !important;}"][movedo_icon align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-shield" margin_bottom="18"][movedo_title heading="h5" align="center"]Traffic Accidents[/movedo_title][vc_column_text]
<p style="text-align: center;">When she reached the first hills of the Italic Mountains, she had a last view back.</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="220" align="center" button_text="Read More" button_hover_color="white" button_size="small" button_link="url:%23|||"][/vc_column][vc_column width="1/3" clipping_animation="clipping-up" animation_delay="1000" css=".vc_custom_1521102308262{padding-top: 13% !important;padding-right: 13% !important;padding-bottom: 13% !important;padding-left: 13% !important;background-color: #121722 !important;}"][movedo_icon align="center" icon_library="simplelineicons" icon_simplelineicons="smp-icon-shield" margin_bottom="18"][movedo_title heading="h5" align="center"]Business Litigation[/movedo_title][vc_column_text]
<p style="text-align: center;">When she reached the first hills of the Italic Mountains, she had a last view back.</p>
[/vc_column_text][movedo_empty_space][movedo_button btn_fluid="custom" btn_custom_width="220" align="center" button_text="Read More" button_hover_color="white" button_size="small" button_link="url:%23|||"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-09';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 9', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-09.jpg');
$data['custom_class'] = 'demo-lawyer page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" columns_gap="60"][vc_column][movedo_title]The allied which you need[/movedo_title][/vc_column][vc_column][movedo_empty_space height_multiplier="custom" height="18"][/vc_column][vc_column width="1/2"][vc_column_text]The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen.When she reached the first hills of the Italic Mountains, she had a last view back. She packed her seven versalia, put her initial into the belt and made herself on the way. When she reached the first hills of the Italic Mountains, she had a last view back.[/vc_column_text][/vc_column][vc_column width="1/2"][movedo_progress_bar bar_style="style-2" values="90|Personal Injury,80|Traffic Accidents,70|Business Litigation,85|Medical Abuse" bar_height="4"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-10';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 10', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-10.jpg');
$data['custom_class'] = 'demo-lawyer page split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" bg_color="#f7f7f7"][vc_column][movedo_split_content title="About" heading_tag="h1" heading="h1" increase_heading="250" custom_font_family="custom-font-1" split_title="yes" split_title_space="large" split_content_height="large" min_height="500" media_type="image" bg_image="" color_overlay="primary-2" opacity_overlay="80"][/movedo_split_content][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none"][vc_column column_custom_position="yes" position_top="minus-3x" width="1/2" heading_color="light" clipping_animation="clipping-right" animation_delay="600" css=".vc_custom_1521102355546{padding-right: 17% !important;padding-left: 17% !important;background-color: #cf9450 !important;}" font_color="#ffffff"][movedo_empty_space height_multiplier="2x"][movedo_title heading_tag="h2" heading="h4"]We give you<br />
personal attention.[/movedo_title][vc_column_text]The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Marks and devious Semikoli, but the Little Blind Text didn’t listen.[/vc_column_text][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column column_custom_position="yes" position_top="minus-3x" width="1/2" heading_color="light" clipping_animation="clipping-left" animation_delay="600" css=".vc_custom_1521102351387{padding-right: 17% !important;padding-left: 17% !important;background-color: #121722 !important;}" font_color="#ffffff"][movedo_empty_space height_multiplier="2x"][movedo_title heading_tag="h2" heading="h4"]Request a free<br />
case evaluation.[/movedo_title][vc_column_text]The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Marks and devious Semikoli, but the Little Blind Text didn’t listen.[/vc_column_text][movedo_empty_space height_multiplier="2x"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-11';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 11', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-11.jpg');
$data['custom_class'] = 'demo-lawyer page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#121722"][vc_column][movedo_title align="center"]Meet Our Attorneys[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">It is a paradisematic country, in which roasted parts of sentences</p>
[/vc_column_text][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/3" heading_color="primary-1" clipping_animation="clipping-up" animation_delay="600"][movedo_team image_size="large" image="" name="John Smith" heading="h6" identity="Bank Lawyer" overlay_color="primary-2" overlay_opacity="90" social_facebook="#" social_twitter="#" social_linkedin="#"]Sample Text[/movedo_team][/vc_column][vc_column width="1/3" heading_color="primary-1" clipping_animation="clipping-up" animation_delay="800"][movedo_team image_size="large" image="" name="John Smith" heading="h6" identity="Bank Lawyer" overlay_color="primary-2" overlay_opacity="90" social_facebook="#" social_twitter="#" social_linkedin="#"]Sample Text[/movedo_team][/vc_column][vc_column width="1/3" heading_color="primary-1" clipping_animation="clipping-up" animation_delay="1000"][movedo_team image_size="large" image="" name="John Smith" heading="h6" identity="Bank Lawyer" overlay_color="primary-2" overlay_opacity="90" social_facebook="#" social_twitter="#" social_linkedin="#"]Sample Text[/movedo_team][/vc_column][/vc_row][vc_row heading_color="light" bg_type="color" padding_top_multiplier="2x" padding_bottom_multiplier="2x" font_color="#ffffff" bg_color="#cf9450"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_callout title="Request a free consultation" heading="h4" button_text="Request Now" button_color="white" button_size="small"][/movedo_callout][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]

CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'demo-lawyer-12';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Lawyer - Section 12', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/demo-lawyer-12.jpg');
$data['custom_class'] = 'demo-lawyer page split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" columns_gap="none" bg_color="#f7f7f7"][vc_column][movedo_split_content title="Questions" heading_tag="h1" heading="h1" increase_heading="250" custom_font_family="custom-font-1" split_title="yes" split_title_space="large" split_content_height="large" min_height="500" media_type="image" bg_image="" split_content_align="right" color_overlay="primary-2" opacity_overlay="80"][/movedo_split_content][/vc_column][/vc_row][vc_row heading_color="light" padding_top_multiplier="" padding_bottom_multiplier="" font_color="#ffffff"][vc_column column_custom_position="yes" position_top="minus-2x" shadow="large" clipping_animation="clipping-left" animation_delay="600" css=".vc_custom_1521102214009{padding-top: 30px !important;padding-right: 30px !important;padding-bottom: 30px !important;padding-left: 30px !important;background-color: #cf9450 !important;}"][movedo_callout title="Request a free consultation" heading="h4" button_text="Request Now" button_color="white" button_size="small"][/movedo_callout][/vc_column][/vc_row]


CONTENT;
$templates[] = $data;


// Main Demo
$data = array();
$data['unique_id'] = $data['id'] = 'creative-studio-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Studio - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/creative-studio-01.jpg');
$data['custom_class'] = 'homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" columns_gap="none" section_full_height="fullheight" bg_type="image" bg_image="" bg_image_type="parallax" padding_top_multiplier="" padding_bottom_multiplier="" parallax_sensor="350" font_color="#ffffff"][vc_column width="1/4" css=".vc_custom_1472741881694{padding: 30px !important;border: 5px solid #ffffff !important;}"][movedo_title heading_tag="h1" line_type="line" line_width="60" line_height="5" line_color="white"]Wave
Of Change[/movedo_title][movedo_empty_space height_multiplier="4x"][vc_column_text text_style="leader-text"]Do you choose to ride, or
BE the Wave of Change?[/vc_column_text][/vc_column][vc_column width="1/4"][/vc_column][vc_column width="1/4"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'creative-studio-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Studio - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/creative-studio-02.jpg');
$data['custom_class'] = 'homepage typography';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_typed_text typed_values="The new benchmark for Users" heading_tag="h2" heading="h2" text_color="black" align="center" textspeed="100" backspeed="80" startdelay="0" backdelay="500" show_cursor=""][movedo_title heading="h6" align="center" animation="grve-fade-in-up" animation_delay="400"]Come on Board[/movedo_title][vc_column_text text_style="leader-text" animation="grve-fade-in-up" animation_delay="400"]
<p style="text-align: center;">Fierent mediocrem suavitate eam id, cu odio consequat eum. Graeco scripserit in eos, putent posidonium mei an, sed ut labitur accusamus instructior. Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium ex sit.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'creative-studio-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Studio - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/creative-studio-03.jpg');
$data['custom_class'] = 'homepage parallax';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" columns_gap="none" section_full_height="fullheight" bg_type="image" bg_image="" bg_image_type="parallax" padding_top_multiplier="" padding_bottom_multiplier="" parallax_sensor="350" font_color="#ffffff"][vc_column width="1/4"][/vc_column][vc_column width="1/4"][/vc_column][vc_column width="1/4"][/vc_column][vc_column width="1/4" css=".vc_custom_1472741881694{padding: 30px !important;border: 5px solid #ffffff !important;}"][movedo_title heading_tag="h1" line_type="line" line_width="60" line_height="5" line_color="white"]User are
our priority[/movedo_title][movedo_empty_space height_multiplier="4x"][vc_column_text text_style="leader-text"]Do you choose to ride, or
BE the Wave of Change?[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'creative-studio-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Studio - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/creative-studio-04.jpg');
$data['custom_class'] = 'homepage';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x" separator_top="tilt-left-separator" separator_top_size="100%" separator_top_color="#f7f7f7"][vc_column width="7/12"][movedo_double_image_text image_mode="portrait" image_mode2="square"][/movedo_double_image_text][/vc_column][vc_column width="5/12"][movedo_title heading_tag="h2" heading="h2"]WordPress like never before[/movedo_title][vc_column_text text_style="leader-text"]Dicat novum iracundia at pro, per audiam tibique mediocritatem id. Ne fugit civibus epicurei cum, et quas alienum definitionem his.[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_library="etlineicons" icon_etlineicons="et-icon-linegraph" title="Amazing Interface" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space height_multiplier="custom" height="40"][movedo_icon_box icon_box_type="side-icon" icon_library="etlineicons" icon_etlineicons="et-icon-layers" title="Header Manipulations" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space height_multiplier="custom" height="40"][movedo_icon_box icon_box_type="side-icon" icon_library="etlineicons" title="Responsive Typography" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur ut tota aeterno suscipiantur pri.[/movedo_icon_box][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'creative-studio-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Creative Studio - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/creative-studio-05.jpg');
$data['custom_class'] = 'homepage steps';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/3"][movedo_title]<span style="color: #31b5ed;">01.</span> Easy to use[/movedo_title][vc_column_text]Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title]<span style="color: #31b5ed;">02.</span> Fun to Create[/movedo_title][vc_column_text]Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title]<span style="color: #31b5ed;">03.</span> Competition Ready[/movedo_title][vc_column_text]Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'classic-agency-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Classic Agency - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/classic-agency-01.jpg');
$data['custom_class'] = 'homepage typography';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_icon icon_size="large" align="center" icon_library="etlineicons" icon_etlineicons="et-icon-circle-compass"][movedo_empty_space][movedo_title heading_tag="h2" heading="h2" align="center" margin_bottom="0"]Creative to all[/movedo_title][movedo_title heading_tag="h2" heading="h2" align="center"]intents and purposes[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Fierent mediocrem suavitate eam id, cu odio consequat eum. Graeco scripserit in eos, putent posidonium mei an, sed ut labitur accusamus instructior. Mollis percipit repudiandae sed eu.</p>[/vc_column_text][movedo_empty_space][movedo_button align="center" button_text="Come on board" button_type="outline" button_hover_color="primary-1" button_shape="round" button_link="url:%23|||"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'classic-agency-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Classic Agency - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/classic-agency-02.jpg');
$data['custom_class'] = 'homepage parallax';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" columns_gap="10" padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column column_effect="vertical-parallax" column_effect_limit="none" width="1/6"][movedo_single_image image_mode="portrait" image=""][/vc_column][vc_column width="1/6"][movedo_single_image image_mode="portrait" image=""][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" width="1/6"][movedo_single_image image_mode="portrait" image=""][/vc_column][vc_column width="1/6"][movedo_single_image image_mode="portrait" image=""][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" width="1/6"][movedo_single_image image_mode="portrait" image=""][/vc_column][vc_column width="1/6"][movedo_single_image image_mode="portrait" image=""][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'classic-agency-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Classic Agency - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/classic-agency-03.jpg');
$data['custom_class'] = 'homepage parallax';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image_type="parallax" padding_top_multiplier="6x" padding_bottom_multiplier="6x" parallax_sensor="350" font_color="#ffffff"][vc_column column_effect="mouse-move-x-y" column_effect_sensitive="normal" column_effect_limit="3x" width="1/2"][movedo_empty_space height_multiplier="3x"][movedo_title heading_tag="h2" heading="h1" increase_heading="200" custom_font_family="custom-font-1"]We build frameworks that respect your time and money.[/movedo_title][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/2"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'classic-agency-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Classic Agency - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/classic-agency-04.jpg');
$data['custom_class'] = 'homepage counters';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" font_color="#ffffff" bg_color="#0652fd"][vc_column width="1/4"][movedo_counter counter_end_val="320" counter_color="white" counter_heading="h1" title="Cups of Coffee" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="108" counter_color="white" counter_heading="h1" title="Pizzas Ordered" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="258" counter_color="white" counter_heading="h1" title="Working Hours" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="4750" counter_color="white" counter_heading="h1" title="Code Lines" heading="link-text" align="center"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'classic-agency-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Classic Agency - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/classic-agency-05.jpg');
$data['custom_class'] = 'homepage parallax typography';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/2"][movedo_title heading="h5" align="right"]<span class="grve-text-primary-1">01.</span> Idea[/movedo_title][movedo_title heading="h5" align="right"]<span class="grve-text-primary-1">02.</span> Design[/movedo_title][movedo_title heading="h5" align="right"]<span class="grve-text-primary-1">03.</span> Product[/movedo_title][/vc_column][vc_column width="1/2"][/vc_column][vc_column][movedo_empty_space][/vc_column][vc_column z_index="10"][movedo_title heading_tag="h1" increase_heading="200" align="center"]The New Highway[/movedo_title][/vc_column][vc_column][movedo_empty_space][/vc_column][vc_column width="1/4"][/vc_column][vc_column width="1/4"][vc_column_text]
<p style="text-align: right;">Lorem ipsum dolor sit amet, et errem graece facilisi eos, aeterno eleifend persequeris eum id. Veritus eleifend vel ad. Lorem volumus mediocritatem dico constituam in.</p>[/vc_column_text][movedo_empty_space][movedo_title heading="h6" align="right"]Movedo People[/movedo_title][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" width="1/4"][movedo_single_image image_mode="portrait"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'classic-agency-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Classic Agency - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/classic-agency-06.jpg');
$data['custom_class'] = 'homepage typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="rgba(255,255,255,0.6)" bg_color="#1c1f21"][vc_column width="1/3"][movedo_slogan title="Easy to use" heading_tag="h3" heading="h6" button_text="" button2_text=""]Praesent ocurreret eu pro, ut eum mucius possit. Et has alii cibo prompta, id delicata appellantur efficiantur mea, id numquam volumus quo. Eum quot dolorem id, tantas mediocritatem qui in. Sale novum torquatos per at, no vocibus mentitum partiendo cum. [/movedo_slogan][/vc_column][vc_column width="1/3"][movedo_slogan title="Fun to create" heading_tag="h3" heading="h6" button_text="" button2_text=""]Praesent ocurreret eu pro, ut eum mucius possit. Et has alii cibo prompta, id delicata appellantur efficiantur mea, id numquam volumus quo. Eum quot dolorem id, tantas mediocritatem qui in. Sale novum torquatos per at, no vocibus mentitum partiendo cum. [/movedo_slogan][/vc_column][vc_column width="1/3"][movedo_slogan title="Competition ready" heading_tag="h3" heading="h6" button_text="" button2_text=""]Praesent ocurreret eu pro, ut eum mucius possit. Et has alii cibo prompta, id delicata appellantur efficiantur mea, id numquam volumus quo. Eum quot dolorem id, tantas mediocritatem qui in. Sale novum torquatos per at, no vocibus mentitum partiendo cum. [/movedo_slogan][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'corporate-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/corporate-01.jpg');
$data['custom_class'] = 'homepage iconbox split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" padding_top_multiplier="" padding_bottom_multiplier=""][vc_column width="1/2" css=".vc_custom_1473953419872{background-color: #f7f7f7 !important;}"][movedo_empty_space height_multiplier="4x"][movedo_single_image image_mode="landscape"][movedo_empty_space height_multiplier="4x"][/vc_column][vc_column width="1/4" css=".vc_custom_1473953487137{padding-right: 12% !important;padding-left: 12% !important;}"][movedo_empty_space height_multiplier="6x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="etlineicons" icon_etlineicons="et-icon-linegraph" icon_color="black" title="Amazing Interface" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. [/movedo_icon_box][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="etlineicons" icon_etlineicons="et-icon-layers" icon_color="black" title="Amazing Interface" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. [/movedo_icon_box][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="etlineicons" icon_etlineicons="et-icon-global" icon_color="black" title="Translate Ready" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. [/movedo_icon_box][movedo_empty_space height_multiplier="6x"][/vc_column][vc_column width="1/4" css=".vc_custom_1473953494270{padding-right: 12% !important;padding-left: 12% !important;}"][movedo_empty_space height_multiplier="6x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="etlineicons" icon_etlineicons="et-icon-trophy" icon_color="black" title="High Rated Team" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. [/movedo_icon_box][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="etlineicons" icon_color="black" title="Responsive Typography" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. [/movedo_icon_box][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="etlineicons" icon_etlineicons="et-icon-lifesaver" icon_color="black" title="Dedicated Support" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. [/movedo_icon_box][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'corporate-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/corporate-02.jpg');
$data['custom_class'] = 'homepage counters';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#21313b"][vc_column width="1/4"][movedo_counter counter_end_val="328" counter_color="blue" counter_heading="h1" title="Cups of Coffee" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="108" counter_color="blue" counter_heading="h1" title="Pizzas Ordered" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="258" counter_color="blue" counter_heading="h1" title="Working Hours" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="4750" counter_color="blue" counter_heading="h1" title="Code Lines" heading="link-text" align="center"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'corporate-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/corporate-03.jpg');
$data['custom_class'] = 'homepage call-action';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_title heading_tag="h2" heading="h1" custom_font_family="custom-font-1" align="center"]The Movedo Generation of multi-purpose themes is here. In a marketplace volatile you need to build confident themes.[/movedo_title][movedo_empty_space][movedo_button align="center" button_text="MEET OUR LEADERS" button_color="blue" button_shape="round" button_link="url:%23|||"][/vc_column][vc_column width="1/4"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'corporate-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Corporate - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/corporate-04.jpg');
$data['custom_class'] = 'homepage split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" font_color="#ffffff" bg_color="#21313b"][vc_column width="1/2" css=".vc_custom_1473954422313{padding-top: 20% !important;padding-right: 25% !important;padding-bottom: 20% !important;padding-left: 25% !important;}"][movedo_title heading_tag="h2" heading="h1"]At The Top of your lifetime investments[/movedo_title][vc_column_text text_style="leader-text"]Mea admodum quaestio ei, tota nemore postulant et mea. Nec eu quaeque sapientem, mel senserit theophrastus an. Has vero mundi voluptatibus ei, dicit mentitum te mel.[/vc_column_text][movedo_divider line_type="custom-line" line_width="100px" line_height="5" line_color="blue" padding_top="30"][/vc_column][vc_column width="1/2" css=".vc_custom_1473954445905{background-image: url(https://images.unsplash.com/photo-1448669476458-ef3a9136823f?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'shop-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Shop - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/shop-01.jpg');
$data['custom_class'] = 'homepage typography parallax';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/3"][/vc_column][vc_column width="2/3"][movedo_title heading_tag="h1" heading="h1"]WE MOVE
FASHION MOVES US[/movedo_title][/vc_column][vc_column][movedo_empty_space][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="6x" width="1/3" column_parallax="column-parallax"][movedo_empty_space][movedo_single_image image_mode="portrait"][movedo_empty_space][/vc_column][vc_column width="2/3"][vc_row_inner][vc_column_inner width="3/4"][vc_column_text text_style="leader-text"]
<p class="p1"><span class="s1">Vis duis eius postulant et, audiam maiorum nominavi vix an. Ea omnes aliquip expetendis eum, suas nonumes postulant usu at, homero quodsi fierent cu qui. Et usu iracundia referrentur. Nec ea minim petentium.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner][movedo_empty_space][/vc_column_inner][vc_column_inner width="1/2"][movedo_single_image image_mode="portrait"][/vc_column_inner][vc_column_inner width="1/2"][movedo_counter counter_end_val="20" counter_prefix="-" counter_suffix="%" counter_color="blue" counter_heading="h1" increase_counter_heading="300" title="FOR OCTOMBER" heading="h1"][movedo_empty_space][vc_column_text]Lorem convenire adolescens in vim, ei vix vocibus probatus antiopam. At per dico meis appetere. Ea his audire saperet. Cetero eripuit percipit duo euoportere persequeris nam cu, at noluisse intellegam vix, sea ut laudem complectitur. Cete eripuit percipit duo eu, est veri elitr saepe id. Oportere pers queris nam cu. At noluisse intellegam vix, sea ut laudem complectitur.[/vc_column_text][movedo_empty_space][movedo_button button_text="Check out our offers" button_color="orange" button_shape="extra-round" button_link="url:%23|||"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;

$data = array();
$data['unique_id'] = $data['id'] = 'shop-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Shop - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/shop-02.jpg');
$data['custom_class'] = 'homepage typography parallax';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="" padding_bottom_multiplier="" separator_bottom="curve-left-separator" separator_bottom_size="100%" separator_bottom_color="#000000"][vc_column column_effect="mouse-move-x-y" column_effect_sensitive="high" column_effect_limit="5x" column_custom_position="yes" position_top="3x" width="1/2" css=".vc_custom_1474297707961{padding-top: 60px !important;padding-right: 60px !important;padding-bottom: 60px !important;padding-left: 60px !important;background-color: #15c7ff !important;border-radius: 30px !important;}" z_index="3" font_color="#ffffff"][movedo_title heading="h1" increase_heading="300" align="right" margin_bottom="0"]2016[/movedo_title][movedo_title heading="h1" increase_heading="200" align="right"]NEW TRENDS[/movedo_title][vc_column_text]
<p style="text-align: right;">At per dico meis appetere. Ea his audire saperet. Cetero eripuit percipit duo euoportere persequeris nam cu, at noluisse intellegam vix, sea ut laudem complectitur. Cete eripuit percipit duo.</p>[/vc_column_text][/vc_column][vc_column width="1/2" z_index="6"][movedo_single_image image_mode="portrait"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'shop-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Shop - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/shop-03.jpg');
$data['custom_class'] = 'homepage call-action parallax';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image_type="parallax" color_overlay="dark" opacity_overlay="40" padding_top_multiplier="6x" padding_bottom_multiplier="6x" parallax_sensor="350" font_color="#ffffff"][vc_column][movedo_title align="center" margin_bottom="0"]NEW TRENDS[/movedo_title][movedo_empty_space][movedo_title heading_tag="h2" heading="h1" increase_heading="300" align="center"]SPECIAL OFFERS[/movedo_title][vc_column_text text_style="leader-text"]
<p class="p1" style="text-align: center;"><span class="s1">Lorem ipsum dolor sit amet, nec diceret minimum nominati no. Facer zril omnes cu cum, everti officiis cu sea.</span></p>[/vc_column_text][movedo_empty_space][movedo_button align="center" button_text="CHECK OUT OUR OFFERS" button_color="orange" button_hover_color="white" button_shape="extra-round" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'shop-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Shop - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/shop-04.jpg');
$data['custom_class'] = 'homepage typography parallax split';
$data['content'] = <<<CONTENT
[vc_row columns_gap="none" equal_column_height="middle-content" padding_top_multiplier="4x" padding_bottom_multiplier="4x" separator_top="curve-left-separator" separator_top_size="100%" separator_top_color="#f7f7f7"][vc_column width="1/2" heading_color="light" css=".vc_custom_1474296786260{padding-right: 18% !important;padding-left: 18% !important;background-color: #000000 !important;}" font_color="#ffffff"][movedo_title align="right"]<span style="color: #f9d531;">DISCOVER</span>[/movedo_title][movedo_title heading="h1" increase_heading="140" align="right" margin_bottom="0"]WINTER 2017[/movedo_title][movedo_title heading="h1" increase_heading="200" align="right" margin_bottom="0"]COLLECTION[/movedo_title][movedo_empty_space][movedo_button align="right" button_text="Read More About" button_type="underline" button_color="white" button_line_color="orange" button_link="url:%23|||"][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" width="1/2"][movedo_single_image image_mode="large"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'app-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'App - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/app-01.jpg');
$data['custom_class'] = 'homepage typography parallax call-action';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image_type="parallax" padding_top_multiplier="6x" padding_bottom_multiplier="6x" parallax_sensor="350" font_color="#ffffff"][vc_column][movedo_empty_space height_multiplier="2x"][movedo_title heading="h5" align="center" margin_bottom="0"]Exclusive Bundle[/movedo_title][movedo_empty_space height_multiplier="custom" height="30"][movedo_title heading_tag="h2" heading="h1" increase_heading="200" align="center"]DOWNLOAD MOVEDO APP NOW[/movedo_title][vc_column_text text_style="leader-text"]
<p style="text-align: center;">Tollit nostro blandit sed te, eu omnium regione apeirian sed, duo detracto detraxit in. Te nec unum aliquid, quo et dolor incorrupte.</p>[/vc_column_text][movedo_empty_space height_multiplier="custom" height="30"][movedo_button align="center" button_text="Download for free" button_color="white" button_shape="round" button_link="url:%23|||"][movedo_empty_space height_multiplier="2x"][/vc_column][/vc_row][vc_row bg_type="color" bg_color="#ecf0f4"][vc_column column_effect="vertical-parallax" column_effect_limit="4x" column_custom_position="yes" position_top="minus-4x" el_wrapper_class="grve-drop-shadow" css=".vc_custom_1474008539256{padding-right: 25% !important;padding-left: 25% !important;background-color: #ffffff !important;border-radius: 5px !important;}"][movedo_empty_space height_multiplier="3x"][movedo_title heading_tag="h2" heading="h1" increase_heading="140" align="center"]Discover Our Features[/movedo_title][vc_column_text]
<p style="text-align: center;">Dicat scripta percipit vim in, vidit atomorum cum cu. Ad has natum facer debet, cu populo sanctus admodum has. Eu possit consectetuer pri, pri dicta nonumy ei, eripuit conclusionemque ex nam. Est reque eligendi cu, salutandi elaboraret ad usu, eu vim autem tation.</p>[/vc_column_text][movedo_empty_space height_multiplier="custom" height="40"][movedo_single_image image_type="image-link" image_mode="thumbnail" link="url:https%3A%2F%2Fvimeo.com%2F58363288|||" link_class="grve-video-popup"][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row][vc_row section_type="fullwidth" bg_type="color" padding_top_multiplier="2x" padding_bottom_multiplier="4x" bg_color="#ecf0f4"][vc_column width="1/3" css=".vc_custom_1472762563520{border-right-width: 1px !important;padding-right: 21% !important;padding-left: 21% !important;border-right-color: rgba(0,0,0,0.1) !important;border-right-style: solid !important;}"][movedo_title]<span class="grve-text-primary-1">01.</span> Easy to use[/movedo_title][vc_column_text]Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium[/vc_column_text][/vc_column][vc_column width="1/3" css=".vc_custom_1472762570203{border-right-width: 1px !important;padding-right: 21% !important;padding-left: 21% !important;border-right-color: rgba(0,0,0,0.1) !important;border-right-style: solid !important;}"][movedo_title]<span class="grve-text-primary-1">02.</span> Fun to Create[/movedo_title][vc_column_text]Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium[/vc_column_text][/vc_column][vc_column width="1/3" css=".vc_custom_1472748349690{padding-right: 21% !important;padding-left: 21% !important;}"][movedo_title]<span class="grve-text-primary-1">03.</span> Competition Ready[/movedo_title][vc_column_text]Mollis percipit repudiandae sed eu. Erat porro eos ex, iriure pertinacia ea cum, quis molestie petentium[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'design-agency-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Design Agency - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/design-agency-01.jpg');
$data['custom_class'] = 'homepage typography steps';
$data['content'] = <<<CONTENT
[vc_row columns_gap="60" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" bg_color="#f7f7f7"][vc_column][movedo_title heading_tag="h2" heading="h1" increase_heading="140" custom_font_family="custom-font-1" align="center" animation="grve-fade-in-up"]All entities Move
and nothing remains still[/movedo_title][/vc_column][vc_column][movedo_empty_space height_multiplier="custom" height="36"][/vc_column][vc_column][movedo_title heading="small-text" align="center" animation="grve-fade-in-up" animation_delay="400"]Masterfully Handcrafted for Awesomeness[/movedo_title][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/3"][movedo_title heading="link-text" animation="grve-fade-in-up" animation_delay="600"]<span style="color: #6d10e0;">01 |</span> Page Builder[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="600"]Cras rhoncus aliquam leo, non fusce nibh leo, ac rutrum, quis, a porttitor ac donec egestas, himenaeos turpis at donec vitae ac laoreet.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading="link-text" animation="grve-fade-in-up" animation_delay="800"]<span style="color: #6d10e0;">02 |</span> Fresh Ideas[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="800"]Cras rhoncus aliquam leo, non fusce nibh leo, ac rutrum, quis, a porttitor ac donec egestas, himenaeos turpis at donec vitae ac laoreet.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading="link-text" animation="grve-fade-in-up" animation_delay="1000"]<span style="color: #6d10e0;">03 |</span> Design Solutions[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="1000"]Cras rhoncus aliquam leo, non fusce nibh leo, ac rutrum, quis, a porttitor ac donec egestas, himenaeos turpis at donec vitae ac laoreet.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'design-agency-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Design Agency - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/design-agency-02.jpg');
$data['custom_class'] = 'homepage split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" font_color="#ffffff" bg_color="#0e093c"][vc_column width="1/2" css=".vc_custom_1485167907971{background-image: url(https://images.unsplash.com/photo-1489097474497-6db3de299415?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" css=".vc_custom_1474009577811{padding-top: 12% !important;padding-right: 14% !important;padding-bottom: 12% !important;padding-left: 14% !important;}"][movedo_title heading_tag="h2" heading="h1" increase_heading="200" custom_font_family="custom-font-1"]Movedo is the new benchmark for Users[/movedo_title][movedo_empty_space][vc_column_text text_style="leader-text"]Design with the user in mind to enjoy the clean look. Feeling at home with backend, being an artist with frontend. Web design encompasses many different skills and disciplines in the production and maintenance of websites.[/vc_column_text][movedo_empty_space][movedo_button button_text="Come on board" button_color="white" button_hover_color="primary-3" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'landing-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/landing-01.jpg');
$data['custom_class'] = 'homepage';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" equal_column_height="middle-content" section_full_height="fullheight" bg_type="image" bg_image="" bg_image_type="parallax" bg_image_size="full" color_overlay="custom" color_overlay_custom="rgba(71,35,219,0.95)" mobile_equal_column_height="false" font_color="#ffffff"][vc_column width="5/12"][movedo_slogan title="Creative to all intents and purposes." heading_tag="h1" heading="h1" increase_heading="140" text_style="leader-text" button_text="" button_color="white" button_hover_color="blue" button_shape="extra-round" button_link="url:%23|||" button2_text="Purchase Movedo" button2_type="outline" button2_color="white" button2_hover_color="blue" button2_shape="extra-round" button2_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"]There is a fine line between creating greatness and accomplishing awesomeness. This time, we worked to prove that sky is not the limit.[/movedo_slogan][/vc_column][vc_column column_effect="mouse-move-x-y" column_effect_sensitive="normal" column_effect_limit="3x" width="7/12"][movedo_empty_space][movedo_single_image image_mode="portrait" image=""][movedo_empty_space][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'landing-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/landing-02.jpg');
$data['custom_class'] = 'homepage split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" padding_top_multiplier="" padding_bottom_multiplier="" tablet_portrait_equal_column_height="false" mobile_equal_column_height="false"][vc_column width="1/2" tablet_width="7-12" tablet_sm_width="1" css=".vc_custom_1477674283755{padding-right: 22% !important;padding-left: 22% !important;background-color: #f4f6fe !important;}"][movedo_empty_space height_multiplier="2x"][movedo_title heading="link-text" animation="grve-fade-in-down" animation_delay="1200"]WHAT WE CAN DO[/movedo_title][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-up" margin_bottom="0"]Masterfully Handcrafted[/movedo_title][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-up" animation_delay="400" margin_bottom="0"]for Awesomeness[/movedo_title][movedo_empty_space][movedo_quote animation="grve-fade-in-up" animation_delay="800"]A creative and multi-purpose WP theme masterfully handcrafted for nothing less than awesomeness[/movedo_quote][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column width="1/2" tablet_width="5-12" tablet_sm_width="1" heading_color="light" font_color="#ffffff"][vc_row_inner][vc_column_inner css=".vc_custom_1477072957308{padding: 13% !important;background-color: #15c7ff !important;}"][movedo_social_links icon_size="small" icon_color="white" icon_shape="circle" shape_color="white" shape_type="outline" align="center" twitter_url="#" facebook_url="#" github_url="#" behance_url="#"][/vc_column_inner][vc_column_inner css=".vc_custom_1477073143846{padding-top: 12% !important;padding-right: 13% !important;padding-bottom: 12% !important;padding-left: 13% !important;background-color: #4635bc !important;}"][movedo_title align="center"]We really appreciate your feedback[/movedo_title][movedo_empty_space height_multiplier="custom" height="12"][movedo_button align="center" button_text="Stay Connected" button_type="outline" button_color="white" button_hover_color="blue" button_shape="extra-round" button_link="url:%23|||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'landing-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/landing-03.jpg');
$data['custom_class'] = 'homepage iconbox';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-linegraph" icon_color="blue" title="Amazing Interface" heading="h5" animation="grve-zoom-in"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-trophy" icon_color="blue" title="High Rated Team" heading="h5" animation="grve-zoom-in" animation_delay="400"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-global" icon_color="blue" title="Translation Ready" heading="h5" animation="grve-zoom-in" animation_delay="600"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-layers" icon_color="blue" title="Header Manipulations" heading="h5" animation="grve-zoom-in" animation_delay="800"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_library="etlineicons" icon_color="blue" title="Responsive Typography" heading="h5" animation="grve-zoom-in" animation_delay="1000"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space][/vc_column][vc_column width="1/3" tablet_sm_width="1-2"][movedo_empty_space][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-lifesaver" icon_color="blue" title="Dedicated Support" heading="h5" animation="grve-zoom-in" animation_delay="1200"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'landing-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/landing-04.jpg');
$data['custom_class'] = 'homepage parallax';
$data['content'] = <<<CONTENT
[vc_row equal_column_height="middle-content" padding_bottom_multiplier="" mobile_equal_column_height="false" separator_bottom="curve-right-separator" separator_bottom_size="100%" separator_bottom_color="#f4f6fe"][vc_column width="5/12"][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-up" margin_bottom="0"]We DO MOVE[/movedo_title][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-up" animation_delay="400" margin_bottom="0"]Your World[/movedo_title][movedo_empty_space][movedo_quote animation="grve-fade-in-up" animation_delay="800"]It justifies its name by introducing motion dynamics in columns. Scroll or move your mouse and the whole world does move[/movedo_quote][/vc_column][vc_column column_effect="mouse-move-x" column_effect_sensitive="normal" column_effect_limit="3x" width="7/12"][movedo_single_image image_mode="portrait" image=""][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'landing-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/landing-05.jpg');
$data['custom_class'] = 'homepage counters';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image="" bg_image_type="parallax" bg_image_size="responsive" parallax_threshold="0.5" color_overlay="custom" color_overlay_custom="rgba(26,17,91,0.9)" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff"][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="328" counter_color="white" counter_heading="h1" title="Cups of Coffee" heading="link-text" align="center" animation="grve-fade-in-up"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="260" counter_color="white" counter_heading="h1" title="Pizzas Ordered" heading="link-text" align="center" animation="grve-fade-in-up" animation_delay="400"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="437" counter_color="white" counter_heading="h1" title="Working Hours" heading="link-text" align="center" animation="grve-fade-in-up" animation_delay="600"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="2674" counter_color="white" counter_heading="h1" title="Code Lines" heading="link-text" align="center" animation="grve-fade-in-up" animation_delay="800"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'landing-6';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Landing - Section 6', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/landing-06.jpg');
$data['custom_class'] = 'homepage pricing';
$data['content'] = <<<CONTENT
[vc_row bg_type="color" padding_top_multiplier="6x" separator_bottom="curve-left-separator" separator_bottom_size="120px" separator_bottom_color="#0e093c" bg_color="#f4f6fe"][vc_column column_effect="vertical-parallax" column_effect_limit="none" column_custom_position="yes" position_top="minus-6x" width="1/3" mobile_column_effect="none" mobile_column_positions="none"][movedo_pricing_table title="BASIC" description="For freelancers" price="19" heading="h1" increase_heading="200" interval="$ / Month" values="10|presentations month,Support at $25 Hour,1|campaign month" align="center" animation="grve-fade-in-up" button_text="Purchase now" button_type="underline" button_color="purple" button_line_color="grey" button_link="url:%23|||"][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" column_custom_position="yes" position_top="minus-4x" width="1/3" mobile_column_effect="none" mobile_column_positions="none"][movedo_pricing_table title="STANDARD" description="For medium sized teams" price="25" heading="h1" increase_heading="200" interval="$ / Month" values="10|presentations month,Support at $25 Hour,1|campaign month" align="center" animation="grve-fade-in-up" animation_delay="400" button_text="Purchase now" button_type="underline" button_color="purple" button_line_color="grey" button_link="url:%23|||"][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" column_custom_position="yes" position_top="minus-2x" width="1/3" mobile_column_effect="none" mobile_column_positions="none"][movedo_pricing_table title="ENTERPRISE" description="For large companies" price="74" heading="h1" increase_heading="200" interval="$ / Month" values="10|presentations month,Support at $25 Hour,1|campaign month" align="center" animation="grve-fade-in-up" animation_delay="600" button_text="Purchase now" button_type="underline" button_color="purple" button_line_color="grey" button_link="url:%23|||"][/vc_column][/vc_row][vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#0e093c"][vc_column][movedo_empty_space height_multiplier="3x"][movedo_title heading="link-text" align="center"]Become Unique Now[/movedo_title][movedo_title heading_tag="h2" heading="h1" align="center" margin_bottom="0"]At The Top of your[/movedo_title][movedo_title heading_tag="h2" heading="h1" align="center" margin_bottom="0"]lifetime investments[/movedo_title][movedo_empty_space][movedo_button align="center" button_text="Purchase Movedo" button_color="blue" button_hover_color="white" button_shape="extra-round" button_link="url:https%3A%2F%2Fthemeforest.net%2Fitem%2Fmovedo-we-do-move-your-world%2F17923709%3Fref%3Dgreatives||target:%20_blank|"][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'restaurant-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/restaurant-01.jpg');
$data['custom_class'] = 'homepage parallax typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" font_color="#ffffff" bg_color="#90908d"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_quote align="center"]Michelin star awarded Philip Lemaître is our new chef de cuisine.[/movedo_quote][/vc_column][vc_column width="1/4"][/vc_column][/vc_row][vc_row equal_column_height="middle-content" padding_top_multiplier="4x" padding_bottom_multiplier="4x"][vc_column width="1/3"][movedo_title heading_tag="h2" heading="h2" custom_font_family="custom-font-1"]Embracing the cultural
diversity of our metropolis[/movedo_title][vc_column_text]Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique. Te duo eripuit commune singulis, an suas utinam pro.[/vc_column_text][movedo_empty_space][movedo_icon_box icon_box_type="side-icon" icon_size="extra-small" icon_library="simplelineicons" icon_simplelineicons="smp-icon-arrow-down-circle" icon_color="grey" title="DISCOVER NEW TASTES" heading="h6" link="url:%23taste|||"][/movedo_icon_box][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="none" column_custom_position="yes" position_top="minus-6x" width="1/3" mobile_column_positions="none"][movedo_single_image image_mode="portrait" image=""][/vc_column][vc_column width="1/3"][movedo_single_image image_mode="portrait"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'restaurant-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/restaurant-02.jpg');
$data['custom_class'] = 'homepage parallax counters';
$data['content'] = <<<CONTENT
[vc_row bg_type="image" bg_image="" bg_image_type="parallax" bg_image_size="responsive" color_overlay="dark" opacity_overlay="60" padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/4"][/vc_column][vc_column width="1/2" heading_color="light" font_color="rgba(255,255,255,0.8)"][movedo_title heading_tag="h2" heading="h2" custom_font_family="custom-font-1" align="center"]The most delicious surf &amp; turf ever[/movedo_title][vc_column_text]
<p style="text-align: center;">Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique. Te duo eripuit commune singulis, an suas utinam pro.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column column_effect="mouse-move-x-y" column_custom_position="yes" position_left="3x" width="1/4" mobile_column_positions="none" el_wrapper_class="grve-drop-shadow" css=".vc_custom_1477993090009{background-color: #ffffff !important;border-radius: 5px !important;}"][movedo_empty_space height_multiplier="custom" height="45px"][movedo_counter counter_end_val="32" counter_color="black" counter_heading="h1" increase_counter_heading="140" title="YEARS OF EXPERIENCE" heading="link-text" custom_font_family="custom-font-1" align="center"][movedo_empty_space height_multiplier="custom" height="45px"][/vc_column][vc_column column_effect="mouse-move-x-y" column_effect_invert="true" column_custom_position="yes" position_top="1x" position_left="1x" width="1/4" mobile_column_positions="none" el_wrapper_class="grve-drop-shadow" css=".vc_custom_1477993096262{background-color: #ffffff !important;border-radius: 5px !important;}"][movedo_empty_space height_multiplier="custom" height="45px"][movedo_counter counter_end_val="60" counter_color="black" counter_heading="h1" increase_counter_heading="140" title="SPECIAL DISHES" heading="link-text" custom_font_family="custom-font-1" align="center"][movedo_empty_space height_multiplier="custom" height="45px"][/vc_column][vc_column column_effect="mouse-move-x-y" column_custom_position="yes" position_left="minus-1x" width="1/4" mobile_column_positions="none" el_wrapper_class="grve-drop-shadow" css=".vc_custom_1477993102697{background-color: #ffffff !important;border-radius: 5px !important;}"][movedo_empty_space height_multiplier="custom" height="45px"][movedo_counter counter_end_val="40" counter_color="black" counter_heading="h1" increase_counter_heading="140" title="Desserts" heading="link-text" custom_font_family="custom-font-1" align="center"][movedo_empty_space height_multiplier="custom" height="45px"][/vc_column][vc_column column_effect="mouse-move-x-y" column_effect_invert="true" column_custom_position="yes" position_top="1x" position_left="minus-3x" width="1/4" mobile_column_positions="none" el_wrapper_class="grve-drop-shadow" css=".vc_custom_1477993109585{background-color: #ffffff !important;border-radius: 5px !important;}"][movedo_empty_space height_multiplier="custom" height="45px"][movedo_counter counter_end_val="260" counter_color="black" counter_heading="h1" increase_counter_heading="140" title="SPECIAL WINES" heading="link-text" custom_font_family="custom-font-1" align="center"][movedo_empty_space height_multiplier="custom" height="45px"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'restaurant-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/restaurant-03.jpg');
$data['custom_class'] = 'homepage pricing';
$data['content'] = <<<CONTENT
[vc_row columns_gap="60" padding_top_multiplier="6x" padding_bottom_multiplier="6x" section_id="taste"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_title heading_tag="h2" heading="h2" custom_font_family="custom-font-1" align="center"]Reinventing innovation in the food industry[/movedo_title][vc_column_text]<p style="text-align: center;">Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique. Te duo eripuit commune singulis, an suas utinam pro.</p>[/vc_column_text][/vc_column][vc_column width="1/4"][/vc_column][vc_column][movedo_empty_space height_multiplier="3x"][/vc_column][vc_column width="1/2" font_color="#adadad"][vc_row_inner][vc_column_inner width="2/3"][movedo_title heading="h5" custom_font_family="custom-font-1" margin_bottom="12"]Roasted Sunchoke &amp; Celeriac[/movedo_title][vc_column_text]Beluga Lentils, Kabocha Squash, Quince.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h1" custom_font_family="custom-font-1" align="right"]$14.50[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_divider line_type="double-line" padding_top="30" padding_bottom="30"][vc_row_inner][vc_column_inner width="2/3"][movedo_title heading="h5" custom_font_family="custom-font-1" margin_bottom="12"]Early Fall Squash[/movedo_title][vc_column_text]Roasted Spaghetti Squash, Spiced Cashews, Ginger Mousse.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h1" custom_font_family="custom-font-1" align="right"]$16.00[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_divider line_type="double-line" padding_top="30" padding_bottom="30"][vc_row_inner][vc_column_inner width="2/3"][movedo_title heading="h5" custom_font_family="custom-font-1" margin_bottom="12"]Pear &amp; Parsnip[/movedo_title][vc_column_text]<p class="p1"><span class="s1">Pickled Asian Pear, Granola, Chanterelles.</span></p>[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h1" custom_font_family="custom-font-1" align="right"]$15.00[/movedo_title][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" font_color="#adadad"][vc_row_inner][vc_column_inner width="2/3"][movedo_title heading="h5" custom_font_family="custom-font-1" margin_bottom="12"]Pan-roasted Chicken[/movedo_title][vc_column_text]Warm Farro-Brussels Sprout Salad, Pine Nuts.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h1" custom_font_family="custom-font-1" align="right"]$23.50[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_divider line_type="double-line" padding_top="30" padding_bottom="30"][vc_row_inner][vc_column_inner width="2/3"][movedo_title heading="h5" custom_font_family="custom-font-1" margin_bottom="12"]Sweet Potato Doughnuts[/movedo_title][vc_column_text]Cranberry Fondant, Warm Macchiato with Milk Foam.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h1" custom_font_family="custom-font-1" align="right"]$12.50[/movedo_title][/vc_column_inner][/vc_row_inner][movedo_divider line_type="double-line" padding_top="30" padding_bottom="30"][vc_row_inner][vc_column_inner width="2/3"][movedo_title heading="h5" custom_font_family="custom-font-1" margin_bottom="12"]Roasted Sunchoke &amp; Celeriac[/movedo_title][vc_column_text]Beluga Lentils, Kabocha Squash, Quince.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][movedo_title heading="h1" custom_font_family="custom-font-1" align="right"]$16.50[/movedo_title][/vc_column_inner][/vc_row_inner][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column][movedo_button btn_fluid="yes" button_text="See our menu" button_color="black" button_hover_color="grey" button_shape="round" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'restaurant-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Restaurant - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/restaurant-04.jpg');
$data['custom_class'] = 'homepage split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" font_color="#676767" bg_color="#0e1115"][vc_column width="2/3"][movedo_gmap map_zoom="14" map_height="550"][/vc_column][vc_column width="1/3"][movedo_title heading="h2" custom_font_family="custom-font-1" align="center"]Visit our Restaurant[/movedo_title][vc_column_text]
<p style="text-align: center;">44 Oxford Street, London, UK 22004
Phone : +12 533 767 003
Email : gousti@gusti.eu[/vc_column_text][movedo_empty_space][movedo_button align="center" button_text="Book a table" button_type="outline" button_color="white" button_hover_color="white" button_shape="round" button_link="url:%23book-table|||" button_class="grve-modal-popup"][/vc_column][/vc_row][vc_row padding_top_multiplier="" padding_bottom_multiplier="" desktop_visibility="hide" tablet_visibility="hide" tablet_sm_visibility="hide" mobile_visibility="hide"][vc_column][movedo_modal modal_id="book-table"][vc_row_inner][vc_column_inner width="1/4"][/vc_column_inner][vc_column_inner width="1/2"][movedo_title heading="h1" custom_font_family="custom-font-1" align="center"]Book A Table[/movedo_title][vc_column_text text_style="leader-text"]<p style="text-align: center;">Congue appetere temporibus vix ex, eum quis nibh te. Ius essent meliore reprehendunt te. An sed eirmod tibique. Te duo eripuit commune singulis, an suas utinam pro.</p>[/vc_column_text][movedo_empty_space height_multiplier="2x"][contact-form-7 id="15461"][/vc_column_inner][vc_column_inner width="1/4"][/vc_column_inner][/vc_row_inner][/movedo_modal][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'barbershop-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Barbershop - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/barbershop-01.jpg');
$data['custom_class'] = 'homepage pricing split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" padding_top_multiplier="" padding_bottom_multiplier=""][vc_column width="1/2" css=".vc_custom_1477312900598{padding: 21% !important;}"][movedo_title heading_tag="h2" heading="h2"]Haircuts[/movedo_title][movedo_empty_space height_multiplier="custom" height="15"][vc_row_inner][vc_column_inner width="5/6"][vc_column_text]EASY TRIM[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][vc_column_text]<p style="text-align: right;">$12.50</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][movedo_divider line_type="dashed-line" padding_top="15" padding_bottom="15"][vc_row_inner][vc_column_inner width="5/6"][vc_column_text]FULL CUT[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][vc_column_text]<p style="text-align: right;">$23.50</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][movedo_divider line_type="dashed-line" padding_top="15" padding_bottom="15"][vc_row_inner][vc_column_inner width="5/6"][vc_column_text]SIDEBURN CUT[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][vc_column_text]<p style="text-align: right;">$10.50</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][movedo_divider line_type="dashed-line" padding_top="15" padding_bottom="15"][vc_row_inner][vc_column_inner width="5/6"][vc_column_text]MULLET CUT[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][vc_column_text]<p style="text-align: right;">$32.50</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][movedo_divider line_type="dashed-line" padding_top="15" padding_bottom="15"][vc_row_inner][vc_column_inner width="5/6"][vc_column_text]BALD SHAVE[/vc_column_text][/vc_column_inner][vc_column_inner width="1/6"][vc_column_text]<p style="text-align: right;">$42.50</p>[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" css=".vc_custom_1477312930391{background-image: url(https://images.unsplash.com/photo-1484291150605-0860ed671f04?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'barbershop-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'Barbershop - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/barbershop-02.jpg');
$data['custom_class'] = 'homepage parallax';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#000000"][vc_column][movedo_image_text image_mode="portrait" image="" layout="2" image_text_align="right" title="Licensed Barbers" heading="h2" content_align="right"]Over the last years I did a lot photos. A lot of these are not really valuable but that’s not the point. It’s more like freezing the moment for later. Today I do it more „professional“ compared to the early days. [/movedo_image_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-i-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us I - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-i-01.jpg');
$data['custom_class'] = 'page call-action';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image_type="horizontal-parallax-rl" bg_image_size="responsive" bg_image_vertical_position="top" color_overlay="primary-1" opacity_overlay="80" padding_top_multiplier="custom" padding_bottom_multiplier="custom" separator_bottom="tilt-right-separator" parallax_sensor="350" font_color="#ffffff" padding_top="15%" padding_bottom="15%"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title heading_tag="h1" heading="h1" increase_heading="200" custom_font_family="custom-font-1" align="center" animation="grve-fade-in"]It is our pleasure and privilege to present Movedo.[/movedo_title][/vc_column][vc_column width="1/6"][/vc_column][/vc_row][vc_row padding_top_multiplier="3x" padding_bottom_multiplier="3x"][vc_column column_custom_position="yes" position_top="minus-6x" width="1/2" mobile_column_positions="none" z_index="5"][vc_row_inner][vc_column_inner css=".vc_custom_1472570355501{padding-top: 28% !important;padding-bottom: 28% !important;background: #d8d8d8 url(https://images.unsplash.com/photo-1473193410341-9a0ef2464204?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;border-radius: 5px !important;}"][vc_column_text]
<h3 style="text-align: center;"><span style="color: #ffffff;">Jumpstart your business</span></h3>[/vc_column_text][movedo_empty_space height_multiplier="custom" height="18"][movedo_button align="center" button_text="Try it for free" button_hover_color="white" button_shape="extra-round"][/vc_column_inner][/vc_row_inner][movedo_empty_space][vc_column_text]<p class="p1" style="text-align: right;"><span class="s1">Delectus inimicus no mel. Et has prodesset reformidans, vim id decore quidam indoctum. Eum ea suas nullam inciderint, nec ludus causae offendit</span></p>[/vc_column_text][movedo_empty_space][movedo_icon_box icon_box_type="side-icon" icon_side_align="right" icon_size="small" icon_library="simplelineicons" icon_simplelineicons="smp-icon-people" title="Meet our team" heading="h6"][/movedo_icon_box][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="6x" width="1/2" tablet_portrait_column_effect="none" mobile_column_effect="none"][vc_row_inner][vc_column_inner css=".vc_custom_1472570359955{padding-top: 28% !important;padding-bottom: 28% !important;background-image: url(https://images.unsplash.com/photo-1473357237784-6e0cb4e70a67?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;border-radius: 5px !important;}"][vc_column_text]<h3 style="text-align: center;"><span style="color: #ffffff;">We plan your project</span></h3>[/vc_column_text][movedo_empty_space height_multiplier="custom" height="18"][movedo_button align="center" button_text="Purchase Movedo" button_hover_color="white" button_shape="extra-round"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-i-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us I - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-i-02.jpg');
$data['custom_class'] = 'page iconbox';
$data['content'] = <<<CONTENT
[vc_row bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" bg_color="#f8f8f8"][vc_column width="1/4"][/vc_column][vc_column width="1/2"][movedo_slogan title="Intelligible options" heading="h3" align="center" button_text="" button2_text=""]Accumsan fabellas mel te. Mei nisl sint te. Ea scaevola accusata appellantur nec, te decore molestie sit. Ad cum dicta senserit, vel in facilisi patrioque.[/movedo_slogan][movedo_empty_space][movedo_title heading="link-text" align="center"]Masterfully Handcrafted[/movedo_title][/vc_column][vc_column width="1/4"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column column_effect="mouse-move-x-y" width="1/3" el_wrapper_class="grve-drop-shadow" css=".vc_custom_1472571065696{padding-right: 30px !important;padding-left: 30px !important;background-color: #ffffff !important;border-radius: 5px !important;}"][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-linegraph" title="Amazing Interface" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column column_effect="mouse-move-x-y" column_effect_sensitive="normal" column_effect_limit="3x" width="1/3" css=".vc_custom_1472571244757{padding-right: 30px !important;padding-left: 30px !important;background-color: #ffffff !important;border-radius: 5px !important;}" el_wrapper_class="grve-drop-shadow" z_index="5"][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-trophy" title="High Rated Team" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column column_effect="mouse-move-x-y" width="1/3" css=".vc_custom_1472571051465{padding-right: 30px !important;padding-left: 30px !important;background-color: #ffffff !important;border-radius: 5px !important;}" el_wrapper_class="grve-drop-shadow"][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_library="etlineicons" icon_etlineicons="et-icon-lifesaver" title="Dedicated Support" heading="h5"]Stet solum ceteros ad pri, amet alia scripta qui ea. Cum an aeterno efficiantur. Sit nihil detracto et, ut tota aeterno suscipiantur pri.[/movedo_icon_box][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column][movedo_empty_space height_multiplier="2x"][/vc_column][vc_column][movedo_button align="center" button_text="Checkout our features" button_shape="extra-round" button_link="url:%23|||"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-ii-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-ii-01.jpg');
$data['custom_class'] = 'page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_full_height="fullheight" bg_type="image" bg_image_type="horizontal-parallax-lr" bg_image_size="responsive" parallax_threshold="0.1" color_overlay="dark" opacity_overlay="10" font_color="#ffffff"][vc_column column_effect="mouse-move-x-y" column_effect_invert="true" width="1/2"][movedo_title heading_tag="h1" heading="h1" increase_heading="300" animation="grve-fade-in-left" margin_bottom="0"]User is[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="300" animation="grve-fade-in-left" animation_delay="400"]Our priority[/movedo_title][vc_column_text text_style="leader-text" animation="grve-fade-in-up" animation_delay="600"]Quo dolorum utroque in, zril saperet pro ex. Sit lorem labitur integre iuvaret accusam. Imperdiet dissentiet eam at, alia aeterno cu duo.[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_size="small" icon_library="simplelineicons" icon_simplelineicons="smp-icon-arrow-right-circle" icon_color="white" icon_shape="circle" icon_shape_color="primary-1" title="Become a member" heading="h5" animation="grve-fade-in-up" animation_delay="1000"][/movedo_icon_box][/vc_column][vc_column width="1/2"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-ii-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-ii-02.jpg');
$data['custom_class'] = 'page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="5x" padding_bottom_multiplier="5x" tablet_portrait_equal_column_height="false" mobile_equal_column_height="false" font_color="rgba(255,255,255,0.6)" bg_color="#1c1f21"][vc_column width="1/3"][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-up" margin_bottom="0"]We create[/movedo_title][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-up" animation_delay="400"]with Users in mind[/movedo_title][vc_column_text animation="grve-fade-in-up" animation_delay="600"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus complectitur.[/vc_column_text][movedo_empty_space][vc_column_text animation="grve-fade-in-up" animation_delay="800"]Omnis labores ullamcorper cu ius, ad justo suscipiantur conclu daturque his, assum nemore ocurreret ne quo. Ut usu maior um suavitate. Platonem tractatos id sit. Duo duis ceteros dignissim cu, etiam perpetua pro id.[/vc_column_text][movedo_empty_space][movedo_button animation="grve-fade-in-up" animation_delay="1000" button_text="Checkout our work" button_hover_color="white" button_shape="extra-round" button_link="url:http%3A%2F%2Fgreatives.eu%2Fthemes%2Fmovedo%2Fportfolio-masonry-sticked%2F|||"][/vc_column][vc_column width="2/3"][vc_row_inner][vc_column_inner width="1/2"][movedo_single_image image_type="image-popup" image_mode="landscape"][movedo_empty_space][movedo_single_image image_type="image-popup" image_mode="landscape"][/vc_column_inner][vc_column_inner width="1/2"][movedo_single_image image_type="image-popup" image_mode="landscape"][movedo_empty_space][movedo_single_image image_type="image-popup" image_mode="landscape"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-ii-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-ii-03.jpg');
$data['custom_class'] = 'page split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" padding_top_multiplier="" padding_bottom_multiplier=""][vc_column width="1/2" css=".vc_custom_1472576134985{background-image: url(https://images.unsplash.com/photo-1461701204332-2aa3db5b20c8?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column column_effect="mouse-move-x-y" column_effect_limit="2x" column_effect_invert="true" width="1/2" css=".vc_custom_1472576212808{padding-top: 27% !important;padding-right: 19% !important;padding-bottom: 27% !important;padding-left: 19% !important;}"][movedo_title heading_tag="h2" heading="h1" animation="grve-fade-in-right"]<span class="grve-text-primary-1">01. </span>Design &amp; Development[/movedo_title][movedo_title heading="h6" animation="grve-fade-in-right" animation_delay="400"]Ei tritani definitionem nec, eu mel utroque adversarium[/movedo_title][vc_column_text animation="grve-fade-in-right" animation_delay="600"]Usu eirmod invidunt id, sit probo partem voluptaria ei. Prima deserunt id mea. Et vocent animal his. Vis ea eruditi efficiantur, cum in sapientem consequat. Accumsan fabellas mel te. Mei nisl sint te. Ea scaevola accusata appellantur nec, te decore molestie sit. Ad cum dicta senserit, vel in facilisi patrioque, cu legere equidem phaedrum.[/vc_column_text][movedo_divider line_type="custom-line" line_width="100" line_height="5" animation="grve-fade-in-right" animation_delay="800" padding_top="30"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-ii-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-ii-04.jpg');
$data['custom_class'] = 'page typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="color" padding_top_multiplier="5x" padding_bottom_multiplier="5x" bg_color="#1c1f21" font_color="#ffffff"][vc_column column_effect="vertical-parallax" column_effect_limit="3x" column_effect_invert="true"][movedo_title heading="h1" increase_heading="140" custom_font_family="custom-font-1" align="center"]The Movedo Generation of multi-purpose themes is here. In a marketplace volatile you need to build confident themes.[/movedo_title][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-ii-5';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 5', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-ii-05.jpg');
$data['custom_class'] = 'page';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="4x" padding_bottom_multiplier="4x"][vc_column][movedo_team image_size="portrait" image="" team_layout="layout-2" name="John Smith" heading="h5" identity="DESIGNER" overlay_opacity="0" social_facebook="#" social_twitter="#" social_linkedin="#"]Eum te offendit vulputate quaerendum, malorum verterem dispu tando id mei. Vis facete consequuntur id, ne his iuvaret ornatus, usu reque tincidunt philosophia.[/movedo_team][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-iii-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-iii-01.jpg');
$data['custom_class'] = 'page split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" tablet_portrait_equal_column_height="false" mobile_equal_column_height="false" font_color="#ffffff" bg_color="#1c1f21"][vc_column width="1/2" column_fullheight="fullheight" tablet_sm_width="1" css=".vc_custom_1472732601943{background-image: url(https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" tablet_sm_width="1" css=".vc_custom_1472732650026{padding-right: 20% !important;padding-left: 20% !important;}"][movedo_empty_space height_multiplier="6x"][movedo_title heading_tag="h1" heading="h1" increase_heading="200" custom_font_family="custom-font-1" animation="grve-fade-in-up" margin_bottom="0"]We move your world[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="200" custom_font_family="custom-font-1" animation="grve-fade-in-up" animation_delay="600"]You rock theirs.[/movedo_title][vc_column_text text_style="leader-text" animation="grve-fade-in-up" animation_delay="800"]The Movedo Generation of multi-purpose themes is here. In a marketplace volatile you need to build confident themes.[/vc_column_text][movedo_empty_space][movedo_icon_box icon_box_type="side-icon" icon_size="large" icon_library="simplelineicons" icon_simplelineicons="smp-icon-control-play" title="CHECK OUT OUR TRAILER" heading="h6" link="url:%23|||" animation="grve-fade-in-up" animation_delay="1200"][/movedo_icon_box][movedo_empty_space height_multiplier="6x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-iii-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-iii-02.jpg');
$data['custom_class'] = 'page iconbox';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" columns_gap="60" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" font_color="#ffffff" bg_color="#0652fd"][vc_column width="1/3"][movedo_icon_box icon_top_align="left" icon_size="large" icon_library="etlineicons" icon_etlineicons="et-icon-tools" icon_color="white" title="Flexibility" heading="h5"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus complectitur cu. Mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][vc_column width="1/3"][movedo_icon_box icon_top_align="left" icon_size="large" icon_library="etlineicons" icon_etlineicons="et-icon-lightbulb" icon_color="white" title="Code Quality" heading="h5"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus complectitur cu. Mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][vc_column width="1/3"][movedo_icon_box icon_top_align="left" icon_size="large" icon_library="etlineicons" icon_etlineicons="et-icon-speedometer" icon_color="white" title="Customizability" heading="h5"]Graeci vivendum senserit te sit, sit cu diam iusto putant. Duo doctus erroribus complectitur cu. Mucius aliquam aliquando no usu, eum singulis invenire consetetur.[/movedo_icon_box][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-iii-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-iii-03.jpg');
$data['custom_class'] = 'page parallax';
$data['content'] = <<<CONTENT
[vc_row equal_column_height="middle-content" padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/3"][movedo_single_image image_mode="landscape"][movedo_empty_space][movedo_title heading="h6" align="right"]At The Top of your lifetime investments[/movedo_title][/vc_column][vc_column width="1/3"][movedo_single_image image_mode="portrait"][/vc_column][vc_column column_effect="vertical-parallax" column_effect_limit="4x" column_effect_invert="true" column_custom_position="yes" position_left="minus-3x" width="1/3"][movedo_slogan title="Introducing Motion Dynamics" heading="h1" button_text="Checkout our Features" button_color="primary-3" button_shape="extra-round" button_link="url:%23|||" button2_text=""]Vis te natum erroribus, his in magna vocent lucilius. Expetendis instructior qui eu. Ex cum brute aeterno euismod, mucius suscipiantur has ad. Prima suavitate per an. Modo ullum id sit, utinamae periculis comprehensam, eu his euripidis referrentur.[/movedo_slogan][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-us-iii-4';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Us II - Section 4', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-us-iii-04.jpg');
$data['custom_class'] = 'page parallax typography';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" bg_type="image" bg_image_type="parallax" bg_image_size="responsive" color_overlay="dark" opacity_overlay="80" padding_top_multiplier="6x" padding_bottom_multiplier="6x" parallax_sensor="550" font_color="#ffffff"][vc_column width="1/6"][/vc_column][vc_column width="2/3"][movedo_title heading="h6" line_type="line" align="center"]WHO WE ARE[/movedo_title][movedo_title heading="h1" increase_heading="120" custom_font_family="custom-font-1" align="center" animation="grve-zoom-in"]A fusion of talents developed by a Web Designer, a Coder, an Informatics Teacher and a Communications Specialist.[/movedo_title][/vc_column][vc_column width="1/6"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-i-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me I - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-i-01.jpg');
$data['custom_class'] = 'page';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_full_height="fullheight" bg_type="image" bg_image_size="responsive" color_overlay="dark" opacity_overlay="60" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff"][vc_column width="1/3"][movedo_title heading_tag="h1" heading="h1" increase_heading="300" animation="grve-fade-in-up"]Alex Martin[/movedo_title][movedo_title heading_tag="h2" heading="h2" animation="grve-fade-in-up" animation_delay="400"]Im a freelancer designer[/movedo_title][vc_column_text text_style="leader-text" animation="grve-fade-in-up" animation_delay="600"]<p class="p1"><span class="s1">In fabulas repudiare mea, apeirian persecuti pro ei, no meis invidunt contentiones eos. At munere putant mei, est no rebum doctus consulatu. Sint fabulas explicari ad vis, nostro malorum.</span></p>[/vc_column_text][movedo_empty_space height_multiplier="2x"][movedo_icon_box icon_box_type="side-icon" icon_size="extra-small" icon_library="simplelineicons" icon_simplelineicons="smp-icon-location-pin" icon_color="white" title="New York, NY 10013" heading="h6" animation="grve-fade-in-up" animation_delay="800"][/movedo_icon_box][movedo_empty_space height_multiplier="custom" height="15"][movedo_icon_box icon_box_type="side-icon" icon_size="extra-small" icon_library="simplelineicons" icon_simplelineicons="smp-icon-earphones-alt" icon_color="white" title="+51 32 231 11 11" heading="h6" animation="grve-fade-in-up" animation_delay="1000"][/movedo_icon_box][movedo_empty_space height_multiplier="custom" height="15"][movedo_icon_box icon_box_type="side-icon" icon_size="extra-small" icon_library="simplelineicons" icon_simplelineicons="smp-icon-bubbles" icon_color="white" title="alexmartin@greatives.eu" heading="h6" animation="grve-fade-in-up" animation_delay="1200"][/movedo_icon_box][/vc_column][vc_column width="1/3"][/vc_column][vc_column width="1/3"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-ii-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me II - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-ii-01.jpg');
$data['custom_class'] = 'page steps';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/3"][movedo_title heading_tag="h2" heading="h1" increase_heading="200" custom_font_family="custom-font-3"]<span style="color: #15c7ff;">01</span>[/movedo_title][movedo_title heading="h5"]SHARING EXCELLENCE[/movedo_title][vc_column_text text_style="leader-text"]After a trustworthy and everlasting interaction with you, we bring Movedo![/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading_tag="h2" heading="h1" increase_heading="200" custom_font_family="custom-font-3"]<span style="color: #15c7ff;">02</span>[/movedo_title][movedo_title heading="h5"]DESIGN SOLUTIONS[/movedo_title][vc_column_text text_style="leader-text"]All our products are future proof. Your websites will always look razor-sharp.[/vc_column_text][/vc_column][vc_column width="1/3"][movedo_title heading_tag="h2" heading="h1" increase_heading="200" custom_font_family="custom-font-3"]<span style="color: #15c7ff;">03</span>[/movedo_title][movedo_title heading="h5"]ELITE AUTHOR[/movedo_title][vc_column_text text_style="leader-text"]Greatives endeavor to thorough research for building stylish &amp; topic-related templates.[/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-ii-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me II - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-ii-02.jpg');
$data['custom_class'] = 'page counters';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" bg_type="color" padding_top_multiplier="4x" padding_bottom_multiplier="4x" font_color="#ffffff" bg_color="#15c7ff"][vc_column width="1/4"][movedo_counter counter_end_val="328" counter_color="white" counter_heading="h1" increase_counter_heading="140" title="Cups of Coffee" heading="link-text" custom_font_family="custom-font-3" align="center" animation="grve-fade-in-up"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="108" counter_color="white" counter_heading="h1" increase_counter_heading="140" title="Pizzas Ordered" heading="link-text" custom_font_family="custom-font-3" align="center" animation="grve-fade-in-up" animation_delay="400"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="258" counter_color="white" counter_heading="h1" increase_counter_heading="140" title="Working Hours" heading="link-text" custom_font_family="custom-font-3" align="center" animation="grve-fade-in-up" animation_delay="600"][/vc_column][vc_column width="1/4"][movedo_counter counter_end_val="4750" counter_color="white" counter_heading="h1" increase_counter_heading="140" title="Code Lines" heading="link-text" custom_font_family="custom-font-3" align="center" animation="grve-fade-in-up" animation_delay="800"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-ii-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me II - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-ii-03.jpg');
$data['custom_class'] = 'page split';
$data['content'] = <<<CONTENT
[vc_row section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier=""][vc_column width="1/2" css=".vc_custom_1476079894262{background-image: url(https://images.unsplash.com/photo-1484061332158-4f5335f3c503?w=1024) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][/vc_column][vc_column width="1/2" css=".vc_custom_1476079988628{padding-top: 20% !important;padding-right: 25% !important;padding-bottom: 20% !important;padding-left: 25% !important;}"][movedo_empty_space height_multiplier="3x"][movedo_title heading="link-text" margin_bottom="6"]<span class="grve-text-blue">MOVEDO TEAM</span>[/movedo_title][movedo_title]DECENT SUCCESS[/movedo_title][vc_column_text]Consul corpora interesset ei cum. Audiam tacimates cotidieque no has, ius iisque neglegentur eu. Est quas habemus imperdiet an, duis dictas perfecto sea ei. Nominati expetenda adversarium in ius, suscipit scaevola eu mea, has ei porro pertinacia. Quo libris oblique at, dolorum nominavi et vix.[/vc_column_text][movedo_empty_space][movedo_progress_bar bar_style="style-2" values="90|Development,80|Design,70|Marketing" color="blue" bar_height="3"][movedo_empty_space height_multiplier="3x"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-iii-1';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me III - Section 1', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-iii-01.jpg');
$data['custom_class'] = 'page split';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" section_type="fullwidth" columns_gap="none" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="" padding_bottom_multiplier="" bg_color="#1c1f21"][vc_column width="1/2"][movedo_title heading="link-text" align="center" margin_bottom="6"]<span style="color: #15c7ff;">FREELANCER / DESIGNER</span>[/movedo_title][movedo_title heading_tag="h1" heading="h1" increase_heading="140" align="center"]I'm Alex Smith[/movedo_title][vc_column_text text_style="leader-text"]<p style="text-align: center;">I create clean, fast and smooth themes</p>[/vc_column_text][/vc_column][vc_column width="1/2"][movedo_single_image image_mode="large" image_full_column="yes"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-iii-2';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me III - Section 2', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-iii-02.jpg');
$data['custom_class'] = 'page typography';
$data['content'] = <<<CONTENT
[vc_row padding_top_multiplier="6x" padding_bottom_multiplier="6x"][vc_column width="1/2"][movedo_title heading="h1" increase_heading="120" custom_font_family="custom-font-1" align="right"]All our products are future proof. Your websites will always look razor-sharp.[/movedo_title][movedo_empty_space][movedo_social_links icon_size="small" icon_color="blue" align="right" twitter_url="#" facebook_url="#" pinterest_url="#"][/vc_column][vc_column width="1/2"][vc_column_text]<strong>Ac consequat pulvinar at nunc rutrum</strong>, efficitur luctus erat, hendrerit mi Praesent in. Morbi gravida Morbi lacinia magna maximus consectetur rhoncus semper. Ligula. Volutpat, congue ornare conubia tincidunt massa augue turpis laoreet, arcu lobortis risus. Elit. Velit aliquet Proin egestas, ornare. Donec laoreet, accumsan tempus amet.[/vc_column_text][movedo_empty_space][vc_column_text]Lorem ipsum neque malesuada sed Cras bibendum nibh placerat ac lacinia In arcu vitae nisi. A Proin Cras nec volutpat litora eu Suspendisse In odio Nunc nibh. Aliquet turpis Fusce sociosqu porttitor elit. Morbi Vestibulum rutrum, nostra, urna viverra. Ullamcorper. Sapien Proin leo, Quisque condimentum laoreet, Nunc vitae eu neque quam. [/vc_column_text][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


$data = array();
$data['unique_id'] = $data['id'] = 'about-me-iii-3';
$data['type'] = 'movedo_templates';
$data['name'] = esc_html__( 'About Me III - Section 3', 'movedo-extension' );
$data['image_path'] = preg_replace( '/\s/', '%20', MOVEDO_EXT_PLUGIN_DIR_URL . 'movedo-templates/images/about-me-iii-03.jpg');
$data['custom_class'] = 'page counters';
$data['content'] = <<<CONTENT
[vc_row heading_color="light" equal_column_height="middle-content" bg_type="color" padding_top_multiplier="6x" padding_bottom_multiplier="6x" font_color="#ffffff" bg_color="#000000"][vc_column width="1/4"][movedo_slogan title="My Skills" button_text="" button2_text=""]Quisque condimentum laoreet[/movedo_slogan][/vc_column][vc_column width="1/4" css=".vc_custom_1476082933565{border-left-width: 1px !important;border-left-color: rgba(255,255,255,0.3) !important;border-left-style: solid !important;}"][movedo_counter counter_suffix="%" counter_color="blue" counter_heading="h1" title="Customer Support" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_suffix="%" counter_color="blue" counter_heading="h1" title="Branding Design" heading="link-text" align="center"][/vc_column][vc_column width="1/4"][movedo_counter counter_suffix="%" counter_color="blue" counter_heading="h1" title="Customer Support" heading="link-text" align="center"][/vc_column][/vc_row]
CONTENT;
$templates[] = $data;


		return $templates;
	}
}

$movedo_vc_templates = new Movedo_Vc_Templates();
$movedo_vc_templates->init();
