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
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3353.29813823482!2d-79.8714723!3d32.810864599999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88fe71ac55ad8bd1%3A0x3d1fd4e0fdc88bfb!2sExotic%20Vet%20Care!5e0!3m2!1sen!2sus!4v1789660222843!5m2!1sen!2sus"
                    width="100%" height="370" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>