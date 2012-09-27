<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>
			
					<div id="inner-header" class="wrap clearfix">
						test4		
						<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
						<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php //bloginfo('name'); ?></a></p>
															
						<h1 class="single-title"><span class="light-grey">Les réalisations</span> <br/>de Uzful</h1>
					
					</div> <!-- end #inner-header -->

				</nav> <!-- end nav -->			
			
			</header> <!-- end header -->
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="clearfix" role="main">

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

							<header class="article-header clearfix">
							
							    <?php 

							    //WHAT WE NEED -NO NATIVE- TO DYNAMICALLY GRAB

							     //CLIENT OU EXTENSION COMMANDITAIRE CE PROJET
							    $relclient = get_post_meta($post->ID, '_work_rel_client', false);
							    if(count($relclient))
							    	$relclient = $relclient[0];
							    
							    $client = get_user_by('id', $relclient);


							    if(!$client)
							    {
							    	$relExt = get_post_meta($post->ID, '_work_rel_ext', false);
							    	if(count($relExt))
							    		$relExt = $relExt[0];
							    	$myExt = get_post($relExt);
							    	$client_name = $myExt->post_title;
							    	$client_id = $myExt->ID;
							    }
							    else
							    {
							    	$client_name = $client->user_nicename;	
							    	$client_id = $client->ID;
							    }

							    //LES OFFRES LIEES A CE PROJET
							    $offers_ids = get_post_meta($post->ID, '_work_rel_offers', false);
							    
							    if($offers_ids)
							    {
									    $args = array(
								    	'post_type' => 'offer',
								    	'post_status' => 'publish', 
								    	'post__in' => $offers_ids, 
								    	'orderby' => 'title', 
								    	'order' => 'DESC' 
								    );
								    
								    $offers_query = new WP_Query($args);
					    		}

					    		//LES EMPLOYES LIES A CE PROJET
					    		$employee_ids = get_post_meta($post->ID, '_work_rel_emp', false);
							    
							    if($employee_ids)
							    {
									$args1 = array(
										'include' => $employee_ids,
										'role=employee'
										);

								    
								    $employees = get_users($args1);
								    //var_dump($partners);
					    		}

					    		//LES PARTENAIRES LIES A CE PROJET
					    		$partners_ids = get_post_meta($post->ID, 'rel_partners', false);
							    								
							    if($partners_ids)
							    {
									$args2 = array(
										'include' => $partners_ids,
										'role=partner'
										);

								    
								    $partners = get_users($args2);
								    //var_dump($partners);
					    		}


							    ?>
							    <div class="head-wrapper sixcol first">
								    <div class="alignleft clearfix">

								    	<h2 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
										<p class="subtitle"><?php echo esc_attr( get_post_meta( $post->ID, '_meta_subtitle', true ) ); ?></p>							    	
										<p><?php //_e('Posted', 'uzfultheme'); ?> Réalisation en <time datetime="<?php echo the_time('m-Y'); ?>" pubdate><?php the_time(get_option('date_format')); ?> </time> pour <?php echo $client_name; ?></p>										

								    </div>
								</div>
							    <div class="offers twocol last">
							    		
							    <?php 
							    	//on stocke le post de la boucle globale
							    	$myPost = $post;

							    	if (isset($offers_query) && $offers_query->have_posts()) {
							    		//var_dump($offers_query);
						    			while ($offers_query->have_posts()) {
						    				$offers_query->the_post();

						    				//var_dump($post);
						    				?>
						    				<a href="<?php the_permalink() ?>" class="image-link alignleft" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('uzful-thumb-55'); ?></a>
						    				<?php
						    			}
						    			// Reset Post Data
										wp_reset_postdata();
						    		}

						    		//on repointe vers le post de la boucle globale
							    	$post = $myPost;						    		
							    ?>
							    </div><!-- end offers -->
							    <?php //_e('by', 'uzfultheme'); ?> <?php //the_author_posts_link(); ?> <!--<span class="amp">&</span> --> <?php //_e('filed under', 'uzfultheme'); ?> <?php //the_category(', '); ?>
						
						    </header> <!-- end article header -->
					
						    <section class="post-content" >
						    	<div id="chapeau" class="sixcol first post-content" >
						    		<?php echo MultiPostThumbnails::the_post_thumbnail('folio_work', 'secondary-image', NULL,  'uzful-thumb-700'); ?>
						    		<div id="sum" class="resume clearfix">
									    <?php 
									    
									    	$sum =  get_post_meta( $post->ID, '_wp_editor_sum', true );
									    	echo $sum;

									    ?>
									</div><!-- end  sum -->
						    	</div><!-- end  chapeau -->

						    	<div id="ressources" class="twocol last">
						    		<h3>Les gens qui ont assuré :</h3>
						    		<h4 class="light-grey">à l'agence</h4>
						    		<div id="employees" class="clearfix">
						    			
						    			<?php
								    		
								    		//on stocke le post de la boucle globale
									    	$myPost = $post;

									    	//TODO:ici c'est tout buggé
									    	if (isset($employees)) {
									    		//var_dump($employee_ids);
									    		$first = true;
								    			foreach ($employees as $employee) {
								    				//echo $employee->ID.',';
								    				?>
						    						<a class="image-link alignleft <?php if($first) echo 'first'; ?>" rel="user-profile" title="<?php //$employee->; ?>"><?php echo user_avatar_get_avatar($employee->ID, 72); ?></a>
						    						<?php
								    				$first = false;	
								    			}
								    		}

						    			?>

						    		</div><!-- end  employees -->
									<h4 class="light-grey">Esclaves partenaires</h4>
						    		<div id="partners" class="clearfix">
						    			<?php

						    				if (isset($partners)) {
						    					//var_dump($partners_ids);
									    		//var_dump($offers_query);
									    		$first = true;
								    			foreach ($partners as $partner) {
								    				?>

						    						<a class="image-link alignleft <?php if($first) echo 'first'; ?>" rel="user-profile" title="<?php echo $partner->display_name; ?>" href="<?php echo $partner->user_url; ?>"><?php echo user_avatar_get_avatar($partner->ID, 72); ?></a>
						    						<?php
								    				
								    				$first = false;	

								    			}
								    		}

								    		//on repointe vers le post de la boucle globale
									    	$post = $myPost;

									    ?>

						    		</div><!-- end  partners -->
						    		<div id="client">
						    			<h3>Une idée réalisée pour :</h3>
						    			<a class="image-link alignleft"><?php echo user_avatar_get_avatar($client_id, 110); ?></a>
						    		</div><!-- end  client -->
						    	</div><!-- end  ressources -->
						    	
						    	<div id="description" class="post-content first eightcol clearfix">
						    		
						    			<?php the_content(); ?>

						    	</div> <!-- end description -->

						    </section> <!-- end article section -->
						
						    <footer class="article-footer">

								<div id="links1" class="threecol first">
									<?php if(get_post_meta( $post->ID, '_work_url_related', true)) { ?>
								    	<a class="button-goto-project button-cta plus " href="<?php echo  get_post_meta( $post->ID, '_work_url_related', true ); ?>"><span id="text">Voir le projet en vrai !</span><span id="plus"></span></a>								    
								    <?php } ?>
								    								    	
								</div><!-- end  links1 -->

								<div id="links2" class="fivecol last">
									<!-- Bouton Twitter -->
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo post_permalink(); ?>" data-via="uzful" data-lang="fr" data-related="uzful">Tweeter</a>					
									<!-- Bouton Facebook -->
									<div class="fb-like" data-href="<?php echo post_permalink(); ?>" data-send="false" data-layout="button_count" data-width="115" data-show-faces="false" data-font="verdana"></div>									
									<!-- Bouton Pinterest -->
									<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(post_permalink()); ?>&media=<?php echo urlencode(MultiPostThumbnails::get_post_thumbnail_url('folio_work', 'secondary-image')); ?>&description=" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
								</div><!-- end  links1 -->
						    	<div class="results fivecol first">
						    		<div class="results-container">
							    		<h3>Résultats</h3>
							    		<p>
							    			<?php 
							    				$results =  get_post_meta( $post->ID, '_work_results', true );
										    	echo $results;
							    			?>
							    		</p>
							    		<hr/>
							    		<h3 class="cell">Ca vous donne envie ?</h3>
							    		<div class="cell">
											<div class="image-replacement ico-tel first">Téléphone : </div><span class="tel">+33 1 47 85 21 47</span> <!-- classe hCard d’e-mail -->
										</div>
										<div class="cell">
											<div class="image-replacement ico-email first">Email : </div><a class="email" href"mailto:contact[atte]uzful[p]fr">Contacte-nous !</a> <!-- classe hCard d’e-mail -->
										</div>
						    		</div>
						    	</div>
						    	<div class="plus threecol last">
						    		

						    	</div> <!-- end plus -->

						    </footer> <!-- end article footer -->
						    
						    <?php // comments_template(); // uncomment if you want to use them ?>
					
					    </article> <!-- end article -->
					
					
					    <?php endwhile; ?>			
					
					    <?php else : ?>
					
        					<article id="post-not-found" class="hentry clearfix">
        						<header class="article-header">
        							<h1><?php _e("Oops, Post Not Found!", "uzfultheme"); ?></h1>
        						</header>
        						<section class="post-content">
        							<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "uzfultheme"); ?></p>
        						</section>
        						<footer class="article-footer">
        						    <p><?php _e("This is the error message in the single-custom_type.php template.", "uzfultheme"); ?></p>
        						</footer>
        					</article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <?php //get_sidebar(); // sidebar 1 ?>
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
