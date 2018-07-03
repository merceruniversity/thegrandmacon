<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * Webnus MEC taxonomy walker class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_tax_walker extends Walker_Category_Checklist
{
    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0)
    {
		if(empty($args['taxonomy'])) $taxonomy = 'category';
        else $taxonomy = $args['taxonomy'];

		if($taxonomy == 'category') $name = 'post_category';
		else $name = 'mec_tax_input['.$taxonomy.']';

		$args['popular_cats'] = empty($args['popular_cats']) ? array() : $args['popular_cats'];
		$class = in_array($category->term_id, $args['popular_cats']) ? ' class="popular-category"' : '';

		$args['selected_cats'] = empty($args['selected_cats']) ? array() : $args['selected_cats'];

		if(!empty($args['list_only']))
        {
			$aria_cheched = 'false';
			$inner_class = 'category';

			if(in_array($category->term_id, $args['selected_cats']))
            {
				$inner_class .= ' selected';
				$aria_cheched = 'true';
			}
            // Show only Terms with Posts
            if($category->count)
            {
                $output .= "\n".'<li'.$class.'>'.
                    '<div class="'.$inner_class.'" data-term-id='.$category->term_id.
                    ' tabindex="0" role="checkbox" aria-checked="'.$aria_cheched.'">'.
                    esc_html(apply_filters('the_category', $category->name)).'</div>';
            }
		}
        else
        {
            // Show only Terms with Posts
            if($category->count)
            {
                $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>".
                    '<label class="selectit"><input value="'.$category->term_id.'" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' .$category->term_id.'"'.
                    checked(in_array($category->term_id, $args['selected_cats']), true, false).
                    disabled(empty($args['disabled']), false, false).' /> '.
                    esc_html(apply_filters('the_category', $category->name)).'</label>';
            }
		}
	}
}

