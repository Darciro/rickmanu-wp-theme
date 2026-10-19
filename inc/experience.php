<?php

/**
 * Experience post type (career history) and its meta fields.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_EXPERIENCE_POST_TYPE = 'rickmanu_experience';

/**
 * Registers the Experience post type. The post title holds the company name.
 */
function rickmanu_experience_register_post_type(): void
{
    register_post_type(RICKMANU_EXPERIENCE_POST_TYPE, [
        'labels'        => [
            'name'                  => __('Experience', 'rickmanu'),
            'singular_name'         => __('Experience', 'rickmanu'),
            'add_new_item'          => __('Add New Experience', 'rickmanu'),
            'edit_item'             => __('Edit Experience', 'rickmanu'),
            'new_item'              => __('New Experience', 'rickmanu'),
            'view_item'             => __('View Experience', 'rickmanu'),
            'search_items'          => __('Search Experience', 'rickmanu'),
            'not_found'             => __('No experience found.', 'rickmanu'),
            'not_found_in_trash'    => __('No experience found in Trash.', 'rickmanu'),
            'all_items'             => __('All Experience', 'rickmanu'),
            'enter_title_here'      => __('Company name', 'rickmanu'),
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_rest'  => true,
        'menu_position' => 20,
        'menu_icon'     => 'dashicons-businessman',
        'supports'      => ['title', 'page-attributes'],
        'hierarchical'  => false,
        'has_archive'   => false,
        'rewrite'       => false,
    ]);
}
add_action('init', 'rickmanu_experience_register_post_type');

/**
 * Registers the experience meta fields and the meta box that edits them.
 */
function rickmanu_experience_register_fields(): void
{
    rickmanu_register_meta_fields(RICKMANU_EXPERIENCE_POST_TYPE, __('Experience details', 'rickmanu'), [
        'period'  => [
            'label'       => __('Period', 'rickmanu'),
            'type'        => 'text',
            'required'    => true,
            'placeholder' => 'Oct 2025 — Current',
        ],
        'group'   => [
            'label'       => __('Group', 'rickmanu'),
            'type'        => 'text',
            'description' => __('Optional parent company, e.g. "(Dentsu Group)".', 'rickmanu'),
        ],
        'role'    => [
            'label'    => __('Role', 'rickmanu'),
            'type'     => 'text',
            'required' => true,
        ],
        'summary' => [
            'label' => __('Summary', 'rickmanu'),
            'type'  => 'textarea',
            'rows'  => 4,
        ],
        'current' => [
            'label'       => __('Current position', 'rickmanu'),
            'type'        => 'checkbox',
            'description' => __('Highlights the period of this position.', 'rickmanu'),
        ],
    ]);
}
add_action('init', 'rickmanu_experience_register_fields');

/**
 * Seeds the post type with the original static career history, once.
 * Skipped when experience posts already exist.
 */
function rickmanu_experience_seed(): void
{
    if (get_option('rickmanu_experience_seeded') || ! current_user_can('edit_posts')) {
        return;
    }

    update_option('rickmanu_experience_seeded', true, false);

    $existing = get_posts([
        'post_type'      => RICKMANU_EXPERIENCE_POST_TYPE,
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ]);

    if ($existing) {
        return;
    }

    $jobs = [
        [
            'period'  => 'Oct 2025 — Current',
            'company' => 'Merkle',
            'group'   => '(Dentsu Group)',
            'role'    => 'Smart Integrations Engineer',
            'summary' => 'Tailor-made solutions for international clients, focused on web applications and system integrations through APIs and web services, within a multidisciplinary team distributed across Europe and Central Asia.',
            'current' => true,
        ],
        [
            'period'  => 'Sep 2024 — Sep 2025',
            'company' => 'Doutor Finanças',
            'group'   => '',
            'role'    => 'Software Engineer / Scrum Master',
            'summary' => 'Full-stack development with PHP (Laravel) and WordPress, building dynamic Gutenberg blocks in JavaScript. As Scrum Master, facilitated agile ceremonies and managed backlogs for news portals, hotsites and landing pages.',
            'current' => false,
        ],
        [
            'period'  => 'Oct 2019 — Sep 2024',
            'company' => 'Integer Consulting',
            'group'   => '',
            'role'    => 'Innovation Center Manager / Project Manager & Tech Leader',
            'summary' => 'Started as an external consultant in Germany (PHP/Laravel, React), then progressed internally to Tech Lead, Scrum Master and Project Manager — leading teams on CRM, logistics and web projects across multiple industries.',
            'current' => false,
        ],
        [
            'period'  => 'Oct 2017 — Oct 2019',
            'company' => 'Hepta Tecnologia e Informática',
            'group'   => '',
            'role'    => 'Software Engineer',
            'summary' => 'Worked directly for the Ministry of Culture: WordPress/Joomla websites, Laravel systems and legacy maintenance. Technical lead on the migration and update of legacy systems.',
            'current' => false,
        ],
        [
            'period'  => 'Apr 2015 — Oct 2017',
            'company' => 'Talk2',
            'group'   => '',
            'role'    => 'Software Developer',
            'summary' => 'PHP systems across several frameworks, web and hybrid mobile apps with React/React Native and Angular, and front-end solutions for multiple industries.',
            'current' => false,
        ],
        [
            'period'  => 'Oct 2014 — Apr 2015',
            'company' => 'Basis Tecnologia da Informação S.A.',
            'group'   => '',
            'role'    => 'Software Developer',
            'summary' => 'Maintained PHP web systems for the Ministry of Defence and built APIs to connect to web services.',
            'current' => false,
        ],
        [
            'period'  => 'Aug 2012 — Jun 2014',
            'company' => 'Cast Informática S.A.',
            'group'   => '',
            'role'    => 'Software Developer',
            'summary' => 'PHP web systems with HTML5, CSS3 (Bootstrap, Semantic UI) and JavaScript (Ajax, Vanilla, jQuery); MySQL/PostgreSQL databases; WordPress/Drupal themes and plugins.',
            'current' => false,
        ],
    ];

    foreach ($jobs as $order => $job) {
        $post_id = wp_insert_post([
            'post_type'   => RICKMANU_EXPERIENCE_POST_TYPE,
            'post_status' => 'publish',
            'post_title'  => $job['company'],
            'menu_order'  => $order,
        ]);

        if (is_wp_error($post_id) || ! $post_id) {
            continue;
        }

        update_post_meta($post_id, 'period', $job['period']);
        update_post_meta($post_id, 'group', $job['group']);
        update_post_meta($post_id, 'role', $job['role']);
        update_post_meta($post_id, 'summary', $job['summary']);
        update_post_meta($post_id, 'current', $job['current'] ? '1' : '0');
    }
}
add_action('admin_init', 'rickmanu_experience_seed');
