<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="https://use.typekit.net/dai5bzy.css">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="wrapper" class="hfeed">
        <header id="header">
            <div id="main-header">
                <div class="nav-header-inner">
                    <div class="logo-container">
                        <a href="/" id="logo-anchor"><img class="header-logo" src="/wp-content/uploads/2025/10/Logo.svg"
                                alt="<?php echo get_bloginfo('name') ?>"></a>
                    </div>
                    <div class="nav-container">
                        <nav id="menu">
                            <?php wp_nav_menu(
                    array(
                        'menu' => 'Main Menu',
                        'theme_location' => 'Main Menu',
                        'menu_id' => 'main-menu'
                    )
                    ); ?>
                            <div id="hamburger">
                                <div class="burger-line"></div>
                            </div>
                        </nav>
                    </div>
                    <div class="nav-cta">
                        <div class="nav-cta-inner">
                            <?php $url = find_url(564,'/cityname-statecode-veterinary-appointment/'); ?>
                            <a class="ghost-button" href="tel:<?php the_author_meta( 'phone' )?>">
                                <i style="transform: scaleX(-1);" class="fas fa-phone"></i>
                                <span><?php the_author_meta( 'phone' )?></span></a>
                            <a class="dark-button" href="<?php echo $url ?>">
                                Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <nav id="mobile-menu-container">
                <?php wp_nav_menu(
                array(
                    'menu' => 'Main Menu',
                    'theme_location' => 'Main Menu',
                    'menu_id' => 'mobile-menu'
                )
                ); ?>
            </nav>
        </header>
        <div id="container">