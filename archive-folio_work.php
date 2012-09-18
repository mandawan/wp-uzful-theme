<?php
/*
Template Name: works index
*/
?>

<?php get_header(); 

$the_query = new WP_Query("post_type=folio_work&post_status=publish&posts_per_page=25");
?>
		
				<div id="inner-header" class="wrap clearfix">
						
					
					<div id="animation-home" class="clearfix  first">
					<h1>
						<div id="s1" class="title-block"> </div>
						<div id="s2" class="title-block">Les réalisation</div>
						<div id="s3" class="title-block blue">de uzful</div>
					</h1>

				</div> <!-- end animation -->															
					
				
				</div> <!-- end #inner-header -->

				
									
			</header> <!-- end header -->		

			<div id="content">		
				
				<div id="inner-content" class="wrap clearfix blog"> 

				    <div id="main" class="clearfix" role="main">

					    <?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
						    						    
						    //WHAT WE NEED -NO NATIVE- TO DYNAMICALLY GRAB
						    $myExtArr = get_post_meta($post->ID, '_work_rel_ext', false);
						    $myClientArr = get_post_meta($post->ID, '_work_rel_client', false);

						    if(count($myExtArr))
						    {
						    	$myPost_ext = get_post($myExtArr[0]);
						    	//var_dump($myPost_ext);
						    	$client_name = $myPost_ext->post_title;
						    } else if (count($myClientArr)){
						    	$myUser_client = get_user_by('id', $myClientArr[0]);
						    	$client_name = $myUser_client->display_name;
						    }

						    $offers = get_post_meta($post->ID, '_work_rel_offers', false);
						    
						    if($offers)
						    {
							    $args = array(
							    	'post_type' => 'offer',
							    	'post_status' => 'publish', 
							    	'post__in' => $offers, 
							    	'orderby' => 'title', 
							    	'order' => 'DESC' 
							    );
							    
							    $offers_query = new WP_Query($args);
				    		}
				    		$subtitle = esc_attr( get_post_meta( $post->ID, '_meta_subtitle', true ) );


						    ?>
						<a id="anchor-<?php the_ID(); ?>" name="<?php echo $post->post_name; ?>" data-title="<?php echo $post->post_title; ?>" data-sub="<?php echo $subtitle; ?>" class="anchor"></a>	
						<div data-fullcontent="<?php the_permalink(); ?>" rel="post-<?php the_ID(); ?>"></div>
					    <section id="sum-post-<?php the_ID(); ?>" <?php post_class('clearfix heightcol first'); ?> role="article">

						    <div class="head-wrapper sixcol first">
							    <div class="alignleft" ><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('uzful-thumb-180'); ?></a></div>

							    <div class="chapeau alignleft">

							    	<h2 class="h3"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									<p class="subtitle"><?php echo $subtitle ?></p>
							    	<p class="meta"><?php //_e('Posted', 'uzfultheme'); ?> Réalisé en <time datetime="<?php echo the_time('m-Y'); ?>" pubdate><strong><?php the_time('F Y'); ?></strong></time> pour <span class="client-name"><strong><?php echo $client_name; ?></strong></span></p>
							    	<a class="button-more button-cta plus " href="<?php bloginfo('siteurl'); ?>/works/"><span id="text">Découvrir ce projet</span><span id="plus"></span></a>
							    </div>
							</div>
							<?php //continue; ?>
						    <div class="offers twocol last">
						    		
						    <?php 

						    	$arch_post = $post;

						    	if (isset($offers_query) && $offers_query->have_posts()) {

						    		//var_dump($offers_query);
					    			while ($offers_query->have_posts()) {

					    				$offers_query->the_post();

					    				//var_dump($post);
					    				?>
					    				<a href="<?php the_permalink() ?>" rel="bookmark" class="image-link" title="<?php the_title_attribute(); ?>">
					    					<div class="img"><?php the_post_thumbnail('uzful-thumb-55'); ?></div>
					    					<div class="caption"><span><?php the_title_attribute(); ?></span></div>
					    				</a>
					    				<?php

					    			}

					    			// Reset Post Data
									wp_reset_postdata();
									$post = $arch_post;

					    		}

						    ?>
						    </div>
						    <!--<p><?php //_e('by', 'uzfultheme'); ?> <?php //the_author_posts_link(); ?> <span class="amp">&</span> <?php //_e('filed under', 'uzfultheme'); ?> <?php //the_category(', '); ?>.</p>-->
					

						    
    						<!--<p class="tags"><?php //the_tags('<span class="tags-title">Tags:</span> ', ', ', ''); ?></p>-->
						    
						    <?php // comments_template(); // uncomment if you want to use them ?>
					
					    </section> <!-- end article -->
					
					    <?php endwhile; ?>	
					
					        <?php if (function_exists('bones_page_navi')) { // if experimental feature is active ?>
						
						        <?php bones_page_navi(); // use the page navi function ?>
						
					        <?php } else { // if it is disabled, display regular wp prev & next links ?>
						        <nav class="wp-prev-next">
							        <ul class="clearfix">
								        <li class="prev-link"><?php next_posts_link(_e('&laquo; Older Entries', 'uzfultheme')) ?></li>
								        <li class="next-link"><?php previous_posts_link(_e('Newer Entries &raquo;', 'uzfultheme')) ?></li>
							        </ul>
						        </nav>
					        <?php } ?>		
					
					    <?php else : ?>
					    
					        <article id="post-not-found" class="hentry clearfix">
					            <header class="article-header">
					        	    <h1><?php _e("Oops, Post Not Found!", "uzfultheme"); ?></h1>
					        	</header>
					            <section class="post-content">
					        	    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "uzfultheme"); ?></p>
					        	</section>
					        	<footer class="article-footer">
					        	    <p><?php _e("This is the error message in the index.php template.", "uzfultheme"); ?></p>
					        	</footer>
					        </article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <?php //get_sidebar(); // sidebar 1 ?>

				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php 


//Reset Query
//wp_reset_query();


get_footer(); ?>
