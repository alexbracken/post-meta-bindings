<?php

/*
 * Plugin Name:       Post Meta Bindings
 * Plugin URI:        https://github.com/alexbracken/post-meta-bindings
 * Description:       Allows post data from query loops to be used in block bindings.
 * Version:           1.0.0
 * Author:            Alex Bracken
 * Author URI:        https://alexbracken.co
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

function post_meta_bindings_register_block_bindings_post_core_get_value( array $source_args, $block_instance ) {
	if ( empty( $source_args['key'] ) ) {
		return null;
	}
	
	if ( empty( $block_instance->context['postId'] ) ) {
		return null;
	}
	$post_id = $block_instance->context['postId'];
	
	// If a post isn't public, we need to prevent unauthorized users from accessing the post meta.
	$post = get_post( $post_id );
	if ( ( ! is_post_publicly_viewable( $post ) && ! current_user_can( 'read_post', $post_id ) ) || post_password_required( $post ) ) {
		return null;
	}
	
	switch( $source_args['key'] ) {
		case 'url':
			return get_permalink( $post_id );
		// Some more keys for example:
		case 'title':
			return get_the_title( $post_id );
		case 'excerpt':
			return get_the_excerpt( $post_id );
		case 'featured_image_url':
			return get_the_post_thumbnail_url( $post_id );
		case 'published_date':
			return get_the_date( '', $post_id );
		case 'modified_date':
			return get_the_modified_date( '', $post_id );
	}
	
	return null;
}

// Register Post Meta source in the block bindings registry.
add_action( 'init', function () {
	register_block_bindings_source(
		'post/meta-bindings',
		[
			'label'              => _x( 'Post meta bindings', 'block bindings source' ),
			'get_value_callback' => 'post_meta_bindings_register_block_bindings_post_core_get_value',
			'uses_context'       => [ 'postId' ],
		]
	);
} );
