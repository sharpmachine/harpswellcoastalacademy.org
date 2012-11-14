		</div>
	</div>
	<?php if(of_get_option('footer_widgets', 'yes') == 'yes'): ?>
	<footer class="footer-area">
		<div class="row">
			<section class="columns">
				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 1')): 
				endif;
				?>

				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 2')): 
				endif;
				?>

				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 3')): 
				endif;
				?>

				<?php
				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 4')): 
				endif;
				?>
			</section>
		</div>
	</footer>
	<?php endif; ?>
	<?php if(of_get_option('footer_copyright', 'yes') == 'yes'): ?>
	<footer id="footer">
		<div class="row">
			<ul class="social-networks">
				<?php if(of_get_option('facebook_link')): ?>
				<li><a href="<?php echo of_get_option('facebook_link'); ?>" class="facebook">facebook</a>
					<div class="popup">
						<div class="holder">
							<p>Facebook</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('twitter_link')): ?>
				<li><a href="<?php echo of_get_option('twitter_link'); ?>" class="twitter">twitter</a>
					<div class="popup">
						<div class="holder">
							<p>Twitter</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('linkedin_link')): ?>
				<li><a href="<?php echo of_get_option('linkedin_link'); ?>" class="linked-in">linked in</a>
					<div class="popup">
						<div class="holder">
							<p>LinkedIn</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('rss_link')): ?>
				<li><a href="<?php echo of_get_option('rss_link'); ?>" class="rss">rss</a>
					<div class="popup">
						<div class="holder">
							<p>RSS</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('dribbble_link')): ?>
				<li><a href="<?php echo of_get_option('dribbble_link'); ?>" class="dribbble">dribbble</a>
					<div class="popup">
						<div class="holder">
							<p>Dribbble</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('yt_link')): ?>
				<li class="custom"><a href="<?php echo of_get_option('yt_link'); ?>" class="youtube"><img src="<?php bloginfo('template_directory'); ?>/images/youtube.png" alt="" /></a>
					<div class="popup">
						<div class="holder">
							<p>Youtube</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('pint_link')): ?>
				<li class="custom"><a href="<?php echo of_get_option('pint_link'); ?>" class="pinterest"><img src="<?php bloginfo('template_directory'); ?>/images/pinterest.png" alt="" /></a>
					<div class="popup">
						<div class="holder">
							<p>Pinterest</p>
						</div>
					</div>
				</li>
				<?php endif; ?>
				<?php if(of_get_option('custom_icon_name') && of_get_option('custom_icon_image') && of_get_option('custom_icon_link')): ?>
				<li class="custom"><a href="<?php echo of_get_option('custom_icon_link'); ?>"><img src="<?php echo of_get_option('custom_icon_image'); ?>" alt="<?php echo of_get_option('custom_icon_name'); ?>" /></a>
					<div class="popup">
						<div class="holder">
							<p><?php echo of_get_option('custom_icon_name'); ?></p>
						</div>
					</div>
				</li>
				<?php endif; ?>
			</ul>
			<ul class="copyright">
				<li><?php echo of_get_option('copyright', 'Copyright 2012 Avada | All Rights Reserved | Powered by <a href="http://wordpress.org">WordPress</a>  |  <a href="http://theme-fusion.com">Theme Fusion</a>'); ?></li>
			</ul>
		</div>
	</footer>
	<?php endif; ?>
	</div><!-- wrapper -->
	<?php //include_once('style_selector.php'); ?>
	<?php wp_footer(); ?>
</body>
</html>