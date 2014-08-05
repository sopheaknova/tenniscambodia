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
		?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
					<header class="entry-header">
						<h1 class="entry-title">
							<?php the_title(); ?>
						</h1>
						<div class="entry-meta">
							<span class="album-attr"><?php echo get_the_date('F j, Y'); ?></span>
        					<span class="album-attr"><?php echo __(', At ', SP_TEXT_DOMAIN);?><?php echo get_post_meta( get_the_ID(), 'sp_album_location', true); ?></span>
						</div>
					</header>

					<div class="entry-content">
						<?php
							$postnum = -1;
							$cols = 4; 
							echo sp_get_album_gallery( $post->ID, $postnum, $cols ); 
						?>

						<?php if ( ot_get_option('social_share') != 'off' ) { get_template_part('library/contents/social-share'); } ?>
					</div><!-- .entry-content -->

				</article><!-- #post -->

				<?php if ( ot_get_option( 'related-posts' ) != '1' ) { get_template_part('library/contents/related-gallery'); } ?>

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