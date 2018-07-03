<?php
/** no direct access **/
defined('_MECEXEC_') or die();

/**
 * The Template for displaying all single events
 * 
 * @author Webnus <info@webnus.biz>
 * @package MEC/Templates
 * @version 1.0.0
 */
?>

        <style type="text/css">
			.theiaStickySidebar{display:none !important;}
        </style>
<!-- <div class="main-menu"> -->
        <section id="<?php echo apply_filters('mec_single_page_html_id', 'main-content'); ?>" class="<?php echo apply_filters('mec_single_page_html_class', 'mec-container'); ?>">
		<?php while(have_posts()): the_post(); ?>

            <?php $MEC = MEC::instance(); echo $MEC->single(); ?>

		<?php endwhile; // end of the loop. ?>
	    <?php comments_template(); ?>
        </section>



