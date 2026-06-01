<?php

if (! class_exists('Fancybox_Gallery')) :
    class Fancybox_Gallery
    {
        public function run()
        {
            add_filter('wp_get_attachment_link', array($this, 'add_fancybox_attributes'), 10, 6);
            add_filter('render_block', array($this, 'add_fancybox_to_gallery_block'), 10, 2);
        }

        public function add_fancybox_attributes($html, $id, $size, $permalink, $icon, $text)
        {
            if ($permalink) {
                return $html;
            }

            $html = str_replace('<a ', '<a data-fancybox="gallery" ', $html);
            return $html;
        }

        public function add_fancybox_to_gallery_block($block_content, $block)
        {
            if ($block['blockName'] !== 'core/gallery' && $block['blockName'] !== 'core/image') {
                return $block_content;
            }

            $block_content = preg_replace(
                '/<a ([^>]*?)href="([^"]*?)\.(jpg|jpeg|png|gif|webp|avif)"/i',
                '<a $1href="$2.$3" data-fancybox="gallery"',
                $block_content
            );

            return $block_content;
        }
    }

    (new Fancybox_Gallery())->run();
endif;
