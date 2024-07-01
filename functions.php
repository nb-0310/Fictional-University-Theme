<?php

function university_theme_support() {
    add_theme_support('title-tag');
}

add_action("after_setup_theme", "university_theme_support");

function fictionalUniversityFiles() {
    wp_enqueue_script("university-main-js", get_theme_file_uri("/theme-template/build/index.js"), array("jquery"), "1.0", true);

    wp_enqueue_style("university-main-styles", get_theme_file_uri("/theme-template/build/style-index.css"));
    wp_enqueue_style("university-styles", get_theme_file_uri("/theme-template/build/index.css"));
    wp_enqueue_style("fontawesome-styles", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
}

add_action("wp_enqueue_scripts", "fictionalUniversityFiles");