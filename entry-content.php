<div class="post-container">
    <div class="entry-content post-content" <?php if ( has_category( array( 'dvm', 'team', 'staff' ) ) ) { echo 'id="bio"'; } ?> >
        <?php the_content(); ?>
        <div class="entry-links"><?php wp_link_pages(); ?></div>
    </div>
</div>