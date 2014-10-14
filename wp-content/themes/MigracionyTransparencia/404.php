<?php get_header(); ?>
	<div id="content" class="full-width">
		<span class="vcard" style="display: none;"><span class="fn"><?php the_author_posts_link(); ?></span></span>
		<span class="updated" style="display:none;"><?php the_modified_time( 'c' ); ?></span>	
		<div id="post-404page">
			<div class="post-content">
				<div class="fusion-title title">
					<h2 class="title-heading-left" style="line-height: 54px;padding-bottom:6px;"><?php echo __('P&aacute;gina no encontrada', 'Avada'); ?></h2><div class="title-sep-container"><div class="title-sep sep-double"></div></div>
				</div>
				<div class="fusion-clearfix"></div>
				<div class="error_page">
					<div class="one_third">
						<div class="error-message">404</div>
					</div>
					<div class="one_third useful_links">
						<h3><?php echo __('Aqu&iacute; algunos enlaces &uacute;tiles:', 'Avada'); ?></h3>

						<?php
						if( $smof_data['checklist_circle'] ) {
							$circle_class = 'circle-yes';
						} else {
							$circle_class = 'circle-no';
						}
						wp_nav_menu(array('theme_location' => '404_pages', 'depth' => 1, 'container' => false, 'menu_id' => 'checklist-1', 'menu_class' => 'error-menu list-icon list-icon-arrow ' . $circle_class )); ?>
					</div>
					<div class="one_third last">
						<h3><?php echo __('Busca en nuestro Sitio Web', 'Avada'); ?></a></h3>
						<p><?php echo __('', 'Avada'); ?></p>
						<div class="search-page-search-form">
							<form id="searchform" class="seach-form" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
								<div class="search-table">
									<div class="search-field">
										<input type="text" value="" name="s" id="s" placeholder="<?php _e( 'Search ...', 'Avada' ); ?>"/>
									</div>
									<div class="search-button">
										<input type="submit" id="searchsubmit" value="&#xf002;" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>