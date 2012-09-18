<?php
/*
Template Name: Home Blog
*/
?>

<?php get_header(); 

//The Query
$the_query = new WP_Query('posts_per_page=10');


?>
			
				<div id="inner-header" class="wrap clearfix">
					
					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php //bloginfo('name'); ?></a></p>
														
					
				
				</div> <!-- end #inner-header -->
			
			</header> <!-- end header -->

<!-- if you'd like to use the site description you can un-comment it below -->
					<?php bloginfo('description'); ?>
			
			<div id="content">		
				test4
				<div id="inner-content" class="wrap clearfix blog"> 
				    
				    <div id="main" class="sixcol first clearfix" role="main">
					    <?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
						    <header class="article-header">
							
							    <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							
							    <p class="meta"><?php _e('Posted', 'uzfultheme'); ?> <time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time(get_option('date_format')); ?></time> <?php _e('by', 'uzfultheme'); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e('filed under', 'uzfultheme'); ?> <?php the_category(', '); ?>.</p>
						
						    </header> <!-- end article header -->
					
						    <section class="post-content clearfix">
							    <?php the_content(); ?>
						    </section> <!-- end article section -->
						
						    <footer class="article-footer">

    							<p class="tags"><?php the_tags('<span class="tags-title">Tags:</span> ', ', ', ''); ?></p>

						    </footer> <!-- end article footer -->
						    
						    <?php // comments_template(); // uncomment if you want to use them ?>
					
					    </article> <!-- end article -->
					
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

// Reset Post Data
wp_reset_postdata();

get_footer(); ?>
