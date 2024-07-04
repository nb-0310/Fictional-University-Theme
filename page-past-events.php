<?php get_header(); ?>

<?php
page_banner(
    array(
        "title" => "Past Events",
        "subtitle" => "A recap of our past events."
    )
);
?>

<div class="container container--narrow page-section">
    <?php
    $today = date('Ymd');
    $past_events = new WP_Query(
        array(
            "posts_per_page" => 10,
            "post_type" => "event",
            'meta_key' => 'event-date',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'event-date',
                    'compare' => '<',
                    'value' => $today,
                    'type' => 'numeric'
                )
            )

        )
    );

    if ($past_events->have_posts()) {
        while ($past_events->have_posts()) {
            $past_events->the_post();
            get_template_part('template-parts/event');
        }

        echo paginate_links(
            array(
                'total' => $past_events->max_num_pages
            )
        );
    } else {
        echo '<p>No past events found.</p>';
    }

    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>