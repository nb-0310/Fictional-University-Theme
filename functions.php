<?php

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
    university_menus();
}

add_action("after_setup_theme", "university_theme_support");

function fictionalUniversityFiles()
{
    wp_enqueue_script("university-main-js", get_theme_file_uri("/theme-template/build/index.js"), array("jquery"), "1.0", true);

    wp_enqueue_style("university-main-styles", get_theme_file_uri("/theme-template/build/style-index.css"));
    wp_enqueue_style("university-styles", get_theme_file_uri("/theme-template/build/index.css"));
    wp_enqueue_style("fontawesome-styles", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
}

add_action("wp_enqueue_scripts", "fictionalUniversityFiles");

function mytheme_customize_register($wp_customize) {
    $wp_customize->add_setting('mytheme_font_family', array(
        'default' => 'Arial',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('mytheme_font_family', array(
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
    ));

    $wp_customize->add_setting('mytheme_font_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mytheme_font_color', array(
        'label' => __('Font Color', 'mytheme'),
        'section' => 'mytheme_typography_section',
        'settings' => 'mytheme_font_color',
    )));

    $wp_customize->add_section('mytheme_typography_section', array(
        'title' => __('Typography', 'mytheme'),
        'priority' => 30,
    ));
}

add_action('customize_register', 'mytheme_customize_register');

function mytheme_customizer_css() {
    ?>
    <style type="text/css">
        body {
            font-family: <?php echo esc_html(get_theme_mod('mytheme_font_family', 'Arial')); ?>;
            color: <?php echo esc_html(get_theme_mod('mytheme_font_color', '#000000')); ?>;
        }
    </style>
    <?php
}

add_action('wp_head', 'mytheme_customizer_css');