<?php
/*
Template Name: Single Solicitud
*/
?>
<?php get_header(); ?>

        <div class="content">
            
                <?
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                $type = get_post_type( get_the_ID() );
                if($type == "solicitud"){
                ?>

                <?php the_title(); //show post title?>

                    <?
                    the_content();                    
                    ?>
                
                <?    
                }
                endwhile;
                endif;    
                ?>
                        
        </div>
        
        <?php get_footer(); ?>
<?php get_footer(); ?>