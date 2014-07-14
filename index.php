<?php
/**
 * The main template file.
 */

global $wp_query;
get_header(); ?>
	<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div id="main" class="main">
	
     

    </div> <!-- #main -->
    <?php get_sidebar(); ?>

    <?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>