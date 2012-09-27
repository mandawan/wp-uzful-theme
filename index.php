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
								<div id="s3" class="title-block"><strong>à vocation utile</strong></div>
							</h1>

						</div> <!-- end animation -->															
					</div><!-- end header-content -->	
				
				</div> <!-- end #inner-header -->

				
									
			</header> <!-- end header -->


			<?php 
			//WHAT WE NEED -NO NATIVE- TO DYNAMICALLY GRAB
										    
			$offers_query = new WP_Query($args);
			

			$push_img_file_name = '3529638767_3622b99081_o_NB.jpg';

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


			//PUSH
			$pushID = $wpdb->get_results( "SELECT value FROM options WHERE name = 'pushed_attachement_id' LIMIT 1");
			$pushID = $pushID[0]->value;
			
			$pushPost = get_post($pushID);
			//var_dump($pushPost);
			$pushTitle = $pushPost->post_title;
			$pushSubTitle = $pushPost->post_excerpt;
			$pushDesc = $pushPost->post_content;
			$pushRelatedUrl = get_post_meta($pushID, "url_to_push", true);
			$pushImg = wp_get_attachment_image( $pushID, 'uzful-thumb-480');
			//echo $pushImg;
			
			//PRESTATAIRES
			$args = array(
				'role' => 'partner',
			 );
			
			$partners = get_users($args);


			//EMPLOYES
			$args = array(
				'role' => 'employee',
			 );
			
			$team = get_users($args);


			//CLIENTS
			$args = array(
				'role' => 'client',
			 );
			
			$clients = get_users($args);


			?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="clearfix index" role="main">

				    	
				    	<section id="home-offers" class="eightcol first clearfix">
				    		<a id="anchor-offers" name="anchor-offers" data-title="Nos offres" data-sub="" class="anchor"></a>
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
				    							<a href="<?php the_permalink() ?>" rel="bookmark" class="image-link alignleft vertalign"title="<?php the_title_attribute(); ?>">
					    							<div class="first">
					    								<?php the_post_thumbnail('uzful-thumb-55'); ?>
					    							</div>
					    							<div class="align"><h3 class=""><?php the_title(); ?></h3></div>
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
									<p>La socialisation de l'écosystème digital permet aujourd'hui à toutes les entreprises d'y développer leur business, quelle que soit leur taille. Désormais le budget n'est plus la recette du succès... le savoir-faire, les ressources internes et la capacité d'innovation font la loi ! Allant de la formation ponctuelle à l'externalisation partielle ou totale, l'offre Uzful permet à tous de rester dans la course.<a class="goto-more button-cta clearfix plus" rel="" href="<?php echo get_post_type_archive_link('offer'); ?>"><span id="text">Nos offres en détail</span><span id="plus"></span></a></p>						
								</div>
							</div>

				    	</section> <!-- end home-offers -->
				    	
				    	<section id="home-works" class="eightcol first clearfix section">
				    		<a id="anchor-works" name="anchor-works" data-title="Nos réalisations" data-sub="" class="anchor"></a>
				    		<h2 >Les réalisations <strong>de uzful</strong></h2>
				    		<div id="works" class="masonry">
				    		<?php
				    		if (isset($works_query) && $works_query->have_posts()) {

					    		//var_dump($offers_query);
					    		$sizes = array('355', '230');
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
				    		<a class="button-more button-cta plus" href="<?php echo get_post_type_archive_link('folio_work'); ?>"><span id="text">Voir toutes les réalisations</span><span id="plus"></span></a>
				    	</section> <!-- end home-works -->

						<section id="home-extensions" class="eightcol first clearfix">
							<a id="anchor-extensions" name="anchor-extensions" data-title="Nos extensions" data-sub="" class="anchor"></a>
				    		<h2>Les extensions <strong>de uzful</strong></h2>
				    		<div id="extensions">
				    		<?php

				    		if (isset($extensions_query) && $extensions_query->have_posts()) {

				    			$first = true;

					    		//var_dump($offers_query);
				    			while ($extensions_query->have_posts()) {

				    				$extensions_query->the_post();

					    				//var_dump($post);
				    				?>
				    				<article class="fourcol <?php if($first) echo 'first'; ?> post-content">
				    					<a href="<?php the_permalink() ?>" rel="bookmark" class="image-link greyimg" title="<?php the_title_attribute(); ?>">
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
							</div><!-- end #extensions -->
							<div class="more eightcol clearfix first">
								<a class="button-more button-cta plus" rel="content-more"><span id="text">En savoir plus sur notre démarche</span><span id="plus"></span></a>
								<div class="content-more">
									<p>Plus qu’une agence, Uzful est une structure hybride qui ne se contente pas d’accompagner les idées des autres… Pour être toujours au top de la créativité, elle s'associe au développement de projets innovants et met ses expertises à leur service !<a class="goto-more button-cta clearfix plus" rel="" href="<?php echo get_post_type_archive_link('extension'); ?>"><span id="text">Plus de détails sur nos extensions</span><span id="plus"></span></a></p>						
								</div>
							</div>
				    	</section> <!-- end home-extensions -->				    	
				    	
				    	
				    	<section id="home-blog" class="eightcol first clearfix">
				    		<a id="anchor-blog" name="anchor-blog" data-title="Blog" data-sub="Ici on s'exprime!" class="anchor"></a>		
				    		<div class="fourcol first">
					    		<div class="vertalign">
					    			<div>
				    					<h2>Le <strong>Blog</strong> d'utilité publique</h2>
				    				</div>
				    			</div>
				    			<div class="inner">
				    			<?php 
				    			$k = 0;
				    			while (have_posts()) : the_post();
				    				if($k >= 3) break;
				    			?>
					    			<article>
					    				<time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('j/n'); ?></time>
					    				<h4><?php echo $post->post_title; ?></h4>
					    				<p><?php the_excerpt(); ?> <?php //echo bones_excerpt_more('pouet'); ?></p>
					    			</article>
				    			 <?php 
				    			 	$k++;
				    			 endwhile; ?>
					    		</div><!-- end .inner -->
				    		</div>
				    		
				    		<div class="fourcol last">
				    			<div class="vertalign">
				    				<div>
					    				<h2><?php echo $pushTitle; ?></h2>
				    				</div>
				    			</div>
				    			<div class="inner">
					    			<a title="<?php echo $pushTitle; ?>" class="image-link" name="<?php echo $pushTitle; ?>" href="<?php echo $pushRelatedUrl; ?>"><?php echo $pushImg; ?></a>
					    			<h3><?php echo $pushSubTitle; ?></h3>
					    			<p><?php echo $pushDesc; ?></p>
				    			</div><!-- end .inner -->
				    		</div>

				    	</section><!-- end home-blog -->

				    	
				    	<section id="home-clients" class="eightcol first clearfix">
				    		<a id="anchor-clients" name="anchor-clients" data-title="Clients" data-sub="" class="anchor"></a>		
				    		<h2>Nos <strong>Clients</strong></h2>
				    		<div class="clients">
					    		<div class="clearfix eightcol first carousel-wrapper">
					    			
					    			<div class="list_carousel responsive">
					    				<?php if(count($clients)){ ?>
					    				<ul id="carousel-clients">
					    						<?php foreach ($clients as $client) { ?>
					    							<li><a class=""><?php echo user_avatar_get_avatar($client->ID, 150); ?></a></li>
					    						<?php } ?>
					    				</ul>
					    				<?php } ?>
					    			</div>
				    				<a id="back-clients" class="arrow back">&lt;</a>
				    				<a id="forward-clients" class="arrow forward">&gt;</a>
					    		</div>	
				    		</div>
				    	</section><!-- end home-clients -->

				    	
				    	<section id="home-staff" class="eightcol first clearfix">
				    		<a id="anchor-staff" name="anchor-staff" data-title="Notre équipe" data-sub="" class="anchor"></a>		
				    		<h2>Notre <strong>équipe</strong></h2>
				    		<div class="staff">
			    				<div class="clearfix eightcol first carousel-wrapper">
					    			
					    			<div class="list_carousel responsive">
					    				<?php if(count($team)){ ?>
					    				<ul id="carousel-staff">
					    						<?php foreach ($team as $worker) { ?>
					    							<li><a class=""><?php echo user_avatar_get_avatar($worker->ID, 217); ?></a></li>
					    						<?php } ?>
					    				</ul>
					    				<?php } ?>
					    			</div>
					    			<a id="back-staff" class="arrow back">&lt;</a>
					    			<a id="forward-staff" class="arrow forward">&gt;</a>
					    		</div>						    							    					    			
				    		</div>
				    	</section><!-- end home-staff -->

				    	
				    	<section id="home-partners" class="eightcol first clearfix">
				    		<a id="anchor-partners" name="anchor-partners" data-title="Nos partenaires" data-sub="" class="anchor"></a>		
				    		<h2>Nos <strong>partenaires</strong></h2>
				    		<div class="partners">
								<div class="clearfix eightcol first carousel-wrapper">
					    			
					    			<div class="list_carousel responsive">
					    				<?php if(count($partners)){ ?>
					    				<ul id="carousel-partners">
					    						<?php foreach ($partners as $partner) { ?>
					    							<li><a class=""><?php echo user_avatar_get_avatar($partners->ID, 135); ?></a></li>
					    						<?php } ?>
					    				</ul>
					    				<?php } ?>
					    				<a id="back-partners" class="arrow back">&lt;</a>
					    				<a id="forward-partners" class="arrow forward">&gt;</a>
					    			</div>
					    		</div>					    			
				    		</div>
				    	</section><!-- end home-partners -->
					
				    </div> <!-- end #main -->
    
				    <?php ////get_sidebar(); // sidebar 1 ?>
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>

