<?php

add_filter('user_contactmethods', 'extra_contact_info');  

function extra_contact_info($user_contactmethods){  
  
  unset($user_contactmethods['yim']);  
  unset($user_contactmethods['aim']);  
  unset($user_contactmethods['jabber']);  
  
  $user_contactmethods['twitter'] = 'Twitter Username';  
  $user_contactmethods['facebook'] = 'Facebook Profile URL (or fanpage)';  
  $user_contactmethods['gplus'] = 'Google plus profile URL';  
  $user_contactmethods['linkedin'] = 'Linkedin plus profile URL';  
  $user_contactmethods['viadeo'] = 'Viadeo plus profile URL';  
  $user_contactmethods['skype'] = 'Skype plus profile URL';  
  
  
  return $user_contactmethods;  
}  

//THUMBNAIL PAR DEFAUT
add_filter( 'post_thumbnail_html', 'my_post_thumbnail_html' );

function my_post_thumbnail_html( $html ) {

    if ( empty( $html ) )
        $html = '<img src="' . trailingslashit( get_stylesheet_directory_uri() ) . 'images/default-thumbnail.png' . '" alt="" />';

    return $html;
}



// FUNCTION POOL
// ( functions to create extra profile features... ok )


// let's create the function for the custom user profile
function my_show_extra_profile_fields($user) { 

$user_roles = $user->roles;

if($user_roles[0]=='subscriber') return false;

?>

	<h3>Extra profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="twitter">Twitter</label></th>

			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter profile url.</span>
			</td>
		</tr>


		<tr>
			<th><label for="facebook">Facebook</label></th>

			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your facebook profil url.</span>
			</td>
		</tr>		

		<tr>
			<th><label for="gplus">G+</label></th>

			<td>
				<input type="text" name="gplus" id="gplus" value="<?php echo esc_attr( get_the_author_meta( 'gplus', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Google plus profile url.</span>
			</td>
		</tr>	

		<tr>
			<th><label for="linkedin">Linkedin</label></th>

			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your linkedin profile's url.</span>

			</td>
		</tr>

		<tr>
			<th><label for="viadeo">Viadeo</label></th>

			<td>
				<input type="text" name="viadeo" id="viadeo" value="<?php echo esc_attr( get_the_author_meta( 'viadeo', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Viadeo profile's url.</span>

			</td>
		</tr>	

		<tr>
			<th><label for="skype">Skype</label></th>

			<td>
				<input type="text" name="skype" id="skype" value="<?php echo esc_attr( get_the_author_meta( 'skype', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your skype nickname.</span>

			</td>
		</tr>		

	</table>
<?php 
echo '<input type="hidden" name="myuser_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
}

	// adding the function to the Wordpress creation & edition procedure
	//add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
	//add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	 // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['myuser_nonce'],__FILE__)) return $post_id;

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	delete_user_meta($user_id, 'twitter');
	delete_user_meta($user_id, 'linkedin');
	delete_user_meta($user_id, 'viadeo');
	delete_user_meta($user_id, 'facebook');
	delete_user_meta($user_id, 'gplus');
	delete_user_meta($user_id, 'skype');

	if(isset($_POST['twitter']) && $_POST['twitter'] != '')
	{
		//code copied from wp-admin/includes/user.php
		$url = esc_url_raw( $_POST['twitter'] );
   		$url = preg_match('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is', $url) ? $url : 'http://'.$url;

        add_user_meta( $user_id, 'twitter', $url);
	}

        
    if(isset($_POST['linkedin']) && $_POST['linkedin'] != '')
	{
		//code copied from wp-admin/includes/user.php
		$url = esc_url_raw( $_POST['linkedin'] );
   		$url = preg_match('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is', $url) ? $url : 'http://'.$url;

        add_user_meta( $user_id, 'linkedin', $url);
	}

	if(isset($_POST['viadeo']) && $_POST['viadeo'] != '')
	{
		//code copied from wp-admin/includes/user.php
		$url = esc_url_raw( $_POST['viadeo'] );
   		$url = preg_match('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is', $url) ? $url : 'http://'.$url;

        add_user_meta( $user_id, 'viadeo', $url);
	}

	if(isset($_POST['facebook']) && $_POST['facebook'] != '')
	{
		//code copied from wp-admin/includes/user.php
		$url = esc_url_raw( $_POST['facebook'] );
   		$url = preg_match('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is', $url) ? $url : 'http://'.$url;

        add_user_meta( $user_id, 'facebook', $url);
	}

	if(isset($_POST['gplus']) && $_POST['gplus'] != '')
	{
		//code copied from wp-admin/includes/user.php
		$url = esc_url_raw( $_POST['gplus'] );
   		$url = preg_match('/^(https?|ftps?|mailto|news|irc|gopher|nntp|feed|telnet):/is', $url) ? $url : 'http://'.$url;

        add_user_meta( $user_id, 'gplus', $url);
	}

	if(isset($_POST['skype']) && $_POST['skype'] != '')
	{
		add_user_meta( $user_id, 'skype', $_POST['skype']);
	}	
	
}
	
	// adding the function to the Wordpress profile saving procedure
	//add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
	//add_action( 'personal_options_update', 'my_save_extra_profile_fields' );

?>