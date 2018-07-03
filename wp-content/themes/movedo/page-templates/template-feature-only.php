<?php
/*
Template Name: Feature Section Only
*/
?>
<?php get_header( 'basic' ); ?>

<?php the_post(); ?>
<?php movedo_grve_print_header_feature(); ?>

<?php get_footer( 'basic' );

//Omit closing PHP tag to avoid accidental whitespace output errors.
