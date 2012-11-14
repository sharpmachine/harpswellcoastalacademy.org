<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/respond.min.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ie.css" />
	<![endif]-->

	<?php if(of_get_option('responsiveness', 'yes') == 'yes'): ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/media.css" />
	<?php endif; ?>

	<link href='http://fonts.googleapis.com/css?family=<?php echo urlencode(of_get_option('body_font', 'PT Sans')); ?>:400,400italic,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese' rel='stylesheet' type='text/css' />

	<?php if(of_get_option('headings_font', 'Antic Slab') != 'museo'): ?>
	<link href='http://fonts.googleapis.com/css?family=<?php echo urlencode(of_get_option('headings_font', 'Antic Slab')); ?>:400,400italic,700,700italic&amp;subset=latin,greek-ext,cyrillic,latin-ext,greek,cyrillic-ext,vietnamese' rel='stylesheet' type='text/css' />
	<?php endif; ?>

	<?php if(of_get_option('favicon')): ?>
	<link rel="shortcut icon" href="<?php echo of_get_option('favicon'); ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php wp_enqueue_script('jquery'); ?>
	<?php wp_enqueue_script('jtwt', get_bloginfo('template_directory').'/js/jtwt.js'); ?>
	<?php wp_enqueue_script('jquery.elastislide', get_bloginfo('template_directory').'/js/jquery.elastislide.js'); ?>
	<?php wp_enqueue_script('jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto.js'); ?>
	<?php wp_enqueue_script('jquery.isotope', get_bloginfo('template_directory').'/js/jquery.isotope.min.js'); ?>
	<?php wp_enqueue_script('jquery.flexslider', get_bloginfo('template_directory').'/js/jquery.flexslider-min.js'); ?>
	<?php wp_enqueue_script('jquery.cycle', get_bloginfo('template_directory').'/js/jquery.cycle.lite.js'); ?>
	<?php wp_enqueue_script('jquery.fitvids', get_bloginfo('template_directory').'/js/jquery.fitvids.js'); ?>
	<?php wp_enqueue_script('modernizr', get_bloginfo('template_directory').'/js/modernizr.js'); ?>
	<?php wp_enqueue_script('avada', get_bloginfo('template_directory').'/js/main.js'); ?>
	<?php wp_head(); ?>

	<!--[if IE 8]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	var imgs, i, w;
	var imgs = document.getElementsByTagName( 'img' );
	for( i = 0; i < imgs.length; i++ ) {
	    w = imgs[i].getAttribute( 'width' );
	    if ( 615 < w ) {
	        imgs[i].removeAttribute( 'width' );
	        imgs[i].removeAttribute( 'height' );
	    }
	}
	});
	</script>
	<![endif]-->
	
	<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('.flexslider').flexslider();

		jQuery('.video, .wooslider .slide-content').fitVids();
	});
	jQuery(document).ready(function($) {
		function onAfter(curr, next, opts, fwd) {
		  var $ht = $(this).height();

		  //set the container's height to that of the current slide
		  $(this).parent().animate({height: $ht});
		}

	    $('.reviews').cycle({
			fx: 'fade',
			after: onAfter,
			timeout: <?php echo of_get_option('testimonials_speed', 4000); ?>
		});

		<?php if(of_get_option('image_rollover', 'yes') == 'yes'): ?>
		$('.image').live('mouseenter', function(e) {
			if(!$(this).hasClass('slided')) {
				$(this).find('.image-extras').show().stop(true, true).animate({opacity: '1', left: '0'}, 400);
				$(this).addClass('slided');
			} else {
				$(this).find('.image-extras').stop(true, true).fadeIn('normal');
			}
		});
		$('.image-extras').mouseleave(function(e) {
			$(this).fadeOut('normal');
		});
		<?php endif; ?>
	});
	</script>

	<style type="text/css">
	<?php if(of_get_option('sidebar_position', 'right') == 'left'): ?>
	#sidebar{
		float:left;
	}
	#content{
		float:right;
	}
	<?php endif; ?>

	<?php if(of_get_option('primary_color', '#a0ce4e')): ?>
	a:hover,
	#nav ul .current_page_item a, #nav ul .current-menu-item a, #nav ul > .current-menu-parent a,
	.footer-area ul li a:hover,
	.side-nav li.current_page_item a,
	.portfolio-tabs li.active a, .faq-tabs li.active a,
	.project-content .project-info .project-info-box a:hover,
	.about-author .title a,
	span.dropcap{
		color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;
	}
	#nav ul .current_page_item a, #nav ul .current-menu-item a, #nav ul > .current-menu-parent a,
	#nav ul ul,
	.reading-box,
	.portfolio-tabs li.active a, .faq-tabs li.active a,
	.tab-holder .tabs li.active a,
	.post-content blockquote,
	.progress-bar-content,
	.pagination .current,
	.pagination a.inactive:hover{
		border-color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;
	}
	.side-nav li.current_page_item a{
		border-right-color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;	
	}
	h5.toggle.active span.arrow,
	.post-content ul.arrow li::before,
	.progress-bar-content,
	.pagination .current{
		background-color:<?php echo of_get_option('primary_color', '#a0ce4e'); ?> !important;
	}
	<?php endif; ?>

	<?php if(of_get_option('pricing_box_color', '#92C563')): ?>
	.sep-boxed-pricing ul li.title-row{
		background-color:<?php echo of_get_option('pricing_box_color', '#92C563'); ?> !important;
		border-color:<?php echo of_get_option('pricing_box_color', '#92C563'); ?> !important;
	}
	<?php endif; ?>
	<?php if(of_get_option('image_gradient_top_color', '#D1E990') && of_get_option('image_gradient_bottom_color', '#AAD75B')): ?>
	.image .image-extras{
		background-image: linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -o-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -moz-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -webkit-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -ms-linear-gradient(top, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?> 100%);

		background-image: -webkit-gradient(
			linear,
			left top,
			left bottom,
			color-stop(0, <?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?>),
			color-stop(1, <?php echo of_get_option('image_gradient_bottom_color', '#D1E990'); ?>)
		);
	}
	.no-cssgradients .image .image-extras{
		background:<?php echo of_get_option('image_gradient_top_color', '#D1E990'); ?>;
	}
	<?php endif; ?>
	<?php if(of_get_option('button_gradient_top_color', '#D1E990') && of_get_option('button_gradient_bottom_color', '#AAD75B') && of_get_option('button_gradient_text_color', '#54770f')): ?>
	#main .reading-box .button,
	#main .continue.button,
	#main .portfolio-one .button,
	#main .comment-submit{
		color: <?php echo of_get_option('button_gradient_text_color', '#54770f'); ?> !important;
		background-image: linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -o-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -moz-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -webkit-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);
		background-image: -ms-linear-gradient(top, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 100%);

		background-image: -webkit-gradient(
			linear,
			left top,
			left bottom,
			color-stop(0, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?>),
			color-stop(1, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?>)
		);
		border:1px solid <?php echo of_get_option('button_gradient_bottom_color', '#AAD75B'); ?>;
	}
	.no-cssgradients #main .reading-box .button,
	.no-cssgradients #main .continue.button,
	.no-cssgradients #main .portfolio-one .button,
	.no-cssgradients #main .comment-submit{
		background:<?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?>;
	}
	#main .reading-box .button:hover,
	#main .continue.button:hover,
	#main .portfolio-one .button:hover,
	#main .comment-submit:hover{
		color: <?php echo of_get_option('button_gradient_text_color', '#54770f'); ?> !important;
		background-image: linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -o-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -moz-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -webkit-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);
		background-image: -ms-linear-gradient(top, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?> 0%, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?> 100%);

		background-image: -webkit-gradient(
			linear,
			left top,
			left bottom,
			color-stop(0, <?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?>),
			color-stop(1, <?php echo of_get_option('button_gradient_top_color', '#D1E990'); ?>)
		);
		border:1px solid <?php echo of_get_option('button_gradient_bottom_color', '#AAD75B'); ?>;
	}
	.no-cssgradients #main .reading-box .button:hover,
	.no-cssgradients #main .continue.button:hover,
	.no-cssgradients #main .portfolio-one .button:hover,
	.no-cssgradients #main .comment-submit:hover{
		background:<?php echo of_get_option('button_gradient_bottom_color', '#D1E990'); ?>;
	}
	<?php endif; ?>
	<?php if(of_get_option('layout', 'wide') == 'boxed'): ?>
	body{
		background-color:<?php echo of_get_option('bg_color', '#d7d6d6'); ?>;
		<?php if(of_get_option('background')): ?>
		background-image:url(<?php echo of_get_option('background'); ?>);
		background-repeat:<?php echo of_get_option('background_repeat', 'repeat'); ?>;
			<?php if(of_get_option('bg_full', 'no') == 'yes'): ?>
			background-attachment:fixed;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			<?php endif; ?>
		<?php endif; ?>
		<?php if(of_get_option('bg_pattern_option', 'no') == 'yes' && of_get_option('pattern', 'pattern1')): ?>
		background-image:url("<?php echo get_bloginfo('template_directory') . '/images/patterns/' . of_get_option('pattern', 'pattern1') . '.png'; ?>");
		background-repeat:repeat;
		<?php endif; ?>
	}
	#wrapper{
		background:#fff;
		width:1000px;
		margin:0 auto;
	}
	#layerslider-container{
		overflow:hidden;
	}
	<?php endif; ?>

	<?php if(of_get_option('page_title_bg', get_bloginfo('template_directory') . "/images/page_title_bg.png")): ?>
	.page-title-container{
		background-image:url(<?php echo of_get_option('page_title_bg', get_bloginfo('template_directory') . "/images/page_title_bg.png"); ?>) !important;
	}
	<?php endif; ?>

	<?php if(of_get_option('body_font', 'PT Sans')): ?>
	body,#nav ul li ul li a,
	.more,
	.container h3,
	.meta .date,
	.review blockquote q,
	.review blockquote div strong,
	.footer-area  h3,
	.image .image-extras .image-extras-content h4,
	.project-content .project-info h4,
	.post-content blockquote,
	.button.large,
	.button.small{
		font-family:'<?php echo of_get_option('body_font'); ?>', Arial, Helvetica, sans-serif !important;
	}
	.container h3,
	.review blockquote div strong,
	.footer-area  h3,
	.button.large,
	.button.small{
		font-weight:bold;
	}
	.meta .date,
	.review blockquote q,
	.post-content blockquote{
		font-style:italic;
	}
	<?php endif; ?>
	<?php if(of_get_option('headings_font', 'Antic Slab') != 'museo'): ?>
	#nav,
	#main .reading-box h2,
	#main h2,
	.page-title h1,
	.image .image-extras .image-extras-content h3,
	#main .post h2,
	#sidebar .widget h3,
	.tab-holder .tabs li a,
	.share-box h4,
	.project-content h3,
	.side-nav li a,
	h5.toggle a,
	.full-boxed-pricing ul li.title-row,
	.full-boxed-pricing ul li.pricing-row,
	.sep-boxed-pricing ul li.title-row,
	.sep-boxed-pricing ul li.pricing-row,
	.person-author-wrapper,
	.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6{
		font-family:'<?php echo of_get_option('headings_font'); ?>', arial, helvetica, sans-serif !important;
	}
	<?php endif; ?>
	<?php if(of_get_option('responsiveness', 'yes') == 'no'): ?>
	#header .row, #main .row, .footer-area .row, #footer .row{ width:940px; }
	<?php endif; ?>
	<?php echo of_get_option('custom_css'); ?>
	</style>

	<style type="text/css" id="ss">
	</style>

	<link rel="stylesheet" id="style_selector_ss" href="" />

	<?php echo of_get_option('analytics'); ?>
