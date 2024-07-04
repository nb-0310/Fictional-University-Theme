<?php
get_header();

while (have_posts()) {
    the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
            style="background-image: url(<?php echo get_theme_file_uri("/theme-template/images/ocean.jpg") ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title() ?></h1>
            <div class="page-banner__intro">
                <p>DON'T FORGET TO REPLACE ME LATER.</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="generic-content">

            <div class="metabox metabox--position-up metabox--with-home-link">
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i
                        class="fa fa-home" aria-hidden="true"></i> Back to Programs</a> <span
                    class="metabox__main"><?php the_title(); ?>
                </span>
            </div>

            <p><?php the_content() ?></p>
        </div>

        <?php
        $home_page_events = new WP_Query(
            array(
                'posts_per_page' => 2,
                'post_type' => 'event',
                'meta_key' => 'event-date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'related-programs',
                        'compare' => 'LIKE',
                        'value' => get_the_ID()
                    )
                )
            )
        );

        if ($home_page_events->have_posts()):
            ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Related Event(s)</h2>

            <?php
            while ($home_page_events->have_posts()) {
                $home_page_events->the_post();
                ?>


                <div class="event-summary">
                    <a class="event-summary__date t-center" href="#">
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
                        <p><?php if (has_excerpt()) {
                            echo get_the_excerpt();
                        } else {
                            echo wp_trim_words(get_the_excerpt(), 18);
                        } ?> <a href="#" class="nu gray">Learn more</a>
                        </p>
                    </div>
                </div>

            <?php }
            wp_reset_postdata();
        endif;
        ?>


    </div>

<?php }

get_footer();
?>