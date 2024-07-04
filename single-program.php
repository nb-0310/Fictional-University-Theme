<?php
get_header();

while (have_posts()) {
    the_post(); ?>
    <?php
    page_banner();
    ?>

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
        $related_professors = new WP_Query(
            array(
                'posts_per_page' => -1,
                'post_type' => 'professor',
                'orderby' => 'title',
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

        if ($related_professors->have_posts()):
            ?>
            <hr class="section-break">
            <h2 class="headline headline--medium"><?php the_title(); ?> Professor(s)</h2>

            <ul class="professor-cards">
                <?php
                while ($related_professors->have_posts()) {
                    $related_professors->the_post();
                    ?>

                    <li class="professor-card__list-item">
                        <a class="professor-card" href="<?php the_permalink(); ?>">
                            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professor-landscape'); ?>" alt="">
                            <span class="professor-card__name"><?php the_title(); ?></span>
                            <span></span>
                        </a>
                    </li>

                <?php }
                echo "</ul>";
                wp_reset_postdata();
        endif;

        $home_page_events = new WP_Query(
            array(
                'posts_per_page' => 10,
                'post_type' => 'event',
                'meta_key' => 'event-date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'event-date',
                        'compare' => '>=',
                        'value' => date('Ymd')
                    ),
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
                <h2 class="headline headline--medium">Upcoming <?php the_title(); ?> Event(s)</h2>

                <?php
                while ($home_page_events->have_posts()) {
                    $home_page_events->the_post();
                    get_template_part('template-parts/event');
                }
                wp_reset_postdata();
        endif;
        ?>


    </div>

<?php }

get_footer();
?>