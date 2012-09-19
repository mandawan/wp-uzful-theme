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
function custom_folio_work() { 
	// creating (registering) the custom type 
	register_post_type( 'folio_work', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Travaux', ''), /* This is the Title of the Group */
			'singular_name' => __('Travail', 'Folio Work'), /* This is the individual type */
			'all_items' => __('Tous les travaux', ''), /* the all items menu item */
			'add_new' => __('Ajouter un nouveau', 'uzfultheme'), /* The add new menu item */
			'add_new_item' => __('Ajouter un travail au folio', 'uzfultheme'), /* Add New Display Title */
			'edit' => __( 'Editer', 'uzfultheme' ), /* Edit Dialog */
			'edit_item' => __('Editer ce travail', 'uzfultheme'), /* Edit Display Title */
			'new_item' => __('Nouveau travail', 'uzfultheme'), /* New Display Title */
			'view_item' => __('Voir ce travail', 'uzfultheme'), /* View Display Title */
			'search_items' => __('Chercher des travaux', 'uzfultheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Ce travail n\'a pas ete trouve en base de donnees.', 'uzfultheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Ce travail n\'a pas ete trouve dans la corbeille', 'uzfultheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Un projet qui sera affiche dans la section Folio du site', 'uzfultheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */ 
            'show_in_admin_bar' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'works', 'with_front' => true ), /* you can specify it's url slug */
			'has_archive' => 'works', /* you can rename the slug here */
			'capability_type' => 'post',
            'capabilities' => array(
                'publish_posts' => 'publish_works',
                'edit_posts' => 'edit_works',
                'edit_others_posts' => 'edit_others_works',
                'delete_posts' => 'delete_works',
                'delete_others_posts' => 'delete_others_works',
                'read_private_posts' => 'read_private_works',
                'edit_post' => 'edit_work',
                'delete_post' => 'delete_work',
                'read_post' => 'read_work',
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

    wp_enqueue_style( 'admin_styles',  get_stylesheet_directory_uri() . '/library/css/admin.css' );
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_folio_work');
	

	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/


    
function custom_categories_works() { 
    // now let's add custom categories (these act like categories)
   register_taxonomy( 'work_cat', 
        array('folio_work'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
        array('hierarchical' => true,     /* if this is true it acts like categories */             
            'labels' => array(
                'name' => __( 'Categories de travaux', 'uzfultheme' ), /* name of the custom taxonomy */
                'singular_name' => __( 'Categorie de travaux', 'uzfultheme' ), /* single taxonomy name */
                'search_items' =>  __( 'Chercher des categories de travaux', 'uzfultheme' ), /* search title for taxomony */
                'all_items' => __( 'Toutes les categories de travaux', 'uzfultheme' ), /* all title for taxonomies */
                'parent_item' => __( 'Categorie de travaux parente', 'uzfultheme' ), /* parent title for taxonomy */
                'parent_item_colon' => __( 'Categorie de travaux parente:', 'uzfultheme' ), /* parent taxonomy title */
                'edit_item' => __( 'Editer la categorie de travaux', 'uzfultheme' ), /* edit custom taxonomy title */
                'update_item' => __( 'MAJ la categorie de travaux', 'uzfultheme' ), /* update title for taxonomy */
                'add_new_item' => __( 'Ajouter une nouvelle categorie de travaux', 'uzfultheme' ), /* add new title for taxonomy */
                'new_item_name' => __( 'Nom de la nouvelle categorie de travaux', 'uzfultheme' ) /* name title for taxonomy */
            ),
            'show_ui' => true,
            'query_var' => true,
        )
    );   
}

// adding the function to the Wordpress init
add_action( 'init', 'custom_categories_works');


//TODO:reste à ajouter la gestion des visuels attachés à un travail

//CUSTOM META BOX RESULTAT
/* Define the custom box */
add_action( 'add_meta_boxes', 'init_results_box' );


function init_results_box() {
    foreach (array('folio_work'/*,'page'*/) as $type)
    {
        add_meta_box( 'results_wp_editor_box', 'Résultats du projet', 'setup_results_box', $type );
    }
}


function setup_results_box( $post ) {

    // Use nonce for verification
    $field_value = get_post_meta( $post->ID, '_work_results', true );


    echo '<div class="my_meta_control">';

    echo '  <p class="description">Expliquez brièvement les résultats obtenus (compte tenu des objectifs) de ce projet :</p>';  

    wp_editor( $field_value, 'ta_work_results', array(
        'teeny' => true,
        'media_buttons' => false
        ));

    echo '<input type="hidden" name="result_noncename" value="' . wp_create_nonce(__FILE__) . '" />';    

    echo '</div>';

}

add_action( 'save_post', 'save_results_box' );

function save_results_box( $post_id ) {

    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce($_POST['result_noncename'],__FILE__)) return $post_id;

    // check user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_work', $post_id)) return $post_id;
    }
    // OK, we're authenticated: we need to find and save the data
    // je supprime toutes les entrées pour cette meta
    delete_post_meta($post_id, '_work_results');
    add_post_meta($post_id, '_work_results', $_POST['ta_work_results'] );    

}


//TODO:reste à ajouter la gestion des visuels attachés à un travail

//CUSTOM META BOX EMPLOYES
add_action('add_meta_boxes','init_rel_employees');
function init_rel_employees(){
    //la méthode ci-dessous prévoit d'ajouter cette méta à des pages si besoin
    foreach (array('folio_work'/*,'page'*/) as $type)
    {
        add_meta_box('rel_employees_box', 'Employés liés au projet', 'setup_rel_employees', $type);
    }
}

function setup_rel_employees($post){
    $cond = get_post_meta($post->ID,'_work_rel_emp',false);
    echo '<p>Indiquez les employés reliés à ce projet :</p>';
    //liste des employées
    $blogEmployees = get_users('role=employee');
    //liste des admins
    $blogAdmins = get_users('role=administrator');

    echo '<div class="my_meta_control">';

    echo '  <ul id="employees" class="tabs-panel">';
    
     foreach ($blogAdmins as $user) {
        //$user->user_email
        //$user->user_nicename
        //$user->ID
        echo '      <li><label><input type="checkbox" name="cond[]" '.check($cond,$user->ID).' value="'.$user->ID.'"" />'.$user->user_nicename.'</label></li>';
    }
    echo '      <li>------------------</li>';
    foreach ($blogEmployees as $user) {
        //$user->user_email
        //$user->user_nicename
        //$user->ID
        echo '      <li><label><input type="checkbox" name="cond[]" '.check($cond,$user->ID).' value="'.$user->ID.'"" />'.$user->user_nicename.'</label></li>';
    }

    echo '  </ul>';
    
    echo '</div>';

    echo '<input type="hidden" name="rel_emp_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
    
}

add_action('save_post','save_rel_employees');
function save_rel_employees($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // authentication checks
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['rel_emp_nonce'],__FILE__)) return $post_id;
 
    // check user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_work', $post_id)) return $post_id;
    }
 
    // authentication passed, save data
 


    if(isset($_POST['cond'])){
        // je supprime toutes les entrées pour cette meta
        delete_post_meta($post_id, '_work_rel_emp');
        // et pour chaque conditionnement coché, j'ajoute une metadonnée
        foreach($_POST['cond'] as $c){
            add_post_meta($post_id, '_work_rel_emp', intval($c) );
        }
    }
}

