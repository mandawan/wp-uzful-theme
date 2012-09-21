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
function custom_extention() { 
	
	// creating (registering) the custom type 
	register_post_type( 'extension', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Extensions corpo', ''), /* This is the Title of the Group */
			'singular_name' => __('Extension', 'extension'), /* This is the individual type */
			'all_items' => __('Toutes les extensions', ''), /* the all items menu item */
			'add_new' => __('Ajouter une nouvelle extension', 'uzfultheme'), /* The add new menu item */
			'add_new_item' => __('Ajouter uns extension à Uzful', 'uzfultheme'), /* Add New Display Title */
			'edit' => __( 'Editer', 'uzfultheme' ), /* Edit Dialog */
			'edit_item' => __('Editer cette extenion', 'uzfultheme'), /* Edit Display Title */
			'new_item' => __('Nouvelle extension', 'uzfultheme'), /* New Display Title */
			'view_item' => __('Voir cette extension', 'uzfultheme'), /* View Display Title */
			'search_items' => __('Chercher une extension', 'uzfultheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Cette extension n\'a pas ete trouvée en base de données.', 'uzfultheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Cette extension n\'a pas ete trouve dans la corbeille', 'uzfultheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Une extension qui sera affichée dans la partie dediée du site, et à laquelle des travaux pourront être reliés dans le Folio du site', 'uzfultheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'extensions', 'with_front' => false ), /* you can specify it's url slug */
			'has_archive' => 'extensions', /* you can rename the slug here */
			'capability_type' => 'post',
            'capabilities' => array(
                'publish_posts' => 'publish_extentions',
                'edit_posts' => 'edit_extentions',
                'edit_others_posts' => 'edit_others_extentions',
                'delete_posts' => 'delete_extentions',
                'delete_others_posts' => 'delete_others_extentions',
                'read_private_posts' => 'read_private_extentions',
                'edit_post' => 'edit_extention',
                'delete_post' => 'delete_extention',
                'read_post' => 'read_extention',
            ),
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'sticky'),
			'taxonomies' => array('post_tag') // this is IMPORTANT
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
	add_action( 'init', 'custom_extention');	

?>