<?php


/* ---------------------------------------------------------------------- */
/* Show language list on header
/* ---------------------------------------------------------------------- */
if( !function_exists('languages_list_header')) {

	function languages_list_header(){
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			echo '<div class="language"><ul>';
			echo '<li>' . __('Language: ', 'sptheme') . '</li>';
			foreach($languages as $l){
				echo '<li class="'.$l['language_code'].'">';

				if(!$l['active']) echo '<a href="'.$l['url'].'" title="' . $l['native_name'] . '">';
				echo '<img src="' . $l['country_flag_url'] . '" alt="' . $l['native_name'] . '" />';
				if(!$l['active']) echo '</a>';

				echo '</li>';
			}
			echo '</ul></div>';
		}
	}

}

/* ---------------------------------------------------------------------- */
/*	Get images attached to post
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_post_images' ) ) {

	function sp_post_images( $args=array() ) {
		global $post;

		$defaults = array(
			'numberposts'		=> -1,
			'order'				=> 'ASC',
			'orderby'			=> 'menu_order',
			'post_mime_type'	=> 'image',
			'post_parent'		=>  $post->ID,
			'post_type'			=> 'attachment',
		);

		$args = wp_parse_args( $args, $defaults );

		return get_posts( $args );
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Get thumbnail post
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_post_thumbnail') ) {

	function sp_post_thumbnail($size = 'thumbnail'){
		global $post;
		$thumb = '';
		
		//get the post thumbnail;
		$thumb_id = get_post_thumbnail_id($post->ID);
		$thumb_url = wp_get_attachment_image_src($thumb_id, $size);
		$thumb = $thumb_url[0];
		if ($thumb) return $thumb;
	}		

}

/* ---------------------------------------------------------------------- */
/*	Start content wrap
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_start_content_wrap') ) {

	add_action( 'sp_start_content_wrap_html', 'sp_start_content_wrap' );

	function sp_start_content_wrap() {
		echo '<section id="content" class="container clearfix">';
	}
	
}

/* ---------------------------------------------------------------------- */
/*	End content wrap
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_end_content_wrap') ) {

	add_action( 'sp_end_content_wrap_html', 'sp_end_content_wrap' );

	function sp_end_content_wrap() {
		echo '</section> <!-- #content .container .clearfix -->';
	}

}

/* ---------------------------------------------------------------------- */
/*	Thumnail for social share
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_facebook_thumb') ) {

	function sp_facebook_thumb() {
		if ( is_singular( 'sp_work' ) ) {
			global $post;

			$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
			echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '" />';
		}
	}

	add_action('wp_head', 'sp_facebook_thumb');
}


/* ---------------------------------------------------------------------- */               							
/*  Retrieve the terms list and return array
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_get_terms_list') ) {

	function sp_get_terms_list($taxonomy){
		$args = array(
				'hide_empty'	=> 0
			);
		$taxonomies = get_terms($taxonomy, $args);
		return $taxonomies;
	}

}


/* ---------------------------------------------------------------------- */               							
/*  Get related post by Taxonomy
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_get_posts_related_by_taxonomy') ) {

	function sp_get_posts_related_by_taxonomy($post_id, $taxonomy, $args=array()) {

		//$query = new WP_Query();
		$terms = wp_get_object_terms($post_id, $taxonomy);
		if (count($terms)) {
		
		// Assumes only one term for per post in this taxonomy
		$post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
		$post = get_post($post_id);
		$args = wp_parse_args($args,array(
		  'post_type' => $post->post_type, // The assumes the post types match
		  //'post__in' => $post_ids,
		  'post__not_in' => array($post_id),
		  'tax_query' => array(
		  			array(
						'taxonomy' => $taxonomy,
						'field' => 'term_id',
		  				'terms' => $terms[0]->term_id
					)),
		  'orderby' => 'rand',
		  'posts_per_page' => -1
		  
		));
		$query = new WP_Query($args);
		}
		return $query;
	}

}

if ( !function_exists('sp_get_posttype_related') ) {

	function sp_get_posttype_related($post_id, $args=array()) {

		//$query = new WP_Query();
		$args = wp_parse_args($args,array(
		  'post__not_in' => array($post_id),
		  'orderby' => 'rand',
		  'posts_per_page' => -1,
		  'post_status'    =>   'publish',
		));
		$query = new WP_Query($args);

		return $query;
	}

}

/* ---------------------------------------------------------------------- */               							
/*  Taxonomy has children and has parent
/* ---------------------------------------------------------------------- */
function has_children($cat_id, $taxonomy) {
    $children = get_terms(
        $taxonomy,
        array( 'parent' => $cat_id, 'hide_empty' => false )
    );
    if ($children){
        return true;
    }
    return false;
}

