<?php get_header(); ?>

<main id="main">
    <?php
    get_template_part('template-parts/front/hero');
    get_template_part('template-parts/front/stats');
    get_template_part('template-parts/front/about');
    get_template_part('template-parts/front/experience');
    get_template_part('template-parts/front/skills');
    get_template_part('template-parts/front/projects');
    ?>
</main>

<?php get_footer(); ?>
