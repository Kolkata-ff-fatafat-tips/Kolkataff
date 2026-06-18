<?php get_header(); ?>
<div class="kff-container kff-content-panel">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; else : ?>
        <h1><?php esc_html_e('Nothing Found', 'kolkata-ff-theme'); ?></h1>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
