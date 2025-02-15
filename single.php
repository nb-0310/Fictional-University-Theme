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
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home"
                        aria-hidden="true"></i> Back to Blogs</a> <span class="metabox__main">Posted By
                    <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in
                    <?php echo get_the_category_list(', '); ?>
                </span>
                </p>
            </div>

            <p><?php the_content() ?></p>
        </div>
    </div>

<?php }

get_footer();
?>