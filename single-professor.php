<?php
get_header();

while (have_posts()) {
    the_post(); 
    page_banner();
    ?>

    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail('professor-portrait'); ?></div>
                <div class="two-thirds">
                    <?php
                    $like_count = new WP_Query(
                        array(
                            'post_type' => 'like',
                            'meta_query' => array(
                                array(
                                    'key' => 'liked_professor_id',
                                    'compare' => '=',
                                    'value' => get_the_ID()
                                )
                            )
                        )
                    );

                    $exist_query = new WP_Query(
                        array(
                            'author' => get_current_user_id(),
                            'post_type' => 'like',
                            'meta_query' => array(
                                array(
                                    'key' => 'liked_professor_id',
                                    'compare' => '=',
                                    'value' => get_the_ID()
                                )
                            )
                        )
                    );
                    ?>
                <span class="like-box" data-exists="<?php echo $exist_query->found_posts > 0 ? 'yes' : 'no'; ?>">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <span class="like-count"><?php echo $like_count->found_posts ?></span>
                </span>
                <?php the_content(); ?>
            </div>
            </div>
        </div>
        <?php if (get_field('related-programs')): ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Subject(s) Taught</h2>
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