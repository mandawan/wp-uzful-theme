<!doctype html>  

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	
	<head>
		<meta charset="utf-8">
		
		<title><?php wp_title(''); ?></title>
		
		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<!-- icons & favicons (for more: http://themble.com/support/adding-icons-favicons/) -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/icon32.png" sizes="32x32" />
				
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->
			
		<!-- drop Google Analytics Here -->

		
		<!-- end analytics -->
		<script type='text/javascript'>
		(function (d, t) {
		  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
		  bh.type = 'text/javascript';
		  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=exoa8okp5deqv1lebq0duw';
		  s.parentNode.insertBefore(bh, s);
		  })(document, 'script');
		</script>
	</head>
	
	<body <?php body_class(''); ?>>

	<?php //echo bloginfo('rss2_url'); ?>
		
		

<!--	   	<div class="box-wrap antiscroll-wrap">
        <div class="box">
        <div class="antiscroll-inner">
        <div class="box-inner">-->
    	
	<div id="main-wrapper" class="clearfix">
		<div id="transition-pane"></div>

		<div id="right-pane-container">
			<div id="right-pane">
				<nav id="anchor-nav">
					<ol id="anchors-list">
												
					</ol>
				</nav>
				<div id="infos-uzful"></div>
			</div> <!-- end right-pane -->
		</div> <!-- end right-pane-cointainer -->

		<div id="container" class="full-page-container clearfix">

			
				<?php //bones_main_nav(); // Adjust using Menus in Wordpress Admin ?>
			
		
			<header class="header" role="banner">
				
				

				<nav id="mainNav" role="navigation">

					<ol id="history">
						<li class="home-but" ><a href="<?php echo get_option('home'); ?>/" title="'+pTitle+'"><img width="15" height="35" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.png"></a></li>
					</ol>

				</nav>
			

		