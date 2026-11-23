<?php
/*
 * Template Name: Blog Page
 */
?>

<?php get_header(); ?>
<?php get_template_part('template-parts/default-header'); ?>
<?php
$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

// Sidebar topics (category slug => label), in the mockup's order.
$blog_topics = array(
    'pet-health-care'         => 'Pet Health & Care',
    'case-studies'            => 'Case Studies & Patient Stories',
    'what-to-expect'          => 'What to Expect & Client Resources',
    'practice-news-community' => 'Practice News & Community',
    'wildlife-conservation'   => 'Wildlife & Conservation',
);

// Active filters come from the URL: /blog/?topic=pet-health-care&animal=snakes
$topic_slug  = isset( $_GET['topic'] ) ? sanitize_title( wp_unslash( $_GET['topic'] ) ) : '';
$topic_slug  = isset( $blog_topics[ $topic_slug ] ) ? $topic_slug : '';
$topic_cat   = $topic_slug ? get_category_by_slug( $topic_slug ) : false;
$animal_slug = isset( $_GET['animal'] ) ? sanitize_title( wp_unslash( $_GET['animal'] ) ) : '';
$species_all = evc_species_list();
$animal_tag  = $animal_slug ? get_term_by( 'slug', $animal_slug, 'post_tag' ) : false;
// a species with no tag yet (e.g. Amphibians) is still a valid filter — it just has no posts
$animal_name = $animal_tag ? $animal_tag->name : ( isset( $species_all[ $animal_slug ] ) ? $species_all[ $animal_slug ]['name'] : '' );
$animal_slug = $animal_name ? $animal_slug : '';

// Grab the page URL now — inside the post loop get_permalink() returns the post's URL.
$blog_page_url = get_permalink();

/**
 * Blog page URL with one filter changed. Passing the active value again
 * (or '') clears it, so sidebar items toggle. Always goes back to page 1.
 */
$blog_filter_link = function ( $key, $value ) use ( $topic_slug, $animal_slug, $blog_page_url ) {
    $filters = array( 'topic' => $topic_slug, 'animal' => $animal_slug );
    $filters[ $key ] = ( $filters[ $key ] === $value ) ? '' : $value;
    return add_query_arg( array_filter( $filters ), $blog_page_url );
};

$blog_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'category_name'  => $topic_cat ? $topic_slug : 'blog',
);
if ( $animal_tag ) {
    $blog_args['tag_id'] = $animal_tag->term_id;
} elseif ( $animal_slug ) {
    $blog_args['post__in'] = array( 0 ); // valid species, no posts tagged yet
}
$blog_query = new WP_Query( $blog_args );

$blog_close = '<svg width="12.728" height="12.7279" viewBox="0 0 12.728 12.7279" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M6.36396 4.94978L11.3138 0L12.728 1.41421L7.77816 6.36398L12.728 11.3137L11.3138 12.7279L6.36396 7.77818L1.41422 12.7279L0 11.3137L4.94976 6.36398L0 1.41421L1.41422 0L6.36396 4.94978Z" fill="currentColor"/></svg>';

