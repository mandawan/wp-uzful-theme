<?php

//CUSTOM META BOX SOUS TITRE
add_action('add_meta_boxes','init_subtitle');
function init_subtitle(){
    //la méthode ci-dessous prévoit d'ajouter cette méta à des pages si besoin
    foreach (array('folio_work', 'extension', 'offer'/*,'page'*/) as $type)
    {
        add_meta_box('subtitle_box', 'Sous titre', 'setup_subtitle', $type);
    }
}

function setup_subtitle($post){
        
    echo '<div class="my_meta_control">';

    echo '  <input type="text" name="subtitle" size="30" tabindex="2" value="'.esc_attr( get_post_meta( $post->ID, '_meta_subtitle', true ) ).'" id="subtitle" autocomplete="off">';
        
    echo '</div>';

    echo '<input type="hidden" name="subtitle_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
    
}

add_action('save_post','save_subtitle');
function save_subtitle($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // authentication checks
     // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['subtitle_nonce'],__FILE__)) return $post_id;
 
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
    delete_post_meta($post_id, '_meta_subtitle');

    if(isset($_POST['subtitle']) && $_POST['subtitle'] != '')
    {       
        add_post_meta($post_id, '_meta_subtitle', $_POST['subtitle']);
    }
}

//CUSTOM META BOX RESUME
/* Define the custom box */
add_action( 'add_meta_boxes', 'init_custom_excerpt_box' );


function init_custom_excerpt_box() {
    foreach (array('folio_work', 'offer', 'extension'/*,'page'*/) as $type)
    {
        add_meta_box( 'custom_excerpt_wp_editor_box', 'Résumé riche', 'setup_custom_excerpt_box', $type );
    }
}


function setup_custom_excerpt_box( $post ) {

  // Use nonce for verification
  
  $field_value = get_post_meta( $post->ID, '_wp_editor_sum', true );
  wp_editor( $field_value, '_wp_editor_excerpt' );

  wp_nonce_field( plugin_basename( __FILE__ ), 'custom_excerpt_noncename' );
}

add_action( 'save_post', 'save_custom_excerpt_box' );

function save_custom_excerpt_box( $post_id ) {

    //error_log(DOING_AUTOSAVE);
    //error_log(DOING_AUTOSAVE);

    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!wp_verify_nonce( $_POST['custom_excerpt_noncename'], plugin_basename( __FILE__ ) )) return $post_id;

    // check user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
        //if (!current_user_can('edit_'.$_POST['post_type'], $post_id)) return $post_id;
    }

    // je supprime toutes les entrées pour cette meta
    delete_post_meta($post_id, '_wp_editor_sum');

    if(isset($_POST['_wp_editor_excerpt']))
    {       
        add_post_meta($post_id, '_wp_editor_sum', $_POST['_wp_editor_excerpt']);
    }

}


//CUSTOM META BOX URL HTTP
add_action('add_meta_boxes','init_url_related');
function init_url_related(){
    //la méthode ci-dessous prévoit d'ajouter cette méta à des pages si besoin
    foreach (array('folio_work', 'extension'/*,'page'*/) as $type)
    {
        add_meta_box('url_related_box', 'URL du projet', 'setup_url_related', $type, 'side');
    }
}

function setup_url_related($post){
        
    echo '<div class="my_meta_control">';

    echo '  <input type="text" name="url_related" size="30" tabindex="2" value="'.esc_attr( get_post_meta( $post->ID, '_work_url_related', true ) ).'" id="url_related" autocomplete="off">';
        
    echo '</div>';

    echo '<input type="hidden" name="url_related_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
    
}

add_action('save_post','save_url_related');
function save_url_related($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // authentication checks
     // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['url_related_nonce'],__FILE__)) return $post_id;
 
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
    delete_post_meta($post_id, '_work_url_related');

    if(isset($_POST['url_related']) && $_POST['url_related'] != '')
    {       
        add_post_meta($post_id, '_work_url_related', $_POST['url_related']);
    }
}

//CUSTOM META BOX PARTENAIRES
add_action('add_meta_boxes','init_rel_partners');
function init_rel_partners(){
    //la méthode ci-dessous prévoit d'ajouter cette méta à des pages si besoin
    foreach (array('folio_work', 'extension'/*,'page'*/) as $type)
    {
        add_meta_box('rel_partners_box', 'Partenaires liés au projet', 'setup_rel_partners', $type, 'normal');
    }
}

function setup_rel_partners($post){
    $cond = get_post_meta($post->ID,'rel_partners',false);
    echo '<p>Indiquez les partenaires ayant contribué à ce projet :</p>';
    //liste des employées
    $blogusers = get_users('role=partner');
    
    echo '<div class="my_meta_control">';

    echo '  <ul id="partners" class="tabs-panel">';
    
    foreach ($blogusers as $user) {
        //$user->user_email
        //$user->user_nicename
        //$user->ID
        echo '      <li><label><input type="checkbox" name="partners[]" '.check($cond,$user->ID).' value="'.$user->ID.'"" />'.$user->user_nicename.'</label></li>';
    }

    echo '  </ul>';
    
    echo '</div>';

    echo '<input type="hidden" name="rel_part_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
    
}

add_action('save_post','save_rel_partners');
function save_rel_partners($post_id){
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

    // authentication checks
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['rel_part_nonce'],__FILE__)) return $post_id;
 
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
        delete_post_meta($post_id, 'rel_partners');
        // et pour chaque conditionnement coché, j'ajoute une metadonnée
        foreach($_POST['partners'] as $c){
            add_post_meta($post_id, 'rel_partners', intval($c) );
        }
    }
}


?>
