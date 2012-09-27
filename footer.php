			<footer class="footer" role="contentinfo">
			
				<div id="inner-footer" class="wrap clearfix">
					<div id="search-and-social" class="eightcol first">
						
							<div id="text" class="first twocol">
								<h3 class="white">Ça marche comme Google :</h3>
							</div>
							<div id="form-container" class="threecol clearfix search-container">
							    <?php get_search_form(); ?>
							    
							</div>
						
						<div id="" class="first threecol social-buttons">
							<div class="alignleft">
								<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.uzful.fr" data-via="uzful" data-lang="fr" data-related="uzful">Tweeter</a>					
							</div>
							
							<div class="alignleft">
								<div class="fb-like" data-href="http://www.uzful.fr" data-send="false" data-layout="button_count" data-width="115" data-show-faces="false" data-font="verdana"></div>
							</div>
						</div>

					</div>
					<!-- //TODO: mettre une carte dynamique (open street maps ou gmaps) -->
					<div id="map-container" class="sixcol first map-uzful"><!--<img rel="map" class="" title="Nous retrouver facilement"/ src="<?php echo get_template_directory_uri(); ?>/library/images/map.png"/>-->
						<div id="map">
							<!-- //GMaps -->
						</div>
					</div>
					
					<div id="address" class="onecol first">
						<div class="vcard"> <!-- appel au format hCard -->
							<div class="fleft column">
								<h3 class="white">On est là</h3>
								<ul class="adr"> <!-- propriété globale d’adresse hCard -->
									<li class="fn org name">Uzful</li>
									<li class="title" style="	display:none;">Agence utile</li>
									<li class="street-address">48-50, rue voltaire</li>
									<li><span class="postal-code">93100</span><span>, </span><span class="locality">Montreuil</span>
										<span class="country-name" style="text-transform: uppercase;">France</span>
									</li>
								</ul>
							</div>
							<div class="fleft column">
								<h3 class="white clearfix">Keep in touch</h3>
								<div class="p">
									<div><div class='image-replacement ico-tel first'>Tél. </div><span class="tel">+33 1 47 85 21 47</span> <!-- classe hCard de téléphone --></div>
									<div><div class="image-replacement ico-email">Email : </div><a class="email" href="schtroumpf=contact[pouet]uzful[lol]fr">contact[pouet]uzful[lol]fr</a> <!-- classe hCard d’e-mail --></div>
								</div>
							</div>
							<div class="fleft column">
								<h3 class="white">Uzful jobs</h3>
								<div class="p">
									<div class="image-replacement ico-email first">Email : </div><a class="email" href="schtroumpf=job[pouet]uzful[lol]fr">job[pouet]uzful[lol]fr</a> <!-- classe hCard d’e-mail -->
								</div>
							</div>
						</div> <!-- end .vcard -->
					</div> <!-- end address -->
					<div id="social-links"> <!-- grid code class in CSS --> 
						<ul class="clearfix">
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="rss" class="first" href="http://uzful.fr/rss">Flux Rss</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="twitter" class="first" href="http://twitter.com/uzful">Twitter</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="vimeo" href="http://vimeo.com/uzful">Vimeo</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="linkedin" href="http://www.linkedin.com/company/uzful">Linkedin</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="facebook" href="http://facebook.com/uzful">Facebook</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="google-plus" href="http://google.com/uzful">Google +</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="slideshare" href="http://fr.slideshare.net/UZFUL">SlideShare</a>
							</li>
							<li class="social url"> <!-- classes hCard de type social et de lien -->
								<a id="delicious" href="http://delicious.com/uzful">Delicious</a>
							</li>
						</ul>
					</div>

										
					
	                <div id="copyright" class="eightcol first">	
						<p class="attribution" class="eightcol">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>
					</div>
				</div> <!-- end #inner-footer -->
				<!-- nav role="navigation" class="eightcol first">-->
					<?php //bones_footer_links(); // Adjust using Menus in Wordpress Admin ?>
                <!-- </nav>-->
			</footer> <!-- end footer -->

		</div> <!-- end #container -->
		
	</div><!-- end #main-wrapper -->
   <!--         </div>
          </div>
        </div>
      </div> -->
	
		<?php
		 wp_footer(); // js scripts are inserted using this function ?>
		<script type='text/javascript'>
			//nécessaire pour l'index ne soit pas visible avant le lancement du chargement ajax de l'uri demandée ('/' ou autre)
			if (window.location.href.indexOf('!') != -1)
			{ window.document.getElementById('content').style.display = 'none';	}	
			else
			{}
		</script>
		<!-- //FB -->
		<div id="fb-root"></div>
		<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
		<!-- Twitter -->
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<!-- Pinterest -->		
		<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>		
		<!-- NOSCRIPT -->
		<noscript>//nothing needeed</noscript>

	</body>

</html> <!-- end page. what a ride! -->
