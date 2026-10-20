<?php get_template_part('template-parts/contact'); ?>

<footer class="border-t border-line max-[820px]:pb-23">
    <div class="page-shell flex flex-wrap justify-between gap-3 py-7 text-sm text-fg-subtle">
        <p>
            <?php
            /* translators: %s: current year. */
            printf(esc_html__('© %s Ricardo Carvalho (Rick Manu). All rights reserved.', 'rickmanu'), esc_html(wp_date('Y')));
            ?>
        </p>
        <p class="font-mono">&lt;developer/&gt; · <?php esc_html_e('senior software engineer', 'rickmanu'); ?></p>
    </div>
</footer>

</div><!-- #smooth-content -->
</div><!-- #smooth-wrapper -->

<?php wp_footer(); ?>

</body>

</html>
