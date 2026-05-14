<?php $position = get_field('position'); ?>
<header class="header staff-header">
    <div
        class="inner-header <?php if ( has_post_thumbnail() ) { ?> has-thumbnail <?php } else { ?> no-thumbnail <?php } ?>">
        <div class="entry-title">
            <h1 class="baseline"><?php echo get_the_title(); ?></h1>
            <!-- <p class="baseline"><?php echo $position ?></p> -->
            <?php if ( has_excerpt() ) { echo '<p class="baseline">' . get_the_excerpt() . '</p>'; } ?>
            <div class="buttons-ctn">
                <a class="dark-button" href="#bio">Read Bio</a>
            </div>
        </div>
        <?php if ( has_post_thumbnail() ) { ?>
        <img class="thumbnail-image" src="<?php echo get_the_post_thumbnail_url(); ?>"
            alt="<?php echo get_the_title(); ?>" />
        <?php } ?>
    </div>
</header>