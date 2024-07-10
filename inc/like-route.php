<?php
function universityLikeRoutes()
{
    register_rest_route(
        "university",
        "manageLike",
        array(
            "methods" => "POST",
            "callback" => 'createLike'
        )
    );

    register_rest_route(
        "university",
        "manageLike",
        array(
            "methods" => "DELETE",
            "callback" => 'deleteLike'
        )
    );

    register_rest_route(
        "university",
        "manageLike",
        array(
            "methods" => "GET",
            "callback" => 'getLike'
        )
    );
}

function getLike () {
    return 'HEYYY';
}

function createLike($data)
{
    $id = sanitize_text_field($data['professorId']);
    wp_insert_post(
        array(
            'post_type' => 'like',
            'post_status' => 'publish',
            'post_title' => 'Our PHP Create Post Test',
            'meta_input' => array(
                'liked_professor_id' => $id
            )
        )
    );
}

function deleteLike()
{
    return 'Thanks for deleting';
}

add_action("rest_api_init", "universityLikeRoutes");