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
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i
                        class="fa fa-home" aria-hidden="true"></i> Back to Events</a> <span
                    class="metabox__main"><?php the_title(); ?>
                </span>
            </div>

            <p><?php the_content() ?></p>
        </div>
        <?php if (get_field('related-programs')): ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Related Program(s)</h2>
            <ul>
                <?php
                $relations = get_field('related-programs');
                foreach ($relations as $program) {
                    ?>
                    <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>

                <?php }
                ?>
            </ul>
        <?php endif; ?>
    </div>

<?php }

get_footer();
?>