function category_has_parent($catid){
    $category = get_category($catid);
    if ($category->category_parent > 0){
        return true;
    }
    return false;
}

/* ---------------------------------------------------------------------- */
/*  Get related pages
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_get_related_pages') ) {

	function sp_get_related_pages() {

		$orig_post = $post;
		global $post;
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag)
			$tag_ids[] = $individual_tag->term_id;
			$args=array(
			'post_type' => 'page',
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=>5
			);
			$pages_query = new WP_Query( $args );
			if( $pages_query->have_posts() ) {
				echo '<div id="relatedpages"><h3>Related Pages</h3><ul>';
				while( $pages_query->have_posts() ) {
				$pages_query->the_post(); ?>
				<li><div class="relatedthumb"><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumb'); ?></a></div>
				<div class="relatedcontent">
				<h3><a href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<?php the_time('M j, Y') ?>
				</div>
				</li>
			<?php }
				echo '</ul></div>';
			} else { 
				echo "No Related Pages Found:";
			}
		}
		$post = $orig_post;
		wp_reset_postdata(); 

	}
	
}

/* ---------------------------------------------------------------------- */
/*  Get related post
/* ---------------------------------------------------------------------- */ 
if ( ! function_exists( 'sp_related_posts' ) ) {

	function sp_related_posts() {
		wp_reset_postdata();
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'				=> true,
			'update_post_meta_cache'	=> false,
			'update_post_term_cache'	=> false,
			'ignore_sticky_posts'		=> 1,
			'orderby'					=> 'rand',
			'post__not_in'				=> array($post->ID),
			'posts_per_page'			=> 3
		);
		// Related by categories
		if ( ot_get_option('related-posts') == 'categories' ) {
			
			$cats = get_post_meta($post->ID, 'related-cat', true);
			
			if ( !$cats ) {
				$cats = wp_get_post_categories($post->ID, array('fields'=>'ids'));
				$args['category__in'] = $cats;
			} else {
				$args['cat'] = $cats;
			}
		}
		// Related by tags
		if ( ot_get_option('related-posts') == 'tags' ) {
		
			$tags = get_post_meta($post->ID, 'related-tag', true);
			
			if ( !$tags ) {
				$tags = wp_get_post_tags($post->ID, array('fields'=>'ids'));
				$args['tag__in'] = $tags;
			} else {
				$args['tag_slug__in'] = explode(',', $tags);
			}
			if ( !$tags ) { $break = true; }
		}
		
		$query = !isset($break) ? new WP_Query($args) : new WP_Query;
		return $query;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Displays a page pagination
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme_admin') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', SP_TEXT_DOMAIN) . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', SP_TEXT_DOMAIN) . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme_admin') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

