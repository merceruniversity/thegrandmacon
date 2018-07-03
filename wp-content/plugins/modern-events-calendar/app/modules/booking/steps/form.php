<?php
/** no direct access **/
defined('_MECEXEC_') or die();

$event_id = $event->ID;
$reg_fields = $this->main->get_reg_fields($event_id);

$event_tickets = isset($event->data->tickets) ? $event->data->tickets : array();
$price_details = $this->book->get_price_details($tickets, $event_id, $event_tickets);

$current_user = wp_get_current_user();
$first_for_all = (!isset($this->settings['booking_first_for_all']) or (isset($this->settings['booking_first_for_all']) and $this->settings['booking_first_for_all'] == 1)) ? true : false;
?>
<form id="mec_book_form<?php echo $uniqueid; ?>" class="mec-booking-form-container" novalidate="novalidate">
    <h4><?php _e('Attendees Form', 'mec'); ?></h4>
    <ul class="mec-book-tickets-container">

        <?php $j = 0; foreach($tickets as $ticket_id=>$count): if(!$count) continue; $ticket = $event_tickets[$ticket_id]; for($i = 1; $i <= $count; $i++): $j++; ?>
        <li class="mec-book-ticket-container <?php echo (($j > 1 and $first_for_all) ? 'mec-util-hidden' : ''); ?>">

            <h4><span class="mec-ticket-name"><?php echo $ticket['name']; ?></span><span class="mec-ticket-price"><?php echo $ticket['price_label']; ?></span></h4>
            
            <div class="mec-book-field-name mec-reg-mandatory" data-ticket-id="<?php echo $j; ?>">
                <label for="mec_book_reg_field_name<?php echo $j; ?>"><?php _e('Name', 'mec'); ?></label>
                <input id="mec_book_reg_field_name<?php echo $j; ?>" type="text" name="book[tickets][<?php echo $j; ?>][name]" value="<?php echo trim((isset($current_user->user_firstname) ? $current_user->user_firstname : '').' '.(isset($current_user->user_lastname) ? $current_user->user_lastname : '')); ?>" placeholder="<?php _e('Name', 'mec'); ?>" required />
            </div>
            <div class="mec-book-field-email mec-reg-mandatory" data-ticket-id="<?php echo $j; ?>">
                <label for="mec_book_reg_field_email<?php echo $j; ?>"><?php _e('Email', 'mec'); ?></label>
                <input id="mec_book_reg_field_email<?php echo $j; ?>" type="email" name="book[tickets][<?php echo $j; ?>][email]" value="<?php echo isset($current_user->user_email) ? $current_user->user_email : ''; ?>" placeholder="<?php _e('Email', 'mec'); ?>" required />
            </div>
            
            <!-- Custom fields -->
            <?php if(count($reg_fields)): foreach($reg_fields as $reg_field_id=>$reg_field): if(!is_numeric($reg_field_id) or !isset($reg_field['type'])) continue; ?>
            <div class="mec-book-reg-field-<?php echo $reg_field['type']; ?> <?php echo ((isset($reg_field['mandatory']) and $reg_field['mandatory']) ? 'mec-reg-mandatory' : ''); ?>" data-ticket-id="<?php echo $j; ?>" data-field-id="<?php echo $reg_field_id; ?>">
                <?php if(isset($reg_field['label']) and $reg_field['type'] != 'agreement'): ?><label for="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>"><?php _e($reg_field['label'], 'mec'); ?><?php echo ((isset($reg_field['mandatory']) and $reg_field['mandatory']) ? '<span class="wbmec-mandatory">*</span>' : ''); ?></label><?php endif; ?>

                <?php /** Text **/ if($reg_field['type'] == 'text'): ?>
                <input id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>" type="text" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" value="" placeholder="<?php _e($reg_field['label'], 'mec'); ?>" <?php if(isset($reg_field['mandatory']) and $reg_field['mandatory']) echo 'required'; ?> />
                
                <?php /** Email **/ elseif($reg_field['type'] == 'email'): ?>
                <input id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>" type="email" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" value="" placeholder="<?php _e($reg_field['label'], 'mec'); ?>" <?php if(isset($reg_field['mandatory']) and $reg_field['mandatory']) echo 'required'; ?> />
                
                <?php /** Tel **/ elseif($reg_field['type'] == 'tel'): ?>
                <input id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>" type="tel" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" value="" placeholder="<?php _e($reg_field['label'], 'mec'); ?>" <?php if(isset($reg_field['mandatory']) and $reg_field['mandatory']) echo 'required'; ?> />

                <?php /** Textarea **/ elseif($reg_field['type'] == 'textarea'): ?>
                <textarea id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" placeholder="<?php _e($reg_field['label'], 'mec'); ?>" <?php if(isset($reg_field['mandatory']) and $reg_field['mandatory']) echo 'required'; ?>></textarea>

                <?php /** Dropdown **/ elseif($reg_field['type'] == 'select'): ?>
                <select id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" placeholder="<?php _e($reg_field['label'], 'mec'); ?>" <?php if(isset($reg_field['mandatory']) and $reg_field['mandatory']) echo 'required'; ?>>
                    <?php foreach($reg_field['options'] as $reg_field_option): ?>
                    <option value="<?php esc_attr_e($reg_field_option['label'], 'mec'); ?>"><?php _e($reg_field_option['label'], 'mec'); ?></option>
                    <?php endforeach; ?>
                </select>

                <?php /** Radio **/ elseif($reg_field['type'] == 'radio'): ?>
                <?php foreach($reg_field['options'] as $reg_field_option): ?>
                <label for="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id.'_'.strtolower(str_replace(' ', '_', $reg_field_option['label'])); ?>">
                    <input type="radio" id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id.'_'.strtolower(str_replace(' ', '_', $reg_field_option['label'])); ?>" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" value="<?php _e($reg_field_option['label'], 'mec'); ?>" />
                    <?php _e($reg_field_option['label'], 'mec'); ?>
                </label>
                <?php endforeach; ?>

                <?php /** Checkbox **/ elseif($reg_field['type'] == 'checkbox'): ?>
                <?php foreach($reg_field['options'] as $reg_field_option): ?>
                <label for="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id.'_'.strtolower(str_replace(' ', '_', $reg_field_option['label'])); ?>">
                    <input type="checkbox" id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id.'_'.strtolower(str_replace(' ', '_', $reg_field_option['label'])); ?>" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>][]" value="<?php _e($reg_field_option['label'], 'mec'); ?>" />
                    <?php _e($reg_field_option['label'], 'mec'); ?>
                </label>
                <?php endforeach; ?>

                <?php /** Agreement **/ elseif($reg_field['type'] == 'agreement'): ?>
                <label for="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>">
                    <input type="checkbox" id="mec_book_reg_field_reg<?php echo $j.'_'.$reg_field_id; ?>" name="book[tickets][<?php echo $j; ?>][reg][<?php echo $reg_field_id; ?>]" value="1" checked="checked" />
                    <?php echo ((isset($reg_field['mandatory']) and $reg_field['mandatory']) ? '<span class="wbmec-mandatory">*</span>' : ''); ?>
                    <?php echo sprintf(__($reg_field['label'], 'mec'), '<a href="'.get_the_permalink($reg_field['page']).'" target="_blank">'.get_the_title($reg_field['page']).'</a>'); ?>
                </label>

                <?php /** Paragraph **/ elseif($reg_field['type'] == 'p'): ?>
                <p><?php _e($reg_field['content'], 'mec'); ?></p>

                <?php endif; ?>
            </div>
            <?php endforeach; endif; ?>

            <input type="hidden" name="book[tickets][<?php echo $j; ?>][id]" value="<?php echo $ticket_id; ?>" />
            <input type="hidden" name="book[tickets][<?php echo $j; ?>][count]" value="1" />
        </li>
        <?php endfor; endforeach; ?>

        <?php if($j > 1 and $first_for_all): ?>
        <li class="mec-first-for-all-wrapper">
            <label>
                <input type="hidden" name="book[first_for_all]" value="0" />
                <input type="checkbox" name="book[first_for_all]" value="1" checked="checked" id="mec_book_first_for_all<?php echo $uniqueid; ?>" onchange="mec_toggle_first_for_all<?php echo $uniqueid; ?>();" />
                <?php _e("Fill other attendees's information like the first form.", 'mec'); ?>
            </label>
        </li>
        <?php endif; ?>

    </ul>
    <div class="mec-book-form-price">
        <?php if(isset($price_details['details']) and is_array($price_details['details']) and count($price_details['details'])): ?>
        <ul class="mec-book-price-details">
            <?php foreach($price_details['details'] as $detail): ?>
            <li class="mec-book-price-detail mec-book-price-detail-type<?php echo $detail['type']; ?>">
                <span class="mec-book-price-detail-description"><?php echo $detail['description']; ?></span>
                <span class="mec-book-price-detail-amount"><?php echo $this->main->render_price($detail['amount']); ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <span class="mec-book-price-total"><?php echo $this->main->render_price($price_details['total']); ?></span>
    </div>
    <input type="hidden" name="book[date]" value="<?php echo $date; ?>" />
    <input type="hidden" name="book[event_id]" value="<?php echo $event_id; ?>" />
    <input type="hidden" name="action" value="mec_book_form" />
    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
    <input type="hidden" name="uniqueid" value="<?php echo $uniqueid; ?>" />
    <input type="hidden" name="step" value="2" />
    <?php wp_nonce_field('mec_book_form_'.$event_id); ?>
    <button type="submit"><?php _e('Next', 'mec'); ?></button>
</form>