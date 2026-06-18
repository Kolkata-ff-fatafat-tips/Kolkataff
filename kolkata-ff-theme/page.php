<?php get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('kff-page'); ?>>
        <?php the_content(); ?>
        <?php edit_post_link(__('Edit page', 'kolkata-ff-theme'), '<div class="kff-container kff-edit-link">', '</div>'); ?>
    </article>
<?php endwhile; ?>
<?php get_footer(); ?>