/* ---------------------------------------------------------------------- */
/*	Comment Template
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_comment_template' ) ) {

	function sp_comment_template( $comment, $args, $depth ) {
		global $retina;
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>

		<li id="comment-<?php comment_ID(); ?>" class="comment clearfix">

			<?php $av_size = isset($retina) && $retina === 'true' ? 96 : 48; ?>
			
			<div class="user"><?php echo get_avatar( $comment, $av_size, $default=''); ?></div>

			<div class="message">
				
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => 3 ) ) ); ?>

				<div class="info">
					<h4><?php echo (get_comment_author_url() != '' ? comment_author_link() : comment_author()); ?></h4>
					<span class="meta"><?php echo comment_date('F jS, Y \a\t g:i A'); ?></span>
				</div>

				<?php comment_text(); ?>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="await"><?php _e( 'Your comment is awaiting moderation.', 'goodwork' ); ?></em>
				<?php endif; ?>

			</div>

		</li>

		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'goodwork' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'goodwork'), ' ' ); ?></p></li>
		<?php
				break;
		endswitch;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Ajaxify Comments
/* ---------------------------------------------------------------------- */

add_action('comment_post', 'ajaxify_comments',20, 2);
function ajaxify_comments($comment_ID, $comment_status){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//If AJAX Request Then
		switch($comment_status){
			case '0':
				//notify moderator of unapproved comment
				wp_notify_moderator($comment_ID);
			case '1': //Approved comment
				echo "success";
				$commentdata=&get_comment($comment_ID, ARRAY_A);
				$post=&get_post($commentdata['comment_post_ID']); 
				wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
			break;
			default:
				echo "error";
		}
		exit;
	}
}

