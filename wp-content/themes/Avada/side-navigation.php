<?php
// Template Name: Side Navigation
get_header(); ?>
	<?php
	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} else {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	}
	?>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if(has_post_thumbnail()): ?>
			<div class="image">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail('blog-large'); ?>
					<div class="image-extras">
						<div class="image-extras-content">
							<img src="<?php bloginfo('template_directory'); ?>/images/link-ico.png" alt="<?php the_title(); ?>"/>
							<h3><?php the_title(); ?><h3>
						</div>
					</div>
				</a>
			</div>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
		<ul class="side-nav">
			<?php
			$post_ancestors = get_post_ancestors($post->ID);
			$post_parent = end($post_ancestors);
			?>
			<?php if(is_page($post_parent)): ?><?php endif; ?>
			<li <?php if(is_page($post_parent)): ?>class="current_page_item"<?php endif; ?>><a href="<?php echo get_permalink($post_parent); ?>" title="Back to Parent Page"><?php echo get_the_title($post_parent); ?></a></li>
			<?php
			if($post_parent)
			$children = wp_list_pages("title_li=&child_of=".$post_parent."&echo=0");
			else
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
			if ($children) {
			?>
			<?php echo $children; ?>
			<?php } ?>
		</ul>
		<?php
		$selected_sidebar_replacement = get_post_meta($post->ID, 'sbg_selected_sidebar_replacement', true);
		if(!$selected_sidebar_replacement[0] == 0) {
			generated_dynamic_sidebar();
		}
		?>
	</div>
<?php get_footer(); ?>