<?php get_header(); ?>

<main id="main" class="page-shell flex flex-col gap-12 pt-24 pb-10">
    <h1 class="font-display text-[clamp(40px,6vw,64px)] leading-none font-extrabold tracking-[-0.035em]">
        <?php
        if (is_search()) {
            /* translators: %s: search query. */
            printf(esc_html__('Results for “%s”', 'rickmanu'), esc_html(get_search_query()));
        } elseif (is_archive()) {
            echo esc_html(wp_strip_all_tags(get_the_archive_title()));
        } elseif (is_404()) {
            esc_html_e('Page not found', 'rickmanu');
        } else {
            esc_html_e('Posts', 'rickmanu');
        }
        ?>
    </h1>

    <?php if (have_posts()) : ?>
        <ol class="flex flex-col border-t border-line">
            <?php
            while (have_posts()) :
                the_post();
            ?>
                <li <?php post_class('flex flex-wrap gap-x-10 gap-y-3 border-b border-line py-8'); ?>>
                    <time class="flex-[1_1_200px] pt-1.5 font-mono text-sm text-fg-subtle" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                    <div class="flex min-w-0 flex-[999_1_520px] flex-col gap-2">
                        <h2 class="font-display text-[28px] font-semibold tracking-[-0.015em]">
                            <a class="transition-colors hover:text-accent" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="text-base text-fg-muted"><?php the_excerpt(); ?></div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ol>

        <?php
        the_posts_pagination([
            'class'     => 'font-mono text-sm text-fg-subtle [&_.nav-links]:flex [&_.nav-links]:flex-wrap [&_.nav-links]:gap-4 [&_.current]:text-accent [&_a:hover]:text-accent',
            'prev_text' => esc_html__('← Newer', 'rickmanu'),
            'next_text' => esc_html__('Older →', 'rickmanu'),
        ]);
        ?>
    <?php else : ?>
        <p class="text-fg-muted">
            <?php esc_html_e('Nothing here yet.', 'rickmanu'); ?>
            <a class="text-accent underline underline-offset-4 hover:text-fg" href="<?php echo esc_url(rickmanu_home_url()); ?>"><?php esc_html_e('Back to the home page →', 'rickmanu'); ?></a>
        </p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
