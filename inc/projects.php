<?php

/**
 * Project post type (portfolio) and its meta fields.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_PROJECT_POST_TYPE = 'rickmanu_project';

/**
 * Project types offered in the editor, keyed by the stored value.
 *
 * @return array<string, string>
 */
function rickmanu_get_project_types(): array
{
    return [
        'web'  => __('Web', 'rickmanu'),
        'game' => __('Game', 'rickmanu'),
    ];
}

/**
 * Registers the Project post type. The post title holds the project name and
 * the featured image is the project screenshot.
 */
function rickmanu_project_register_post_type(): void
{
    register_post_type(RICKMANU_PROJECT_POST_TYPE, [
        'labels'        => [
            'name'                  => __('Projects', 'rickmanu'),
            'singular_name'         => __('Project', 'rickmanu'),
            'add_new_item'          => __('Add New Project', 'rickmanu'),
            'edit_item'             => __('Edit Project', 'rickmanu'),
            'new_item'              => __('New Project', 'rickmanu'),
            'view_item'             => __('View Project', 'rickmanu'),
            'search_items'          => __('Search Projects', 'rickmanu'),
            'not_found'             => __('No projects found.', 'rickmanu'),
            'not_found_in_trash'    => __('No projects found in Trash.', 'rickmanu'),
            'all_items'             => __('All Projects', 'rickmanu'),
            'enter_title_here'      => __('Project name', 'rickmanu'),
            'featured_image'        => __('Project image', 'rickmanu'),
            'set_featured_image'    => __('Set project image', 'rickmanu'),
            'remove_featured_image' => __('Remove project image', 'rickmanu'),
            'use_featured_image'    => __('Use as project image', 'rickmanu'),
        ],
        'public'        => true,
        'show_ui'       => true,
        'show_in_rest'  => true,
        'menu_position' => 21,
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => ['title', 'thumbnail', 'page-attributes'],
        'hierarchical'  => false,
        'has_archive'   => false,
        'rewrite'       => false,
    ]);
}
add_action('init', 'rickmanu_project_register_post_type');

/**
 * Registers the project meta fields and the meta box that edits them.
 */
function rickmanu_project_register_fields(): void
{
    rickmanu_register_meta_fields(RICKMANU_PROJECT_POST_TYPE, __('Project details', 'rickmanu'), [
        'type'        => [
            'label'    => __('Type', 'rickmanu'),
            'type'     => 'select',
            'required' => true,
            'choices'  => rickmanu_get_project_types(),
            'default'  => 'web',
        ],
        'url'         => [
            'label'    => __('Project URL', 'rickmanu'),
            'type'     => 'url',
            'required' => true,
        ],
        'year'        => [
            'label'       => __('Year', 'rickmanu'),
            'type'        => 'text',
            'description' => __('Optional.', 'rickmanu'),
            'placeholder' => gmdate('Y'),
        ],
        'description' => [
            'label'       => __('Description', 'rickmanu'),
            'type'        => 'textarea',
            'description' => __('Optional. Shown in the project details dialog.', 'rickmanu'),
            'rows'        => 4,
        ],
        'stack'       => [
            'label'       => __('Stack', 'rickmanu'),
            'type'        => 'text',
            'description' => __('Optional. Technologies separated by commas, e.g. "PHP, WordPress, React".', 'rickmanu'),
        ],
        'github'      => [
            'label'       => __('GitHub URL', 'rickmanu'),
            'type'        => 'url',
            'description' => __('Optional. Link to the source code.', 'rickmanu'),
        ],
    ]);
}
add_action('init', 'rickmanu_project_register_fields');

/**
 * Copies a theme image into the media library and returns its attachment ID,
 * or 0 on failure.
 */
function rickmanu_project_sideload_image(string $filename, int $post_id, string $title): int
{
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $source = get_theme_file_path('assets/images/projects/' . $filename);

    if (! is_readable($source)) {
        return 0;
    }

    // media_handle_sideload() moves the file, so work on a copy of the theme asset.
    $temp = wp_tempnam($filename);

    if (! $temp || ! copy($source, $temp)) {
        return 0;
    }

    $attachment_id = media_handle_sideload(['name' => $filename, 'tmp_name' => $temp], $post_id, $title);

    if (is_wp_error($attachment_id)) {
        wp_delete_file($temp);

        return 0;
    }

    return (int) $attachment_id;
}

/**
 * Seeds the post type with the original static projects, once.
 * Skipped when project posts already exist.
 */
function rickmanu_project_seed(): void
{
    if (get_option('rickmanu_projects_seeded') || ! current_user_can('edit_posts')) {
        return;
    }

    update_option('rickmanu_projects_seeded', true, false);

    $existing = get_posts([
        'post_type'      => RICKMANU_PROJECT_POST_TYPE,
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    if ($existing) {
        return;
    }

    $projects = [
        [
            'title' => 'Mined Underwater',
            'type'  => 'game',
            'image' => 'mined-underwater.png',
            'url'   => 'https://play.google.com/store/apps/details?id=com.galdartech.minedunderwater',
        ],
        [
            'title' => 'WordPress Meetup',
            'type'  => 'web',
            'image' => 'wp-meetup.png',
            'url'   => 'https://www.meetup.com/pt-br/wordpress-brasilia/',
        ],
        [
            'title' => 'Monitor de Sustentabilidade',
            'type'  => 'web',
            'image' => 'monitor-sustentabilidade.png',
            'url'   => 'https://monitor.gppesalq.agr.br/',
        ],
        [
            'title' => 'Portas abertas para direitos',
            'type'  => 'web',
            'image' => 'portas-abertas.png',
            'url'   => 'https://portasabertasparadireitos.com.br/',
        ],
        [
            'title' => 'O Mediador',
            'type'  => 'web',
            'image' => 'mediador.png',
            'url'   => 'https://omediador.pt/',
        ],
        [
            'title' => 'Geografia da fome',
            'type'  => 'web',
            'image' => 'geografia-da-fome.png',
            'url'   => 'https://geografiadafome.fsp.usp.br/',
        ],
        [
            'title' => 'Que estado queremos',
            'type'  => 'web',
            'image' => 'que-estado-queremos.png',
            'url'   => 'https://queestadoqueremos.org/',
        ],
        [
            'title' => 'Prêmio Profissionais da Música',
            'type'  => 'web',
            'image' => 'ppm.png',
            'url'   => 'https://ppm.art.br',
        ],
    ];

    foreach ($projects as $order => $project) {
        $post_id = wp_insert_post([
            'post_type'   => RICKMANU_PROJECT_POST_TYPE,
            'post_status' => 'publish',
            'post_title'  => $project['title'],
            'menu_order'  => $order,
        ]);

        if (is_wp_error($post_id) || ! $post_id) {
            continue;
        }

        update_post_meta($post_id, 'type', $project['type']);
        update_post_meta($post_id, 'url', $project['url']);

        $attachment_id = rickmanu_project_sideload_image($project['image'], $post_id, $project['title']);

        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}
add_action('admin_init', 'rickmanu_project_seed');
