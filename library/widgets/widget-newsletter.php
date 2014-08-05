<?php

add_action( 'widgets_init', 'sp_newletter_widget' );
function sp_newletter_widget() {
	register_widget( 'sp_widget_newletter' );
}

/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/

class sp_widget_newletter extends WP_Widget {
	/*
	*****************************************************
	* widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'sp-widget-newsletter';
		$prefix = SP_THEME_NAME . ': ';
		$name   = '<span>' . $prefix . __( 'Newsletter', 'sptheme_widget' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'sp-widget-newsletter',
			'description' => __( 'A widget to present bulleting or newsletter','sptheme_widget' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
		
	}
		
		
	function widget( $args, $instance) {
		extract ($args);
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title']);
		$post_num = $instance['post_num'];
		$archive_link = $instance['archive_link'];
		
		/* Before widget (defined by themes). */
		$out = $before_widget;
		
		/* Title of widget (before and after define by theme). */
		if ( $title )
			$out .= $before_title . $title . $after_title;

		$out .= sp_get_newsletter( $post_num, 1, $archive_link );
	
		/* After widget (defined by themes). */		
		$out .= $after_widget;

		echo $out;
	}	
	
	/**
	 * Update the widget settings.
	 */	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_num'] = strip_tags( $new_instance['post_num'] );
		$instance['archive_link'] = strip_tags( $new_instance['archive_link'] );

		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form( $instance ) {
		global $post;
		/* Set up some default widget settings. */
		$defaults = array( 
			'title' => 'Newsletter', 
			'post_num' => '5',
			'archive_link' => '');
		$instance = wp_parse_args( (array) $instance, $defaults); 

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  class="widefat">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>">Number of post: </label>
			<input id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" value="<?php echo $instance['post_num']; ?>" type="text" size="3" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'archive_link' ); ?>"><?php _e('Archive link:', 'sptheme_widget') ?></label>
		<input type="text" id="<?php echo $this->get_field_id( 'archive_link' ); ?>" name="<?php echo $this->get_field_name( 'archive_link' ); ?>" value="<?php echo $instance['archive_link']; ?>"  class="widefat">
		</p>
        
	   <?php 
    }
} //end class
?>