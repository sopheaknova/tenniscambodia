<?php 
	$meta_query = array(
			    'relation'  =>   'AND',
			    array(
			        'key'       =>   'sp_event_end_date',
			        'value'     =>   date('Y-m-d h:i', time()+(3600*7)),
			        'compare'   =>   '>=',
			        'type'		=> 'DATETIME'
			    )
			);

	$related = sp_get_posttype_related(get_the_ID(), array('post_type' => 'event', 'posts_per_page' => 4, 'meta_query' => $meta_query)); 
?>

<?php if ( $related->have_posts() ): $count = 1; ?>
<section class="related-posts">
<h4 class="heading"><?php _e('Other event...', SP_TEXT_DOMAIN); ?></h4>
	<div class="sp-widget-upcoming-events clearfix">
	<?php while ( $related->have_posts() ) : $related->the_post(); ?>
	<div class="two-fourth<?php echo ($count == 2) ? ' last' : '';?>">
		<?php echo sp_event_highlight(false); ?>
	</div><!--/.related-->
	<?php $count++; endwhile; ?>
	</div>
</section>
<?php endif; ?>

<?php wp_reset_query(); ?>
