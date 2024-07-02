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
    <ul class="link-list min-list">
        <?php
        while (have_posts()) {
            the_post();
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>

        <?php } ?>
    </ul>
    <?php echo paginate_links(); ?>
</div>

<?php get_footer(); ?>