<?php get_header(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/buscar.css" />
<div class="avada-row">
	<div id="content" class="full-width" style="width:100%">
        <!--
        <div class="search-page-search-form">
		<div class="busca">
			<p class="la-busqueda"><span>Buscar</span></p>
		</div>
		
		<form id="searchform" class="seach-form" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
			<div class="search-table">
				<div class="search-field"><input type="text" value="" name="s" id="s" placeholder="<?php _e( 'Search ...', 'Avada' ); ?>"/></div>
				<div class="search-button"><input type="submit" id="searchsubmit" value="&#xf002;" /></div>
			</div>
		</form>
		-->
	</div>
	
	<div id="posts-container" class=" clearfix">
		<div class="post-content">
			<div class="meta">
				<div class="date">
					<p class="year"><span>2013</span></p>
					<p class="month">11/02</p>
				</div>
			</div>
			<div class="excerpt-container strip-html">
				<h2 class="entry-title">
					<a href="">Prueba</a>
				</h2>
				<p>Prueba</p>
			</div>
			
			<div class="fusion-sharing-box share-box">					
				<?php echo $social_icons->render_social_icons( $sharingbox_soical_icon_options ); ?>
			</div>						
		</div>
	</div>
	
	<div class="divisor-gris-dotted"></div>
</div>
</div>

<?php get_footer(); ?>
