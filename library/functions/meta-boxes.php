<?php

/*  Initialize the meta boxes.
/* ------------------------------------ */
add_action( 'admin_init', '_custom_meta_boxes' );

function _custom_meta_boxes() {

	$prefix = 'sp_';
  
/*  Custom meta boxes
/* ------------------------------------ */
$page_options = array(
	'id'          => 'page-options',
	'title'       => 'Page Options',
	'desc'        => '',
	'pages'       => array( 'page' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Primary Sidebar',
			'id'		=> $prefix . 'sidebar_primary',
			'type'		=> 'sidebar-select',
			'desc'		=> 'Overrides default'
		),
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix . 'layout',
			'type'		=> 'radio-image',
			'desc'		=> 'Overrides the default layout option',
			'std'		=> 'inherit',
			'choices'	=> array(
				array(
					'value'		=> 'inherit',
					'label'		=> 'Inherit Layout',
					'src'		=> SP_ASSETS_ADMIN . 'images/layout-off.png'
				),
				array(
					'value'		=> 'col-1c',
					'label'		=> '1 Column',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-1c.png'
				),
				array(
					'value'		=> 'col-2cl',
					'label'		=> '2 Column Left',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cl.png'
				),
				array(
					'value'		=> 'col-2cr',
					'label'		=> '2 Column Right',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cr.png'
				)
			)
		)
	)
);

