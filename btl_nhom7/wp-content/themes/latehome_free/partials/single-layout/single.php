<?php

$container = get_theme_mod('latehome_free_container_type');


?>
<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

    <div class="row">

        <!-- Do the left sidebar check -->
        <?php get_template_part('global-templates/left-sidebar-check'); ?>

        <div class="site-main" id="main">

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('partials/loop/content-single'); ?>

                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; // end of the loop. ?>

        </div><!-- #main -->

        <!-- Do the right sidebar check -->
        <?php get_template_part('global-templates/right-sidebar-check'); ?>

    </div><!-- .row -->
</div>	
