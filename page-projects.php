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

    <div class="absolute bottom-0 left-0 w-full flex flex-col items-center">
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

<main class="relative flex flex-col justify-center bg-slate-50 overflow-hidden">
    <div class="w-full max-w-5xl mx-auto px-4 md:px-6 py-24">

        <div class="space-y-20">

            <div>
                <h2 class="font-bold text-lg mb-4">With CSS Columns</h2>
                <!-- With columns -->
                <div class="columns-2 md:columns-4 gap-4 space-y-4">
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-01.jpg" width="232" height="290" alt="Image 01" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-02.jpg" width="232" height="290" alt="Image 02" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-03.jpg" width="232" height="174" alt="Image 03" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-04.jpg" width="232" height="155" alt="Image 04" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-05.jpg" width="232" height="349" alt="Image 05" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-06.jpg" width="232" height="250" alt="Image 06" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-07.jpg" width="232" height="349" alt="Image 07" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-08.jpg" width="232" height="155" alt="Image 08" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-09.jpg" width="232" height="250" alt="Image 09" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-10.jpg" width="232" height="290" alt="Image 10" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-11.jpg" width="232" height="155" alt="Image 11" />
                    <img class="w-full rounded-xl shadow" src="https://cruip-tutorials.vercel.app/masonry/masonry-12.jpg" width="232" height="309" alt="Image 12" />
                </div>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>