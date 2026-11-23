<?php
// "Explore More [Species] Content" — species comes from the post's tags,
// falling back to a random species when no tag matches one.
$species = evc_blog_species_for_post( get_the_ID() );
if ( ! $species ) {
    return;
}
?>
<section class="blog-explore">
    <div class="blog-explore-inner">
        <?php if ( $species['icon'] ) : ?>
        <img class="blog-explore-icon" src="<?php echo esc_url( $species['icon'] ); ?>" alt="" width="120" height="120" />
        <?php endif; ?>
        <h2 class="blog-explore-title">Explore More <?php echo esc_html( $species['name'] ); ?> Content</h2>
        <a class="dark-button" href="<?php echo esc_url( evc_blog_filter_url( $species['slug'] ) ); ?>">View More Posts</a>
    </div>
</section>
