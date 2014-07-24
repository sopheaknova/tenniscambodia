<?php $related = sp_get_posttype_related(get_the_ID(), array('post_type' => 'gallery', 'posts_per_page' => 3)); ?>

<?php if ( $related->have_posts() ): ?>
<section class="related-posts">
<h4 class="heading"><?php _e('Related ablum...', SP_TEXT_DOMAIN); ?></h4>

<ul class="album-cover clearfix">
	
	<?php while ( $related->have_posts() ) : $related->the_post(); ?>
	<li class="related post-hover">
		<article <?php post_class(); ?>>
			<?php echo sp_related_album('thumb-medium'); ?>
		</article>
	</li><!--/.related-->
	<?php endwhile; ?>

</ul><!--/.post-related-->
</section>
<?php endif; ?>

<?php wp_reset_query(); ?>