/* ---------------------------------------------------------------------- */
/*	Full Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_post_meta' ) ) {
	function sp_post_meta() {
		printf( __( '<i class="icon icon-calendar-1"></i><a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s"> %4$s</time></a><span class="by-author"> by </span><span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="posted-in"> in </span><i class="icon icon-tag"> </i> %8$s ', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', SP_TEXT_DOMAIN ), get_the_author() ) ),
			get_the_author(),
			get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="with-comments"><?php _e( ' with ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '<i class="icon icon-comment-1"></i> % Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open() ?>
		<?php edit_post_link( __( 'Edit', SP_TEXT_DOMAIN ), '<span class="sep"> | </span><span class="edit-link">', '</span>' );
	}
};

/* ---------------------------------------------------------------------- */
/*	Mini Meta post entry
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_meta_mini' ) ) :
	function sp_meta_mini() {
		printf( __( '<a href="%1$s" title="%2$s"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="sep"> |  </span>', SP_TEXT_DOMAIN ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
			//get_the_category_list( ', ' )
		);
		if ( comments_open() ) : ?>
				<span class="sep"><?php _e( ' | ', SP_TEXT_DOMAIN ); ?></span>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comments', SP_TEXT_DOMAIN ) . '</span>', __( '1 Comment', SP_TEXT_DOMAIN ), __( '% Comments', SP_TEXT_DOMAIN ) ); ?></span>
		<?php endif; // End if comments_open()
	}
endif;

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_get_video_img($url) {
	
	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id =  $my_array_of_vars['v'] ;
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video_id = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .= 'http://img.youtube.com/vi/'.$video_id.'/0.jpg';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video_id = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		$output .=$hash[0]['thumbnail_large'];
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='http://www.dailymotion.com/thumbnail/video/'.$video_id;
	}

	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Embeded add video from youtube, vimeo and dailymotion
/* ---------------------------------------------------------------------- */
function sp_add_video ($url, $width = 620, $height = 349) {

	$video_url = @parse_url($url);
	$output = '';

	if ( $video_url['host'] == 'www.youtube.com' || $video_url['host']  == 'youtube.com' ) {
		parse_str( @parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video =  $my_array_of_vars['v'] ;
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.youtu.be' || $video_url['host']  == 'youtu.be' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.vimeo.com' || $video_url['host']  == 'vimeo.com' ){
		$video = (int) substr(@parse_url($url, PHP_URL_PATH), 1);
		$output .='<iframe src="http://player.vimeo.com/video/'.$video.'" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}
	elseif( $video_url['host'] == 'www.dailymotion.com' || $video_url['host']  == 'dailymotion.com' ){
		$video = substr(@parse_url($url, PHP_URL_PATH), 7);
		$video_id = strtok($video, '_');
		$output .='<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$video_id.'"></iframe>';
	}

	return $output;
}

/* ---------------------------------------------------------------------- */
/*	Embeded soundcloud
/* ---------------------------------------------------------------------- */

function sp_soundcloud($url , $autoplay = 'false' ) {
	return '<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;auto_play='.$autoplay.'&amp;show_artwork=true"></iframe>';
}

function sp_portfolio_grid( $col = 'list', $posts_per_page = 5 ) {
	
	$temp ='';
	$output = '';
	
	$args = array(
			'posts_per_page' => (int) $posts_per_page,
			'post_type' => 'portfolio',
			);
			
	$post_list = new WP_Query($args);
		
	ob_start();
	if ($post_list && $post_list->have_posts()) {
		
		$output .= '<ul class="portfolio ' . $col . '">';
		
		while ($post_list->have_posts()) : $post_list->the_post();
		
		$output .= '<li>';
		$output .= '<div class="two-fourth"><div class="post-thumbnail">';
		$output .= '<a href="'.get_permalink().'"><img src="' . sp_post_thumbnail('portfolio-2col') . '" /></a>';
		$output .= '</div></div>';
		
		$output .= '<div class="two-fourth last">';
		$output .= '<a href="'.get_permalink().'" class="port-'. $col .'-title">' . get_the_title() .'</a>';
		$output .= '</div>';	
		
		$output .= '</li>';	
		endwhile;
		
		$output .= '</ul>';
		
	}
	$temp = ob_get_clean();
	$output .= $temp;
	
	wp_reset_postdata();
	
	return $output;
	
}

/* ---------------------------------------------------------------------- */
/*	Get Most Racent posts from Category
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_last_posts_cat' ) ) {
	function sp_last_posts_cat( $post_num = 5 , $thumb = true , $category = 1 ) {

		global $post;
		
		$out = '';
		if ( is_singular() && !is_front_page() ) :
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'post__not_in' => array($post->ID) );	
		else : 
			$args = array( 'cat' => $category, 'posts_per_page' => (int) $post_num, 'offset' => 5 );
		endif;
		

		$custom_query = new WP_Query( $args );

		$out .= '<section class="custom-posts clearfix">';
		if( $custom_query->have_posts() ) :
			while ( $custom_query->have_posts() ) : $custom_query->the_post();

			$out .= '<article>';
			$out .= '<a href="' . get_permalink() . '" class="clearfix">';
			if ( has_post_thumbnail() && $thumb ) :
				$out .= get_the_post_thumbnail();
			else :
				$out .= '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME .'images/placeholder/thumb-small.png">';	
			endif;
			$out .= '<h5>' . get_the_title() . '</h5>';
			$out .= '<span class="time">' . get_the_time('j M, Y') . '</span>';
			$out .= '</a>';
			$out .= '</article>';

			endwhile; wp_reset_postdata();
		endif;
		$out .= '<a href="' . esc_url(get_category_link( $category )) . '" class="learn-more">' . __('More news', SP_TEXT_DOMAIN) .'</a>';
		$out .= '</section>';

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Columns switcher
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_colums_switcher' ) ) {
	function sp_colums_switcher( $cols = 2 ) {
		switch ( $cols ) {
			case "2":
				$cols = 'two-fourth';
			break;

			case "3":
				$cols = 'one-third';
			break;
			
			case "4":
				$cols = 'one-fourth';
			break;

			default:
				break;
		}
		return $cols;
	}
}		

/* ---------------------------------------------------------------------- */
/*	Get latest gallery/album
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_album_gallery' ) ) {
	function sp_get_album_gallery( $album_id = '', $photo_num = 10, $cols = 4, $size = 'post-slider' ) {

		global $post;

		$gallery = explode( ',', get_post_meta( $album_id, 'sp_gallery', true ) );

		$count = 0;
		$out = '<div class="gallery clearfix photogallery">';
		
		if ( $gallery[0] != '' ) :
			foreach ( $gallery as $image ) :
				$imageid = wp_get_attachment_image_src($image, $size);
				if ( is_singular('gallery') ) {
					$out .= '<div class="' . sp_colums_switcher($cols) . '">';
					$out .= '<a href="' . wp_get_attachment_url($image) . '">';
					$out .= '<img class="attachment-medium wp-post-image" src="' . $imageid[0] . '">';
					$out .= '</a>';
					$out .= '</div><!-- .one-third -->';
				} else {
					if ( $count < $photo_num ) {
						$out .= '<a href="' . wp_get_attachment_url($image) . '">';
						$out .= '<img class="attachment-medium wp-post-image" src="' . $imageid[0] . '">';
						$out .= '</a>';
					}
				}
				$count++;
			endforeach; 
		else : 
			$out .= __( 'Sorry there is no image for this album.', SP_TEXT_DOMAIN );
		endif;

		$out .= '</div>';

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Get Cover of Album
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_cover_album' ) ) {
	function sp_get_cover_album( $photo_num = 10, $cols = 3, $size = 'thumbnail' ) {

		global $post;

		$args = array(
			'post_type' 		=>	'gallery',
			'posts_per_page'	=>	$photo_num,
		);

		$custom_query = new WP_Query( $args );

		if( $custom_query->have_posts() ) :
			$out = '<div class="album-cover clearfix photogallery">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$out .= '<div class="' . sp_colums_switcher($cols) . '">';
				$out .= sp_related_album('post-slider');
                $out .= '</div><!-- .cols -->';

			endwhile; wp_reset_postdata();
			$out .= '</div><!-- .album-cover -->';
		endif;

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Get Related Album
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_related_album' ) ) {
	function sp_related_album( $size = 'thumbnail' ) {

		$out = '';
		$out .= '<a href="' . get_permalink() . '">';
		if ( has_post_thumbnail() ):
            $out .= get_the_post_thumbnail( get_the_ID(), $size);
        elseif ( ot_get_option('placeholder') != 'off' ):
            $out .=  '<img class="wp-image-placeholder" src="' . SP_ASSETS_THEME . 'images/placeholder/thumb-medium.png" alt="' . the_title() . '" />';
        endif;
        $out .= '<h5>' . get_the_title() . '</h5>';
        $out .= '<span class="album-attr">' . get_the_date('F j, Y') . '</span>';
        $out .= '<span class="album-attr">' . get_post_meta( get_the_ID(), 'sp_album_location', true) . '</span>';
        $out .= '</a>';

		return $out;
	}
}                

/* ---------------------------------------------------------------------- */
/*	Display sliders
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_sliders' ) ) {
	function sp_sliders( $slide_id, $size = 'thumbnail' ){
		
		$sliders = explode( ',', get_post_meta( $slide_id, 'sp_sliders', true ) );
		$out = '';
		$out .='<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#slideshow").flexslider({
						animation: "slide",
						pauseOnHover: true,
						controlNav: false
					});
				});		
				</script>';
		$out .= '<div id="slideshow" class="flexslider">';
		$out .= '<ul class="slides">';

		foreach ( $sliders as $image ){
			
			$imageid = wp_get_attachment_image_src($image, $size);

			$out .= '<li>';
			$out .= '<img src="' . $imageid[0] . '">';
			$out .= '</li>';
		
		}

		$out .= '</ul>';
		$out .= '</div>';	

		return $out;	
	}
}

/* ---------------------------------------------------------------------- */
/*	Player Member
/* ---------------------------------------------------------------------- */

/* Get player member */ 
if ( ! function_exists( 'sp_get_player_member' ) ) {
	function sp_get_player_member( $category_id = '', $numberposts = '10' ){
		global $post;

		$out = '';

		$args = array(
			'post_type' => 'player',
			'post_status' => 'publish',
			'posts_per_page' => $numberposts
			);
		$custom_query = new WP_Query( $args );
		if( $custom_query->have_posts() ) :
			$out .= '<div class="sp-player">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$out .= '<div class="one-third ' . $post->ID . '">' . sp_single_player_meta( 'thumb-medium' ) . '</div>';
			endwhile;
			wp_reset_postdata();
			$out .= '</div>';
		endif;
		return $out;	
	}
}

/* Single player */ 
if ( ! function_exists( 'sp_single_player_meta' ) ) {
	function sp_single_player_meta( $size = 'thumbnail', $style = 'default' ){
		global $post;

		$out = '';
		
		if ( is_singular('player') ) {
			$out .= '<a href="'.sp_post_thumbnail( 'large' ).'"><img class="attachment-medium wp-post-image" src="' . sp_post_thumbnail( $size ) . '" /></a>';
		} else { 
			$out .= '<a href="'.get_permalink().'"><img class="attachment-medium wp-post-image" src="' . sp_post_thumbnail( $size ) . '" /></a>';
			$out .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
		}

		return $out;	
	}
}

/* Related player */ 
if ( ! function_exists( 'sp_related_player_meta' ) ) {
	function sp_related_player_meta( $size = 'thumbnail', $style = 'default' ){
		global $post;

		$out = '';
		$out .= '<div class="sp-player ' . $style . '">';
		$out .= '<a href="'.get_permalink().'"><img class="attachment-medium wp-post-image" src="' . sp_post_thumbnail( $size ) . '" /></a>';
		$out .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
	    $out .= '</div>';

		return $out;	
	}
}

/* ---------------------------------------------------------------------- */
/*	Get logos by type 
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_logos_by_type' ) ) {
	function sp_get_logos_by_type( $term_id = '', $logo_num = 10, $is_slideshow = false, $size = 'large' ) {

		global $post;

		$out = '';
		$args = array(
			 'post_type' =>	'logo',
             'posts_per_page' => $logo_num,
             'post_status' => 'publish',
             'tax_query' => array(
                    array(
                        'taxonomy' => 'logo-type',
                        'field' => 'ids',
                        'terms' => $term_id
                    )
                )
        );
        $sponsors = new WP_Query( $args );


        if( $sponsors->have_posts() ) :
        	if ( $is_slideshow ) {
        	$out .='<script type="text/javascript">
				jQuery(document).ready(function($){
					$(".logo-slideshow").flexslider({
						animation: "fade",
						pauseOnHover: true,
						controlNav: false
					});
				});		
				</script>';
        	$out .= '<div class="logo-slideshow flexslider">';
        	$out .= '<ul class="slides">';
            while ( $sponsors->have_posts() ) : $sponsors->the_post();
        		$website_url = (get_post_meta( $post->ID, 'sp_website_url', true )) ? get_post_meta( $post->ID, 'sp_website_url', true ) : '#';
                if ( has_post_thumbnail() ) :
                    $out .= '<li><a href="' . $website_url . '" target="_blank">';
                    $out .= get_the_post_thumbnail( $post->ID, $size);    
                    $out .= '</a></li>';
                endif;
            endwhile; wp_reset_postdata();
            $out .= '</ul>';
            $out .= '</div>';
        	} else {
        	while ( $sponsors->have_posts() ) : $sponsors->the_post();
        		$website_url = (get_post_meta( $post->ID, 'sp_website_url', true )) ? get_post_meta( $post->ID, 'sp_website_url', true ) : '#';
                if ( has_post_thumbnail() ) :
                    $out .= '<a href="' . $website_url . '" target="_blank">';
                    $out .= get_the_post_thumbnail( $post->ID, $size);    
                    $out .= '</a>';
                endif;
            endwhile; wp_reset_postdata();
            }
        endif;

		return $out;
	}
}

/* ---------------------------------------------------------------------- */
/*	Event
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_upcoming_event' ) ) {
	function sp_upcoming_event( $postnum = 10, $excerpt = true ) {

		global $wp_post_types;

		$out ='';
		$args = array(
		    'post_type'             =>   'event',
		    'posts_per_page'        =>   $postnum,
		    'post_status'           =>   'publish',
		    'ignore_sticky_posts'   =>   true,
		    /*'meta_key'              =>   'sp_event_start_date',
		    'orderby'               =>   'meta_value_num',*/
		    'order'                 =>   'ASC',
		    'meta_query'			=> 	 array(
											    'relation'  =>   'AND',
											    array(
											        'key'       =>   'sp_event_end_date',
											        'value'     =>   date('Y-m-d h:i', time()+(3600*7)),
											        'compare'   =>   '>=',
											        'type'		=> 'DATE'
											    )
											)	
		);

		$custom_query = new WP_Query( $args );

		while( $custom_query->have_posts() ): $custom_query->the_post();
			$out .= sp_event_highlight($excerpt); 
		endwhile; wp_reset_postdata();
		$out .= '<a class="learn-more" href="' . get_post_type_archive_link( 'event' ) . '">' . __( 'All events', SP_TEXT_DOMAIN ) . '</a>';

		return $out;

	}
}

