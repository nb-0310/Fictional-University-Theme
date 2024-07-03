<?php get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri("/theme-template/images/library-hero.jpg"); ?>)">
    </div>
    <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">
            Past Events
        </h1>
        <h3 class="headline headline--small">A recap of our past events.</h3>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    $today = date('Ymd');
    $past_events = new WP_Query(
        array(
            "posts_per_page" => 1,
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
            ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                    <span class="event-summary__month">
                        <?php
                        $date = new DateTime(get_field('event-date'));
                        echo $date->format('M'); ?>
                    </span>
                    <span class="event-summary__day"><?php echo $date->format('j'); ?></span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a
                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 18); ?> <a href="<?php the_permalink(); ?>"
                            class="nu gray">Learn more</a>
                    </p>
                </div>
            </div>
        <?php }

        echo paginate_links(array(
            'total' => $past_events->max_num_pages
        ));
    } else {
        echo '<p>No past events found.</p>';
    }

    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>