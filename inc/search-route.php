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

    while ($professors->have_posts()) {
        $professors->the_post();

        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push($results['general_info'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'type' => get_post_type(),
                'authorName' => get_the_author()
            )
            );
        }

        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professor-landscape')
            )
            );
        }

        if (get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            )
            );
        }

        if (get_post_type() == 'event') {
            $description = NULL;

            has_excerpt() ?
                $description = get_the_excerpt()
                :
                $description = wp_trim_words(get_the_excerpt(), 18);


            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => get_date()['month'],
                'day' => get_date()['day'],
                'excerpt' => $description
            )
            );
        }
    }

    return $results;
}

function get_date()
{
    $date = new DateTime(get_field('event-date'));
    return array(
        "month" => $date->format('M'),
        'day' => $date->format('j')
    );
}

add_action("rest_api_init", "university_register_search");
