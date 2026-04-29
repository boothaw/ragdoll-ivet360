<?php
/*
Template Name: Contact Page
*/


get_header(); ?>
<main id="content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php get_template_part('template-parts/default-header'); ?>
        <div class="entry-content inner-wrapper">
            <div class="contact-content">
                <?php the_content(); ?>
            </div>
            <div class="contact-sidebar">
                <div class="lite-card">
                    <h2>Hours</h2>
                    <?php echo do_shortcode('[business_hours]') ?>
                </div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2795.2598617760495!2d-122.6753!3d45.524976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5495732d5ad4de19%3A0x6e8ef0690debfad0!2siVET360!5e0!3m2!1sen!2sus!4v1777401608198!5m2!1sen!2sus"
                    width="100%" height="370" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>