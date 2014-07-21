<?php

//All custom posts
load_template( SP_BASE_DIR . 'library/custom-posts/cp-slider.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-gallery.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-logo.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/cp-player.php' );

//Taxonomies
load_template( SP_BASE_DIR . 'library/custom-posts/taxonomy-logo.php' );
load_template( SP_BASE_DIR . 'library/custom-posts/taxonomy-player.php' );
	
/*==========================================================================*/

//Change title text when creating new post
if ( is_admin() )
	add_filter( 'enter_title_here', 'sp_change_new_post_title' );	
	
/*
* Changes "Enter title here" text when creating new post
*/
if ( ! function_exists( 'sp_change_new_post_title' ) ) {
	function sp_change_new_post_title( $title ){
		$screen = get_current_screen();

		if ( 'gallery' == $screen->post_type )
			$title = __( "Album name", 'sptheme_admin' );

		if ( 'logo' == $screen->post_type )
			$title = __( "Logo name", 'sptheme_admin' );

		return $title;
	}
} // /sp_change_new_post_title