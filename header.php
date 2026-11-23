<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />


    <link rel="preload" href="https://use.typekit.net/ieq7wgm.css" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://use.typekit.net/ieq7wgm.css">
    </noscript>
	
	<meta name="msvalidate.01" content="11752785691794D19B62315044917C36" />

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="EVC" />
    <link rel="manifest" href="/site.webmanifest" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="sticky-header">
        <div class="sticky-section" id="sticky-one">
            <?php $url = 'https://vet.digitail.io/clinics/exotic-vet-care'; ?>
            <a class="sticky-button" href="<?php echo $url ?>" aria-label="book online" target="_blank" rel="noopener noreferrer"> <i
                    class="fas fa-calendar-day"></i>
                <span>Book Online</span></a>
        </div>
        <div class="sticky-section" id="sticky-two">
            <a class="sticky-button" href="tel:<?php the_author_meta( 'phone' )?>" aria-label="call us"> <i style="transform: scaleX(-1);"
                    class="fas fa-phone"></i> <span>Call Now</span></a>
        </div>
        <div class="sticky-section" id="sticky-three">
            <a class="sticky-button" href="https://exoticvetcare.myvetstoreonline.pharmacy/shop" target="_blank" aria-label="pharmacy"> <i
                    class="fas fa-prescription-bottle-alt"></i>
                <span>Online Pharmacy</span> </a>
        </div>
    </div>
    <div id="wrapper" class="hfeed">
        <header id="header">
            <div id="main-header">
                <div class="nav-header-inner">
                    <div class="logo-container">
                        <a href="/" id="logo-anchor"><img class="header-logo"
                                src="/wp-content/uploads/2026/09/Exotic-Vet-Care-Logo.svg"
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
                            <a class="dark-button emergency-button" href="/emergency-care/" aria-label="emergencies">
                                <svg class="btn-icon btn-icon--flip" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                    aria-hidden="true" focusable="false">
                                    <path
                                        d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h16c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm144-248c0 4.4-3.6 8-8 8h-56v56c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8v-56h-56c-4.4 0-8-3.6-8-8v-48c0-4.4 3.6-8 8-8h56v-56c0-4.4 3.6-8 8-8h48c4.4 0 8 3.6 8 8v56h56c4.4 0 8 3.6 8 8v48zm176 248c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z" />
                                </svg>
                                <span>Emergency Care</span>
                            </a>
                            <a class="dark-button" href="<?php echo $url ?>" target="_blank" rel="noopener noreferrer">
                                Book Now 24/7</a>
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