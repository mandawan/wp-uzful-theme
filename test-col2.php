<?php
/*
Template Name: test col
*/
?>

<?php get_header(); 
?>
			
				<div id="inner-header" class="wrap clearfix">
					
					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php //bloginfo('name'); ?></a></p>
														
					
				
				</div> <!-- end #inner-header -->
			
			</header> <!-- end header -->			

			<div id="content">
			
				<div id="inner-content" class="wrap clearfix" style="border: 1px solid; ">
			
				    <div id="main" class="onecol first black" role="main">
				    </div> <!-- end #main -->
    				
				    <div id="main" class="onecol white" role="main">
				    </div> <!-- end #main -->

				    <div id="main" class="onecol black" role="main">
				    </div> <!-- end #main -->

				    <div id="main" class="onecol white" role="main">
				    </div> <!-- end #main -->

				    <div id="main" class="onecol black" role="main">
				    </div> <!-- end #main -->
    				
				    <div id="main" class="onecol white" role="main">
				    </div> <!-- end #main -->
				    
				    <div id="main" class="onecol black" role="main">
				    </div> <!-- end #main -->

				    <div id="main" class="onecol last white" role="main">
				    </div> <!-- end #main -->
				    
				</div> <!-- end #inner-content -->

				<div id="inner-content" class="wrap clearfix" style="border: 1px solid; ">
			
				    <div id="main" class="sixcol first white" role="main">
				    </div> <!-- end #main -->
    				  
				    <div id="main" class="twocol black" role="main">
				    </div> <!-- end #main -->

				    
				    </div> <!-- end #main -->
				    
<ul id="membersList">
<?php
	$blogusers = get_users('role=employee');
    foreach ($blogusers as $user) {
        echo '<li>' . $user->user_email . '</li>';
        echo '<li>' . $user->user_nicename . '</li>';
        echo '<li>' . $user->ID . '</li>';      
    }
?>
</ul>
				</div> <!-- end #inner-content -->



    			<div id="inner-content" class="wrap clearfix" style="border: 1px solid; ">

    				<p class="highlight">
    					Four loko flexitarian twee, street art tumblr echo park dreamcatcher carles messenger bag authentic. Odd future sriracha twee pop-up, forage PBR iphone master cleanse photo booth ethical mustache keffiyeh. 
    				</p>

    			</div> <!-- end #inner-content -->

			</div> <!-- end #content -->



<?php get_footer(); ?>