if ( ! function_exists( 'sp_event_highlight' ) ) {
	function sp_event_highlight( $excerpt = true ) {

		$event_start_date = explode( ' ', get_post_meta( get_the_ID(), 'sp_event_start_date', true ) );
		$event_end_date = explode( ' ', get_post_meta( get_the_ID(), 'sp_event_end_date', true ) );
		$event_passed_class = ( get_post_meta( get_the_ID(), 'sp_event_end_date', true ) >= date('Y-m-d h:i') ) ? '' : ' passed-event';

		$out ='';
		$out .= '<article class="upcoming-event' . $event_passed_class .'">';
        $out .= '<div class="event-meta">';
        $out .= '<span class="event-day">' . date('d', strtotime($event_start_date[0])) . '</span>';
        $out .= '<span class="event-month">' . date('M', strtotime($event_start_date[0])) . '</span>';
        $out .= '</div>';
        $out .= '<a href="' . get_permalink() . '" class="event-title">';
        $out .= '<h5>';
        $out .= get_the_title();
        if ( get_post_meta( get_the_ID(), 'sp_event_end_date', true ) <= date('Y-m-d h:i') )
        	$out .= '<span>' . __( 'Passed Event', SP_TEXT_DOMAIN ) . '</span>';
        $out .= '</h5>';
        $out .= '<span class="event-location">At ' . get_post_meta( get_the_ID(), 'sp_event_location', true ) . '</span>';
        $out .= '<span class="event-time">' . date('h:i A', strtotime($event_start_date[1])) . ' to ' . date('h:i A', strtotime($event_end_date[1])) . '</span>';
        $out .= '</a>';
        if ($excerpt) :
        	$out .= '<p>' . get_the_excerpt() . '</p>';
        	$out .= '<a class="learn-more" href="' . get_permalink() . '">' . __( 'Detail', SP_TEXT_DOMAIN ) . '</a>';
        endif; 	
    	$out .= '</article>';

		return $out;

	}
}		