$MEC_tax_walker = new MEC_tax_walker();
?>
<div class="mec-calendar-metabox">
    <?php
        // Add a nonce field so we can check for it later.
        wp_nonce_field('mec_calendar_data', 'mec_calendar_nonce');
    ?>
    <div id="mec_meta_box_calendar_no_filter" class="mec-util-hidden">
        <p><?php _e('No filter options applicable for this skin.', 'mec'); ?></p>
    </div>
    <div class="mec-meta-box-fields" id="mec_meta_box_calendar_filter">
        <div class="mec-form-row">
            <h4><?php echo $this->main->m('taxonomy_categories', __('Categories', 'mec')); ?></h4>
            <ul>
            <?php
                $selected_categories = explode(',', get_post_meta($post->ID, 'category', true));
                wp_terms_checklist(0, array(
                    'descendants_and_self'=>0,
                    'taxonomy'=>'mec_category',
                    'selected_cats'=>$selected_categories,
                    'popular_cats'=>false,
                    'checked_ontop'=>false,
                    'walker'=>$MEC_tax_walker
                ));
            ?>
            </ul>
            <p class="description"><?php _e('Choose your desired categories for filtering the events.', 'mec'); ?></p>
        </div>
        <div class="mec-form-row">
            <h4><?php echo $this->main->m('taxonomy_locations', __('Locations', 'mec')); ?></h4>
            <ul>
            <?php
                $selected_locations = explode(',', get_post_meta($post->ID, 'location', true));
                wp_terms_checklist(0, array(
                    'descendants_and_self'=>0,
                    'taxonomy'=>'mec_location',
                    'selected_cats'=>$selected_locations,
                    'popular_cats'=>false,
                    'checked_ontop'=>false,
                    'walker'=>$MEC_tax_walker
                ));
            ?>
            </ul>
            <p class="description"><?php _e('Choose your desired locations for filtering the events.', 'mec'); ?></p>
        </div>
        <div class="mec-form-row">
            <h4><?php echo $this->main->m('taxonomy_organizers', __('Organizers', 'mec')); ?></h4>
            <ul>
            <?php
                $selected_organizers = explode(',', get_post_meta($post->ID, 'organizer', true));
                wp_terms_checklist(0, array(
                    'descendants_and_self'=>0,
                    'taxonomy'=>'mec_organizer',
                    'selected_cats'=>$selected_organizers,
                    'popular_cats'=>false,
                    'checked_ontop'=>false,
                    'walker'=>$MEC_tax_walker
                ));
            ?>
            </ul>
            <p class="description"><?php _e('Choose your desired organizers for filtering the events.', 'mec'); ?></p>
        </div>
        <div class="mec-form-row">
            <h4><?php echo $this->main->m('taxonomy_labels', __('Labels', 'mec')); ?></h4>
            <ul>
            <?php
                $selected_labels = explode(',', get_post_meta($post->ID, 'label', true));
                wp_terms_checklist(0, array(
                    'descendants_and_self'=>0,
                    'taxonomy'=>'mec_label',
                    'selected_cats'=>$selected_labels,
                    'popular_cats'=>false,
                    'checked_ontop'=>false,
                    'walker'=>$MEC_tax_walker
                ));
            ?>
            </ul>
            <p class="description"><?php _e('Choose your desired labels for filtering the events.', 'mec'); ?></p>
        </div>
        <div class="mec-form-row">
            <h4><?php _e('Tags', 'mec'); ?></h4>
            <?php $selected_tags = get_post_meta($post->ID, 'tag', true); ?>
            <input type="text" name="mec_tax_input[mec_tag]" value="<?php echo $selected_tags; ?>" class="widefat" />
            <p class="description"><?php _e('Insert your desired tags comma separated.', 'mec'); ?></p>
        </div>
        <div class="mec-form-row">
            <h4><?php _e('Authors', 'mec'); ?></h4>
            <ul>
            <?php
                $selected_authors = explode(',', get_post_meta($post->ID, 'author', true));
                $authors = get_users(array(
                    'role__not_in'=>array('subscriber', 'contributor'),
                    'orderby'=>'post_count',
                    'order'=>'DESC',
                    'number'=>'-1',
                    'fields'=>array('ID', 'display_name')
                ));
                
                foreach($authors as $author)
                {
                    echo '<li><label><input id="in-mec_author-'.$author->ID.'" name="mec_tax_input[mec_author][]" type="checkbox" value="'.$author->ID.'" '.(in_array($author->ID, $selected_authors) ? 'checked="checked"' : '').' /> '.$author->display_name.'</label></li>';
                }
            ?>
            </ul>
            <p class="description"><?php _e('Choose your desired authors for filtering the events.', 'mec'); ?></p>
        </div>
        <div class="mec-form-row">
            <h4><?php _e('Dates', 'mec'); ?></h4>
            <div class="mec-form-row mec-switcher">
                <?php $show_past_events = get_post_meta($post->ID, 'show_past_events', true); ?>
				<div class="mec-col-4">
                    <label for="mec_show_past_events"><?php _e('Include Expired Events', 'mec'); ?></label>
				</div>
				<div class="mec-col-4">
                    <input type="hidden" name="mec[show_past_events]" value="0" />
                    <input type="checkbox" name="mec[show_past_events]" class="mec-checkbox-toggle" id="mec_show_past_events" value="1" <?php if($show_past_events == '' or $show_past_events == 1) echo 'checked="checked"'; ?> />
                    <label for="mec_show_past_events"></label>
				</div>
            </div>
            <p class="description"><?php _e('You have ability to include past/expired events if you like so it will show upcoming and expired events based on start date that you selected.', 'mec'); ?></p>
            <div id="mec_date_only_past_filter">
                <div class="mec-form-row mec-switcher">
                    <?php $show_only_past_events = get_post_meta($post->ID, 'show_only_past_events', true); ?>
                    <div class="mec-col-4">
                        <label for="mec_show_only_past_events"><?php _e('Show Only Expired Events', 'mec'); ?></label>
                    </div>
                    <div class="mec-col-4">
                        <input type="hidden" name="mec[show_only_past_events]" value="0" />
                        <input type="checkbox" name="mec[show_only_past_events]" class="mec-checkbox-toggle" id="mec_show_only_past_events" value="1" <?php if($show_only_past_events == 1) echo 'checked="checked"'; ?> />
                        <label for="mec_show_only_past_events"></label>
                    </div>
                </div>
                <p class="description"><?php _e('It shows only expired/past events.', 'mec'); ?></p>
            </div>
            <div id="mec_date_ongoing_filter">
                <div class="mec-form-row mec-switcher">
                    <?php $show_only_ongoing_events = get_post_meta($post->ID, 'show_only_ongoing_events', true); ?>
                    <div class="mec-col-4">
                        <label for="mec_show_only_ongoing_events"><?php _e('Show Only Ongoing Events', 'mec'); ?></label>
                    </div>
                    <div class="mec-col-4">
                        <input type="hidden" name="mec[show_only_ongoing_events]" value="0" />
                        <input type="checkbox" name="mec[show_only_ongoing_events]" class="mec-checkbox-toggle" id="mec_show_only_ongoing_events" value="1" <?php if($show_only_ongoing_events == 1) echo 'checked="checked"'; ?> />
                        <label for="mec_show_only_ongoing_events"></label>
                    </div>
                </div>
                <p class="description"><?php _e('It shows only ongoing events on List and Grid skins.', 'mec'); ?></p>
            </div>
        </div>
    </div>
</div>