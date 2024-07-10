<?php get_header();

if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
}

while (have_posts()) {
    the_post();
    page_banner();
    ?>

    <div class="container container--narrow page-section">
        <div class="create-note">
            <h2 class="headline headline--medium">Create New Note</h2>
            <input type="text" placeholder="Title" class="new-note-title">
            <textarea name="" id="" class="new-note-body" placeholder="Your note here ..."></textarea>
            <span class="submit-note">Create Note</span>
        </div>

        <ul class="min-list link-list" id="my-notes">
            <?php
            $user_notes = new WP_Query(
                array(
                    'post_type' => 'note',
                    'posts_per_page' => -1,
                    'author' => get_current_user_id()
                )
            );

            while ($user_notes->have_posts()) {
                $user_notes->the_post(); ?>
                <li id="<?php the_ID(); ?>">
                    <input readonly type="text" class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                    <span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o"></i> Delete</span>
                    <textarea readonly
                        class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i> Save</span>
                </li>
            <?php }
            ?>
        </ul>
    </div>

<?php }
get_footer(); ?>