<?php
// Template Name: Solicitudes
get_header(); ?>
<?php
    $args = array(
      'post_type' => 'solicitud',
      'tax_query' => array(
        array(
          'taxonomy' => 'solicitud_category',
          'field' => 'slug'
        )
      )
    );
    $solicitudes = new WP_Query( $args );
    if( $solicitudes->have_posts() ) {
      while( $solicitudes->have_posts() ) {
        $solicitudes->the_post();
        ?>
          <h1><?php the_title() ?></h1>
          <div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
            <?php the_content() ?>
          </div>
        <?php
      }
    }
    else {
      echo 'Oh ohm no products!';
    }
  ?>
  	</div>

	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
	ergy
	</div>


<?php endwhile;?>




	


	<?php endif; ?>
<?php get_footer(); ?>