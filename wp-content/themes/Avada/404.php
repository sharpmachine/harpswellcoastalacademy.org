<?php get_header(); ?>
	<div id="content" style="<?php echo $content_css; ?>">
		<div id="post-<?php the_ID(); ?>" class="post">
			<div class="post-content">
				<h2><?php _e('Error: 404', 'Avada'); ?></a></h2>
				<p><?php _e("404 error, couldn't find the content you were looking for.", 'Avada'); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>"><?php generated_dynamic_sidebar(); ?></div>
<?php get_footer(); ?>