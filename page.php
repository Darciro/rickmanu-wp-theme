<?php get_header(); ?>

<div class="m-0 bg-[#073C3F] flex items-center justify-center relative">
    <div class="relative w-182 h-40 py-10 flex items-center justify-center overflow-hidden">

        <div class="absolute w-25 h-25 bg-[#004D52] shadow-2xl"></div>

        <div class="relative z-10 flex flex-col items-center">
            <h1 class="font-feature text-[#C9A06F] text-[40px] leading-none">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    Rick Manu
                </a>
            </h1>

            <!-- <p class="font-main-text text-[#C9A06F] text-[22px] mt-6">
                &lt;developer/&gt;
            </p> -->
        </div>

    </div>

    <div class="absolute bottom-0 left-0 w-full flex flex-col items-center hidden">
        <nav class="w-full">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'depth'          => 1,
                'container'      => '',
                'menu_id'        => 'main-navigation',
                'menu_class'     => 'flex w-full justify-between',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker'         => new Split_Nav_Walker(),
            ));
            ?>
        </nav>
    </div>
</div>

<main class="w-full max-w-4xl mx-auto py-20 px-10">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <h1 class="font-feature text-[#073C3F] border-b border-b-[#073C3F] text-[64px] pb-3 mb-12"><?php the_title(); ?></h1>

            <?php the_content(); ?>

    <?php endwhile;
    endif;
    ?>
</main>

<?php get_footer(); ?>