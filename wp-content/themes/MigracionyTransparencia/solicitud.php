<?php

/**
 * Template Name: Solicitudes
 *
 */
get_header(); ?>

<?php
  query_posts( array( 'post_type' => 'Solicitud', 'listing_category' => 'solicitud' ) );
  if ( have_posts() ) : while ( have_posts() ) : the_post();
?>

  <h3><?php the_title(); ?></h3>
  <?php the_content(); ?>
dgttyu
<?php endwhile; endif; wp_reset_query(); ?>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" style="<?php echo $sidebar_css; ?>">
	<?php generated_dynamic_sidebar(); ?>
	</div>
	<?php endif; ?>
<?php get_footer(); ?>