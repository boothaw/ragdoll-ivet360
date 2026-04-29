<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (  ( is_singular('post') && has_category( array('DVM', 'Team') ) ) ) { ?>
    <?php get_template_part('template-parts/team-header'); ?>
    <?php } else { ?>
    <?php get_template_part('template-parts/default-header'); ?>
    <?php } ?>
    <?php get_template_part( 'entry', ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
    <?php if ( is_singular() ) { get_template_part( 'entry-footer' ); } ?>
</article>