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
	
	<?php
		//include de arhivode manejo de base de datos
		include_once "class/search.php";
		
		$Search  = new Search();
		$results = $Search->example();
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
			<div class="divisor-3"></div>
			<?php endif; ?>
			<div class="post">				
				<div class="post-content>
					<p class="subtitulo-negro">Pregunta</p>
					<div class="divisor-verde"></div>
					<div class="el-contenido">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sit amet arcu malesuada, molestie leo et, semper felis.</p>	
					</div>				
					<p class="subtitulo-negro">Respuestas</p>
					<div class="divisor-verde"></div>
					<div class="el-contenido">
						<p>Vestibulum placerat condimentum nibh, a vulputate mi fermentum in. Nulla laoreet libero id felis rhoncus consectetur. Aliquam erat volutpat. Fusce volutpat erat sem, sit amet feugiat ipsum cursus sit amet. Duis in est mauris. Aenean sodales, tortor id tempor pellentesque, lectus felis tincidunt eros, ac tempus massa leo non ipsum.</p> 
					</div>
				<div class="avada-row">	
				<div class="fusion-one-third one_third fusion-column">
					<a class="fusion-button button-16 " href="" title="" target="_blank" type="button">Ver respuesta</a><span style="padding-right: 1px;"></span>
				</div>
				<div class="fusion-one-third one_third fusion-column">					<a class="button medium button custom fusion-button button-flat button-round button-medium button-custom button-16 buttonshadow-no" href="" title="" target="_blank" type="button">Ver resoluci&oacute;n</a><span style="padding-right: 1px;"></span></div>
				<div class="fusion-one-third one_third fusion-column last"><a class="button medium button custom fusion-button button-flat button-round button-medium button-custom button-16 buttonshadow-no" href="" title="" target="_blank" type="button">Ver cumplimiento</a></div>
			        </div>
			</div>
				
			</div>
		</div>
		<?php endif; ?>
	</div>
	
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
				<div id="text-15" class="widget widget_text">
					<div class="textwidget">
						<div class="seccion">
						<p class="titulo">Dependencia</p>
						<p class="info">Instituto Nacional de Migracion</p>
						</div>
						<div class="seccion">
						<p class="titulo">Folio</p>
						<p class="info">0411100082710</p>
						</div>
						<div class="seccion">
						<p class="titulo">Fecha de solicitud</p>
						<p class="info">8 de diciembre de 2013</p>
						</div>
						<div class="seccion">
						<p class="titulo">Tipo de documentos</p>
						<p class="info">Leyes, Protocolos, Circulares</p>
						</div>
						<div class="seccion">
						<p class="titulo">Calidad de respuesta</p>
						<p class="info">Completa, Legible</p>
						</div>
						<div class="seccion">
						<p class="titulo">Recurso de revisi&oacute;n</p>
						<p class="info">No</p>
						<div class="seccion">
						<p class="titulo">Organizaci&oacute;n</p>
						<p class="info">Fundar, Centro de Analisis e Investigacion</p>
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
				<div class="compartir"><p>Compartir:</p></div><?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
				</div>
			<?php endif; ?>
	
	</div>
	
<?php get_footer(); ?>
