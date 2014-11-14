<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
<?php do_action( 'sp_start_content_wrap_html' ); ?>
    <div id="main" class="main">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); 
				$event_passed_class = ( get_post_meta( get_the_ID(), 'sp_event_end_date', true ) >= date('Y-m-d h:i') ) ? '' : ' passed-event';
		?>

				<article id="post-<?php the_ID(); ?>" class="<?php echo $event_passed_class; ?>">
			
					<header class="entry-header">
						<h1 class="entry-title">
							<?php the_title(); ?>

							<span><?php echo __( 'Passed Event', SP_TEXT_DOMAIN ); ?></span>
						</h1>
					</header>
					<?php echo sp_get_single_event_meta(); ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

					<!-- <ul class="post-nav clearfix">
						<li class="previous"><?php previous_post_link('%link', '<i class="icon-left-open-1"></i><strong>'.__('Previous event', SP_TEXT_DOMAIN).'</strong> <span>%title</span>'); ?></li>
						<li class="next"><?php next_post_link('%link', '<i class="icon-right-open-1"></i><strong>'.__('Next event', SP_TEXT_DOMAIN).'</strong> <span>%title</span>'); ?></li>
					</ul> -->

					<?php if ( ot_get_option('social_share') != 'off' ) { get_template_part('library/contents/social-share'); } ?>
					

				</article><!-- #post -->

				<?php if ( ot_get_option( 'related-posts' ) != '1' ) { get_template_part('library/contents/related-event'); } ?>


		<?php		
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile;
		?>
		
	</div><!-- #main -->
	<?php get_sidebar();?>
<?php do_action( 'sp_end_content_wrap_html' ); ?>
<?php get_footer(); ?>