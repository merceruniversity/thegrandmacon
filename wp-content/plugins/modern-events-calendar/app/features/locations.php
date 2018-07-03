<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC locations class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_locations extends MEC_base
{
    public $factory;
    public $main;
    public $settings;

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Factory
        $this->factory = $this->getFactory();
        
        // Import MEC Main
        $this->main = $this->getMain();
        
        // MEC Settings
        $this->settings = $this->main->get_settings();
    }
    
    /**
     * Initialize locations feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        $this->factory->action('init', array($this, 'register_taxonomy'), 20);
        $this->factory->action('mec_location_edit_form_fields', array($this, 'edit_form'));
        $this->factory->action('mec_location_add_form_fields', array($this, 'add_form'));
        $this->factory->action('edited_mec_location', array($this, 'save_metadata'));
        $this->factory->action('created_mec_location', array($this, 'save_metadata'));
        
        $this->factory->action('mec_metabox_details', array($this, 'meta_box_location'), 30);
        if(!isset($this->settings['fes_section_location']) or (isset($this->settings['fes_section_location']) and $this->settings['fes_section_location'])) $this->factory->action('mec_fes_metabox_details', array($this, 'meta_box_location'), 30);
        
        $this->factory->filter('manage_edit-mec_location_columns', array($this, 'filter_columns'));
        $this->factory->filter('manage_mec_location_custom_column', array($this, 'filter_columns_content'), 10, 3);
        
        $this->factory->action('save_post', array($this, 'save_event'), 1);
    }
    
    /**
     * Registers location taxonomy
     * @author Webnus <info@webnus.biz>
     */
    public function register_taxonomy()
    {
        $singular_label = $this->main->m('taxonomy_location', __('Location', 'mec'));
        $plural_label = $this->main->m('taxonomy_locations', __('Locations', 'mec'));

        register_taxonomy(
            'mec_location',
            $this->main->get_main_post_type(),
            array(
                'label'=>$plural_label,
                'labels'=>array(
                    'name'=>$plural_label,
                    'singular_name'=>$singular_label,
                    'all_items'=>sprintf(__('All %s', 'mec'), $plural_label),
                    'edit_item'=>sprintf(__('Edit %s', 'mec'), $singular_label),
                    'view_item'=>sprintf(__('View %s', 'mec'), $singular_label),
                    'update_item'=>sprintf(__('Update %s', 'mec'), $singular_label),
                    'add_new_item'=>sprintf(__('Add New %s', 'mec'), $singular_label),
                    'new_item_name'=>sprintf(__('New %s Name', 'mec'), $singular_label),
                    'popular_items'=>sprintf(__('Popular %s', 'mec'), $plural_label),
                    'search_items'=>sprintf(__('Search %s', 'mec'), $plural_label),
                ),
                'rewrite'=>array('slug'=>'events-location'),
                'public'=>false,
                'show_ui'=>true,
                'hierarchical'=>false,
            )
        );
        
        register_taxonomy_for_object_type('mec_location', $this->main->get_main_post_type());
    }
    
    /**
     * Show edit form of location taxonomy
     * @author Webnus <info@webnus.biz>
     * @param object $term
     */
    public function edit_form($term)
    {
        $this->main->load_map_assets();

        $address = get_metadata('term', $term->term_id, 'address', true);
        $latitude = get_metadata('term', $term->term_id, 'latitude', true);
        $longitude = get_metadata('term', $term->term_id, 'longitude', true);
        $thumbnail = get_metadata('term', $term->term_id, 'thumbnail', true);
    ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_address"><?php _e('Address', 'mec'); ?></label>
            </th>
            <td>
                <input class="mec-has-tip" type="text" placeholder="<?php esc_attr_e('Enter the location address', 'mec'); ?>" name="address" id="mec_address" value="<?php echo $address; ?>" />
                <script type="text/javascript">
                jQuery(document).ready(function()
                {
                    if(typeof google !== 'undefined')
                    {
                        new google.maps.places.Autocomplete(document.getElementById('mec_address'));
                    }
                });
                </script>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_latitude"><?php _e('Latitude', 'mec'); ?></label>
            </th>
            <td>
                <input class="mec-has-tip" type="text" placeholder="<?php esc_attr_e('Geo latitude (Optional)', 'mec'); ?>" name="latitude" id="mec_latitude" value="<?php echo $latitude; ?>" />
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_longitude"><?php _e('Longitude', 'mec'); ?></label>
            </th>
            <td>
                <input class="mec-has-tip" type="text" placeholder="<?php esc_attr_e('Geo longitude (Optional)', 'mec'); ?>" name="longitude" id="mec_longitude" value="<?php echo $longitude; ?>" />
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="mec_thumbnail_button"><?php _e('Thumbnail', 'mec'); ?></label>
            </th>
            <td>
                <div id="mec_thumbnail_img"><?php if(trim($thumbnail) != '') echo '<img src="'.$thumbnail.'" />'; ?></div>
                <input type="hidden" name="thumbnail" id="mec_thumbnail" value="<?php echo $thumbnail; ?>" />
                <button type="button" class="mec_upload_image_button button" id="mec_thumbnail_button"><?php echo __('Upload/Add image', 'mec'); ?></button>
                <button type="button" class="mec_remove_image_button button <?php echo (!trim($thumbnail) ? 'mec-util-hidden' : ''); ?>"><?php echo __('Remove image', 'mec'); ?></button>
            </td>
        </tr>
    <?php
    }
    
    /**
     * Show add form of organizer taxonomy
     * @author Webnus <info@webnus.biz>
     */
    public function add_form()
    {
        $this->main->load_map_assets();
    ?>
        <div class="form-field">
            <label for="mec_address"><?php _e('Address', 'mec'); ?></label>
            <input type="text" name="address"  placeholder="<?php esc_attr_e('Enter the location address', 'mec'); ?>" id="mec_address" value="" />
            <script type="text/javascript">
            jQuery(document).ready(function()
            {
                if(typeof google !== 'undefined')
                {
                    new google.maps.places.Autocomplete(document.getElementById('mec_address'));
                }
            });
            </script>
        </div>
        <div class="form-field">
            <label for="mec_latitude"><?php _e('Latitude', 'mec'); ?></label>
            <input type="text" name="latitude"  placeholder="<?php esc_attr_e('Geo latitude (Optional)', 'mec'); ?>" id="mec_latitude" value="" />
        </div>
        <div class="form-field">
            <label for="mec_longitude"><?php _e('Longitude', 'mec'); ?></label>
            <input type="text" name="longitude"  placeholder="<?php esc_attr_e('Geo longitude (Optional)', 'mec'); ?>" id="mec_longitude" value="" />
        </div>
        <div class="form-field">
            <label for="mec_thumbnail_button"><?php _e('Thumbnail', 'mec'); ?></label>
            <div id="mec_thumbnail_img"></div>
            <input type="hidden" name="thumbnail" id="mec_thumbnail" value="" />
            <button type="button" class="mec_upload_image_button button" id="mec_thumbnail_button"><?php echo __('Upload/Add image', 'mec'); ?></button>
            <button type="button" class="mec_remove_image_button button mec-util-hidden"><?php echo __('Remove image', 'mec'); ?></button>
        </div>
    <?php
    }
    
    /**
     * Save meta data of location taxonomy
     * @author Webnus <info@webnus.biz>
     * @param int $term_id
     */
    public function save_metadata($term_id)
    {
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '0';
        $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '0';
        $thumbnail = isset($_POST['thumbnail']) ? $_POST['thumbnail'] : '';

        // Geo Point is Empty or Address Changed
        if(!trim($latitude) or !trim($longitude) or ($address != get_term_meta($term_id, 'address', true)))
        {
            $geo_point = $this->main->get_lat_lng($address);
            
            $latitude = $geo_point[0];
            $longitude = $geo_point[1];
        }
        
        update_term_meta($term_id, 'address', $address);
        update_term_meta($term_id, 'latitude', $latitude);
        update_term_meta($term_id, 'longitude', $longitude);
        update_term_meta($term_id, 'thumbnail', $thumbnail);
    }
    
    /**
     * Filter columns of location taxonomy
     * @author Webnus <info@webnus.biz>
     * @param array $columns
     * @return array
     */
    public function filter_columns($columns)
    {
        unset($columns['name']);
        unset($columns['slug']);
        unset($columns['description']);
        unset($columns['posts']);
        
        $columns['id'] = __('ID', 'mec');
        $columns['name'] = __('Location', 'mec');
        $columns['address'] = __('Address', 'mec');
        $columns['posts'] = __('Count', 'mec');
        $columns['slug'] = __('Slug', 'mec');

        return $columns;
    }
    
    /**
     * Filter content of location taxonomy columns
     * @author Webnus <info@webnus.biz>
     * @param string $content
     * @param string $column_name
     * @param int $term_id
     * @return string
     */
    public function filter_columns_content($content, $column_name, $term_id)
    {
        switch($column_name)
        {
            case 'id':
                
                $content = $term_id;
                break;

            case 'address':
                
                $content = get_metadata('term', $term_id, 'address', true);
                break;

            default:
                break;
        }

        return $content;
    }
    
    /**
     * Show location meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_location($post)
    {
        $settings = $this->main->get_settings();
        $this->main->load_map_assets();

        $locations = get_terms('mec_location', array('orderby'=>'name', 'hide_empty'=>'0'));
        $location_id = get_post_meta($post->ID, 'mec_location_id', true);
        $dont_show_map = get_post_meta($post->ID, 'mec_dont_show_map', true);
    ?>
        <div class="mec-meta-box-fields" id="mec-location">
            <h4><?php echo sprintf(__('Event %s', 'mec'), $this->main->m('taxonomy_location', __('Location', 'mec'))); ?></h4>
			<div class="mec-form-row">
				<select name="mec[location_id]" id="mec_location_id" title="<?php echo esc_attr__($this->main->m('taxonomy_location', __('Location', 'mec')), 'mec'); ?>">
                    <option value="1"><?php _e('Hide location', 'mec'); ?></option>
                    <option value="0"><?php _e('Insert a new location', 'mec'); ?></option>
					<?php foreach($locations as $location): ?>
					<option <?php if($location_id == $location->term_id) echo 'selected="selected"'; ?> value="<?php echo $location->term_id; ?>"><?php echo $location->name; ?></option>
					<?php endforeach; ?>
				</select>
				<a class="mec-tooltip" title="<?php esc_attr_e('Choose one of saved locations or insert new one below.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
			</div>
			<div id="mec_location_new_container">
				<div class="mec-form-row">
					<input type="text" name="mec[location][name]" id="mec_location_name" value="" placeholder="<?php _e('Location Name', 'mec'); ?>" />
					<p class="description"><?php _e('eg. City Hall', 'mec'); ?></p>
				</div>
				<div class="mec-form-row">
					<input type="text" name="mec[location][address]" id="mec_location_address" value="" placeholder="<?php _e('Event Location', 'mec'); ?>" />
					<p class="description"><?php _e('eg. City hall, Manhattan, New York', 'mec'); ?></p>
                    <?php if(isset($settings['google_maps_api_key']) and trim($settings['google_maps_api_key'])): ?>
                    <script type="text/javascript">
                    jQuery(document).ready(function()
                    {
                        if(typeof google !== 'undefined')
                        {
                            new google.maps.places.Autocomplete(document.getElementById('mec_location_address'));
                        }
                    });
                    </script>
                    <?php endif; ?>
				</div>
				<div class="mec-form-row mec-lat-lng-row">
					<input class="mec-has-tip" type="text" name="mec[location][latitude]" id="mec_location_latitude" value="" placeholder="<?php _e('Latitude', 'mec'); ?>" />
					<input class="mec-has-tip" type="text" name="mec[location][longitude]" id="mec_location_longitude" value="" placeholder="<?php _e('Longitude', 'mec'); ?>" />
					<a class="mec-tooltip" title="<?php esc_attr_e('If you leave the latitude and longitude empty, Modern Events Calendar tries to convert the location address to geopoint.', 'mec'); ?>"><i title="" class="dashicons-before dashicons-editor-help"></i></a>
				</div>
                <?php /* Don't show this section in FES */ if(is_admin()): ?>
				<div class="mec-form-row mec-thumbnail-row">
					<div id="mec_location_thumbnail_img"></div>
					<input type="hidden" name="mec[location][thumbnail]" id="mec_location_thumbnail" value="" />
					<button type="button" class="mec_location_upload_image_button button" id="mec_location_thumbnail_button"><?php echo __('Choose image', 'mec'); ?></button>
					<button type="button" class="mec_location_remove_image_button button mec-util-hidden"><?php echo __('Remove image', 'mec'); ?></button>
				</div>
                <?php else: ?>
                <div class="mec-form-row mec-thumbnail-row">
                    <span id="mec_fes_location_thumbnail_img"></span>
					<input type="hidden" name="mec[location][thumbnail]" id="mec_fes_location_thumbnail" value="" />
					<input type="file" id="mec_fes_location_thumbnail_file" onchange="mec_fes_upload_location_thumbnail();" />
                    <span class="mec_fes_location_remove_image_button button mec-util-hidden" id="mec_fes_location_remove_image_button"><?php echo __('Remove image', 'mec'); ?></span>
				</div>
                <?php endif; ?>
			</div>
            <div class="mec-form-row">
                <input type="hidden" name="mec[dont_show_map]" value="0" />
                <input type="checkbox" id="mec_location_dont_show_map" name="mec[dont_show_map]" value="1" <?php echo ($dont_show_map ? 'checked="checked"' : ''); ?> /><label for="mec_location_dont_show_map"><?php echo __("Don't show map in single event page", 'mec'); ?></label>
            </div>
		</div>
    <?php
    }
    
    /**
     * Save event location data
     * @author Webnus <info@webnus.biz>
     * @param int $post_id
     * @return boolean
     */
    public function save_event($post_id)
    {
        // Check if our nonce is set.
        if(!isset($_POST['mec_event_nonce'])) return false;

        // Verify that the nonce is valid.
        if(!wp_verify_nonce($_POST['mec_event_nonce'], 'mec_event_data')) return false;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) return false;

        // Get Modern Events Calendar Data
        $_mec = isset($_POST['mec']) ? $_POST['mec'] : array();
        
        // Selected a saved location
        if(isset($_mec['location_id']) and $_mec['location_id'])
        {
            // Set term to the post
            wp_set_object_terms($post_id, (int) $_mec['location_id'], 'mec_location');
        
            return true;
        }
        
        $address = (isset($_mec['location']['address']) and trim($_mec['location']['address'])) ? $_mec['location']['address'] : '';
        $name = (isset($_mec['location']['name']) and trim($_mec['location']['name'])) ? $_mec['location']['name'] : (trim($address) ? $address : 'Location Name');
        
        $term = get_term_by('name', $name, 'mec_location');
        
        // Term already exists
        if(is_object($term) and isset($term->term_id))
        {
            // Set term to the post
            wp_set_object_terms($post_id, (int) $term->term_id, 'mec_location');
            
            return true;
        }
        
        $term = wp_insert_term($name, 'mec_location');
        
        // An error ocurred
        if(is_wp_error($term))
        {
            #TODO show a message to user
            return false;
        }
        
        $location_id = $term['term_id'];
        
        if(!$location_id) return false;
        
        // Set Location ID to the parameters
        $_POST['mec']['location_id'] = $location_id;
        
        // Set term to the post
        wp_set_object_terms($post_id, (int) $location_id, 'mec_location');
        
        $latitude = (isset($_mec['location']['latitude']) and trim($_mec['location']['latitude'])) ? $_mec['location']['latitude'] : 0;
        $longitude = (isset($_mec['location']['longitude']) and trim($_mec['location']['longitude'])) ? $_mec['location']['longitude'] : 0;
        $thumbnail = (isset($_mec['location']['thumbnail']) and trim($_mec['location']['thumbnail'])) ? $_mec['location']['thumbnail'] : '';
        
        if(!trim($latitude) or !trim($longitude))
        {
            $geo_point = $this->main->get_lat_lng($address);
            
            $latitude = $geo_point[0];
            $longitude = $geo_point[1];
        }
        
        update_term_meta($location_id, 'address', $address);
        update_term_meta($location_id, 'latitude', $latitude);
        update_term_meta($location_id, 'longitude', $longitude);
        update_term_meta($location_id, 'thumbnail', $thumbnail);

        return true;
    }
}