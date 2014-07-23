<?php //$related = sp_related_posts(); ?>
<?php $related = sp_get_posts_related_by_taxonomy(get_the_ID(), 'player-category', array('posts_per_page' => 3)); ?>

<?php if ( $related->have_posts() ): ?>
<section class="related-posts">
<h4 class="heading"><?php _e('Related player', SP_TEXT_DOMAIN); ?></h4>

<ul class="clearfix">
	
	<?php while ( $related->have_posts() ) : $related->the_post(); ?>
	<li class="related post-hover">
		<article <?php post_class(); ?>>

			<?php
				echo sp_related_player_meta('thumb-medium');
			?>

		</article>
	</li><!--/.related-->
	<?php endwhile; ?>

</ul><!--/.post-related-->
</section>
<?php endif; ?>

<?php wp_reset_query(); ?>
