<?php
	//include de arhivode manejo de base de datos
	include_once "class/search.php";
	include_once "class/functions/string.php";
	
	$slug = getSlug();
	
	if($slug) {
		$Search  = new Search();
		$request = $Search->getBySlug($slug);
		
		if(!$request) {
			header('Location: ' . site_url());
			die();
		}
		
		$response     = $Search->getResponse($request["id_request"]);
		$quality      = $Search->getQualityResponse($response["id_response"]);
		$doc_types    = $Search->getDocumentsTypeResponse($response["id_response"]);
		$resolution   = $Search->getResolution($request["id_request"]);
		$cumplimiento = $Search->getCumplimiento($request["id_request"]);
		$review 	  = $Search->getReview($request["id_request"]);
		
		if($review) {
			$turn_acts = $Search->getActsReviews($review["id_review"]);
		}
	} else {
		header('Location: ' . site_url());
		die();
	}
?>
	
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

			<?php if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))): ?>
				<h2 class="entry-title">
					<?php echo utf8_encode($request["short_name"]); ?>
				</h2>
			<?php else: ?>			
				<span class="entry-title">
					<?php echo utf8_encode($request["short_name"]); ?>
				</span>
				<div class="divisor-3"></div>
			<?php endif; ?>
			
			<div class="post">				
				<div class="post-content">
					<p class="subtitulo-negro">Pregunta</p>
					<div class="divisor-verde"></div>
					<div class="el-contenido">
						<p><?php echo utf8_encode($request["question"]);?></p>	
					</div>
					
					<p class="subtitulo-negro">Respuesta</p>
					<div class="divisor-verde"></div>
					<div class="el-contenido">
						<p><?php echo utf8_encode($response["answer"]);?></p>	
					</div>

					<p class="subtitulo-negro">Recurso de revisi&oacute;n</p>
					<div class="divisor-verde"></div>
					<div class="el-contenido">
						<p>
							<?php
								$string = "";
								if(!$review) echo "No";
								else foreach($turn_acts as $act) $string .= $act["name"] . ",";
								echo utf8_encode(rtrim($string, ","));
							?>
						</p>	
					</div>
					
					<?php if($cumplimiento) { ?>
						<p class="subtitulo-negro">Cumplimiento</p>
						<div class="divisor-verde"></div>
						<div class="el-contenido">
							<p>
								<?php echo utf8_encode($cumplimiento["description"]);?>
							</p>	
						</div>
					<?php } ?>
					
				<div class="avada-row">	
				<div class="fusion-one-third one_third fusion-column">
					<a class="fusion-button button-16" href="http://migracion.fundarlabs.mx/assets/uploads/files/<?php echo $request["file_url"];?>" title="Documento respuesta" target="_blank" type="button">
						Ver respuesta
					</a>
					<span style="padding-right: 1px;"></span>
				</div>
				
				
				<?php if($resolution and !is_null($resolution["file_url"])) { ?>
					<div class="fusion-one-third one_third fusion-column">
						<a class="fusion-button button-16" href="http://migracion.fundarlabs.mx/assets/uploads/files/<?php echo $resolution["file_url"];?>" title="Documento resolución" target="_blank" type="button">
							Ver resoluci&oacute;n
						</a>
						<span style="padding-right: 1px;"></span>
					</div>
				<?php } ?>
				
				<?php if($cumplimiento and !is_null($cumplimiento["file_url"])) { ?>
					<div class="fusion-one-third one_third fusion-column last">
						<a class="fusion-button button-16" href="http://migracion.fundarlabs.mx/assets/uploads/files/<?php echo $cumplimiento["file_url"];?>" title="Documento cumplimiento" target="_blank" type="button">
							Ver cumplimiento
						</a>
					</div>
				<?php } ?>
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
							<p class="info"><?php echo utf8_encode($request["dependecy"]);?></p>
						</div>
						<div class="seccion">
							<p class="titulo">Folio</p>
							<p class="info"><?php echo utf8_encode($request["folio"]);?></p>
						</div>
						<div class="seccion">
							<p class="titulo">Fecha de solicitud</p>
							<p class="info"><?php echo $request["date_published"];?></p>
						</div>
						<div class="seccion">
							<p class="titulo">Tipo de documentos</p>
							<p class="info">
								<?php 
								$string = "";
								foreach($doc_types as $type) $string .= $type["name"] . ",";
								echo utf8_encode(rtrim($string, ","));
								?>
							</p>
						</div>
						<div class="seccion">
							<p class="titulo">Tipo de respuesta</p>
							<p class="info"><?php echo utf8_encode($response["type_answer"]);?></p>
						</div>
						<div class="seccion">
							<p class="titulo">Calidad de respuesta</p>
							<p class="info">
								<?php 
								$string = "";
								foreach($quality as $qua) $string .= $qua["name"] . ",";
								echo utf8_encode(rtrim($string, ","));
								?>
							</p>
						</div>
						<div class="seccion">
							<p class="titulo">Categor&iacute;a</p>
							<p class="info"><?php echo utf8_encode($request["category"]);?></p>
						</div>
						<div class="seccion">
							<p class="titulo">Organizaci&oacute;n</p>
							<p class="info"><?php echo utf8_encode($request["organization"]);?></p>
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
					'title'				=> rawurlencode(utf8_encode($request["short_name"])),
					'description'		=> utf8_encode($request["short_name"]),
					'link'				=> getURL(),
					'pinterest_image'	=> rawurlencode( $full_image[0] ),
				);
				?>
				<div class="fusion-sharing-box share-box">					
				<div class="compartir"><p>Compartir:</p></div><?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
				</div>
			<?php endif; ?>
	
	</div>
	
<?php get_footer(); ?>
