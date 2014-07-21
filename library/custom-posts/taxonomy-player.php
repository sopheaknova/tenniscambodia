<?php
add_action('init', 'sp_tax_player_category_init', 0);

function sp_tax_player_category_init() {
	register_taxonomy(
		'player-category',
		array( 'player' ),
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __( 'Player Categories', 'sptheme_admin' ),
				'singular_name' => __( 'Player Categories', 'sptheme_admin' )
			),
			'sort' => true,
			'rewrite' => array( 'slug' => 'player-category' ),
			'show_in_nav_menus' => false
		)
	);
}