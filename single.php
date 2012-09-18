<?php get_header(); ?>
			
				<div id="inner-header" class="wrap clearfix">
					
					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<p id="logo" class="h1"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php //bloginfo('name'); ?></a></p>
														
					
				
				</div> <!-- end #inner-header -->
			
			</header> <!-- end header -->
			
			<div id="content">
				test6
				<div id="inner-content" class="wrap clearfix">
			
					<div id="main" class="sixcol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
								<header class="article-header">
							
									<h1 class="single-title" itemprop="headline"><?php the_title(); ?></h1>
							
									<p class="meta"><?php _e("Posted", "uzfultheme"); ?> <time datetime="<?php echo the_time('Y-m-j'); ?>" pubdate><?php the_time('F jS, Y'); ?></time> <?php _e("by", "uzfultheme"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e("filed under", "uzfultheme"); ?> <?php the_category(', '); ?>.</p>
						
								</header> <!-- end article header -->
					
								<section class="post-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
								</section> <!-- end article section -->
						
								<footer class="article-footer">
			
									<?php the_tags('<p class="tags"><span class="tags-title">Tags:</span> ', ', ', '</p>'); ?>
							
								</footer> <!-- end article footer -->
					
								<?php comments_template(); // comments should go inside the article element ?>
					
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
					    		    <p><?php _e("This is the error message in the single.php template.", "uzfultheme"); ?></p>
					    		</footer>
							</article>
					
						<?php endif; ?>
			
					</div> <!-- end #main -->
    
					<?php //get_sidebar(); // sidebar 1 ?>

				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>