//CUSTOM META BOX OFFRES CORRELES
add_action('add_meta_boxes','init_rel_offers');
function init_rel_offers(){
    //la méthode ci-dessous prévoit d'ajouter cette méta à des pages si besoin
    foreach (array('folio_work'/*,'page'*/) as $type)
    {
        add_meta_box('rel_offers_box', 'Offres Uzful', 'setup_rel_offers', $type, 'side');
    }
}

function setup_rel_offers($post){
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'metas', get_stylesheet_directory_uri() . '/library/js/metas.js', array('jquery'), '1', true);
    wp_enqueue_style( 'admin_styles',  get_stylesheet_directory_uri() . '/library/css/admin.css' );
    
    $cond = get_post_meta($post->ID,'_work_rel_offers',false);

    echo '<div class="my_meta_control">';

    echo '  <p class="description">Indiquez la(les) offre(s) uzful dans lesquelles entrent ce projet :</p>';
    
    //liste des extensions
    $args = array( 'numberposts' => 1000, 'post_type' => 'offer' );
    $myposts = get_posts( $args );
    echo '  <ul id="offers" class="tabs-panel">';
    foreach ($myposts as $post) {
        //$user->user_email
        //$user->user_nicename
        //$user->ID
        echo '      <li><label><input type="checkbox" name="cond[]" '.check($cond,$post->ID).' value="'.$post->ID.'"" /> '.get_the_post_thumbnail($post->ID, 'uzful-thumb-55').$post->post_title.'</label></li>';
    }
    echo '  </ul>';

    echo '</div>';

    echo '<input type="hidden" name="rel_off_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
    
}

add_action('save_post','save_rel_offers');
function save_rel_offers($post_id){
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // authentication checks
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['rel_off_nonce'],__FILE__)) return $post_id;
 
    // check user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_work', $post_id)) return $post_id;
    }
 
    // authentication passed, save data
 


    if(isset($_POST['cond'])){
        // je supprime toutes les entrées pour cette meta
        delete_post_meta($post_id, '_work_rel_offers');
        // et pour chaque conditionnement coché, j'ajoute une metadonnée
        foreach($_POST['cond'] as $c){
            add_post_meta($post_id, '_work_rel_offers', intval($c) );
        }
    }
}

//CUSTOM META BOX DESTINATION : EXTENSION & CLIENT
add_action('add_meta_boxes','init_rel_ext');
function init_rel_ext(){
    //la méthode ci-dessous prévoit d'ajouter cette méta à des pages si besoin
    foreach (array('folio_work'/*,'page'*/) as $type)
    {
        add_meta_box('rel_ext_box', 'Extension OU client lié(e) au projet', 'setup_rel_ext', $type);
    }
}

