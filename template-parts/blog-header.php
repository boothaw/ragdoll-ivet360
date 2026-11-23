<?php
$blog_labels = evc_blog_labels();
$desc      = function_exists( 'get_field' ) ? get_field( 'descriptive_title' ) : '';
?>
<header class="header blog-header">
    <div class="inner-header <?php echo has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail'; ?>">
        <div class="entry-title">
            <p class="blog-header-date"><time
                    datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></time>
            </p>
            <h1 class="baseline"><?php echo $desc ? esc_html( $desc ) : esc_html( get_the_title() ); ?></h1>
            <?php if ( $blog_labels ) : ?>
            <ul class="buttons-ctn blog-tags blog-header-tags">
                <?php foreach ( $blog_labels as $label ) : ?>
                <li class="blog-tag"><?php echo esc_html( $label ); ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <?php if ( has_post_thumbnail() ) {
            the_post_thumbnail( 'large', array( 'class' => 'thumbnail-image', 'alt' => '' ) );
        } ?>
    </div>
</header>