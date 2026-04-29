<?php
/*
 * Template Name: Services Page
 */
?>

<?php get_header(); ?>
<?php get_template_part('template-parts/default-header'); ?>
<div class="sticky-service-nav">
    <div class="inner-wrapper sticky-inner">
        <span>Explore Services</span>
        <div class="links-ctn"><a href="#primary">Primary Care</a> <a href="#advanced">Advanced
                Care</a> <a href="#specialty">Specialty Care</a></div>
    </div>
</div>
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