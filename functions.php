<?php
require_once get_theme_file_path("/inc/search-route.php");
require_once get_theme_file_path("/inc/like-route.php");
function university_custom_rest()
{
    register_rest_field(
        'post', 
        'authorName', 
        array(
            'get_callback' => function () {
                return get_the_author();
            }
        )
    );
}

add_action("rest_api_init", "university_custom_rest");
function page_banner($args = NULL)
{
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!isset($args['photo'])) {
        if (get_field('page_banner_background') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background')['sizes']['page-banner'];
        } else {
            $args['photo'] = get_theme_file_uri('/theme-template/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>
    <?php
}

function university_menus()
{
    $locations = array(
        "primary" => 'Header Menu',
        'footer_location_1' => 'Footer Menu 1',
        'footer_location_2' => 'Footer Menu 2'
    );
    register_nav_menus($locations);
}

function university_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professor-landscape', 400, 260, true);
    add_image_size('professor-portrait', 480, 650, true);
    add_image_size('page-banner', 1500, 350, true);
    university_menus();
}

add_action("after_setup_theme", "university_theme_support");

function university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $query->set('meta_key', 'event-date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set(
            'meta_query',
            array(
                array(
                    'key' => 'event-date',
                    'compare' => '>=',
                    'value' => date('Ymd'),
                    'type' => 'numeric'
                )
            )
        );

    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function fictionalUniversityFiles()
{
    wp_enqueue_script("university-main-js", get_theme_file_uri("/build/index.js"), array("jquery"), "1.0", true);

    wp_enqueue_style("university-main-styles", get_theme_file_uri("/build/style-index.css"));
    wp_enqueue_style("university-styles", get_theme_file_uri("/build/index.css"));
    wp_enqueue_style("fontawesome-styles", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");

    wp_localize_script('university-main-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action("wp_enqueue_scripts", "fictionalUniversityFiles");

function mytheme_customize_register($wp_customize)
{
    $wp_customize->add_setting(
        'mytheme_font_family',
        array(
            'default' => 'Arial',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mytheme_font_family',
        array(
            'label' => __('Font Family', 'mytheme'),
            'section' => 'mytheme_typography_section',
            'settings' => 'mytheme_font_family',
            'type' => 'select',
            'choices' => array(
                'Arial' => 'Arial',
                'Helvetica' => 'Helvetica',
                'Times New Roman' => 'Times New Roman',
                'Georgia' => 'Georgia',
                'Courier New' => 'Courier New',
            ),
        )
    );

    $wp_customize->add_setting(
        'mytheme_font_color',
        array(
            'default' => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mytheme_font_color',
            array(
                'label' => __('Font Color', 'mytheme'),
                'section' => 'mytheme_typography_section',
                'settings' => 'mytheme_font_color',
            )
        )
    );

    $wp_customize->add_section(
        'mytheme_typography_section',
        array(
            'title' => __('Typography', 'mytheme'),
            'priority' => 30,
        )
    );
}

add_action('customize_register', 'mytheme_customize_register');

function mytheme_customizer_css()
{
    ?>
    <style type="text/css">
        body {
            font-family:
                <?php echo esc_html(get_theme_mod('mytheme_font_family', 'Arial')); ?>
            ;
            color:
                <?php echo esc_html(get_theme_mod('mytheme_font_color', '#000000')); ?>
            ;
        }
    </style>
    <?php
}

add_action('wp_head', 'mytheme_customizer_css');

function ourHeaderUrl () {
    return site_url('/');
}

add_filter('login_headerurl', 'ourHeaderUrl');

function loginCss () {
    wp_enqueue_style("university-main-styles", get_theme_file_uri("/build/style-index.css"));
    wp_enqueue_style("university-styles", get_theme_file_uri("/build/index.css"));
    wp_enqueue_style("fontawesome-styles", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
}

add_action('login_enqueue_scripts', 'loginCss');

function login_title () {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'login_title');