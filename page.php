<?php get_header(); ?>
<?php get_template_part('template-parts/default-header'); ?>
<main id="content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>