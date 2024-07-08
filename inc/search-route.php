<?php
function university_register_search()
{
    register_rest_route(
        "university",
        "search",
        array(
            "methods" => "GET",
            "callback" => "university_search_results"
        )
    );
}

function university_search_results($data)
{
    $professors = new WP_Query(
        array(
            "post_type" => ["post", "page", "professor", "event", "program"],
            "s" => sanitize_text_field($data['term'])
        )
    );

    $results = array(
        'general_info' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
    );

    while($professors->have_posts()) {
        $professors->the_post();

        if (get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['general_info'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'type' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }

        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'event') {
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
    }

    return $results;
}

add_action("rest_api_init", "university_register_search");
