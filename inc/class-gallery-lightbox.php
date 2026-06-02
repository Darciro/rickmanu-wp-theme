<?php

/**
 * Gallery Lightbox
 *
 * Enhances the default WordPress gallery (shortcode and block) to support
 * Fancybox lightbox with caption display on image expand.
 *
 * @package rickmanu
 */

if (! class_exists('Gallery_Lightbox')) :

    class Gallery_Lightbox
    {
        /**
         * Counter used to generate unique gallery group IDs.
         *
         * @var int
         */
        private static int $gallery_count = 0;

        public function run(): void
        {
            // Classic [gallery] shortcode
            add_filter('post_gallery', array($this, 'render_classic_gallery'), 10, 3);

            // Gutenberg core/gallery block
            add_filter('render_block', array($this, 'enhance_block_gallery'), 10, 2);
        }

        /**
         * Override the classic [gallery] shortcode output to add Fancybox support.
         *
         * @param string $output  Current gallery output (empty triggers default).
         * @param array  $attr    Shortcode attributes.
         * @param int    $instance Unique instance number.
         * @return string Modified gallery HTML.
         */
        public function render_classic_gallery(string $output, array $attr, int $instance): string
        {
            global $post;

            $atts = shortcode_atts(
                array(
                    'order'   => 'ASC',
                    'orderby' => 'menu_order ID',
                    'id'      => $post ? $post->ID : 0,
                    'size'    => 'large',
                    'include' => '',
                    'exclude' => '',
                ),
                $attr,
                'gallery'
            );

            $id = intval($atts['id']);

            self::$gallery_count++;
            $gallery_id = 'rickmanu-gallery-' . self::$gallery_count;

            if (! empty($atts['include'])) {
                $include     = preg_replace('/[^0-9,]+/', '', $atts['include']);
                $attachments = get_posts(array(
                    'include'        => $include,
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                ));
                $attachments = wp_list_pluck($attachments, null, 'ID');
            } else {
                $attachments = get_children(array(
                    'post_parent'    => $id,
                    'post_status'    => 'inherit',
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'order'          => $atts['order'],
                    'orderby'        => $atts['orderby'],
                ));
            }

            if (empty($attachments)) {
                return '';
            }

            $html = '<div class="rickmanu-gallery" id="' . esc_attr($gallery_id) . '">';

            foreach ($attachments as $attachment) {
                $full_src = wp_get_attachment_image_src($attachment->ID, 'full');

                if (! $full_src) {
                    continue;
                }

                $caption = trim($attachment->post_excerpt);
                $alt     = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                $alt     = $alt ?: $attachment->post_title;

                $html .= '<figure class="rickmanu-gallery__item">';
                $html .= '<a href="' . esc_url($full_src[0]) . '"'
                    . ' data-fancybox="' . esc_attr($gallery_id) . '"'
                    . ($caption ? ' data-caption="' . esc_attr($caption) . '"' : '')
                    . '>';
                $html .= wp_get_attachment_image(
                    $attachment->ID,
                    $atts['size'],
                    false,
                    array(
                        'alt'     => esc_attr($alt),
                        'loading' => 'lazy',
                    )
                );
                $html .= '</a>';

                if ($caption) {
                    $html .= '<figcaption class="rickmanu-gallery__caption">'
                        . esc_html($caption)
                        . '</figcaption>';
                }

                $html .= '</figure>';
            }

            $html .= '</div>';

            return $html;
        }

        /**
         * Enhance the Gutenberg core/gallery block HTML to add Fancybox support.
         *
         * Adds data-fancybox (group) and data-caption attributes to each image
         * anchor, creating them when the block has no link set.
         *
         * @param string $block_content Rendered block HTML.
         * @param array  $block         Block data.
         * @return string Modified block HTML.
         */
        public function enhance_block_gallery(string $block_content, array $block): string
        {
            if ('core/gallery' !== $block['blockName']) {
                return $block_content;
            }

            self::$gallery_count++;
            $gallery_id = 'rickmanu-gallery-' . self::$gallery_count;

            $doc = new DOMDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            $doc->loadHTML(
                '<html><head><meta charset="UTF-8"></head><body>' . $block_content . '</body></html>'
            );
            libxml_clear_errors();

            $xpath   = new DOMXPath($doc);
            $figures = $xpath->query('//figure[contains(@class,"wp-block-image")]');

            foreach ($figures as $figure) {
                /** @var DOMElement $figure */

                // Collect caption text from figcaption sibling, if present.
                $caption_nodes = $xpath->query('.//figcaption', $figure);
                $caption       = $caption_nodes->length > 0
                    ? trim($caption_nodes->item(0)->textContent)
                    : '';

                $anchors = $xpath->query('.//a', $figure);

                if ($anchors->length > 0) {
                    // Anchor already exists — just decorate it.
                    /** @var DOMElement $anchor */
                    $anchor = $anchors->item(0);
                    $anchor->setAttribute('data-fancybox', $gallery_id);
                    if ($caption) {
                        $anchor->setAttribute('data-caption', $caption);
                    }
                } else {
                    // No anchor — wrap the img element in one.
                    $imgs = $xpath->query('.//img', $figure);
                    if ($imgs->length === 0) {
                        continue;
                    }

                    /** @var DOMElement $img */
                    $img      = $imgs->item(0);
                    $full_src = $img->getAttribute('data-full-url') ?: $img->getAttribute('src');

                    /** @var DOMElement $anchor */
                    $anchor = $doc->createElement('a');
                    $anchor->setAttribute('href', $full_src);
                    $anchor->setAttribute('data-fancybox', $gallery_id);
                    if ($caption) {
                        $anchor->setAttribute('data-caption', $caption);
                    }

                    $img->parentNode->insertBefore($anchor, $img);
                    $anchor->appendChild($img);
                }
            }

            // Extract only the <body> content to return clean HTML.
            $body = $doc->getElementsByTagName('body')->item(0);
            $html = '';
            foreach ($body->childNodes as $child) {
                $html .= $doc->saveHTML($child);
            }

            return $html;
        }
    }

    (new Gallery_Lightbox())->run();

endif;