$post_options = array(
	'id'          => 'post-options',
	'title'       => 'Post Options',
	'desc'        => '',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Primary Sidebar',
			'id'		=> $prefix . 'sidebar_primary',
			'type'		=> 'sidebar-select',
			'desc'		=> 'Overrides default'
		),
		array(
			'label'		=> 'Layout',
			'id'		=> $prefix . 'layout',
			'type'		=> 'radio-image',
			'desc'		=> 'Overrides the default layout option',
			'std'		=> 'inherit',
			'choices'	=> array(
				array(
					'value'		=> 'inherit',
					'label'		=> 'Inherit Layout',
					'src'		=> SP_ASSETS_ADMIN . 'images/layout-off.png'
				),
				array(
					'value'		=> 'col-1c',
					'label'		=> '1 Column',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-1c.png'
				),
				array(
					'value'		=> 'col-2cl',
					'label'		=> '2 Column Left',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cl.png'
				),
				array(
					'value'		=> 'col-2cr',
					'label'		=> '2 Column Right',
					'src'		=> SP_ASSETS_ADMIN . 'images/col-2cr.png'
				)
			)
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Slider post type
/* ---------------------------------------------------------------------- */
$post_type_slider = array(
	'id'          => 'gallery-setting',
	'title'       => 'Upload photos',
	'desc'        => 'These settings enable you to upload photos.',
	'pages'       => array( 'slider' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'sliders',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Gallery post type
/* ---------------------------------------------------------------------- */
$post_type_gallery = array(
	'id'          => 'gallery-setting',
	'title'       => 'Upload photos',
	'desc'        => 'These settings enable you to upload photos.',
	'pages'       => array( 'gallery' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Upload photo',
			'id'		=> $prefix . 'gallery',
			'type'		=> 'gallery',
			'desc'		=> 'Upload photos'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Event post type
/* ---------------------------------------------------------------------- */
$post_type_event = array(
	'id'          => 'event-setting',
	'title'       => 'Event meta',
	'desc'        => 'These settings enable you to setup meta data of event.',
	'pages'       => array( 'event' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Start date',
			'id'		=> $prefix . 'event_start_date',
			'type'		=> 'date-time-picker',
			'desc'		=> 'Select start date for event'
		),
		array(
			'label'		=> 'End date',
			'id'		=> $prefix . 'event_end_date',
			'type'		=> 'date-time-picker',
			'desc'		=> 'Select end date for event'
		),
		array(
			'label'		=> 'Location',
			'id'		=> $prefix . 'event_location',
			'type'		=> 'text',
			'desc'		=> 'Enter location for event'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Logo post type
/* ---------------------------------------------------------------------- */
$post_type_logo = array(
	'id'          => 'logo-setting',
	'title'       => 'URL/Link',
	'desc'        => '(Optional) Enter website address',
	'pages'       => array( 'logo' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Website address',
			'id'		=> $prefix . 'website_url',
			'type'		=> 'text',
			'desc'		=> 'e.g: http://www.google.com'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: video
/* ---------------------------------------------------------------------- */
$post_format_video = array(
	'id'          => 'format-video',
	'title'       => 'Format: Video',
	'desc'        => 'These settings enable you to embed videos into your posts.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Video URL',
			'id'		=> $prefix . 'video_url',
			'type'		=> 'text',
			'desc'		=> 'Recommended to use.'
		),
		array(
			'label'		=> 'Video Embed Code',
			'id'		=> $prefix . 'video_embed_code',
			'type'		=> 'textarea',
			'rows'		=> '2'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Audio
/* ---------------------------------------------------------------------- */
$post_format_audio = array(
	'id'          => 'format-audio',
	'title'       => 'Format: Audio',
	'desc'        => 'These settings enable you to embed audio into your posts. You must provide both .mp3 and .ogg/.oga file formats in order for self hosted audio to function accross all browsers.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'MP3 File URL',
			'id'		=> $prefix . 'audio_mp3_url',
			'type'		=> 'upload',
			'desc'		=> 'The URL to the .mp3 or .m4a audio file'
		),
		array(
			'label'		=> 'OGA File URL',
			'id'		=> $prefix . 'audio_ogg_url',
			'type'		=> 'upload',
			'desc'		=> 'The URL to the .oga, .ogg audio file'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Gallery
/* ---------------------------------------------------------------------- */
$post_format_gallery = array(
	'id'          => 'format-gallery',
	'title'       => 'Format: Gallery',
	'desc'        => '<a title="Add Media" data-editor="content" class="button insert-media add_media" id="insert-media-button" href="#">Add Media</a> <br /><br />
						To create a gallery, upload your images and then select "<strong>Uploaded to this post</strong>" from the dropdown (in the media popup) to see images attached to this post. You can drag to re-order or delete them there. <br /><br /><i>Note: Do not click the "Insert into post" button. Only use the "Insert Media" section of the upload popup, not "Create Gallery" which is for standard post galleries.</i>',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array()
);

/* ---------------------------------------------------------------------- */
/*	Post Format: Chat
/* ---------------------------------------------------------------------- */
$post_format_chat = array(
	'id'          => 'format-chat',
	'title'       => 'Format: Chat',
	'desc'        => 'Input chat dialogue.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Chat Text',
			'id'		=> $prefix . 'chat',
			'type'		=> 'textarea',
			'rows'		=> '2'
		)
	)
);
/* ---------------------------------------------------------------------- */
/*	Post Format: Link
/* ---------------------------------------------------------------------- */
$post_format_link = array(
	'id'          => 'format-link',
	'title'       => 'Format: Link',
	'desc'        => 'Input your link.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Link Title',
			'id'		=> $prefix . 'link_title',
			'type'		=> 'text'
		),
		array(
			'label'		=> 'Link URL',
			'id'		=> $prefix . 'link_url',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Post Format: quote
/* ---------------------------------------------------------------------- */
$post_format_quote = array(
	'id'          => 'format-quote',
	'title'       => 'Format: Quote',
	'desc'        => 'Input your quote.',
	'pages'       => array( 'post' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Quote',
			'id'		=> $prefix . 'quote',
			'type'		=> 'textarea',
			'rows'		=> '2'
		),
		array(
			'label'		=> 'Quote Author',
			'id'		=> $prefix . 'quote_author',
			'type'		=> 'text'
		)
	)
);

/* ---------------------------------------------------------------------- */
/*	Metabox for Home template
/* ---------------------------------------------------------------------- */
$page_template_home = array(
	'id'          => 'home-settings',
	'title'       => 'Home settings',
	'desc'        => '',
	'pages'       => array( 'page' ),
	'context'     => 'normal',
	'priority'    => 'high',
	'fields'      => array(
		array(
			'label'		=> 'Special News',
			'id'		=> $prefix . 'slide_news_options',
			'type'		=> 'tab'
		),
		array(
			'label'		=> 'Special News',
			'id'		=> $prefix . 'news_category',
			'type'		=> 'category-select',
			'desc'		=> 'Select News category'
		),
		array(
			'label'		=> 'Amount of Special News',
			'id'		=> $prefix . 'special_news_num',
			'type'		=> 'text',
			'std'		=> 5,
			'desc'		=> 'Enter number only.',
		),

		array(
			'label'		=> 'Video',
			'id'		=> $prefix . 'video_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Title',
			'id'		=> $prefix . 'video_title',
			'type'		=> 'text',
			'std'		=> ''
		),
		array(
			'label'		=> 'Video URL',
			'id'		=> $prefix . 'video_url_home',
			'type'		=> 'text',
			'std'		=> '',
			'desc'		=> 'http://youtu.be/WuJlpqVjdY4',
		),

		array(
			'label'		=> 'Event',
			'id'		=> $prefix . 'event_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Title',
			'id'		=> $prefix . 'event_title',
			'type'		=> 'text',
			'std'		=> 'Upcoming events'
		),
		array(
			'label'		=> 'Number of Upcoming events',
			'id'		=> $prefix . 'event_num',
			'type'		=> 'text',
			'std'		=> 2,
			'desc'		=> 'Enter latest ammount of event to show',
		),

		array(
			'label'		=> 'Partners',
			'id'		=> $prefix . 'partner_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Title',
			'id'		=> $prefix . 'partner_title',
			'type'		=> 'text',
			'std'		=> 'Partners'
		),
		array(
			'label'		=> 'Partner logo',
			'id'		=> $prefix . 'partner_home',
			'type'		=> 'taxonomy-select',
			'desc'		=> 'By not selecting a parnter category, it will show your latest logos',
			'taxonomy'  => 'logo-type'
		),
		array(
			'label'		=> 'Number of logos',
			'id'		=> $prefix . 'partner_logo_num',
			'type'		=> 'text',
			'std'		=> 1,
			'desc'		=> 'Enter number only.',
		),

		array(
			'label'		=> 'Awards',
			'id'		=> $prefix . 'award_options',
			'type'		=> 'tab'
		), 
		array(
			'label'		=> 'Title',
			'id'		=> $prefix . 'award_title',
			'type'		=> 'text',
			'std'		=> 'Awards'
		),
		array(
			'label'		=> 'Award logo',
			'id'		=> $prefix . 'award_home',
			'type'		=> 'taxonomy-select',
			'desc'		=> 'By not selecting a awards category, it will show your latest logos',
			'taxonomy'  => 'logo-type'
		),
		array(
			'label'		=> 'Number of logos',
			'id'		=> $prefix . 'award_logo_num',
			'type'		=> 'text',
			'std'		=> 1,
			'desc'		=> 'Enter number only.',
		),

		array(
			'label'		=> 'Photogallery',
			'id'		=> $prefix . 'gallery_options',
			'type'		=> 'tab'
		),
		array(
			'label'		=> 'Title',
			'id'		=> $prefix . 'photo_title',
			'type'		=> 'text',
			'std'		=> 'Photogallery'
		),
		array(
			'label'		=> 'Select Album',
			'id'		=> $prefix . 'gallery_home',
			'type'		=> 'custom-post-type-select',
			'desc'		=> 'Select album to show',
			'post_type' => 'gallery',
		),
		array(
			'label'		=> 'Number of photos',
			'id'		=> $prefix . 'photo_num',
			'type'		=> 'text',
			'std'		=> 10,
			'desc'		=> 'Enter number only.',
		),

	)
);

function rw_maybe_include() {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	$template = get_post_meta( $post_id, '_wp_page_template', true );

	return $template;
}

/*  Register meta boxes
/* ------------------------------------ */
	
	ot_register_meta_box( $post_format_audio );
	ot_register_meta_box( $post_format_chat );
	ot_register_meta_box( $post_format_gallery );
	ot_register_meta_box( $post_format_link );
	ot_register_meta_box( $post_format_quote );
	ot_register_meta_box( $post_format_video );
	ot_register_meta_box( $post_options );
	ot_register_meta_box( $post_type_gallery );
	ot_register_meta_box( $post_type_slider );
	ot_register_meta_box( $post_type_logo );
	ot_register_meta_box( $post_type_event );

	$template_file = rw_maybe_include();
	if ( $template_file == 'template-home.php' ) {
	    ot_register_meta_box( $page_template_home );
	}

	ot_register_meta_box( $page_options );
}