function setup_rel_ext($post){
    //wp_enqueue_script('jquery');
    wp_enqueue_script( 'metas', get_stylesheet_directory_uri() . '/library/js/metas.js', array('jquery'));
    
    $exts = get_post_meta($post->ID,'_work_rel_ext',false);
    $clients = get_post_meta($post->ID,'_work_rel_client',false);

    echo '<div class="my_meta_control">';

    echo '  <p class="description">Indiquez la(les) extension(s) à l\'origine de ce projet :</p>';
    
    var_dump($exts);

    //liste des extensions
    $args = array( 'numberposts' => 1000, 'post_type' => 'extension' );
    $myposts = get_posts( $args );

    echo '  <ul id="extensions" class="tabs-panel">';
   
    foreach ($myposts as $post) {
        
        echo '      <li><label><input type="checkbox" name="cond_ext[]" '.check($exts,$post->ID).' value="'.$post->ID.'"" /> '.$post->post_title.'</label></li>';

    }
    echo '  </ul>';

    echo '  <p class="big">OU</p>';

    echo '  <p class="description">Indiquez le(s) client(s) a l\'origine de ce projet :</p>';

    //liste des clients   
    var_dump($clients);
    $myClients = get_users('role=client');
    
    echo '  <ul id="clients" class="tabs-panel">';
    
    foreach ($myClients as $user) {
    
        echo '      <li><label><input type="checkbox" name="cond_client[]" '.check($clients,$user->ID).' value="'.$user->ID.'"" /> '.$user->user_nicename.'</label></li>';
        
    }
    echo '  </ul>';

    echo '  <input type="hidden" name="rel_ext_nonce" value="' . wp_create_nonce(__FILE__) . '" />';

    echo '</div>';
    
}

add_action('save_post','save_rel_ext');
function save_rel_ext($post_id){
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // authentication checks
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['rel_ext_nonce'],__FILE__)) return $post_id;
 
    // check user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_work', $post_id)) return $post_id;
    }
 
    // authentication passed, save data
 
    // je supprime toutes les entrées pour cette meta
    delete_post_meta($post_id, '_work_rel_ext');
    delete_post_meta($post_id, '_work_rel_client');

    if(isset($_POST['cond_ext'])){

        // et pour chaque conditionnement coché, j'ajoute une metadonnée
        foreach($_POST['cond_ext'] as $c){
            add_post_meta($post_id, '_work_rel_ext', intval($c) );
        }
    }
    if(isset($_POST['cond_client']))
    {
        foreach($_POST['cond_client'] as $c){
            add_post_meta($post_id, '_work_rel_client', intval($c) );
        }
    }
}

//NOTE: la methode de sauvegarde des métas en commentaire ci-dessous est très propre, as systématiser

/*  
function rel_emp_metas_save($post_id)
{
    // authentication checks
 
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['rel_emp_nonce'],__FILE__)) return $post_id;
 
    // check user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_work', $post_id)) return $post_id;
    }
 
    // authentication passed, save data
 
    // var types
    // single: _my_meta[var]
    // array: _my_meta[var][]
    // grouped array: _my_meta[var_group][0][var_1], _my_meta[var_group][0][var_2]
 
    $current_data = get_post_meta($post_id, 'rel_emp_meta', TRUE); 
  
    $new_data = $_POST['rel_emp_meta'];
 
    metas_clean($new_data);
     
    if ($current_data)
    {
        if (is_null($new_data)) delete_post_meta($post_id,'rel_emp_meta');
        else update_post_meta($post_id,'rel_emp_meta',$new_data);
    }
    elseif (!is_null($new_data))
    {
        add_post_meta($post_id,'rel_emp_meta',$new_data,TRUE);
    }
 
    return $post_id;
}
 
function metas_clean(&$arr)
{
    if (is_array($arr))
    {
        foreach ($arr as $i => $v)
        {
            if (is_array($arr[$i]))
            {
                metas_clean($arr[$i]);
 
                if (!count($arr[$i]))
                {
                    unset($arr[$i]);
                }
            }
            else
            {
                if (trim($arr[$i]) == '')
                {
                    unset($arr[$i]);
                }
            }
        }
 
        if (!count($arr))
        {
            $arr = NULL;
        }
    }
}
 

*/


// NOTE: FUNCTION POOL
    
    

    // cette fonction me sert à inscrire checked, si jamais la valeur est coché
    function check($cible,$test){
        if(in_array($test,$cible)){return 'checked';}
    }

return;
	// now let's add custom tags (these act like tags)
    register_taxonomy( 'custom_tag', 
    	array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => false,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Custom Tags', 'uzfultheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Custom Tag', 'uzfultheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Custom Tags', 'uzfultheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Custom Tags', 'uzfultheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Custom Tag', 'uzfultheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Custom Tag:', 'uzfultheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Custom Tag', 'uzfultheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Custom Tag', 'uzfultheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Custom Tag', 'uzfultheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Custom Tag Name', 'uzfultheme' ), /* name title for taxonomy */
    			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 


    		),
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); 
    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */
	

?>