if ( ! function_exists( 'sp_get_single_event_meta' ) ) {
	function sp_get_single_event_meta() {

		$event_start_date = explode( ' ', get_post_meta( get_the_ID(), 'sp_event_start_date', true ) );
		$event_end_date = explode( ' ', get_post_meta( get_the_ID(), 'sp_event_end_date', true ) );
		$out = '<div class="event-meta">';
		$out .= '<span class="event-location">At ' . get_post_meta( get_the_ID(), 'sp_event_location', true ) . '</span>';
		$out .= '<span class="event-time">, ' . date('h:i A', strtotime($event_start_date[1])) . ' to ' . date('h:i A', strtotime($event_end_date[1])) . '</span>';
		$out .= '<span class="event-date"><small>From</small> ' . date("l, F j, Y", strtotime($event_start_date[0])) . ' to ' . date("l, F j, Y", strtotime($event_end_date[0])) .'</span>';
		$out .= '</div>';

		return $out;

	}
}

/* ---------------------------------------------------------------------- */
/*	Newsletter
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'sp_get_newsletter' ) ) {
	function sp_get_newsletter( $numberposts = '10', $cols = 2,  $archive_link = '' ){
		global $post;

		$out = '';

		$args = array(
			'post_type' => 'newsletter',
			'post_status' => 'publish',
			'posts_per_page' => $numberposts
			);
		$custom_query = new WP_Query( $args );
		if( $custom_query->have_posts() ) :
			$out .= '<div class="sp-newsletter clearfix">';
			while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$file_url = get_post_meta( $post->ID, 'sp_newsletter_url', true );
				$out .= '<article class="' . sp_colums_switcher($cols) .' post-' . get_the_ID() . '">';
				$out .= '<img class="attachment-medium wp-post-image" src="' . sp_post_thumbnail('medium') . '" width="70" height="90">';
				$out .= '<h5>' . get_the_title() . '</h5>';
				$out .= '<span class="time">' . get_the_date('F j, Y') . '</span>';
				$out .= '<a class="download" href="' . $file_url . '" target="_blank">' . __('Download', SP_TEXT_DOMAIN) . '</a>';
				$out .= '</article>';
			endwhile;
			wp_reset_postdata();
			if ( !empty($archive_link) )
				$out .= '<a class="learn-more" href="' . $archive_link . '">' . __( 'All newsletters', SP_TEXT_DOMAIN ) . '</a>';
			$out .= '</div>';
		endif;

		return $out;	
	}
}	

/* ---------------------------------------------------------------------- */
/*	Contact form: Send email
/* ---------------------------------------------------------------------- */
if ( !function_exists('sp_send_contact_form') ) {

	function sp_send_contact_form(){
		
		parse_str ($_POST['inquiry'], $inquiry);
		$email_from = $inquiry['email'];
		$email = ot_get_option('email_inquiry');
		$subject = $inquiry['name'];
		$body = $inquiry['message'];
		$headers = "From: " . strip_tags($email_from) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email_from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		if (mail($email, $subject, $body, $headers)){
			$out = '<h3>Email was sent successfully.</h3>';
			$out .= '<p>If you don\'t receive our answer after 1 working day, please check your spam email. It may go to your spam mailbox.</p>';
			$out .= '<p>If you have any questions, please kindly contact us at: <a href="mailto:' . $email . '">' . $email . '</a></p>';
			echo $out;
		} else {
			echo '<h5>Sorry, your inquiry cannot be send right now.</h5><p>' . error_message . '</p>';
		};

		die();
	}

	add_action('wp_ajax_nopriv_sp_send_contact_form', 'sp_send_contact_form'); //executes for users that are not logged in.
	add_action('wp_ajax_sp_send_contact_form', 'sp_send_contact_form');

}

/* ---------------------------------------------------------------------- */
/*	Social icons - Widget
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_show_social_icons' ) ) {
	function sp_show_social_icons() {

		$social_icons = ot_get_option( 'social-links' );

		$out = '<section class="social-btn clearfix round">';
		$out .= '<ul>';
		
		foreach ($social_icons as $icons) {
			if ( $icons['social-icon'] == 'icon-facebook' )	
				$out .= '<li class="i-square icon-facebook-squared"><a href="#" target="_self"></a></li>';
			
			if ( $icons['social-icon'] == 'icon-twitter' )
				$out .= '<li class="i-square icon-twitter"><a href="#" target="_self"></a></li>';
			
			if ( $icons['social-icon'] == 'icon-gplus' )
				$out .= '<li class="i-square icon-gplus"><a href="#" target="_self"></a></li>';
			
			if ( $icons['social-icon'] == 'icon-youtube' )	
				$out .= '<li class="i-square icon-youtube"><a href="#" target="_self"></a></li>';
		}

		$out .= '</ul>';
		$out .= '</section>';

		return $out;

	}
}