$blog_arrow = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect width="40" height="40" rx="12" fill="#002a4e" /><path d="M24.1716 18.9999L18.8076 13.6359L20.2218 12.2217L28 19.9999L20.2218 27.778L18.8076 26.3638L24.1716 20.9999H12V18.9999H24.1716Z" fill="#fff" /></svg>';
?>
<main id="content" class="blog-page">
    <section class="blog-section">
        <div class="blog-inner">
            <div class="blog-heading">
                <h2>All Posts</h2>
                <p class="blog-count"><?php echo number_format_i18n( $blog_query->found_posts ); ?> Articles</p>
            </div>

            <div class="blog-layout">
                <div class="blog-posts">
                    <?php if ( $animal_slug || $topic_cat ) : ?>
                    <div class="blog-active-filters" aria-label="Active filters">
                        <?php if ( $animal_slug ) : ?>
                        <a class="blog-active-filter" href="<?php echo esc_url( $blog_filter_link( 'animal', $animal_slug ) ); ?>">
                            <?php echo esc_html( $animal_name ); ?><span class="screen-reader-text"> (remove filter)</span><?php echo $blog_close; ?>
                        </a>
                        <?php endif; ?>
                        <?php if ( $topic_cat ) : ?>
                        <a class="blog-active-filter" href="<?php echo esc_url( $blog_filter_link( 'topic', $topic_slug ) ); ?>">
                            <?php echo esc_html( $blog_topics[ $topic_slug ] ); ?><span class="screen-reader-text"> (remove filter)</span><?php echo $blog_close; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( $blog_query->have_posts() ) : ?>
                    <div class="blog-post-list">
                        <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                        <?php $card_labels = evc_blog_labels( get_the_ID(), 3 ); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-card' ); ?>>
                            <a class="blog-post-link" href="<?php the_permalink(); ?>">
                                <div class="blog-post-image">
                                    <?php if ( has_post_thumbnail() ) {
                                        the_post_thumbnail( 'large', array( 'alt' => '', 'loading' => 'lazy' ) );
                                    } ?>
                                </div>
                                <div class="blog-post-body">
                                    <?php if ( $card_labels ) : ?>
                                    <ul class="blog-tags">
                                        <?php foreach ( $card_labels as $label ) : ?>
                                        <li class="blog-tag"><?php echo esc_html( $label ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                    <h3 class="blog-post-title"><?php the_title(); ?></h3>
                                    <p class="blog-post-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
                                    <span class="blog-post-arrow"><?php echo $blog_arrow; ?></span>
                                </div>
                            </a>
                        </article>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    $pagination = paginate_links( array(
                        'base'      => trailingslashit( $blog_page_url ) . '%_%',
                        'format'    => 'page/%#%/',
                        'current'   => $paged,
                        'total'     => $blog_query->max_num_pages,
                        'add_args'  => array_filter( array( 'topic' => $topic_slug, 'animal' => $animal_slug ) ),
                        'mid_size'  => 1,
                        'prev_text' => '<span class="screen-reader-text">Previous page</span>&larr;',
                        'next_text' => '<span class="screen-reader-text">Next page</span>&rarr;',
                    ) );
                    if ( $pagination ) : ?>
                    <nav class="blog-pagination" aria-label="Blog pagination">
                        <?php echo $pagination; ?>
                    </nav>
                    <?php endif; ?>

                    <?php else : ?>
                    <p class="blog-empty">No articles match these filters yet. <a href="<?php echo esc_url( $blog_page_url ); ?>">View all posts</a></p>
                    <?php endif; wp_reset_postdata(); ?>
                </div>

                <aside class="blog-sidebar" aria-label="Filter blog posts">
                    <div class="blog-filter-card">
                        <h3 class="blog-filter-title"><button type="button" class="blog-filter-toggle" aria-expanded="true" aria-controls="blog-filter-topic">Browse By Topic<svg class="blog-filter-chevron" width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true"><path d="M1 1l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button></h3>
                        <ul class="blog-filter-list" id="blog-filter-topic">
                            <?php foreach ( $blog_topics as $slug => $topic ) : $is_active = ( $slug === $topic_slug ); ?>
                            <li>
                                <a class="blog-filter-item<?php echo $is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $blog_filter_link( 'topic', $slug ) ); ?>"<?php echo $is_active ? ' aria-current="true"' : ''; ?>>
                                    <span class="blog-filter-label"><?php echo esc_html( $topic ); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <?php
                    $species = get_posts( array(
                        'category_name'  => 'species',
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ) );
                    if ( $species ) : ?>
                    <div class="blog-filter-card">
                        <h3 class="blog-filter-title"><button type="button" class="blog-filter-toggle" aria-expanded="true" aria-controls="blog-filter-animal">Browse By Animal<svg class="blog-filter-chevron" width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true"><path d="M1 1l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button></h3>
                        <ul class="blog-filter-list" id="blog-filter-animal">
                            <?php foreach ( $species as $species_post ) :
                                $icon_id  = function_exists( 'get_field' ) ? get_field( 'species_icon', $species_post->ID ) : '';
                                $icon_url = $icon_id ? wp_get_attachment_image_url( $icon_id, 'thumbnail' ) : '';
                                $slug      = sanitize_title( $species_post->post_title );
                                $is_active = ( $slug === $animal_slug );
                            ?>
                            <li>
                                <a class="blog-filter-item has-icon<?php echo $is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $blog_filter_link( 'animal', $slug ) ); ?>"<?php echo $is_active ? ' aria-current="true"' : ''; ?>>
                                    <span class="blog-filter-icon">
                                        <?php if ( $icon_url ) : ?>
                                        <img src="<?php echo esc_url( $icon_url ); ?>" alt="" aria-hidden="true" />
                                        <?php endif; ?>
                                    </span>
                                    <span class="blog-filter-label"><?php echo esc_html( get_the_title( $species_post ) ); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>
