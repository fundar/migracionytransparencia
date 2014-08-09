<?php get_header(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/solicitud.css" />

	<?php
	$content_css = '';
	$sidebar_css = '';
	$content_class = '';
	$sidebar_exists = true;
	if(get_post_meta($post->ID, 'pyre_full_width', true) == 'yes') {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
		$content_class = 'full-width';
		$sidebar_exists = false;
	}
	elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default') {
		if($smof_data['default_sidebar_pos'] == 'Left') {
			$content_css = 'float:right;';
			$sidebar_css = 'float:left;';
		} elseif($smof_data['default_sidebar_pos'] == 'Right') {
			$content_css = 'float:left;';
			$sidebar_css = 'float:right;';
		}
	}

	if($smof_data['single_post_full_width']) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
		$content_class= 'full-width';
		$sidebar_exists = false;
	}
	?>
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php if(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

			<?php
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
		
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<?php else: ?>
			<span class="entry-title"><?php the_title(); ?></span>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if($smof_data['post_meta'] && ( (!$smof_data['post_meta_author']) || (!$smof_data['post_meta_date']) || (!$smof_data['post_meta_cats']) || (!$smof_data['post_meta_comments']) || (!$smof_data['post_meta_tags']) ) ): ?>
			<div class="meta-info">
				<div class="vcard">
					<?php if(!$smof_data['post_meta_author']): ?><?php echo __('By', 'Avada'); ?> <span class="fn"><?php the_author_posts_link(); ?></span><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_date']): ?><span class="updated" style="display:none;"><?php the_modified_time( 'c' ); ?></span><span class="published"><?php the_time($smof_data['date_format']); ?></span><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_cats']): ?><?php if(!$smof_data['post_meta_tags']){ echo __('Categories:', 'Avada') . ' '; } ?><?php the_category(', '); ?><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_tags']): ?><span class="meta-tags"><?php echo __('Tags:', 'Avada') . ' '; the_tags( '' ); ?></span><span class="sep">|</span><?php endif; ?><?php if(!$smof_data['post_meta_comments']): ?><?php comments_popup_link(__('0 Comments', 'Avada'), __('1 Comment', 'Avada'), '% '.__('Comments', 'Avada')); ?><?php endif; ?>
				</div>
			</div>
			<?php endif; ?>


			<?php if($smof_data['blog_comments']): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
				<div id="text-15" class="widget widget_text">
					<div class="textwidget">
						<div class="seccion">
						<p class="titulo">Dependencia</p>
						<p class="info"></p>
						</div>
						<div class="seccion">
						<p class="titulo">Folio</p>
						<p class="info"></p>
						</div>
						<div class="seccion">
						<p class="titulo">Fecha de solicitud</p>
						<p class="info"></p>
						</div>
						<div class="seccion">
						<p class="titulo">Tipo de documentos</p>
						<p class="info"></p>
						</div>
						<div class="seccion">
						<p class="titulo">Calidad de respuesta</p>
						<p class="info"></p>
						</div>
						<div class="seccion">
						<p class="titulo">Recurso de revisi&oacute;n</p>
						<p class="info"></p>
						<div class="seccion">
						<p class="titulo">Organizaci&oacute;n</p>
						<p class="info"></p>
						</div>
					</div>
				</div>
		
				<?php if( $smof_data['social_sharing_box'] ):
				$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				$sharingbox_soical_icon_options = array (
					'sharingbox'		=> 'yes',
					'icon_colors' 		=> $smof_data['sharing_social_links_icon_color'],
					'box_colors' 		=> $smof_data['sharing_social_links_box_color'],
					'icon_boxed' 		=> $smof_data['sharing_social_links_boxed'],
					'icon_boxed_radius' => $smof_data['sharing_social_links_boxed_radius'],
					'tooltip_placement'	=> $smof_data['sharing_social_links_tooltip_placement'],
					'linktarget'		=> '_blank',
					'title'				=> rawurlencode( $post->post_title ),
					'description'		=> get_the_title( $post->ID ),
					'link'				=> get_permalink( $post->ID ),
					'pinterest_image'	=> rawurlencode( $full_image[0] ),
				);
				?>
				<div class="fusion-sharing-box share-box">					
				<p>Compartir:</p><?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
				</div>
			<?php endif; ?>
	
	</div>
	
<?php get_footer(); ?>