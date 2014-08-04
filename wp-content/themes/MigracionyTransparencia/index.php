<?php get_header(); ?>
<div id="sliders-container">
	slider
</div>
<div id="content" class="full-width">
</div>
	
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php if($smof_data['blog_layout'] == 'Timeline'): ?>
		<div class="timeline-icon"><i class="icon-bubbles"></i></div>
		<?php endif; ?>
		<div id="posts-container" class="<?php echo $container_class; ?> clearfix">
			contenido
		</div>
		<?php themefusion_pagination($pages = '', $range = 2); ?>
	</div>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php
		if(is_home()) {
			$name = get_post_meta(get_option('page_for_posts'), 'sbg_selected_sidebar_replacement', true);
			if($name) {
				generated_dynamic_sidebar($name[0]);
			}
		}
		if(is_front_page()) {
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('SidebarHome')):
			endif;
		}
		?>
	</div>
	<?php endif; ?>
<?php get_footer(); ?>