<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

//Class CutomMetaBoxes 
//require_once('lib/metabox/init.php'); // CUSTOM META BOXES

/*
1. library/bones.php
    - head cleanup (remove rsd, uri links, junk css, ect)
	- enqeueing scripts & styles
	- theme support functions
    - custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bones.php'); // if you remove this, bones will break


//FOLIO WORK CUSTOM POST TYPE
require_once('library/folio-post-type.php');

//EXTENSION CUSTOM POST TYPE
require_once('library/extension-post-type.php');

//OFFER CUSTOM POST TYPE
require_once('library/offer-post-type.php');

//USER EXTRA PROPERTIES
require_once('library/user-profile-extras.php');

//CUSTOM ROLES
require_once('library/custom-roles.php');

//MIXINS EXTENDED ADMIN FEATURES
require_once('library/mixins-extended-admin.php');

/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
    - adding support for other languages
*/
require_once('library/translation/translation.php'); // this comes turned off by default


/************* MULTIPLE POST THUMBNAILS REGISTRATION FOR ALL TYPE *************/

if (class_exists('MultiPostThumbnails')) {
    $types = array('folio_work', 'extension', 'offer');
    foreach($types as $type) {
        new MultiPostThumbnails(array(
            'label' => 'Secondary Image',
            'id' => 'secondary-image',
            'post_type' => $type
            )
        );
    }
}


/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'uzful-thumb-700', 730, 400, true );
add_image_size( 'uzful-thumb-480', 480, 300, false );
add_image_size( 'uzful-thumb-355', 355, 240, false );
add_image_size( 'uzful-thumb-230', 230, 9999, false );
add_image_size( 'uzful-thumb-180', 180, 100, true );
add_image_size( 'uzful-thumb-72', 72, 72, true );
add_image_size( 'uzful-thumb-55', 55, 55, true );
/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image, 
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/


/************* OUR SCRIPTS AND STYLES *****************/

add_action('wp_enqueue_scripts', 'uzful_scripts_and_styles', 998);

function uzful_scripts_and_styles ()
{
    //error_log('uzful_scripts_and_styles');
    //if (is_admin()) { return; }
        

    //TODO tout repasser en register + enqueue + tester de déplacer un max de trucs depuis bones.php vers ici.
    wp_register_script( 'jquery-ui', get_stylesheet_directory_uri() . '/library/js/libs/jquery-ui.js', array('jquery'), '', true );
    wp_register_script( 'jquery-easing', get_stylesheet_directory_uri() . '/library/js/libs/jquery.easing.1.3.js', array('jquery'), '1.3', true );
    wp_register_script( 'jquery-transit', get_stylesheet_directory_uri() . '/library/js/libs/jquery.transit.min.js', array('jquery'), '', true );
    wp_register_script( 'debounce', get_stylesheet_directory_uri() . '/library/js/libs/jquery.debounce.js', array('jquery'), '', true );
    wp_register_script( 'gmaps', 'http://maps.google.com/maps/api/js?sensor=false', '', true );
    wp_register_script( 'jquery-waypoints', get_stylesheet_directory_uri() . '/library/js/libs/waypoints.min.js', array('jquery'), '1.1.7', true );
    wp_register_script( 'jquery-infinite-carousel', get_stylesheet_directory_uri() . '/library/js/libs/jquery.inifinite-carousel.js', array('jquery'), '1.0', true );
    //TODO remove this if unused
    wp_register_script( 'jquery-fred-carousel', get_stylesheet_directory_uri() . '/library/js/libs/jquery.carouFredSel-5.6.4-packed.js', array('jquery'), '5.6.4', true );
    wp_register_script( 'jquery-touchwipe', get_stylesheet_directory_uri() . '/library/js/libs/jquery.touchwipe.min.js', array('jquery'), '1.1.1', true );

    //AntiScroll Bar
    wp_enqueue_script( 'mousewheel-script', get_stylesheet_directory_uri() . '/library/js/libs/jquery-mousewheel.js', array('jquery'), '', true);
    wp_enqueue_script( 'antiscroll-script', get_stylesheet_directory_uri() . '/library/js/libs/antiscroll.js', array('jquery', 'mousewheel-script'), '', true);
    
    //Masonry
    wp_enqueue_script( 'masonry-script', get_stylesheet_directory_uri() . '/library/js/libs/masonry.js', array('jquery'), '2.1.05', true);
    
    //imported by style.less @ the bottom of it
    wp_register_style( 'antiscroll-stylesheet', get_stylesheet_directory_uri() . '/library/css/antiscroll.css', array(), '', 'screen' );
    wp_enqueue_style('antiscroll-stylesheet');


    //For AJAXED theming
    wp_enqueue_script( 'hashchange', get_stylesheet_directory_uri() . '/library/js/libs/jquery.ba-hashchange.min.js', array('jquery'), '', true);
    wp_enqueue_script( 'jquery-session', get_stylesheet_directory_uri() . '/library/js/libs/jquery.session.js', array('jquery'), '', true);
    wp_enqueue_script( 'jquery-cookie', get_stylesheet_directory_uri() . '/library/js/libs/jquery.cookie.js', array( 'jquery' ), '', true);

    wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/library/js/libs/jquery.scrollTo.js', array('jquery'), '1.4.3.1', true);    
    wp_enqueue_script( 'ajax-history', get_stylesheet_directory_uri() . '/library/js/myHistory.js', array( 'hashchange', 'jquery', 'bones-js', 'debounce', 'jquery-cookie', 'jquery-session', 'jquery-transit' ), '1.0', true);   
    wp_enqueue_script( 'ajax-nav', get_stylesheet_directory_uri() . '/library/js/navigation.js', array( 'hashchange', 'jquery', 'bones-js', 'jquery-easing', 'debounce', 'jquery-cookie', 'jquery-session', 'jquery-transit', 'ajax-history', 'jquery-waypoints' ), '1.0', true);   
    wp_enqueue_script( 'gmaps');
    //
    
}



