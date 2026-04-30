<?php
add_action( 'after_setup_theme', 'blankslate_setup' );

function blankslate_setup() {
  load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'html5', array( 'search-form' ) );
  global $content_width;
  if ( ! isset( $content_width ) ) { $content_width = 1920; }
  register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'blankslate' ) ) );
}
add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_enqueue() {
wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
wp_enqueue_script( 'jquery' );
}
//add_action( 'wp_footer', 'blankslate_footer' );
function blankslate_load_scripts() {
  wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
  wp_enqueue_script( 'gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/gsap.min.js', array(), null, true );
  wp_enqueue_script( 'gsap-splittext', 'https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/SplitText.min.js', array( 'gsap' ), null, true );
  wp_enqueue_script( 'custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js' , array( 'jquery', 'gsap', 'gsap-splittext' ), '1.0.1', true  );
  wp_enqueue_style( 'lp-styling', get_stylesheet_directory_uri() . '/lp.css' );

}
add_action( 'wp_footer', 'blankslate_footer_scripts' );

function blankslate_footer_scripts() {
}
add_filter( 'document_title_separator', 'blankslate_document_title_separator' );

function blankslate_document_title_separator( $sep ) {
  $sep = '|';
  return $sep;
}
add_filter( 'the_title', 'blankslate_title' );

function blankslate_title( $title ) {
  if ( $title == '' ) {
    return '...';
  } else {
    return $title;
  }
}
add_filter( 'the_content_more_link', 'blankslate_read_more_link' );

function blankslate_read_more_link() {
  if ( ! is_admin() ) {
    return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
  }
}
add_filter( 'excerpt_more', 'blankslate_excerpt_read_more_link' );

function blankslate_excerpt_read_more_link( $more ) {
  if ( ! is_admin() ) {
    global $post;
    return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
  }
}
add_filter( 'intermediate_image_sizes_advanced', 'blankslate_image_insert_override' );

function blankslate_image_insert_override( $sizes ) {
  unset( $sizes['medium_large'] );
  return $sizes;
}
add_action( 'widgets_init', 'blankslate_widgets_init' );

function blankslate_widgets_init() {
  register_sidebar( array(
  'name' => esc_html__( 'Sidebar Widget Area', 'blankslate' ),
  'id' => 'primary-widget-area',
  'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
  'after_widget' => '</li>',
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>',
  ) );
}
add_action( 'wp_head', 'blankslate_pingback_header' );

function footer_one() {
  register_sidebar( array(
      'name' => __( 'Footer One', 'smallenvelop' ),
      'id' => 'footer-one',
  ) );
}
add_action( 'widgets_init', 'footer_one' );

function footer_two() {
  register_sidebar( array(
      'name' => __( 'Footer Two', 'smallenvelop' ),
      'id' => 'footer-two',
  ) );
}
add_action( 'widgets_init', 'footer_two' );

function footer_three() {
  register_sidebar( array(
      'name' => __( 'Footer Three', 'smallenvelop' ),
      'id' => 'footer-three',
  ) );
}
add_action( 'widgets_init', 'footer_three' );

function footer_four() {
  register_sidebar( array(
      'name' => __( 'Footer Four', 'smallenvelop' ),
      'id' => 'footer-four',
  ) );
}
add_action( 'widgets_init', 'footer_four' );

function blankslate_pingback_header() {
  if ( is_singular() && pings_open() ) {
    printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
  }
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );

