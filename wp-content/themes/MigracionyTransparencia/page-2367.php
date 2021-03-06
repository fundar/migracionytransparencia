<?php get_header(); ?>
	<?php
	$content_css = '';
	$sidebar_css = '';
	$sidebar_exists = true;
	if(get_post_meta($post->ID, 'pyre_full_width', true) == 'yes') {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
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
	if(class_exists('Woocommerce')) {
		if(is_cart() || is_checkout() || is_account_page() || (get_option('woocommerce_thanks_page_id') && is_page(get_option('woocommerce_thanks_page_id')))) {
			$content_css = 'width:100%';
			$sidebar_css = 'display:none';
			$sidebar_exists = false;
		}
	}
	?>
	<div id="content" class="inicio" style="<?php echo $content_css; ?>">
		<?php
		if(have_posts()): the_post();
		?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<span class="entry-title" style="display: none;"><?php the_title(); ?></span>
			<span class="vcard" style="display: none;"><span class="fn"><?php the_author_posts_link(); ?></span></span>
			<span class="updated" style="display:none;"><?php the_modified_time( 'c' ); ?></span>		
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php global $smof_data; if(!$smof_data['featured_images_pages'] ): ?>
			<?php if($smof_data['legacy_posts_slideshow']):
			$args = array(
			    'post_type' => 'attachment',
			    'numberposts' => $smof_data['posts_slideshow_number']-1,
			    'post_status' => null,
			    'post_parent' => $post->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image',
				'exclude' => get_post_thumbnail_id()
			);
			$attachments = get_posts($args);
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(!$smof_data['posts_slideshow']): ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php elseif(has_post_thumbnail() ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php else: ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment->ID, '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php else: ?>
			<?php
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(!$smof_data['posts_slideshow']): ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php elseif(has_post_thumbnail() ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php else: ?>
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php
					$i = 2;
					while($i <= $smof_data['posts_slideshow_number']):
					$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'page');
					if($attachment_new_id):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment_new_id); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment_new_id); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" /></a>
					</li>
					<?php endif; $i++; endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<?php endif; ?>
			<?php endif; // password check ?>
			
			<?php
				//include de arhivode manejo de base de datos
				include_once "class/catalogos.php";
				include_once "class/functions/string.php";
				
				$Catalogos      = new Catalogos();
				
				/*obtiene los catalogos para la busqueda*/
				$categories     = $Catalogos->categories();
				$answers_types  = $Catalogos->answersTypes();
				$organizations  = $Catalogos->organizations();
				$dependencies   = $Catalogos->dependencies();
				$years		    = $Catalogos->years();
				
				/*obtiene el html de la numeralia*/
				$numeralia      = $Catalogos->getNumeralia();
			?>
			
		<form action="/solicitudes" method="get" role="search" class="seach-form" id="searchform">
			<div class="post-content" style="margin: -29px 0px 0px;">
				<a name="busqueda"></a>
				<div class="heading"><h3 class="titulo-post">Buscar solicitud</h3></div>
				
				<?php if(isError()) { ?>
				        <div class="fusion-alert alert error alert-dismissable alert-danger">
					<button aria-hidden="true" data-dismiss="alert" class="close toggle-alert" type="button">×</button>                                       
					<p>Actualmente, la información que buscaste no se encuentra en la base de datos.</p>
                                        <p>¿Quieres saber cómo solicitar información pública al gobierno?</p>
                                        <p>Piensa unos minutos sobre qué información necesitas, si ya puede ser pública y disponible en algún lugar, y si no, quién la debería
					tener. Si la información la tiene el gobierno federal, entonces puedes hacer una solicitud de acceso a información a través del sistema
					<a href="https://www.infomex.org.mx/" target="_blank">Infomex</a>. No olvides que siempre hay que preguntar por documentos. Para recibir tips, puedes escribirnos a través
					del <a href="http://migracionytransparencia.org/contacto/" target="_blank">formulario de contacto</a>.</p>
					</div>

				<?php } ?>
				
				<p class="formahome">B&uacute;squeda por palabra</p>
				<div class="search-table">
					<div class="search-field">
						<input type="text" placeholder="Buscar ..." id="s" name="search_query" value="">
					</div>
					<!--
						<div class="search-button">
							<input type="submit" value="&#xf002;" id="searchsubmit">
						</div>
					-->
				</div>
				<p class="formahome2">B&uacute;squeda por folio</p>
				<div class="search-table">
					<div class="search-field">
						<input type="text" placeholder="Buscar ..." id="s" name="search_folio" value="">
					</div>
					<!--
						<div class="search-button">
							<input type="submit" value="&#xf002;" id="searchsubmit">
						</div>
					-->
				</div>
			        </form>
				<p class="formahome2">Por categor&iacute;a</p>
				<div class="search-table">
					<div class="search-field">						
						<select class="search-field search-table" name="category">
							<option value="0">Selecciona una categor&iacute;a</option>
							<?php foreach($categories as $category) { ?>
								<option value="<?php echo $category["id_category"];?>"><?php echo utf8_encode($category["name"]);?></option>
							<?php } ?>
						</select>
					</div>
	
				</div>
				<p class="formahome2">Por dependencia</p>
				<div class="search-table">
					<div class="search-field">						
						<select class="search-field search-table" name="dependency">
							<option value="0">Selecciona una dependencia</option>
							<?php foreach($dependencies as $dependeny) { ?>
								<option value="<?php echo $dependeny["id_dependecy"];?>"><?php echo utf8_encode($dependeny["name"]);?></option>
							<?php } ?>
						</select>
					</div>
	
				</div>
				<p class="formahome2">Por organizaci&oacute;n</p>
				<div class="search-table">
					<div class="search-field">						
						<select class="search-field search-table" name="organization">
							<option value="0">Selecciona una organizaci&oacute;n</option>
							<?php foreach($organizations as $organization) { ?>
								<option value="<?php echo $organization["id_organization"];?>"><?php echo utf8_encode($organization["name"]);?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<p class="formahome2">Por tipo de respuesta</p>
				<div class="search-table">
					<div class="search-field">						
						<select class="search-field search-table" name="answer_type">
							<option value="0">Selecciona un tipo de respuesta</option>
							<?php foreach($answers_types as $answer) { ?>
								<option value="<?php echo $answer["id_type_answer"];?>"><?php echo utf8_encode($answer["name"]);?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<p class="formahome2">Por a&ntilde;o</p>
				<div class="search-table">
					<div class="search-field">
						<select class="search-field search-table" name="ano">
						   <option value="0">Selecciona un a&ntilde;o</option>
						   <?php foreach($years as $year) { ?>
								<option value="<?php echo $year["year"];?>"><?php echo utf8_encode($year["year"]);?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="avada-row" style="margin-top: 30px;">	
					<div style="float: left; margin-right: 5px;">
						<input type="submit" id="submit" class="button-flat busquedas-boton" value="buscar" tabindex="5" name="buscar">
					</div>
                    <div style="float: left;">
						<a class="boton-solicitudes" href="http://migracionytransparencia.org/solicitudes/" type="button">Ver todas las solicitudes</a>
					</div>
				</div>
			</div> <!--fin post content div -->
		</form>
			
			
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if(class_exists('Woocommerce')): ?>
			<?php if($smof_data['comments_pages'] && !is_cart() && !is_checkout() && !is_account_page() && !is_page(get_option('woocommerce_thanks_page_id'))): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php else: ?>
			<?php if($smof_data['comments_pages']): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php endif; ?>
			<?php endif; // password check ?>
		</div>
		
		
		<?php endif; ?>
	</div>
		<div id="sidebar" class="Acercade">						<?php 
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('Acerca de') ) : ?>
                <?php endif; ?>
	</div>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="SidebarInicio" style="<?php echo $sidebar_css; ?>"><?php generated_dynamic_sidebar(); ?></div>

			
	
		
<!-- inicio #recientes- entradas-->
        <div id="content" class="full-width">
		<div class="divisor-2"></div>		
		
			
		<?php 
	$service_query = new WP_Query('page_id=3747');
			while ( $service_query->have_posts() ) : $service_query->the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

		<div class="post_content clearfix" style="padding: 3px 0px;">
			<h3 class="headings"><?php the_title(); ?></h3>
			
			<?php the_content(); ?>
			<?php themefusion_pagination($pages = '', $range = 2); ?>
		</div> 	<!-- end .post_content -->
	</article> <!-- end .entry -->
       <?php endwhile; // end of the loop. ?>
		
	</div><!-- post recientes -->
	
<!-- inicio #organizaciones-->
        <div id="content" class="full-width">
		<div class="divisor-2"></div>		
		
			
		<?php 
	$service_query = new WP_Query('page_id=10531');
			while ( $service_query->have_posts() ) : $service_query->the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

		<div class="post_content clearfix" style="padding: 3px 0px;">
			<h3 class="headings"><?php the_title(); ?></h3>
			
			<?php the_content(); ?>
			<?php themefusion_pagination($pages = '', $range = 2); ?>
		</div> 	<!-- end .post_content -->
	</article> <!-- end .entry -->
       <?php endwhile; // end of the loop. ?>
		
	</div><!-- organizaciones -->		
	
	
	<?php endif ;?>
	<script>
		/*Inserta el html de la numeralia al inicio del sidebar de la numeralia*/
		jQuery(document).ready( function () {
			jQuery('.SidebarInicio > .widget > .textwidget').prepend('<?php echo $numeralia;?>');
		});
	</script>
	
<?php get_footer(); ?>
