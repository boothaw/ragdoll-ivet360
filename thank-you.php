<?php
/*
Template Name: Thank You Page
*/

get_header(); ?>
<main id="content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="header">
            <div
                class="inner-header <?php if ( has_post_thumbnail() ) { ?> has-thumbnail <?php } else { ?> no-thumbnail <?php } ?>">
                <div class="entry-title">
                    <h1 class="baseline">Thank You</h1>
                    <?php if ( has_excerpt()) {
                echo '<p class="baseline">' . get_the_excerpt() . '</p>' ?>
                    <?php } ?>
                </div>
            </div>
        </header>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </article>
    <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>