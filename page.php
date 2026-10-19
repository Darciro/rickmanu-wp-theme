<?php get_header(); ?>

<main id="main" class="page-shell pt-24 pb-10">
    <?php
    while (have_posts()) :
        the_post();
    ?>
        <article <?php post_class('mx-auto flex max-w-3xl flex-col gap-12'); ?>>
            <h1 class="font-display text-[clamp(40px,6vw,64px)] leading-none font-extrabold tracking-[-0.035em]">
                <?php the_title(); ?>
            </h1>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
