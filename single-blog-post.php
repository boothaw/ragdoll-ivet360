<?php
/*
 * Template Name: Blog Post
 * Template Post Type: post
 */

get_header(); ?>
<main id="content" class="blog-single">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php get_template_part( 'template-parts/blog-header' ); ?>

        <section class="blog-single-body">
            <div class="entry-content blog-single-content">
                <?php the_content(); ?>
                <div class="entry-links"><?php wp_link_pages(); ?></div>
            </div>
        </section>

        <?php get_template_part( 'template-parts/blog-explore' ); ?>
    </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
