<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


// let's create the function for the custom type
function custom_offer() { 
	// creating (registering) the custom type 
	register_post_type( 'offer', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Les offres de Uzful', ''), /* This is the Title of the Group */
			'singular_name' => __('Une offre', 'offer'), /* This is the individual type */
			'all_items' => __('Toutes les offres', ''), /* the all items menu item */
			'add_new' => __('Ajouter une nouvelle offre', 'uzfultheme'), /* The add new menu item */
			'add_new_item' => __('Ajouter uns offre à Uzful', 'uzfultheme'), /* Add New Display Title */
			'edit' => __( 'Editer', 'uzfultheme' ), /* Edit Dialog */
			'edit_item' => __('Editer cette offre', 'uzfultheme'), /* Edit Display Title */
			'new_item' => __('Nouvelle offre', 'uzfultheme'), /* New Display Title */
			'view_item' => __('Voir cette offre', 'uzfultheme'), /* View Display Title */
			'search_items' => __('Chercher une offre', 'uzfultheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Cette offre n\'a pas ete trouvée en base de données.', 'uzfultheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Cette offre n\'a pas ete trouvée dans la corbeille', 'uzfultheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Une offre qui sera affichée dans la partie dediée du site, et à laquelle des travaux pourront être reliés dans le Folio du site', 'uzfultheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'offres', 'with_front' => false ), /* you can specify it's url slug */
			'has_archive' => 'offres', /* you can rename the slug here */
			'capability_type' => 'post',
            'capabilities' => array(
                'publish_posts' => 'publish_offres',
                'edit_posts' => 'edit_offres',
                'edit_others_posts' => 'edit_others_offres',
                'delete_posts' => 'delete_offres',
                'delete_others_posts' => 'delete_others_offres',
                'read_private_posts' => 'read_private_offres',
                'edit_post' => 'edit_offre',
                'delete_post' => 'delete_offre',
                'read_post' => 'read_offre',
            ),
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
	//OUF mais obligatoire
    flush_rewrite_rules();
    
	/* this ads your post categories to your custom post type */
	//register_taxonomy_for_object_type('category', 'folio_work');
	/* this ads your post tags to your custom post type */
	//register_taxonomy_for_object_type('post_tag', 'folio_work');
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_offer');	


?>