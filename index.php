<?php get_header(); 

?>

				<div id="inner-header" class="wrap clearfix">
					
					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<div id="header-content">
						<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php //bloginfo('name'); ?></a></p>
						
						<div id="animation-home" class="clearfix  first">
							
							<h1>
								<div id="s1" class="title-block">Agence digitale</div>
								<div id="s2" class="title-block">& social media</div>
								<div id="s3" class="title-block blue">à vocation utile</div>
							</h1>

						</div> <!-- end animation -->															
					</div><!-- end header-content -->	
				
				</div> <!-- end #inner-header -->

				
									
			</header> <!-- end header -->


			<?php 
			//WHAT WE NEED -NO NATIVE- TO DYNAMICALLY GRAB
			
			//BLOG POSTS
			//we store the original loop query
			$articles_query = $wp_query;

			//OFFERS
			$args = array(
								    	'post_type' => 'offer',
								    	'post_status' => 'publish', 
								    	'orderby' => 'date', 
								    	'order' => 'ASC' 
								    );
								    
			$offers_query = new WP_Query($args);
			
			//WORKS
			$args = array(
								    	'post_type' => 'folio_work',
								    	'post__in'  => get_option( 'sticky_posts' ),
								    	'post_status' => 'publish',
								    	'posts_per_page' => 8,
								    	'orderby' => 'date', 
								    	'order' => 'DESC' 
								    );

			$works_query = new WP_Query($args);

			//EXTENSIONS
			$args = array(
								    	'post_type' => 'extension',
								    	'post_status' => 'publish', 
								    	'orderby' => 'date',
								    	'order' => 'DESC' 
								    );

			$extensions_query = new WP_Query($args);


			?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="clearfix index" role="main">

				    	
				    	<section id="home-offers" class="eightcol first clearfix">
				    		<?php
				    		if (isset($offers_query) && $offers_query->have_posts()) {

				    			
					    		//var_dump($offers_query);
					    		$count=0;
				    			while ($offers_query->have_posts()) {

				    				$offers_query->the_post();

				    				//var_dump($post);
				    				?>
				    				<?php if(($count%2)==0) { ?>
				    					<div class="fourcol first">
				    				<?php } ?>
					    				<article class="post-content item-offer>">
				    						<header class="title-wrap">
				    							<a href="<?php the_permalink() ?>" rel="bookmark" class="image-link alignleft"title="<?php the_title_attribute(); ?>">
					    							<div class="first">
					    								<?php the_post_thumbnail('uzful-thumb-55'); ?>
					    							</div>
					    							<div><h3 class=""><?php the_title(); ?></h3></div>
				    							</a>
				    						</header>
					    					<p class="content-more">
					    						<?php 
						    					echo get_post_meta( $post->ID, '_wp_editor_sum', true );
						    					?>
											</p>
					    					
										</article>				    					
									<?php if(($count%2)!=0) { ?>
				    					</div>
				    				<?php } ?>
				    				<?php
				    				$count++;
				    				

				    			}

				    			// Reset Post Data
								wp_reset_postdata();

							}
							?>

							<div class="more eightcol clearfix first">
								<a class="button-more button-cta plus" rel="content-more"><span id="text">Une offre pour tous</span><span id="plus"></span></a>
								<div class="content-more">
									<p>La socialisation de l'écosystème digital permet aujourd'hui à toutes les entreprises d'y développer leur business, quelle que soit leur taille. Désormais le budget n'est plus la recette du succès... le savoir-faire, les ressources internes et la capacité d'innovation font la loi ! Allant de la formation ponctuelle à l'externalisation partielle ou totale, l'offre Uzful permet à tous de rester dans la course.<a class="goto-more button-cta clearfix plus" rel="" href="<?php bloginfo('siteurl'); ?>/offers/"><span id="text">Nos offres en détail</span><span id="plus"></span></a></p>						
								</div>
							</div>

				    	</section> <!-- end home-offers -->
				    	
				    	<section id="home-works" class="eightcol first clearfix section">
				    		<h2 ><span class="light-grey">Les réalisations</span> de uzful</h2>
				    		<div class="masonry">
				    		<?php
				    		if (isset($works_query) && $works_query->have_posts()) {

					    		//var_dump($offers_query);
					    		$sizes = array('355', '230', '180');
					    		$size = $sizes[0];
				    			while ($works_query->have_posts()) {

				    				$works_query->the_post();

				    				
				    				

				    				//var_dump($post);
				    				?>
				    				<article class="item-work alignleft">
				    					<a href="<?php the_permalink(); ?>" rel="bookmark" class="image-link" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('uzful-thumb-'.$size); ?></a>
				    					<h3 id="work-title"><a href="<?php the_permalink(); ?>" rel="post-<?php the_ID(); ?>"><?php echo $post->post_title; ?></a></h3>
				    					<span id="work-subtitle"><?php echo get_post_meta( $post->ID, '_meta_subtitle', true ); ?></span>
				    				</article>
				    				<?php

				    				$size = $sizes[rand(0, count($sizes)-1)];

				    			}

				    			// Reset Post Data
								wp_reset_postdata();

							}
							?>				    		
				    		</div>
				    		<a class="button-more button-cta plus" href="<?php bloginfo('siteurl'); ?>/works/"><span id="text">Voir toutes les réalisations</span><span id="plus"></span></a>
				    	</section> <!-- end home-works -->

						<section id="home-extensions" class="eightcol first clearfix">
				    		<h2><span class="light-grey">Les extensions</span> de uzful</h2>
				    		<?php

				    		if (isset($extensions_query) && $extensions_query->have_posts()) {

				    			$first = true;

					    		//var_dump($offers_query);
				    			while ($extensions_query->have_posts()) {

				    				$extensions_query->the_post();

					    				//var_dump($post);
				    				?>
				    				<article class="fourcol <?php if($first) echo 'first'; ?> post-content">
				    					<a href="<?php the_permalink() ?>" rel="bookmark" class="image-link alignleft greyimg" title="<?php the_title_attribute(); ?>">
				    						<?php the_post_thumbnail('uzful-thumb-480'); ?>
				    					</a>
				    					<h3><a href="<?php the_permalink(); ?>" rel="post-<?php the_ID(); ?>"><?php echo $post->post_title; ?></a></h3>
				    					<h5 class="light-grey sans-serif"><?php echo get_post_meta( $post->ID, '_meta_subtitle', true ); ?></h5>
				    					<p>
				    						<?php 
					    					echo get_post_meta( $post->ID, '_wp_editor_sum', true );
					    					?>
					    				</p>
				    				</article>
				    				<?php
				    				$first = false;
				    			}

				    			// Reset Post Data
								wp_reset_postdata();

							}
							?>	
							<div class="more eightcol clearfix first">
								<a class="button-more button-cta plus" rel="content-more"><span id="text">En savoir plus sur notre démarche</span><span id="plus"></span></a>
								<div class="content-more">
									<p>Plus qu’une agence, Uzful est une structure hybride qui ne se contente pas d’accompagner les idées des autres… Pour être toujours au top de la créativité, elle s'associe au développement de projets innovants et met ses expertises à leur service !<a class="goto-more button-cta clearfix plus" rel="" href="<?php bloginfo('siteurl'); ?>/extensions/"><span id="text">Plus de détails sur nos extensions</span><span id="plus"></span></a></p>						
								</div>
							</div>
				    	</section> <!-- end home-extensions -->				    	

					
				    </div> <!-- end #main -->
    
				    <?php ////get_sidebar(); // sidebar 1 ?>
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>

