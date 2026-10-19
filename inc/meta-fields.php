<?php

/**
 * Native post meta fields for the theme post types.
 *
 * Registers each field with register_post_meta() (type, default and a
 * sanitize callback, so every write path is sanitized) and renders them in a
 * classic meta box saved with a nonce and capability check.
 *
 * A field is defined as:
 *
 * - label       (string) Field label.
 * - type        (string) text, url, textarea, select or checkbox.
 * - required    (bool)   Adds the HTML required attribute.
 * - description (string) Help text shown below the field.
 * - placeholder (string) Input placeholder.
 * - choices     (array)  Value => label pairs, for select fields.
 * - default     (mixed)  Value returned when the meta is not set.
 * - rows        (int)    Rows, for textarea fields.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_META_NONCE_NAME = 'rickmanu_meta_nonce';
const RICKMANU_META_INPUT_NAME = 'rickmanu_meta';

/**
 * Sanitize callback for a field, picked by its type.
 *
 * @param array<string, mixed> $field Field definition.
 */
function rickmanu_get_meta_sanitizer(array $field): callable
{
    return match ($field['type'] ?? 'text') {
        'url'      => static fn($value): string => esc_url_raw((string) $value),
        'textarea' => static fn($value): string => sanitize_textarea_field((string) $value),
        'checkbox' => static fn($value): string => rest_sanitize_boolean($value) ? '1' : '0',
        'select'   => static fn($value): string => array_key_exists((string) $value, $field['choices'] ?? [])
            ? (string) $value
            : (string) ($field['default'] ?? ''),
        default    => static fn($value): string => sanitize_text_field((string) $value),
    };
}

/**
 * Registers the fields of a post type, plus the meta box that edits them.
 * Call it on "init", after the post type is registered.
 *
 * @param string                           $post_type Post type slug.
 * @param string                           $title     Meta box title.
 * @param array<string, array<string, mixed>> $fields Field definitions keyed by meta key.
 */
function rickmanu_register_meta_fields(string $post_type, string $title, array $fields): void
{
    foreach ($fields as $key => $field) {
        $is_checkbox = 'checkbox' === ($field['type'] ?? 'text');

        register_post_meta($post_type, $key, [
            'type'              => $is_checkbox ? 'boolean' : 'string',
            'single'            => true,
            'default'           => $field['default'] ?? ($is_checkbox ? false : ''),
            'show_in_rest'      => false,
            'sanitize_callback' => rickmanu_get_meta_sanitizer($field),
            'auth_callback'     => static fn($allowed, $meta_key, $post_id): bool => current_user_can('edit_post', $post_id),
        ]);
    }

    add_action("add_meta_boxes_{$post_type}", static function () use ($post_type, $title, $fields): void {
        add_meta_box(
            'rickmanu-meta-' . $post_type,
            $title,
            static fn(WP_Post $post) => rickmanu_render_meta_fields($post, $fields),
            $post_type,
            'normal',
            'high'
        );
    });

    add_action("save_post_{$post_type}", static function (int $post_id, WP_Post $post) use ($fields): void {
        rickmanu_save_meta_fields($post_id, $post, $fields);
    }, 10, 2);
}

/**
 * Prints the meta box fields.
 *
 * @param array<string, array<string, mixed>> $fields Field definitions keyed by meta key.
 */
function rickmanu_render_meta_fields(WP_Post $post, array $fields): void
{
    wp_nonce_field('rickmanu_save_meta_' . $post->ID, RICKMANU_META_NONCE_NAME);
    ?>
    <table class="form-table" role="presentation">
        <?php foreach ($fields as $key => $field) : ?>
            <?php
            $type        = $field['type'] ?? 'text';
            $id          = 'rickmanu-meta-' . $key;
            $name        = RICKMANU_META_INPUT_NAME . '[' . $key . ']';
            $value       = get_post_meta($post->ID, $key, true);
            $description = $field['description'] ?? '';
            $described   = $description ? ' aria-describedby="' . esc_attr($id . '-description') . '"' : '';
            $required    = ! empty($field['required']) ? ' required' : '';
            ?>
            <tr>
                <th scope="row">
                    <label for="<?php echo esc_attr($id); ?>">
                        <?php echo esc_html($field['label']); ?>
                        <?php if ($required) : ?>
                            <span aria-hidden="true">*</span>
                        <?php endif; ?>
                    </label>
                </th>
                <td>
                    <?php if ('textarea' === $type) : ?>
                        <textarea id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" class="large-text" rows="<?php echo esc_attr((string) ($field['rows'] ?? 4)); ?>" <?php echo $described . $required; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from escaped values above. ?>><?php echo esc_textarea((string) $value); ?></textarea>
                    <?php elseif ('select' === $type) : ?>
                        <select id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" <?php echo $described . $required; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from escaped values above. ?>>
                            <?php foreach ($field['choices'] ?? [] as $choice => $choice_label) : ?>
                                <option value="<?php echo esc_attr((string) $choice); ?>" <?php selected((string) $value, (string) $choice); ?>><?php echo esc_html($choice_label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php elseif ('checkbox' === $type) : ?>
                        <input type="hidden" name="<?php echo esc_attr($name); ?>" value="0" />
                        <input type="checkbox" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" value="1" <?php checked((bool) $value); ?> <?php echo $described; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from escaped values above. ?> />
                    <?php else : ?>
                        <input type="<?php echo 'url' === $type ? 'url' : 'text'; ?>" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr((string) $value); ?>" class="large-text" placeholder="<?php echo esc_attr($field['placeholder'] ?? ''); ?>" <?php echo $described . $required; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Built from escaped values above. ?> />
                    <?php endif; ?>
                    <?php if ($description) : ?>
                        <p class="description" id="<?php echo esc_attr($id . '-description'); ?>"><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
}

/**
 * Saves the submitted meta box fields. Empty values remove the meta.
 *
 * @param array<string, array<string, mixed>> $fields Field definitions keyed by meta key.
 */
function rickmanu_save_meta_fields(int $post_id, WP_Post $post, array $fields): void
{
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    $nonce = isset($_POST[RICKMANU_META_NONCE_NAME]) ? sanitize_text_field(wp_unslash($_POST[RICKMANU_META_NONCE_NAME])) : '';

    if (! wp_verify_nonce($nonce, 'rickmanu_save_meta_' . $post_id) || ! current_user_can('edit_post', $post_id)) {
        return;
    }

    $submitted = isset($_POST[RICKMANU_META_INPUT_NAME]) && is_array($_POST[RICKMANU_META_INPUT_NAME])
        ? wp_unslash($_POST[RICKMANU_META_INPUT_NAME]) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Each value is sanitized below by the callback registered with register_post_meta().
        : [];

    foreach ($fields as $key => $field) {
        if (! isset($submitted[$key]) || ! is_scalar($submitted[$key])) {
            continue;
        }

        $value = sanitize_meta($key, (string) $submitted[$key], 'post', $post->post_type);

        if ('' === $value) {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, wp_slash($value));
        }
    }
}
