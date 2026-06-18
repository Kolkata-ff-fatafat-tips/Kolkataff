<?php get_header(); ?>
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        the_content();
        edit_post_link(__('Edit homepage', 'kolkata-ff-theme'), '<div class="kff-container kff-edit-link">', '</div>');
    }
} else {
    echo do_shortcode('[kff_home]');
}
?>
<?php get_footer(); ?>