/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Sidebar 1',
    	'description' => 'The first (primary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    
    Just change the name to whatever your new
    sidebar's id is, for example:
    
    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => 'Sidebar 2',
    	'description' => 'The second (secondary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php
    
    */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			    <?php /*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */ ?>
			    <!-- custom gravatar call -->
			    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>&s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'uzfultheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Your comment is awaiting moderation.', 'uzfultheme') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
    $form = '<div id="search-form-wrap" class="clearfix">
    <form role="search" method="get" id="searchform" action="'. home_url() .'" /">
    <div id="search-box" class="clearfix">
    <input class="search" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Que cherches-tu ?..."/>
    <button id="search-button" class="submit image-replacement" type="submit"><span>Rechercher</span></button>
    </div>
    </form>
    </div>';

    return $form;
} // don't remove this bracket!


/************* AJAXED NAVIGATION SYSTEM *****************/

//add_filter('post_link', 'ajaxed_links');
add_filter('the_permalink', 'ajaxed_links');
add_filter('tag_link ', 'ajaxed_links');
add_filter('category_link', 'ajaxed_links');
add_filter('page_link', 'ajaxed_links');
add_filter('post_type_archive_link', 'ajaxed_links');

// Regex based links transformation function
function ajaxed_links($fullLink){
    //error_log("ajaxed -> ".$fullLink);
    $ndd = get_bloginfo('url');
    $ancre = str_replace($ndd,'',$fullLink); //on décompose
    return $ndd.'/#!'.$ancre; //on recompose
}

function un_ajaxed_links($fullLink){
    error_log("unajaxed -> ".$fullLink);
    $ndd = get_bloginfo('url').'/#!';
    $ancre = str_replace($ndd,'',$fullLink); //on décompose

    error_log("unajaxed -> ".$ancre);
    return $ndd.$ancre; //on recompose
}

