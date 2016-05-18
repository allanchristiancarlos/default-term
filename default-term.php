<?php
/*
Plugin Name: Default Term
Plugin URI: https://github.com/allanchristiancarlos/default-term
Description: Allows you to set the default term of a taxonomy
Version: 0.0.1
Author: Allan Christian Carlos
Author URI: https://github.com/allanchristiancarlos
License: GPL2
Text Domain: default-term
*/

/**
 * Installs the default taxonomy default terms
 * @return void 
 */
function default_term_install_terms()
{
	global $wp_taxonomies;

	// Loop through all taxonomies registered
	foreach( $wp_taxonomies as $taxonomy_name => $taxonomy )
	{
		// Check if it has settings
		if (!isset($taxonomy->default_term)) 
		{
			continue;
		}

		$term = $taxonomy->default_term;

		// Check if the term already exists
		if ($id = term_exists( $term, $taxonomy_name )) 
		{
			update_option( 'default_' . sanitize_key( $taxonomy_name ), $id['term_id'] );

			continue;
		}

		$slug = isset($taxonomy->default_term_slug) ? $taxonomy->default_term_slug : $term;

		// if it doesnt exists insert it
		$term = wp_insert_term( $term, $taxonomy_name, array(
			'slug' => sanitize_title( $slug )
		));

		if (is_wp_error($term)) 
		{
			continue;
		}

		update_option( 'default_' . sanitize_key( $taxonomy_name ), $term['term_id'] );
	}
}


/**
 * Removes the delete link when in the list of taxonomy
 * in the admin area
 * @return void
 */
function default_term_remove_delete_link()
{
	global $wp_taxonomies,$wp_post_types;

	foreach ($wp_taxonomies as $taxonomy_name => $taxonomy) 
	{
		// Check if it has settings
		if (!isset($taxonomy->default_term)) 
		{
			continue;
		}
		
		add_filter( $taxonomy_name . '_row_actions', create_function('$actions, $term', '
			if($term->term_id != default_term_get_default_term(\''. $taxonomy_name .'\'))
			{
				return $actions;
			}
			
			unset($actions["delete"]);

			return $actions;
		'), 10, 2 );
	}

	// Customize the saving of the posts in the admin
	add_action( 'save_post', 'default_term_save_post', 99999, 3 );
}

add_action( 'admin_init', 'default_term_remove_delete_link' );


/**
 * Hook save post to save the default terms to the post
 * @param  int $post_id The id of the post
 * @param  WP_Post $post    The post object
 * @param  boolean $update  Whether the post is an update or new post
 * @return void
 */
function default_term_save_post($post_id, $post, $update)
{
	global $wp_taxonomies, $wp_posttypes;

	// Means post is not submmited
	if (empty($_POST)) 
	{
		return;
	}

	foreach ((array)$_POST['tax_input'] as $taxonomy_name => $values) 
	{
		$taxonomy = get_taxonomy( $taxonomy_name );

		if (COUNT(array_filter($values)) > 0) 
		{
			continue;
		}

		$default_term = default_term_get_default_term( $taxonomy_name );

		// If there is no default term then don't to anything
		if (empty($default_term)) 
		{
			continue;
		}

		if (!$taxonomy->hierarchical) 
		{
			$term = get_term( $default_term, $taxonomy_name );

			if (is_wp_error($term)) 
			{
				continue;
			}

			$default_term = $term->name;
		}

		// Don't force default term if the post is just an update
		if ($post->post_modified != $post->post_date && isset($taxonomy->default_term_force) && !$taxonomy->default_term_force) 
		{
			continue;
		}

		// Else asign the default term if the post has no taxonomy terms.
		wp_set_post_terms( $post_id, $default_term, $taxonomy_name );
	}
}


/**
 * Gets the default term id of the taxonomy
 * @param  string $taxonomy_name The slug of the taxonomy
 * @return int                
 */
function default_term_get_default_term($taxonomy_name)
{
	return get_option('default_' . sanitize_key( $taxonomy_name ));
}


/**
 * Installs the default taxonomy terms when the plugin is activated
 * @return void
 */
function default_term_activation()
{
	default_term_install_terms();
}

register_activation_hook( __FILE__, 'default_term_activation' );

