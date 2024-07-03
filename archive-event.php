<?php get_header(); ?>

<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri("/theme-template/images/library-hero.jpg") ?>)">
    </div>
    <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">
            All Events
        </h1>
        <h3 class="headline headline--small">See What is going on in our world
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post();
        ?>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php echo the_permalink(); ?>">
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
                <p><?php echo wp_trim_words(get_the_excerpt(), 18); ?> <a href="<?php echo the_permalink(); ?>"
                        class="nu gray">Learn more</a>
                </p>
            </div>
        </div>
    <?php }
    echo paginate_links();
    ?>
</div>

<?php get_footer(); ?>