<?php

/**
 * Front page career timeline.
 *
 * @package rickmanu
 */

?>
<section id="experience" class="page-shell flex flex-col gap-12 pt-30 pb-10" aria-labelledby="experience-title">
    <?php
    get_template_part('template-parts/section-heading', null, [
        'eyebrow' => __('02 / git log --career', 'rickmanu'),
        'title'   => __('Experience', 'rickmanu'),
        'id'      => 'experience-title',
        'meta'    => '<span class="text-[15px] text-fg-subtle">' . esc_html__('2012 — today', 'rickmanu') . '</span>',
    ]);
    ?>

    <ol class="flex flex-col border-t border-line">
        <?php foreach (rickmanu_get_experience() as $rickmanu_job) : ?>
            <li class="flex flex-wrap gap-x-10 gap-y-3 border-b border-line py-8">
                <p class="flex-[1_1_200px] pt-1.5 font-mono text-sm <?php echo $rickmanu_job['current'] ? 'text-accent' : 'text-fg-subtle'; ?>">
                    <?php echo esc_html($rickmanu_job['period']); ?>
                </p>
                <div class="flex min-w-0 flex-[999_1_520px] flex-col gap-2">
                    <h3 class="font-display text-[28px] font-semibold tracking-[-0.015em]">
                        <?php echo esc_html($rickmanu_job['company']); ?>
                        <?php if ($rickmanu_job['group']) : ?>
                            <span class="font-normal text-fg-subtle"><?php echo esc_html($rickmanu_job['group']); ?></span>
                        <?php endif; ?>
                    </h3>
                    <p class="font-medium text-fg-soft"><?php echo esc_html($rickmanu_job['role']); ?></p>
                    <p class="text-base text-fg-muted"><?php echo esc_html($rickmanu_job['summary']); ?></p>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>
</section>
