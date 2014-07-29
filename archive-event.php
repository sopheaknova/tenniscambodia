<?php
/**
 * The template for displaying Archive pages
 */

global $wp_query;
get_header(); ?>
	<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div id="main" class="main">
        
    <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php echo __( 'Events', SP_TEXT_DOMAIN );?></h1>
            </header><!-- .page-header --> 

            <?php /* Start the Loop */ ?>
        
            <?php   
                    $current_date = date('Y-m-d h:i'); 

                    while ( have_posts() ) : the_post(); 

                        $event_end_date = get_post_meta( get_the_ID(), 'sp_event_end_date', true ); 
            ?>

                        <article id="post-<?php the_ID(); ?>" class="<?php echo ( $event_end_date >= $current_date ) ? '' : ' passed-event';?>">
                
                        <?php echo sp_event_highlight(); ?>

                        </article><!-- #post -->
            <?php
                    endwhile; 
                    // Pagination
                    if(function_exists('wp_pagenavi'))
                        wp_pagenavi();
                    else 
                        echo sp_pagination();
                else : 

                    get_template_part( 'library/contents/no-results' );

                endif; 
            ?>
    </div> <!-- #main -->
    <?php get_sidebar(); ?>
    <?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>