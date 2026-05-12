<?php
/*
Template Name: Simple Template
Template Post Type: post, page
*/


get_header(); ?>
<main id="content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php get_template_part('template-parts/default-header'); ?>
        <div class="post-container">
            <div class="entry-content post-content lite-card inner-wrapper">
                <?php the_content(); ?>
                <div class="entry-links"><?php wp_link_pages(); ?></div>
            </div>
            <?php if ( has_category( 'services' ) ) :
                $homepage_id = get_option( 'page_on_front' );
                $blocks = parse_blocks( get_post_field( 'post_content', $homepage_id ) );
                foreach ( $blocks as $block ) {
                    if ( 'image-content-block/main' === $block['blockName'] && ! empty( $block['attrs']['className'] ) && false !== strpos( $block['attrs']['className'], 'services-cta' ) ) {
                        echo preg_replace( '/<p[^>]*>.*?<\/p>/si', '', render_block( $block ) );
                        break;
                    }
                }
            endif; ?>
        </div>
    </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>