</head>
<body <?php body_class($class); ?>>
	<div id="wrapper">
	<header id="header">
		<div class="row">
			<div class="logo"><a href="<?php bloginfo('siteurl'); ?>"><img src="<?php echo of_get_option('logo', get_bloginfo('template_directory')."/images/logo.gif"); ?>" alt="<?php bloginfo('name'); ?>" /></a></div>
			<nav id="nav" class="nav-holder">
				<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'depth' => 3, 'container' => false, 'menu_id' => 'nav')); ?>
			</nav>
		</div>
	</header>
	<?php
	// Layer Slider
	$slider_page_id = $post->ID;
	if(is_home() && !is_front_page()){
		$slider_page_id = get_option('page_for_posts');
	}
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'layer' && (get_post_meta($slider_page_id, 'pyre_slider', true) || get_post_meta($slider_page_id, 'pyre_slider', true) != 0)): ?>
	<div id="layerslider-container">
		<div id="layerslider-wrapper">
		<div class="ls-shadow-top"></div>
		<?php echo do_shortcode('[layerslider id="'.get_post_meta($slider_page_id, 'pyre_slider', true).'"]'); ?>
		<div class="ls-shadow-bottom"></div>
		</div>
	<?php if(get_post_meta($slider_page_id, 'pyre_fallback', true)): ?>
	<div id="fallback-slide">
		<img src="<?php echo get_post_meta($slider_page_id, 'pyre_fallback', true); ?>" alt="" />
	</div>
	<?php endif; ?>
	</div>
	<?php endif; ?>
	<?php
	// Flex Slider
	if(get_post_meta($slider_page_id, 'pyre_slider_type', true) == 'flex' && (get_post_meta($slider_page_id, 'pyre_wooslider', true) || get_post_meta($slider_page_id, 'pyre_wooslider', true) != 0)) {
		echo do_shortcode('[wooslider slide_page="'.get_post_meta($slider_page_id, 'pyre_wooslider', true).'" slider_type="slides" limit="'.of_get_option('flexslider_slides', '5').'"]');
	}
	?>
	<?php if(of_get_option('page_title_bar', 'yes') == 'yes'): ?>
	<?php if(((is_page() || is_single() || is_singular('avada_portfolio')) && get_post_meta($post->ID, 'pyre_page_title', true) == 'yes') && !is_front_page()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h1><?php the_title(); ?></h1>
			<?php kriesi_breadcrumb(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_home() && !is_front_page() && get_post_meta($slider_page_id, 'pyre_page_title', true) == 'yes'): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h1><?php echo of_get_option('blog_title', 'Blog'); ?></h1>
			<?php kriesi_breadcrumb(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_search()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h1><?php _e('Search results for:', 'Avada'); ?> <?php echo get_search_query(); ?></h1>
		</div>
	</div>
	<?php endif; ?>
	<?php if(is_archive()): ?>
	<div class="page-title-container">
		<div class="page-title">
			<h1><?php single_cat_title(); ?></h1>
			<?php kriesi_breadcrumb(); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
	<div id="main" style="overflow:hidden !important;">
		<div class="row">