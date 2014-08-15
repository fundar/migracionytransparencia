<?php
	//include de arhivode manejo de base de datos
	include_once "class/search.php";
	include_once "class/functions/string.php";
	
	/*limit offset*/
	$limit       = 10;
	$offset      = getOffset($limit);
	$currentPage = getPage();
	$Search      = new Search();
	
	/*Comprueba si se hizo una busqueda o del home*/
	$query = isSearch();
	
	if($query) {
		$requests = $Search->byQuery($query);
		
		if(!$requests) {
			header('Location: ' . site_url() . "?error=not-found");
			die();
		}
	} else {
		/*Busca todas las solicitudes*/
		$requests = $Search->all($limit, $offset);
		
		if(!$requests) {
			header('Location: ' . site_url());
			die();
		}
		
		/*paginación*/
		$count = $Search->countAll();
		$pages = getPages($limit, $count);
	}
?>

<?php get_header(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/buscar.css" />
<div class="avada-row">
	<div id="content" class="full-width" style="width:100%">
        <div class="search-page-search-form">
			<div class="busca">
				<p class="la-busqueda"><span>Resultado de la busqueda</span></p>
			</div>
		
			<a class="fusion-button button-16" href="/" title="Regrear a la busqueda" type="link">
				Regresar al formulario de busqueda
			</a>
		</div>
		
		<div id="posts-container" class=" clearfix">
			<?php foreach($requests as $request) { ?>
				<div class="post-content">
					<div class="meta">
						<div class="date">
							<p class="year">
								<span>
									<?php echo getYear($request["date_published"]);?>
								</span>
							</p>
							<p class="month">
								<span><?php echo getMonth($request["date_published"]);?>/<?php echo getDay($request["date_published"]);?></span>
							</p>
						</div>
					</div>
					<div class="excerpt-container strip-html">
						<h2 class="entry-title">
							<a href="/solicitudes/solicitud/?slug=<?php echo $request["slug"];?>" title="<?php echo utf8_encode($request["short_name"]);?>">
								<?php echo utf8_encode($request["short_name"]);?>
							</a>
						</h2>
						<p><?php echo utf8_encode($request["question"]);?></p>
					</div>
					
					<?php if( $smof_data['social_sharing_box'] ) {
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
							'link'				=> home_url() . "/solicitudes/solicitud/?slug=" . $request["slug"],
							'pinterest_image'	=> rawurlencode( $full_image[0] ),
						);
					} ?>
				
					<div class="fusion-sharing-box share-box">					
						<?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
					</div>						
				</div>
				<div class="divisor-gris-dotted"></div>
			<?php } ?>
		</div>
		
		<?php if(isset($pages)) { ?>
			<?php for($page=1; $page<=$pages; $page++) { ?>
				<a class="pag" href="/solicitudes/?page=<?php echo $page; ?>" title="Paginación de solicitudes"<?php echo ($currentPage==$page) ? ' class="active-page"' : '';?>>
					<?php echo $page; ?>
				</a>
			<?php } ?>
		<?php } ?>
	</div>
</div>

<?php get_footer(); ?>