// Enable indexing by treating links that already pointed to an anchor
function remove_more_jump_link($link) {
    $offset = strpos($link, '#more-');
    if ($offset) {
    $end = strpos($link, '"',$offset);
    }
    if ($end) {
    $link = substr_replace($link, '', $offset, $end-$offset);
    }
    return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

/************* SOME ADMIN PANEL CUSTOM / REMOVE USELESS O DANGEROUS STuFF *****************/

function remove_editor_menu() {
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}

add_action('_admin_menu', 'remove_editor_menu', 1);


/************* CUSTOM RSS FEED *****************/

function myfeed_request($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        // on ajoute ici les "custom types" de post qu'on souhaite voir dans le flux rss -> posts et boulots du folio
        //TODO: mieux former le flux rss si on grp folio + blog, sinon distinguer deux fluex RSS ?
        $qv['post_type'] = array('post', 'folio_work');
    return $qv;
}
add_filter('request', 'myfeed_request');

/************ UTILS ******************/

/**
 * Adding a checkbox to the attachment edition panel
 * checked = display attachement image, title and caption to home as a push
 *
 * @param array $form_fields
 * @param object $post
 * @return array
 */
function _is_pushed_to_home_fields_to_edit($form_fields, $post) {
    //we use this variable to set whether or not the checkbox is currently checked
    //defaults to not being checked
    $checked = get_post_meta($post->ID, "is_pushed_to_home", true) ? "CHECKED" : "";
    
    //to add a field to the form, there are a few values to set here
    //label: the label of the field being output
    //input: the type of input being output - can use 'html' as value for more custom control
    //value: the current value of the input
    //helps: the descriptive text shown below the field
    //html: the custom html to use for a field if input is set to 'html' (see: 'ik_is_hero')
    $form_fields["url_to_push"] = array(
        "label" => __("URL to push on home page"),
        'input' => "text",
        "value" => get_post_meta($post->ID, "url_to_push", true),
        "helps" => __("If checked, this image will show in the widget."),
    );

    $form_fields["is_pushed_to_home"] = array(
        "label" => __("Show it as a push on home page"),
        'input' => 'html',
        'html'  => "<input type='checkbox'
                name='attachments[{$post->ID}][is_pushed_to_home]'
                id='attachments[{$post->ID}][is_pushed_to_home]'
                        value='1' {$checked}/><br />",
        "helps" => __("If checked, this image will show in the widget with its Title, caption, and description, it will be clickable to your URL too."),
    );
 
   return $form_fields;
}
 
// now attach our function to the hook
add_filter("attachment_fields_to_edit", "_is_pushed_to_home_fields_to_edit", null, 2);

function _is_pushed_to_home_fields_to_save($post, $attachment) {
    global $wpdb;
    //there can be only one attachment pushed to the home, we unpush any already pushed attachment
    $wpdb->query( 
        $wpdb->prepare("UPDATE wp_postmeta SET meta_value = 0 WHERE meta_key = 'is_pushed_to_home' AND meta_value = 1"
        )
    );

    if( isset($attachment['url_to_push']) ){
        update_post_meta($post['ID'], 'url_to_push', $attachment['url_to_push']);
    }

    //for the checkbox we save the value if it's currently checked
    //if it's not checked there won't be a value set, so we set it to '0'
    if( isset($attachment['is_pushed_to_home']) ){
        update_post_meta($post['ID'], 'is_pushed_to_home', $attachment['is_pushed_to_home']);
    } else {
        update_post_meta($post['ID'], 'is_pushed_to_home', 0);
    }
    

    $postID = $post['ID'];
    $res = $wpdb->get_results( "UPDATE options SET value = $postID WHERE name = 'pushed_attachement_id'");

    //error_log($res);

    return $post;
}
 
// now attach our function to the hook
add_filter("attachment_fields_to_save", "_is_pushed_to_home_fields_to_save", null , 2);


function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

//add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );


function obfuscate_email($email, $encode = 1, $reverse = 0, $before = '<span class="email">', $after = '</span>') {
 $output = '';
 if ($reverse) {
  $email = strrev($email);
  $output = $before;
 }
 if ($encode) {
  for ($i = 0; $i < (strlen($email)); $i++) {
   $output .= '&#' . ord($email[$i]) . ';';
  }  
 } else {
  $output .= $email;
 }
 if ($reverse) {
  $output .= $after;
 }
 return $output;
}

function get_attachment_id_from_src ($image_src) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid LIKE '%$image_src%' LIMIT 1";
        $id = $wpdb->get_var($query);
        return $id;
}

// cette fonction me sert à inscrire checked, si jamais la valeur est coché
function check($cible,$test){
    if(in_array($test,$cible)){return 'checked';}
}
function check2($value){
    if($value OR $value == 'true' OR $value == 1 OR $value == '1'){return 'checked';}
}
?>