function blankslate_enqueue_comment_reply_script() {
  if ( get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}

function blankslate_custom_pings( $comment ) {
  ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
}
add_filter( 'get_comments_number', 'blankslate_comment_count', 0 );

function blankslate_comment_count( $count ) {
  if ( ! is_admin() ) {
    global $id;
    $get_comments = get_comments( 'status=approve&post_id=' . $id );
    $comments_by_type = separate_comments( $get_comments );
    return count( $comments_by_type['comment'] );
  } else {
    return $count;
  }
}

function add_file_types_to_uploads($file_types){
  $new_filetypes = array();
  $new_filetypes['svg'] = 'image/svg+xml';
  $file_types = array_merge($file_types, $new_filetypes );
  return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

function change_jquery() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', '3.5.1' );
}
add_action( 'wp_enqueue_scripts', 'change_jquery' );

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
function my_show_extra_profile_fields( $user ) { ?>
<h3>Extra profile information</h3>
<table class="form-table">
    <tr>
        <th><label for="phone">Phone Number</label></th>
        <td>
            <input type="text" name="phone" id="phone"
                value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>"
                class="regular-text" /><br />
            <span class="description">Please enter your phone number.</span>
        </td>
    </tr>
</table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

update_usermeta( $user_id, 'phone', $_POST['phone'] );
}

// CUSTOM FUNCTIONS BELOW

function hero_section($atts) {
	ob_start();
	$data = shortcode_atts(array(
		'video_on_off' => 'on',
        'title_one' => 'Premier Pet Care<br>in [CITY NAME], [STATE CODE]',
        'title_two' => 'for Your Best Friend'
	),$atts);
	?>
<div id="hero-container" <?php if ($data['video_on_off'] == 'off') { ?>
    style="background-image: url('/wp-content/uploads/2020/03/homepage-slider.png');" <?php } ?>>
    <?php if ($data['video_on_off'] == 'on') { ?>
    <div id="video-text">
        <h1 class="baseline"><?php echo $data['title_one'] ?></h1>
        <?php $url = find_url(564,'/cityname-statecode-veterinary-appointment/'); ?>
        <div class="btns-ctn">
            <a href="<?php echo $url ?>" class="button-container">
                <div class="blue-button">
                    Book Appointment
                </div>
            </a>
            <a href="tel:<?php the_author_meta( 'phone' )?>" class="button-container">
                <div class="blue-button">
                    Call <?php the_author_meta( 'phone' )?>
                </div>
            </a>
        </div>
    </div>
    <div style="width: 100%" class="wp-video">
        <div id="video-overlay"></div>
        <video muted autoplay="autoplay" loop class="wp-video-shortcode" id="video-697-2" width="100%" height="100%"
            preload="metadata">
            <source type="video/mp4" src="/wp-content/uploads/2024/11/pexels-bethany-ferr-5481755-1440p.mp4" /><a
                href="/wp-content/uploads/2024/11/pexels-bethany-ferr-5481755-1440p.mp4">/wp-content/uploads/2024/11/pexels-bethany-ferr-5481755-1440p.mp4</a>
        </video>
    </div>
    <?php } ?>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('hero_section','hero_section');


function three_callouts($atts) {
	ob_start();
	$data = shortcode_atts(array(
        'title' => ''
	),$atts);
	?>
<div id="three-callouts">
    <?php $url = find_url(567,'/veterinarian-cityname-statecode/'); ?>
    <a href="<?php echo $url ?>" style="background-image: url('/wp-content/uploads/2024/10/Featured-Team.png')"
        class="callout">
        <div class="callout-text">
            <h2 class="baseline">Meet<br>Our Team</h2>
        </div>
    </a>
    <!-- <?php $url = find_url(41,'/cityname-statecode-veterinary-services/'); ?> -->
    <a href="#" style="background-image: url('/wp-content/uploads/2024/10/Featured-Pharmacy.png')" class="callout">
        <div class="callout-text">
            <h2 class="baseline">Online<br>Pharmacy</h2>
        </div>
    </a>
    <?php $url = find_url(564,'/cityname-statecode-veterinary-appointment/'); ?>
    <a href="<?php echo $url ?>" style="background-image: url('/wp-content/uploads/2024/10/Featured-Careers.png')"
        class="callout">
        <div class="callout-text">
            <h2 class="baseline">Schedule<br>Your Visit</h2>
        </div>
    </a>
</div>

<?php
	return ob_get_clean();
}
add_shortcode('three_callouts','three_callouts');


function homepage_services() {
	ob_start();
	?>
<div class="home-services-card">
    <h3 id="services-title" class="center-title underlined baseline">Our Services</h3>
    <div id="services-box">
        <div class="services-inner">
            <?php
						$args = array(
							'category_name' => 'Services',
							'posts_per_page' => '8',
                            'tag' => 'Featured',
                            'orderby' => 'title',
		                    'order' => 'ASC'
						);
						$posts_array = new WP_Query($args);
						if ( $posts_array -> have_posts() ) :
							while ( $posts_array -> have_posts() ) :
								$posts_array -> the_post();
								$id = get_the_ID();
								$link = get_permalink();
								$title = get_the_title();
						?>
            <a href="<?php echo $link ?>" class="service">
                <svg class="check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 20" fill="none">
                    <g clip-path="url(#clip0_2150_276)">
                        <path
                            d="M8.74089 12.3772C8.69095 12.2772 8.61602 12.2022 8.59105 12.1022C7.86681 10.7019 7.01769 9.40169 5.99376 8.20147C5.69407 7.8264 5.31946 7.70138 4.84495 7.85141C3.39646 8.32649 1.94797 8.77658 0.474508 9.25166C-0.0499457 9.4267 -0.174816 9.9768 0.224768 10.3519C0.6743 10.7769 1.12383 11.177 1.57336 11.5771C3.72113 13.6025 5.51925 15.8779 6.79292 18.5784C7.16753 19.4035 7.76691 19.6036 8.61602 19.2535C9.2154 19.0035 9.7898 18.7534 10.3892 18.5284C11.1634 18.2033 11.7378 17.6782 12.0375 16.8781C12.7617 15.0527 13.5609 13.2524 14.4849 11.5271C16.0583 8.60154 17.9813 5.92605 20.4537 3.67564C21.5026 2.72546 22.6514 1.90031 23.7752 1.02515C24.0749 0.800109 24.0749 0.500053 23.7752 0.325021C23.076 -0.0500478 22.3767 -0.125062 21.6275 0.250007C19.8293 1.17518 18.1311 2.20037 16.5328 3.42559C13.9355 5.40096 11.7378 7.72638 9.93964 10.4519C9.54006 11.077 9.14048 11.7021 8.74089 12.3772Z"
                            fill="white" />
                        <path
                            d="M8.74087 12.3773C9.16542 11.7272 9.54003 11.077 9.96459 10.4519C11.7627 7.72642 13.9604 5.401 16.5577 3.42563C18.1311 2.20041 19.8293 1.15022 21.6274 0.25005C22.3767 -0.125019 23.0759 -0.025001 23.7752 0.325063C24.0749 0.475091 24.0749 0.800151 23.7752 1.02519C22.6514 1.90035 21.5026 2.7255 20.4537 3.67568C17.9812 5.92609 16.0582 8.60159 14.4849 11.5271C13.5608 13.2524 12.7617 15.0528 12.0374 16.8781C11.7377 17.6532 11.1633 18.2034 10.3891 18.5284C9.78977 18.7785 9.21537 19.0035 8.616 19.2535C7.76688 19.6036 7.1675 19.3786 6.79289 18.5784C5.51922 15.9029 3.72109 13.6275 1.57333 11.5771C1.1238 11.1521 0.674268 10.752 0.224736 10.3519C-0.174847 9.97684 -0.0749515 9.42674 0.474476 9.25171C1.92297 8.77662 3.37146 8.32654 4.81995 7.85145C5.29446 7.70142 5.64409 7.85145 5.96875 8.20151C6.99269 9.40173 7.8418 10.702 8.56605 12.1022C8.616 12.2022 8.66594 12.2773 8.74087 12.3773Z"
                            fill="#ECFBFE" />
                    </g>
                    <defs>
                        <clipPath id="clip0_2150_276">
                            <rect width="24" height="19.4286" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span class="baseline"><?php echo $title ?></span>
            </a>
            <?php endwhile; endif; ?>
        </div>
        <?php $url = find_url(41,'/cityname-statecode-veterinary-services/'); ?>
        <a href="<?php echo $url ?>" class="button-container full-width-button">
            <div class="lite-button">
                View All Services
            </div>
        </a>
    </div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('homepage_services','homepage_services');

function team_section() {
	ob_start();
	?>
<svg id="team-border-one" version="1.1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"
    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 1803.9 214.6" style="enable-background:new 0 0 1803.9 214.6;" xml:space="preserve">
    <style type="text/css">
    .st0 {
        display: none;
    }

    .st1 {
        display: inline;
    }

    .st2 {
        fill: url(#SVGID_3_);
    }

    .st3 {
        clip-path: url(#SVGID_5_);
    }

    .st4 {
        fill: #D7E1E9;
    }

    .st5 {
        fill: #C5D6E1;
    }

    .st6 {
        fill: #95D9F1;
    }

    .st7 {
        clip-path: url(#SVGID_7_);
    }

    .st8 {
        fill: none;
        stroke: #014051;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-miterlimit: 10;
    }

    .st9 {
        fill: #014051;
    }

    .st10 {
        opacity: 0.17;
        fill: #308BAC;
    }

    .st11 {
        fill: #308BAC;
    }

    .st12 {
        opacity: 0.8;
    }

    .st13 {
        fill: #E5EBF0;
    }

    .st14 {
        fill: #D9E3EA;
    }

    .st15 {
        fill: #E7ECF1;
    }

    .st16 {
        fill: #C9D8E3;
    }

    .st17 {
        fill: #FFFFFF;
    }

    .st18 {
        fill: url(#SVGID_12_);
    }

    .st19 {
        opacity: 0.44;
        fill: #014051;
    }

    .st20 {
        fill: url(#SVGID_17_);
    }

    .st21 {
        fill: url(#SVGID_20_);
    }

    .st22 {
        fill: url(#SVGID_23_);
    }

    .st23 {
        fill: url(#SVGID_30_);
    }

    .st24 {
        fill: url(#SVGID_31_);
    }

    .st25 {
        fill: #58595B;
    }

    .st26 {
        opacity: 0.44;
        fill: #58595B;
    }
    </style>
    <metadata>
        <sfw xmlns="&ns_sfw;">
            <slices></slices>
            <sliceSourceBounds bottomLeftOrigin="true" height="7352.9" width="7006.4" x="-100" y="-7352.9">
            </sliceSourceBounds>
            <optimizationSettings>
                <targetSettings fileFormat="PNG24Format" targetSettingsID="0">
                    <PNG24Format filtered="false" interlaced="false" matteColor="#FFFFFF" noMatteColor="false"
                        transparency="true">
                    </PNG24Format>
                </targetSettings>
            </optimizationSettings>
        </sfw>
    </metadata>
    <g id="template_references" class="st0">
    </g>
    <g id="Layer_2">
        <polygon class="st4 light-gray-line-one" points="1132,110.2 1132,110.2 903.9,81.7 1803.9,31.5 1803.9,110.2 1803.9,110.2 1803.9,188.9 903.9,81.7
			1132,110.2 	" />
        <polygon id="gray-line-one" class="st5"
            points="1803.9,0.4 903.9,81.7 903.8,81.8 903.6,81.7 0,0 0,158.5 984.1,157.6 984,157.5 1803.9,158.2 	" />
        <path id="light-gray-line-one" class="st4 light-gray-line-one" d="M902,81.6L0,31.2v79v0v79L901.9,81.9l0,0l-227.4,28.4l0,0l0,0L902,81.9l227.4,28.4l0,0l0,0L902,81.9l0,0
			l901.9,107.5v-79v0v-79L902,81.6z M902,81.9L902,81.9L902,81.9L902,81.9L902,81.9z" />
        <polygon class="st6" points="0,166.5 902,81.7 1803.9,166.5 1803.9,214.6 0,214.6 	" />
    </g>
</svg>
<div id="meet-the-team">
    <div class="inner-wrapper">
        <div class="fifty-percent">
            <img id="team-image" src="/wp-content/uploads/2020/04/meet-our-team.png" alt="Meet Our Team">
        </div>
        <div class="fifty-percent">
            <h3 id="team-title">Meet Our Team</h3>
            <p id="team-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur.</p>
            <?php $url = find_url(567,'/veterinarian-cityname-statecode/'); ?>
            <a href="<?php echo $url ?>" class="button-container">
                <div class="blue-button">
                    Get to know our team
                </div>
            </a>
        </div>
    </div>
</div>
<svg id="team-border-two" version="1.1" xmlns:x="&ns_extend;" xmlns:i="&ns_ai;" xmlns:graph="&ns_graphs;"
    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 1803.9 214.6" style="enable-background:new 0 0 1803.9 214.6;" xml:space="preserve">
    <style type="text/css">
    .st0 {
        display: none;
    }

    .st1 {
        display: inline;
    }

    .st2 {
        fill: url(#SVGID_3_);
    }

    .st3 {
        clip-path: url(#SVGID_5_);
    }

    .st4 {
        fill: #D7E1E9;
    }

    .st5 {
        fill: #C5D6E1;
    }

    .st6 {
        fill: #95D9F1;
    }

    .st7 {
        clip-path: url(#SVGID_7_);
    }

    .st8 {
        fill: none;
        stroke: #014051;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-miterlimit: 10;
    }

    .st9 {
        fill: #014051;
    }

    .st10 {
        opacity: 0.17;
        fill: #308BAC;
    }

    .st11 {
        fill: #308BAC;
    }

    .st12 {
        opacity: 0.8;
    }

    .st13 {
        fill: #E5EBF0;
    }

    .st14 {
        fill: #D9E3EA;
    }

    .st15 {
        fill: #E7ECF1;
    }

    .st16 {
        fill: #C9D8E3;
    }

    .st17 {
        fill: #FFFFFF;
    }

    .st18 {
        fill: url(#SVGID_12_);
    }

    .st19 {
        opacity: 0.44;
        fill: #014051;
    }

    .st20 {
        fill: url(#SVGID_17_);
    }

    .st21 {
        fill: url(#SVGID_20_);
    }

    .st22 {
        fill: url(#SVGID_23_);
    }

    .st23 {
        fill: url(#SVGID_30_);
    }

    .st24 {
        fill: url(#SVGID_31_);
    }

    .st25 {
        fill: #58595B;
    }

    .st26 {
        opacity: 0.44;
        fill: #58595B;
    }
    </style>
    <metadata>
        <sfw xmlns="&ns_sfw;">
            <slices></slices>
            <sliceSourceBounds bottomLeftOrigin="true" height="7352.9" width="7006.4" x="-100" y="-7352.9">
            </sliceSourceBounds>
            <optimizationSettings>
                <targetSettings fileFormat="PNG24Format" targetSettingsID="0">
                    <PNG24Format filtered="false" interlaced="false" matteColor="#FFFFFF" noMatteColor="false"
                        transparency="true">
                    </PNG24Format>
                </targetSettings>
            </optimizationSettings>
        </sfw>
    </metadata>
    <g id="template_references-two" class="st0">
    </g>
    <g id="Layer_3">
        <polygon class="st4 light-gray-line-two"
            points="671.9,104.3 671.9,104.3 900,132.8 0,183.1 0,104.3 0,104.3 0,25.6 900,132.8 671.9,104.3 	" />
        <polygon id="gray-line-two" class="st5"
            points="819.8,57 819.9,57.1 0,56.4 0,214.2 900,132.8 900.1,132.7 900.3,132.9 1803.9,214.6 1803.9,56.1 	" />
        <path id="light-gray-line-two" class="st4 light-gray-line-two" d="M902,132.7L902,132.7l227.3-28.4l0,0l0,0L902,132.7l-227.4-28.4l0,0l0,0L902,132.7L902,132.7L0,25.2v79v0v79
			L902,133l902,50.3v-79v0v-79L902,132.7z M902,132.7L902,132.7L902,132.7L902,132.7L902,132.7z" />
        <polygon class="st6" points="1803.9,48 902,132.8 0,48 0,0 1803.9,0 	" />
    </g>
</svg>
<?php
	return ob_get_clean();
}
add_shortcode('team_section','team_section');

function service_call_card($atts) {
	ob_start();
	$data = shortcode_atts(array(
	),$atts);
	?>
<div class="service-call-card">
    <h3 class="center-title underlined baseline">Have Any Questions?</h3>
    <div class="appointment-box">
        <a href="tel:<?php the_author_meta( 'phone' )?>" class="button-container">
            <div class="blue-button">
                Call <?php the_author_meta( 'phone' )?>
            </div>
        </a>
    </div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('service_call_card','service_call_card');

function openings_card($atts) {
	ob_start();
	$data = shortcode_atts(array(
	),$atts);
	?>
<div class="service-call-card join-team-card">
    <h3 class="center-title underlined baseline">Learn More About Our Team</h3>
    <div class="appointment-box">
        <a href="/about-hospitalname-statecode/" class="button-container">
            <div class="blue-button">
                About Us
            </div>
        </a>
    </div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('openings_card','openings_card');

function appointment_area($atts) {
	ob_start();
	$data = shortcode_atts(array(
		'background_image' => '/wp-content/uploads/2020/03/homepage-appointment-image.png',
		'margin_top' => '0',
	),$atts);
	?>
<section class="appointment-area"
    style="background-image: url('<?php echo $data['background_image']?>'); margin-top: <?php echo $data['margin_top']?>">
    <div class="inner-wrapper">
        <div class="appointment-container" id="appointment-container">
            <h2 class="center-title underlined baseline">Make an appointment<br>with us today!</h2>
            <div class="appointment-box">
                <a href="tel:<?php the_author_meta( 'phone' )?>" class="button-container">
                    <div class="lite-button">
                        Call <?php the_author_meta( 'phone' )?>
                    </div>
                </a>
                <?php $url = find_url(564,'/cityname-statecode-veterinary-appointment/'); ?>
                <a href="<?php echo $url ?>" class="button-container">
                    <div class="lite-button">
                        Book An Appointment
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<?php
	return ob_get_clean();
}
add_shortcode('appointment_area','appointment_area');

function dvm_section($atts) {
    $data = shortcode_atts(array(
		'category' => '',
	),$atts);
	ob_start();
	?>
<section class="dvm-section">
    <div class="dvm-container inner-wrapper">
        <div class="dvm-team-container">
            <?php
		$args = array(
			'category_name' => $data['category'],
			'posts_per_page' => '-1',
			'order' => 'ASC'
			);
			$loop = new WP_Query($args);
			if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
			$id = get_the_ID();
			$img = get_the_post_thumbnail_url($id);
			$name = get_the_title();
            $link = get_the_permalink();
			$content = get_the_content();
            $position = get_field('position');
            

            if ($img == null) {
                $img = "/wp-content/uploads/2020/11/iVET360-staff-photo-placeholder-1.png";
            }

            $content = strip_shortcodes($content);

            $content = preg_replace('/<!--.*?-->/s', '', $content);
    
            $content = apply_filters('the_content', $content);
    
            preg_match('/<p>(.*?)<\/p>/is', $content, $matches);
            $first_paragraph = isset($matches[0]) ? $matches[0] : '';

			?>
            <div class="dvm-team-container-inner">
                <div class="dvm-photo" style="background-image: url(<?php echo $img; ?>);">
                </div>
                <div class="dvm-text">
                    <h3 class="baseline"><?php echo $name ?></h3>
                    <?php if ($position) { ?>
                    <p><?php echo $position ?></p>
                    <?php } ?>
                    <p><?php echo $first_paragraph ?></p>
                    <a href="<?php echo $link ?>">Read Full Bio</a>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>
<?php
	return ob_get_clean();
}
add_shortcode('dvm_section','dvm_section');

function staff_section($atts) {
    	$data = shortcode_atts(array(
		'title' => '',
		'category' => '',
	),$atts);
	ob_start();
	?>
<section class="staff-section">
    <div class="staff-container">
        <h2>Our Care Team</h2>
        <div class="staff-team-container">
            <?php
		$args = array(
			'category_name' => $data['category'],
			'posts_per_page' => '-1',
			'order' => 'ASC'
			);
			$loop = new WP_Query($args);
			if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
			$id = get_the_ID();
			$img = get_the_post_thumbnail_url($id);
			$name = get_the_title();
			$content = get_the_content();
            $position = get_field('position');

            if ($img == null) {
                $img = "/wp-content/uploads/2020/11/iVET360-staff-photo-placeholder-1.png";
            }
			?>
            <div class="staff-team-container-inner">
                <!-- <div class="team-photo" style="background-image: url(<?php echo $img; ?>);"> -->
                <div class="team-photo" style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.15)), 
    url(<?php echo $img; ?>) center/cover no-repeat;">
                    <div class="team-text">
                        <h3 class="baseline"><?php echo $name ?></h3>
                        <p><?php echo $position ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>
<?php
	return ob_get_clean();
}
add_shortcode('staff_section','staff_section');

function service_list($atts) {
	ob_start();
    $data = shortcode_atts(array(
		'tag' => '',
	),$atts);
	?>
<div class="services-card" id="<?php echo $data['tag'] ?>">

    <div class="services-list">
        <?php
				$args = array(
					'category_name' => 'Services',
					'posts_per_page' => -1,
                    'tag' => $data['tag'],
		            'order' => 'ASC'
				);
				$loop = new WP_Query($args);
				if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
				$id = get_the_ID();
				$img = get_the_post_thumbnail_url($id);
				$link = get_permalink();
				$title = get_the_title();
				?>
        <a href="<?php echo $link ?>" class="service-item" id="service-<?php echo $id ?>">
            <h2>
                <?php echo $title ?>
            </h2>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="12" fill="#046077" />
                <path
                    d="M24.1716 18.9999L18.8076 13.6359L20.2218 12.2217L28 19.9999L20.2218 27.778L18.8076 26.3638L24.1716 20.9999H12V18.9999H24.1716Z"
                    fill="#ECFBFE" />
            </svg>
        </a>
        <?php endwhile; endif ?>
    </div>
    <div class="buttons-ctn">
        <?php $url = find_url(564,'/cityname-statecode-veterinary-appointment/'); ?>
        <a class="dark-button" href="<?php echo $url ?>">Book Now</a>
        <a class="ghost-button" href="tel:<?php the_author_meta( 'phone' )?>"><?php the_author_meta( 'phone' )?></a>
    </div>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('service_list','service_list');

function get_excerpt_if_set( $post_id = null ) {
    // Use current post if no ID is provided
    if ( ! $post_id ) {
        global $post;
        $post_id = $post->ID;
    }

    // Check if the post has an excerpt
    if ( has_excerpt( $post_id ) ) {
        // Return the excerpt
        return get_the_excerpt( $post_id );
    }

    // Return false if no excerpt is set
    return false;
}

function row_link($atts) {
	ob_start();
    $data = shortcode_atts(array(
		'title' => '',
		'link' => '',
	),$atts);
	?>

<a href="<?php echo $data['link'] ?>" class="service-item">
    <h2>
        <?php echo $data['title'] ?>
    </h2>
    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="40" height="40" rx="12" fill="#046077" />
        <path
            d="M24.1716 18.9999L18.8076 13.6359L20.2218 12.2217L28 19.9999L20.2218 27.778L18.8076 26.3638L24.1716 20.9999H12V18.9999H24.1716Z"
            fill="#ECFBFE" />
    </svg>
</a>
<?php
	return ob_get_clean();
}
add_shortcode('row_link','row_link');

function footer_call_section($atts) {
	ob_start();
	$data = shortcode_atts(array(
		'link' => '#',
		'icon' => 'fab fa-facebook-f',
		'name' => 'Facebook',
		'color' => '#03404f'
	),$atts);
	?>
<section class="footer-callout">
    <div class="footer-callout-container">
        <h3 class="baseline">Ready to</h3>
        <h2 class="baseline">Make an Appointment?</h2>
        <div class="footer-callout-wrapper">
            <p>
                <i style="transform: scaleX(-1);" class="fas fa-phone"></i> <a href="tel:[PHONE NUMBER]">[PHONE
                    NUMBER]</a>
            </p>
            <a href="/contact-hospitalname-cityname-statecode/" class="blue-button">Book Now</a>
        </div>
    </div>
</section>
<?php
	return ob_get_clean();
}
add_shortcode('footer_call_section','footer_call_section');

function join_team_section($atts) {
	ob_start();
	$data = shortcode_atts(array(
		'email' => '[EMAIL ADDRESS]'
	),$atts);
	?>
<section class="footer-callout join-our-team">
    <div class="footer-callout-container">
        <h2 class="baseline">Ready to Join Our Team?</h2>
        <div class="footer-callout-wrapper">
            <p>
                We’re always interested in growing our team with the right people, so if you think you’d be a great fit,
                please feel free to email your resume to <a
                    href="mailto:<?php echo $data['email'] ?>"><?php echo $data['email'] ?>.</a>
            </p>
        </div>
    </div>
</section>
<?php
	return ob_get_clean();
}
add_shortcode('join_team_section','join_team_section');

function review_block($atts) {
	ob_start();
	$data = shortcode_atts(array(
		'link' => '#',
		'icon' => 'fab fa-facebook-f',
		'name' => 'Facebook',
		'color' => '#3D5D99'
	),$atts);
	?>
<a class="review-block" href="<?php echo $data['link'] ?>" target="_blank" rel=”noopener”>
    <i class="<?php echo $data['icon'] ?>"></i>
</a>
<?php
	return ob_get_clean();
}
add_shortcode('review_block','review_block');


function service_child($classes){
  $cat = get_the_category();
  if($cat){
    if($cat[0]->slug === 'services') {
      $classes[] = 'service-post';
    }
  }
  return $classes;
}
add_filter( 'body_class', 'service_child' );


function current_openings(){
  ob_start(); ?>
<div class="services-card careers-card">

    <div class="services-list careers-list">
        <?php
				$args = array(
					'category_name' => 'Career',
					'posts_per_page' => -1,
		            'order' => 'ASC'
				);
				$loop = new WP_Query($args);
				if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
				$id = get_the_ID();
				$img = get_the_post_thumbnail_url($id);
				$link = get_permalink();
				$title = get_the_title();
				?>
        <a href="<?php echo $link ?>" class="service-item career-item" id="career-<?php echo $id ?>">
            <h2>
                <?php echo $title ?>
            </h2>
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="12" fill="#046077" />
                <path
                    d="M24.1716 18.9999L18.8076 13.6359L20.2218 12.2217L28 19.9999L20.2218 27.778L18.8076 26.3638L24.1716 20.9999H12V18.9999H24.1716Z"
                    fill="#ECFBFE" />
            </svg>
        </a>
        <?php endwhile; endif ?>
    </div>
</div>
<?php return ob_get_clean();
}
add_shortcode('current_openings','current_openings');


function openings_list(){
  ob_start(); ?>
<ul class="openings">
    <?php
        $args = array(
          'category_name' => 'career'
        );
        $loop = new WP_Query($args);
        if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
        $link = get_permalink();
        $title = get_the_title();
        $content = wpautop(get_the_content());
      ?>
    <li class="opening-li"><?php echo $title; ?><a href="<?php echo $link ?>" class="blue-button">Learn More</a>
    </li>
    <?php endwhile; endif; wp_reset_postdata(); ?>
</ul>
<?php return ob_get_clean();
}
add_shortcode('openings_list','openings_list');


function rye_svgs(){
      ob_start(); ?>
<svg class="ears" viewBox="0 0 891 532" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_805_162)">
        <path
            d="M862.477 114.979C858.542 95.964 826.788 65.3103 774.592 117.893C725.927 166.92 617.635 345.516 603.206 369.453C581.708 357.656 535.939 340.428 451.091 339.521V339.486C449.92 339.486 448.767 339.495 447.605 339.503C446.443 339.503 445.298 339.486 444.118 339.486V339.521C359.367 340.419 313.607 357.612 292.074 369.409C277.548 345.314 169.353 166.894 120.714 117.893C68.5181 65.3103 36.764 95.9552 32.8288 114.979C-0.0785835 274.014 11.3043 288.76 24.0518 351.881C31.9573 391.012 70.2348 430.206 70.2348 430.206C70.2348 430.206 77.0047 498.52 104.956 541.279C132.898 584.037 171.237 583.809 171.237 583.809L262.573 554.563L264.563 542.916H630.743L632.733 554.563L724.069 583.809C724.069 583.809 762.408 584.037 790.35 541.279C818.293 498.52 825.071 430.206 825.071 430.206C825.071 430.206 863.349 391.012 871.254 351.881C884.002 288.76 895.385 274.014 862.477 114.979ZM169.714 534.131C169.714 534.131 145.047 538.356 121.682 489.946C98.3179 441.536 112.245 409.412 112.245 409.412C112.245 409.412 103.16 399.763 84.1179 381.813C65.076 363.863 43.93 314.968 55.1456 217.135C66.3612 119.302 83.2815 143.52 108.072 171.841C132.871 200.162 223.477 396.752 223.477 396.752C185.296 355.068 129.192 359.17 129.192 359.17L182.699 423.101C164.203 423.647 145.293 438.243 145.293 438.243L185.49 467.858C165.568 488.493 169.705 534.122 169.705 534.122L169.714 534.131ZM447.957 532.731H189.971C189.971 532.731 234.675 421.288 376.402 392.245C390.021 414.113 412.311 460.815 412.311 532.379H479.068C479.068 460.815 501.359 414.113 514.978 392.245C656.696 421.296 701.409 532.731 701.409 532.731H447.966H447.957ZM811.206 381.813C792.164 399.763 783.079 409.412 783.079 409.412C783.079 409.412 797.006 441.536 773.641 489.946C750.277 538.356 725.61 534.131 725.61 534.131C725.61 534.131 729.756 488.502 709.825 467.867L750.022 438.252C750.022 438.252 731.103 423.656 712.616 423.11L766.123 359.179C766.123 359.179 710.019 355.077 671.838 396.761C671.838 396.761 762.452 200.171 787.243 171.85C812.042 143.529 828.962 119.302 840.169 217.144C851.385 314.977 830.239 363.88 811.197 381.822L811.206 381.813Z"
            fill="white" />
    </g>
    <defs>
        <clipPath id="clip0_805_162">
            <rect width="891" height="532" fill="white" />
        </clipPath>
    </defs>
</svg>
<svg class="ears" viewBox="0 0 891 533" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_805_146)">
        <path
            d="M852.003 295.176C850.994 230.444 859.014 213.511 792.582 64.3425C784.642 46.5064 746.872 23.2 706.88 86.0556C671.244 142.06 607.468 326.006 594.004 365.405C569.644 354.084 524.997 340.576 449.908 339.779V339.744C448.722 339.744 447.571 339.753 446.403 339.762C445.234 339.762 444.084 339.744 442.898 339.744V339.779C367.809 340.576 323.17 354.092 298.802 365.405C285.338 326.006 221.562 142.06 185.925 86.0556C145.934 23.2089 108.164 46.5064 100.224 64.3425C33.792 213.511 41.8116 230.435 40.8025 295.176C40.174 335.309 69.3668 382.019 69.3668 382.019C69.3668 382.019 61.3649 450.584 79.6524 498.578C97.9399 546.572 135.648 554.574 135.648 554.574L231.635 545.43L232.096 544.288H660.693L661.153 545.43L757.14 554.574C757.14 554.574 794.848 546.572 813.136 498.578C831.423 450.584 823.421 382.019 823.421 382.019C823.421 382.019 852.614 335.309 851.986 295.176H852.003ZM174.507 443.733C150.51 459.728 144.792 505.438 144.792 505.438C144.792 505.438 119.653 504.296 107.084 451.726C94.5143 399.156 115.086 370.592 115.086 370.592C115.086 370.592 108.226 359.165 93.3725 337.451C78.5194 315.738 68.2338 263.177 100.232 169.465C132.231 75.7612 143.659 103.184 161.937 136.324C180.216 169.465 227.077 382.011 227.077 382.011C198.512 332.875 142.517 324.873 142.517 324.873L181.367 399.147C163.079 395.722 141.375 406.007 141.375 406.007L174.516 443.715L174.507 443.733ZM448.288 538.446V538.455H446.005H443.721C443.721 538.455 443.721 538.455 443.721 538.446L188.997 537.879L188.891 533.294C188.891 533.294 233.804 421.347 376.138 392.075C389.814 413.921 412.448 460.985 412.448 533.294H479.57C479.57 460.985 502.204 413.921 515.879 392.075C658.214 421.347 703.127 533.294 703.127 533.294L703.234 537.879L448.297 538.446H448.288ZM799.433 337.46C784.58 359.173 777.72 370.601 777.72 370.601C777.72 370.601 798.291 399.165 785.722 451.735C773.153 504.305 748.014 505.447 748.014 505.447C748.014 505.447 742.305 459.737 718.299 443.742L751.44 406.034C751.44 406.034 729.727 395.748 711.448 399.174L750.298 324.9C750.298 324.9 694.302 332.902 665.738 382.037C665.738 382.037 712.59 169.491 730.877 136.351C749.165 103.21 760.592 75.7877 792.582 169.491C824.581 263.195 814.295 315.765 799.442 337.478L799.433 337.46Z"
            fill="white" />
    </g>
    <defs>
        <clipPath id="clip0_805_146">
            <rect width="891" height="532.285" fill="white" />
        </clipPath>
    </defs>
</svg>
<svg class="ears" viewBox="0 0 891 533" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_805_114)">
        <path
            d="M851.995 295.521C850.986 230.789 859.005 213.856 792.573 64.6875C784.633 46.8514 746.863 23.545 706.872 86.4006C671.323 142.272 607.777 325.44 594.102 365.458C569.76 354.128 525.094 340.585 449.908 339.788V339.753C448.731 339.753 447.571 339.762 446.403 339.77C445.234 339.77 444.084 339.753 442.897 339.753V339.788C352.956 340.744 306.688 359.943 286.648 371.76C278.266 366.184 207.275 322.696 82.0157 357.899C66.3041 362.316 54.7083 375.699 52.7255 391.898C48.6715 424.959 49.0521 483.512 88.3978 535.162H140.153L132.222 544.306H660.56L661.162 545.793L757.149 554.936C757.149 554.936 794.857 546.935 813.145 498.941C831.432 450.947 823.43 382.382 823.43 382.382C823.43 382.382 852.623 335.672 851.995 295.539V295.521ZM448.279 535.144H272.167C282.656 512.13 293.836 475.431 292.72 424.897C315.841 411.752 343.494 400.617 376.333 393.881C390.027 415.868 412.439 462.826 412.439 534.781H479.561C479.561 462.826 501.973 415.868 515.667 393.881C658.161 423.091 703.118 535.135 703.118 535.135H448.288L448.279 535.144ZM799.425 337.796C784.572 359.51 777.711 370.937 777.711 370.937C777.711 370.937 798.283 399.501 785.713 452.071C773.144 504.641 748.005 505.783 748.005 505.783C748.005 505.783 742.296 460.073 718.29 444.078L751.431 406.37C751.431 406.37 729.718 396.085 711.439 399.51L750.289 325.236C750.289 325.236 694.293 333.238 665.729 382.373C665.729 382.373 712.581 169.827 730.868 136.687C749.156 103.546 760.583 76.1238 792.573 169.827C824.572 263.531 814.286 316.101 799.433 337.814L799.425 337.796Z"
            fill="white" />
    </g>
    <defs>
        <clipPath id="clip0_805_114">
            <rect width="891" height="532.285" fill="white" />
        </clipPath>
    </defs>
</svg>
<svg class="ears" viewBox="0 0 891 533" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_805_98)">
        <path
            d="M818.951 390.836C816.968 375.283 805.904 362.466 790.82 358.182C686.822 328.67 620.054 353.358 595.226 365.998C571.149 354.57 526.271 340.602 449.899 339.788V339.753C448.722 339.753 447.562 339.762 446.394 339.77C445.225 339.77 444.075 339.753 442.889 339.753V339.788C352.947 340.744 306.679 359.943 286.639 371.76C278.257 366.184 207.266 322.696 82.0065 357.899C66.2948 362.316 54.6992 375.699 52.7165 391.898C47.8746 431.394 49.3527 507.297 116.068 564.319H254.906C254.906 564.319 260.66 557.663 267.679 544.306H604.095C611.114 557.663 616.868 564.319 616.868 564.319H755.706C823.023 506.792 823.917 430.031 818.924 390.844L818.951 390.836ZM448.288 535.153H272.176C282.665 512.139 293.844 475.44 292.729 424.906C315.85 411.761 343.493 400.626 376.333 393.889C390.027 415.877 412.439 462.835 412.439 534.79H479.561C479.561 462.835 501.974 415.877 515.667 393.889C539.611 398.793 560.784 406.052 579.469 414.708C576.486 470.527 588.454 510.616 599.634 535.144H448.288V535.153Z"
            fill="white" />
    </g>
    <defs>
        <clipPath id="clip0_805_98">
            <rect width="891" height="532.285" fill="white" />
        </clipPath>
    </defs>
</svg>
<?php return ob_get_clean();
}
add_shortcode('rye_svgs','rye_svgs');

function rye() {
	ob_start();
	?>
<div class="rye">
    <div class="rye-hero">
        <?php echo do_shortcode('[rye_svgs]')?>
        <div>
            <h1>we're<br>all ears!</h1>
        </div>
    </div>
    <section class="rye-body">
        <div class="rye-body-container">
            <h2>Would you mind taking a moment to rate your
                experience with [HOSPITAL NAME]?</h2>
            <p>It's always been our goal to see that you and your pet feel comfortable, welcome, and cared for at
                our
                hospital. We know your animal companions mean the world to you, which is why their health and
                well-being
                is so
                important to us. We want to know how we are doing!</p>
            <p><span>Just choose Thumbs Up or Thumbs Down below.</span><br>
                Your feedback is sincerely appreciated because it helps us know if we're doing all we can for you
                and
                your pet. Thank you so much!</p>
            <div class="rye-btns">
                <a class="tu" href="/thank-you/">
                    <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="thumb-up-fill">
                            <path id="Vector"
                                d="M8 35.9999H20V84H8C5.79088 84 4 82.2092 4 80V39.9999C4 37.7908 5.79088 35.9999 8 35.9999ZM29.1716 30.8283L54.7736 5.22644C55.4772 4.52264 56.5916 4.44348 57.3876 5.04064L60.798 7.5984C62.7368 9.05248 63.6104 11.5301 63.0124 13.8786L58.3992 31.9999H84C88.4184 31.9999 92 35.5816 92 39.9999V48.4172C92 49.4624 91.7952 50.4972 91.3976 51.4632L79.02 81.5228C78.4028 83.0216 76.942 84 75.3212 84H32C29.7909 84 28 82.2092 28 80V33.6568C28 32.5959 28.4214 31.5785 29.1716 30.8283Z"
                                fill="white" />
                        </g>
                    </svg>
                </a>
                <a class="td" href="/were-sorry/">
                    <svg width="96" height="96" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="thumb-up-fill">
                            <path id="Vector"
                                d="M8 35.9999H20V84H8C5.79088 84 4 82.2092 4 80V39.9999C4 37.7908 5.79088 35.9999 8 35.9999ZM29.1716 30.8283L54.7736 5.22644C55.4772 4.52264 56.5916 4.44348 57.3876 5.04064L60.798 7.5984C62.7368 9.05248 63.6104 11.5301 63.0124 13.8786L58.3992 31.9999H84C88.4184 31.9999 92 35.5816 92 39.9999V48.4172C92 49.4624 91.7952 50.4972 91.3976 51.4632L79.02 81.5228C78.4028 83.0216 76.942 84 75.3212 84H32C29.7909 84 28 82.2092 28 80V33.6568C28 32.5959 28.4214 31.5785 29.1716 30.8283Z"
                                fill="white" />
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('rye','rye');

function ty() {
	ob_start();
	?>
<div class="rye ty">
    <section class="rye-body">
        <div class="rye-body-container">
            <h2>Would you also be willing to leave us a review?</h2>
            <p>Most people look to online reviews when choosing a veterinarian, and sharing your experience helps
                them
                find us. We believe your pet deserves the best veterinary services possible, and we hope you’ll take
                a
                few moments and help us reach others.</p>
            <p class="bolden"><strong>Please choose your preferred review site below—and thank you!</strong></p>
            <div class="rye-btns">
                <a href="https://g.page/r/CcKGJGwJhCjsEBE/review" target="_blank" rel="noreferrer">
                    <i class="fab fa-google" aria-hidden="true"></i>
                </a>
                <a href="https://www.yelp.com/writeareview/biz/28n2QgURqu0_fXpCgieWuQ?return_url=%2Fbiz%2F28n2QgURqu0_fXpCgieWuQ"
                    target="_blank" rel="noreferrer">
                    <i class="fab fa-yelp" aria-hidden="true"></i>

                </a>
                <a href="https://www.facebook.com/aqueductah/reviews" target="_blank" rel="noreferrer">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>
</div>
<?php
	return ob_get_clean();
}
add_shortcode('ty','ty');

function testimonials_cards($atts) {
    $data = shortcode_atts(array(
        'title' => ''
    ), $atts);
    ob_start();
    ?>
<div class="testimonial-cards-ctn">
    <?php
        $args = array(
            'category_name' => 'Testimonials',
            'posts_per_page' => 3
        );
        $posts_array = new WP_Query($args);

        // Array of image URLs
        $images = array(
            '/wp-content/uploads/2026/04/icon-seated-cat.svg',
            '/wp-content/uploads/2026/04/icon-seated-greyhound.svg',
            '/wp-content/uploads/2026/04/icon-standing-cat.svg',
        );

        $i = 0; // Counter

        if ($posts_array->have_posts()) :
            while ($posts_array->have_posts()) :
                $posts_array->the_post();
                $id = get_the_ID();
                $title = get_the_title();
                $raw_content = get_the_content();
                $formatted_review = wp_kses_post($raw_content);

                // Get image based on loop count
                $img_url = $images[$i % count($images)]; // cycles if fewer images than posts
        ?>
    <div class="testimonial-card">
        <div class="testimonial-card-content">
            <p>
                <?php echo wp_trim_words($formatted_review, 35, ' <a href="/testimonials/">...Read More</a>'); ?>
            </p>
            <p class="testimonial-title"><?php echo esc_html($title); ?></p>
        </div>
        <img src="<?php echo esc_url($img_url); ?>" alt="testimonial - <?php echo esc_attr($title); ?>" />
    </div>
    <?php
                $i++;
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
</div>
<?php
    return ob_get_clean();
}
add_shortcode('testimonials_cards', 'testimonials_cards');

function random_testimonial($atts) {
    $data = shortcode_atts(array(
        'page' => ''
    ), $atts);
    ob_start();
    ?>
<section class="testimonial-section bg-img">
    <div class="inner-wrapper testimonial-inner-ctn">

        <?php
        $args = array(
            'category_name' => 'Testimonials',
            'posts_per_page' => 1,
            'orderby'        => 'rand',
        );
        $posts_array = new WP_Query($args);

        if ($posts_array->have_posts()) :
            while ($posts_array->have_posts()) :
                $posts_array->the_post();
                $id = get_the_ID();
                $title = get_the_title();
                $raw_content = get_the_content();
                $formatted_review = wp_kses_post($raw_content);

        ?>
        <div class="testimonial-card">
            <div class="testimonial-card-content">
                <span>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </span>
                <p>
                    <?php echo $raw_content ?>
                </p>
                <p class="testimonial-title"><?php echo esc_html($title); ?></p>
            </div>
        </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>

</section>
<?php
    return ob_get_clean();
}
add_shortcode('random_testimonial', 'random_testimonial');



function testimonial_page($atts) {
    $data = shortcode_atts(array(
        'title' => 'Overheard<br>At The<br>Dog Park'
	),$atts);
	ob_start();
	?>
<section class="testimonial-page inner-wrapper">
    <div class="testimonial-page__inner">
        <?php
                $args = array(
                    'category_name' => 'Testimonials',
                    'posts_per_page' => '-1'
                );
                $posts_array = new WP_Query($args);
                if ( $posts_array -> have_posts() ) :
                    while ( $posts_array -> have_posts() ) :
                        $posts_array -> the_post();
                        $id = get_the_ID();
                        $img = get_the_post_thumbnail_url($id);
                        $link = get_permalink();
                        $review = get_the_content();
                        $title = get_the_title();
                ?>
        <div class="testimonial-card">
            <?php echo $review ?>
            <p class="testimonial-title">-<?php echo $title ?></p>
        </div>
        <?php endwhile; endif; ?>
    </div>
</section>
<?php
	return ob_get_clean();
}
add_shortcode('testimonial_page','testimonial_page');

function find_url($id, $default){
	//$url = find_url(172,'/cityname-statecode-veterinary-appointment/');
	$site_url = site_url();
	if(isset($id)){
		$page = get_post( $id );
		if ( $page ) {
			$slug = $page->post_name;
		}
		else{
			$slug = $default;
		}
	}else{
		$slug = $default;
	}
	
	return $site_url.'/'.$slug;
}

add_post_type_support( 'page', 'excerpt' );


function dvm_names() {
    	ob_start();
    $args = array(
        'category_name' => 'DVM',
        'posts_per_page' => '-1'
    );
    $loop = new WP_Query($args);
    if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
    $id = get_the_ID();
    $name = get_the_title();
?>
<?php echo $loop->current_post + 1 === $loop->post_count ? ' and ' : '' ?>
<?php echo $name ?>
<?php echo $loop->current_post + 1 === $loop->post_count ? '' : ', ' ?>
<?php endwhile; endif;
return ob_get_clean();
}
add_shortcode('dvm_names', 'dvm_names');

function wrapRoadNameAndNumber($address) {
    // Regular expression to match the road number and name along with trailing punctuation (comma or period)
	$pattern = '/^(\d+\s+(?:[A-Za-z0-9\.]+\s?)*[.,])(\s*[A-Za-z\s]+,\s*[A-Z]{2}\s*\d{5})$/';

    // Wrap both parts in separate spans
     $replacement = '<span>$1</span><span>$2</span>';

    return preg_replace($pattern, $replacement, $address);
}

function lp($atts) {
	ob_start();
	$data = shortcode_atts(array(
		'tracking_line' => '[PHONE NUMBER]',
		'appt_link' => '/make-appointment-ads/',
		'map_link' => 'https://maps.app.goo.gl/QBBZaRyUKsYtVBY17',
		'address' => '[Hospital Address]',
		'name' => get_bloginfo('name'),
		'logo' => '/wp-content/uploads/2025/03/AVC-logo.svg',
		'hero' => '/wp-content/uploads/2025/03/AVC-lp-hero-card.png',
		'team_img' => '/wp-content/uploads/2025/03/AVC-lp-team.png',
		'services_img' => '/wp-content/uploads/2025/03/AVC-lp-services.png',
        'doctors_text' => "doctors combine advanced veterinary expertise with genuine compassion for every pet we see. When it comes to your pet's health, you deserve a team that treats your furry family members like their own. We believe in staying at the forefront of veterinary medicine through continuous learning and ongoing training, ensuring your pet receives the most current care available.",
        'doctors_text_two' => "are all accepting new clients - we look forward to building a lasting relationship with you and your beloved pets.",
        'careteam_text' => "our dedicated team is the heart of our practice. From welcoming smiles at the front desk to gentle, attentive care in the exam room, our technicians, assistants, receptionists, and kennel staff share one goal: creating a warm, comfortable environment for you and your pet. Come meet the friendly faces behind [HOSPITAL NAME] and discover how our commitment to compassionate service makes all the difference."
	), $atts);
	
	$title = get_the_title();
	$excerpt = get_the_excerpt();
	 $modalToggle = get_post_meta($id, 'modal-status', true );
    // a value of "modal-on" in the dashboard turns this on ^
    $updatedAddress = wrapRoadNameAndNumber($data['address']);  
	?>
<div class="new-lp">
    <section class="lp-hero">
        <div class="lp-hero-content content-wrapper">
            <div class="fifty-percent">
                <div class="logo-ctn">
                    <img class="lp-logo" src="<?php echo $data['logo'] ?>" alt="<?php echo $sitename ?>" />
                    <a href="<?php echo $data['appt_link'] ?>" class="lp-btn">book now</a>
                </div>
                <h1><?php echo $title?></h1>
                <p><?php echo $excerpt ?></p>
            </div>
            <div class="fifty-percent">
                <div class="hero-card">
                    <img class="<?php echo $modalToggle ?>" src="<?php echo $data['hero'] ?>" alt="About" />
                    <a href="<?php echo $data['appt_link'] ?>" class="lp-btn">book now</a>
                    <a href="tel:<?php echo $data['tracking_line'] ?>"
                        class="lp-btn"><?php echo $data['tracking_line'] ?></a>
                </div>
            </div>
        </div>
        <div class="lp-hero-sub content-wrapper">
            <p>Now Accepting New Clients</p>
            <a target="_blank" href="<?php echo $data['map_link'] ?>"><?php echo $updatedAddress ?></a>
        </div>
    </section>
    <section class="lp-services-section">
        <div class="lp-services-content content-wrapper">
            <div class="fifty-percent">
                <img class="services-img" src="<?php echo $data['services_img'] ?>" alt="About">
            </div>
            <div class="lp-services fifty-percent">
                <h2 class="lp-sub-title">Our Services</h2>
                <ul class="lp-check-ctas">
                    <?php
						$args = array(
							'category_name' => 'Services',
							'posts_per_page' => '10',
							'order' => 'ASC'
						);
						$loop = new WP_Query($args);
						if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
						$id = get_the_ID();
						$title = get_the_title();
						
						// Clean and normalize the title first
						$title = trim($title); // remove leading/trailing spaces
						$title = preg_replace('/\s+/', ' ', $title); // normalize weird spaces
						$title = str_ireplace('medicine', 'Care', $title); // replace medicine with care

						// Now check for your unwanted keywords
						if (
							stripos($title, 'pharmacy') !== false ||
							stripos($title, 'stem cell') !== false ||
							stripos($title, 'regenerative') !== false ||
							stripos($title, 'prescription') !== false 
						) {
							continue;
						}
					?>
                    <li class="check-cta"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 20" fill="none">
                            <g clip-path="url(#clip0_2067_2887)">
                                <path
                                    d="M8.74089 12.3773C8.69095 12.2773 8.61602 12.2023 8.59105 12.1023C7.86681 10.702 7.01769 9.40175 5.99376 8.20153C5.69407 7.82646 5.31946 7.70144 4.84495 7.85147C3.39646 8.32655 1.94797 8.77664 0.474508 9.25173C-0.0499457 9.42676 -0.174816 9.97686 0.224768 10.3519C0.6743 10.777 1.12383 11.1771 1.57336 11.5772C3.72113 13.6025 5.51925 15.8779 6.79292 18.5784C7.16753 19.4036 7.76691 19.6036 8.61602 19.2536C9.2154 19.0035 9.7898 18.7535 10.3892 18.5284C11.1634 18.2034 11.7378 17.6783 12.0375 16.8781C12.7617 15.0528 13.5609 13.2525 14.4849 11.5271C16.0583 8.6016 17.9813 5.92611 20.4537 3.6757C21.5026 2.72552 22.6514 1.90037 23.7752 1.02521C24.0749 0.80017 24.0749 0.500114 23.7752 0.325082C23.076 -0.0499868 22.3767 -0.125001 21.6275 0.250068C19.8293 1.17524 18.1311 2.20043 16.5328 3.42565C13.9355 5.40102 11.7378 7.72644 9.93964 10.4519C9.54006 11.0771 9.14048 11.7022 8.74089 12.3773Z"
                                    fill="white"></path>
                                <path
                                    d="M8.74087 12.3773C9.16542 11.7272 9.54003 11.077 9.96459 10.4519C11.7627 7.72642 13.9604 5.401 16.5577 3.42563C18.1311 2.20041 19.8293 1.15022 21.6274 0.25005C22.3767 -0.125019 23.0759 -0.025001 23.7752 0.325063C24.0749 0.475091 24.0749 0.800151 23.7752 1.02519C22.6514 1.90035 21.5026 2.7255 20.4537 3.67568C17.9812 5.92609 16.0582 8.60159 14.4849 11.5271C13.5608 13.2524 12.7617 15.0528 12.0374 16.8781C11.7377 17.6532 11.1633 18.2034 10.3891 18.5284C9.78977 18.7785 9.21537 19.0035 8.616 19.2535C7.76688 19.6036 7.1675 19.3786 6.79289 18.5784C5.51922 15.9029 3.72109 13.6275 1.57333 11.5771C1.1238 11.1521 0.674268 10.752 0.224736 10.3519C-0.174847 9.97684 -0.0749515 9.42674 0.474476 9.25171C1.92297 8.77662 3.37146 8.32654 4.81995 7.85145C5.29446 7.70142 5.64409 7.85145 5.96875 8.20151C6.99269 9.40173 7.8418 10.702 8.56605 12.1022C8.616 12.2022 8.66594 12.2773 8.74087 12.3773Z"
                                    fill="#024050"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_2067_2887">
                                    <rect width="24" height="19.4286" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg> <?php echo $title ?></li>
                    <?php endwhile; endif; ?>
                </ul>
                <p>Not sure if we offer the service you need? Call <a href="tel:<?php echo $data['tracking_line'] ?>">
                        <?php echo $data['tracking_line'] ?></a> to discuss your pet’s specific needs with our
                    animal
                    care team! </p>
            </div>
        </div>
    </section>
    <section class="lp-hours">
        <div class="content-wrapper">
            <h2 class="lp-sub-title">Hours</h2>
            <?php
            if (shortcode_exists('business_hours')) {

            echo do_shortcode('[business_hours]');
            
            } else { ?>
            <div class="hours">
                <div class="day">
                    <p>Monday</p>
                    <p>9:00 AM - 5:00 PM</p>
                </div>
                <div class="day">
                    <p>Tuesday</p>
                    <p>9:00 AM - 5:00 PM</p>
                </div>
                <div class="day">
                    <p>Wednesday</p>
                    <p>9:00 AM - 5:00 PM</p>
                </div>
                <div class="day">
                    <p>Thursday</p>
                    <p>9:00 AM - 5:00 PM</p>
                </div>
                <div class="day">
                    <p>Friday</p>
                    <p>9:00 AM - 5:00 PM</p>
                </div>
                <div class="day">
                    <p>Saturday</p>
                    <p>Closed</p>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
    <section class="lp-team-section">
        <div class="lp-team-content content-wrapper">
            <div class="fifty-percent">
                <img src="<?php echo $data['team_img'] ?>" alt="Our Team" />
            </div>
            <div class="fifty-percent">
                <div class="lp-team-content-upper">
                    <h2 class="lp-sub-title">Our Team</h2>
                    <div class="sl-lp-btns">
                        <div class="sl-lp-side sl-lp-left">
                            <i class="fas fa-chevron-left sl-lp-arrow-container sl-lp-left"></i>

                        </div>
                        <div class="sl-lp-side sl-lp-right">
                            <i class="fas fa-chevron-right sl-lp-arrow-container"></i>
                        </div>
                    </div>
                </div>
                <div class="lp-team-members">
                    <div class="sl-lp-wrapper">
                        <div class="sl-lp-container">
                            <div class="sl-lp-content">
                                <p class="sl-lp-name">Our Doctors</p>
                                <div class="sl-lp-text">
                                    <p><?php echo get_bloginfo('name'); ?>'s
                                        <?php echo $data['doctors_text'] ?>
                                        <?php echo do_shortcode('[dvm_names]') ?>
                                        <?php echo $data['doctors_text_two'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="sl-lp-content">
                                <p class="sl-lp-name">Our Care Team</p>
                                <div class="sl-lp-text">
                                    <p>At <?php echo get_bloginfo('name'); ?>, <?php echo $data['careteam_text'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="lp-footer">
        <div class="lp-footer-content content-wrapper">
            <img class="lp-footer-logo" src="<?php echo $data['logo'] ?>" alt="logo" />
            <div class="lp-footer-btns-ctn">
                <a href="<?php echo $data['appt_link'] ?>" class="lp-btn">Book Now</a>
                <a href="tel:<?php echo $data['tracking_line'] ?>"
                    class="lp-btn"><?php echo $data['tracking_line'] ?></a>
                <a target="_blank" href="<?php echo $data['map_link'] ?>" class="lp-btn">View Map</a>
            </div>
        </div>
    </section>
</div>

<?php
return ob_get_clean();
}
add_shortcode('lp', 'lp');



add_filter('gform_enable_legacy_markup', '__return_false');


/**
 * Auto-prepend blocks for 'services' posts (runs once unless reset)
 */
function my_auto_prepend_blocks_on_save( $post_id, $post, $update ) {
    if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
        return;
    }

    if ( has_category( 'services', $post ) ) {

        if ( get_post_meta( $post_id, '_auto_blocks_added', true ) ) {
            return;
        }

        $default_blocks = '
             <!-- wp:heading {"textAlign":"center","className":"baseline"} -->
            <h2 class="wp-block-heading has-text-align-center baseline">Your pet deserves routine care.</h2>
            <!-- /wp:heading -->
            <!-- wp:paragraph {"align":"center"} -->
            <p class="has-text-align-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra sapien euismod orci egestas pretium. Phasellus sit amet sapien vehicula, malesuada nisl vel, dignissim metus. In non porttitor sapien, ac lobortis augue.</p>
            <!-- /wp:paragraph -->
            <!-- wp:accordion-block/custom-main -->
            <!-- wp:paragraph {"placeholder":"Add your accordion content here..."} -->
            <p></p>
            <!-- /wp:paragraph -->
            <!-- /wp:accordion-block/custom-main -->
        ';

        $new_content = $default_blocks . "\n\n" . $post->post_content;

        remove_action( 'save_post', 'my_auto_prepend_blocks_on_save', 10 );

        wp_update_post( array(
            'ID'           => $post_id,
            'post_content' => $new_content,
        ) );

        update_post_meta( $post_id, '_auto_blocks_added', 1 );

        add_action( 'save_post', 'my_auto_prepend_blocks_on_save', 10, 3 );
    }
}
add_action( 'save_post', 'my_auto_prepend_blocks_on_save', 10, 3 );


/**
 * Add a meta box with reset button for 'services' posts
 */
function my_auto_blocks_meta_box() {
    add_meta_box(
        'my_auto_blocks_control',
        'Auto Blocks',
        'my_auto_blocks_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'my_auto_blocks_meta_box' );

function my_auto_blocks_meta_box_callback( $post ) {
    if ( ! has_category( 'services', $post ) ) {
        echo '<p>This tool only applies to posts in the <strong>services</strong> category.</p>';
        return;
    }

    $already_added = get_post_meta( $post->ID, '_auto_blocks_added', true );
    $button_label  = $already_added ? '🔁 Reset Auto Blocks' : '⚡ Run Auto Blocks';

    wp_nonce_field( 'my_auto_blocks_reset', 'my_auto_blocks_reset_nonce' );

    echo '<p>Use this button to manually run or reset the auto block insertion for this post.</p>';
    echo '<button type="button" class="button button-primary" id="my-auto-blocks-reset-btn" data-post-id="' . esc_attr( $post->ID ) . '">' . esc_html( $button_label ) . '</button>';

    ?>
<script>
jQuery(document).ready(function($) {
    $('#my-auto-blocks-reset-btn').on('click', function() {
        const postId = $(this).data('post-id');
        const button = $(this);
        button.prop('disabled', true).text('Working...');
        $.post(ajaxurl, {
            action: 'my_auto_blocks_reset',
            post_id: postId,
            nonce: $('#my_auto_blocks_reset_nonce').val()
        }, function(response) {
            alert(response.data.message);
            location.reload();
        });
    });
});
</script>
<?php
}

/**
 * Handle AJAX reset/run
 */
function my_auto_blocks_reset_ajax() {
    check_ajax_referer( 'my_auto_blocks_reset', 'nonce' );

    $post_id = intval( $_POST['post_id'] );

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_send_json_error( array( 'message' => 'Permission denied.' ) );
    }

    // Delete the meta flag so it can run again on next save
    delete_post_meta( $post_id, '_auto_blocks_added' );

    // Immediately run it once
    $post = get_post( $post_id );
    my_auto_prepend_blocks_on_save( $post_id, $post, true );

    wp_send_json_success( array( 'message' => 'Auto blocks have been reset and re-added successfully!' ) );
}
add_action( 'wp_ajax_my_auto_blocks_reset', 'my_auto_blocks_reset_ajax' );

add_filter('wpseo_robots', function($robots) {
    if (is_page_template('thank-you.php') || is_page_template('landing.php')) {
        return 'noindex, nofollow, noimageindex, noarchive, nosnippet';
    }
    return $robots;
});