<?php get_header(); ?>
<main id="content">
    <article id="post-0" class="post not-found">
        <header class="header">
            <div class="inner-header">
                <h1 class="entry-title baseline"><?php esc_html_e( '...Oops', 'blankslate' ); ?></h1>
            </div>
        </header>
        <div class="post-container">
            <div class="entry-content post-content">
                <div class="post-img-container">
                    <img src="/wp-content/uploads/2020/04/trash-dog_404.png" alt="Dog with their head in a trash can">
                </div>
                <h2 class="post-title">We can’t seem to find the page you’re looking for</h2>
                <div id="error-box">
                    <p id="error-code">ERROR CODE: 404</p>
                    <p id="error-message">Maybe it’s out there somewhere...<br>You can usually find what you’re looking
                        for on our <a href="/">homepage</a>.</p>
                </div>
            </div>
        </div>
    </article>
</main>
<?php get_footer(); ?>