<header class="header">
    <div
        class="inner-header <?php if ( has_post_thumbnail() ) { ?> has-thumbnail <?php } else { ?> no-thumbnail <?php } ?>">
        <div class="entry-title">
            <h1 class="baseline"><?php echo get_the_title(); ?></h1>
            <?php if ( has_excerpt()) {
                echo '<p class="baseline">' . get_the_excerpt() . '</p>' ?>
            <?php } ?>
            <?php if ( is_front_page() || ( is_singular('post') && has_category('services') ) ) { ?>
            <div class="buttons-ctn">
                <?php $url = find_url(564,'/cityname-statecode-veterinary-appointment/'); ?>
                <a class="dark-button" href="<?php echo $url ?>">Book Now</a>
                <a class="ghost-button"
                    href="tel:<?php the_author_meta( 'phone' )?>"><?php the_author_meta( 'phone' )?></a>
            </div>
            <?php } ?>
        </div>
        <?php if ( has_post_thumbnail() ) { ?>
        <img class="thumbnail-image" src=<?php echo get_the_post_thumbnail_url(); ?>"
            alt="<?php echo get_the_title(); ?>" />
        <?php } ?>
    </div>
</header>