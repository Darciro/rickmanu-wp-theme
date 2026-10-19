<?php

/**
 * Portfolio content rendered by the front page template parts.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Career history from the Experience post type (inc/experience.php),
 * ordered by the "Order" attribute in the editor, most recent first.
 *
 * @return array<int, array{period: string, company: string, group: string, role: string, summary: string, current: bool}>
 */
function rickmanu_get_experience(): array
{
    $posts = get_posts([
        'post_type'      => RICKMANU_EXPERIENCE_POST_TYPE,
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        'no_found_rows'  => true,
    ]);

    return array_map(
        static fn(WP_Post $post): array => [
            'period'  => (string) get_post_meta($post->ID, 'period', true),
            'company' => $post->post_title,
            'group'   => (string) get_post_meta($post->ID, 'group', true),
            'role'    => (string) get_post_meta($post->ID, 'role', true),
            'summary' => (string) get_post_meta($post->ID, 'summary', true),
            'current' => (bool) get_post_meta($post->ID, 'current', true),
        ],
        $posts
    );
}

/**
 * Hard skills grouped by category. Each category color feeds the --cat CSS variable.
 *
 * @return array<int, array{id: string, label: string, color: string, skills: string[]}>
 */
function rickmanu_get_skill_categories(): array
{
    return [
        [
            'id'     => 'backend',
            'label'  => __('Back-end', 'rickmanu'),
            'color'  => '#C8F05A',
            'skills' => ['PHP', 'Laravel', 'Symfony', 'Zend Framework', 'Composer', 'Node.js', 'OOP', 'MVC Architecture'],
        ],
        [
            'id'     => 'frontend',
            'label'  => __('Front-end', 'rickmanu'),
            'color'  => '#7DD3FC',
            'skills' => ['JavaScript ES6+', 'TypeScript', 'React', 'Angular', 'Sass / SCSS', 'TailwindCSS', 'Webpack', 'Gulp', 'WCAG Accessibility'],
        ],
        [
            'id'     => 'mobile',
            'label'  => __('Mobile & games', 'rickmanu'),
            'color'  => '#F9A8D4',
            'skills' => ['React Native', 'Expo', 'Unity'],
        ],
        [
            'id'     => 'apis',
            'label'  => __('APIs & CMS', 'rickmanu'),
            'color'  => '#FDBA74',
            'skills' => ['REST APIs', 'SOAP Web Services', 'API Integration', 'WordPress', 'Drupal', 'Joomla', 'Institutional Portals', 'Hotsites', 'Landing Pages'],
        ],
        [
            'id'     => 'data',
            'label'  => __('Data', 'rickmanu'),
            'color'  => '#C4B5FD',
            'skills' => ['MySQL', 'MariaDB', 'PostgreSQL', 'SQLite', 'MongoDB', 'NoSQL', 'Firebase', 'SQL'],
        ],
        [
            'id'     => 'devops',
            'label'  => __('Quality & DevOps', 'rickmanu'),
            'color'  => '#5EEAD4',
            'skills' => ['PHPUnit', 'Cypress', 'PHPStan', 'Docker', 'Git', 'NPM', 'CI/CD'],
        ],
    ];
}

/**
 * Soft skills shown below the hard skills explorer.
 *
 * @return string[]
 */
function rickmanu_get_soft_skills(): array
{
    return [
        __('Technical Leadership', 'rickmanu'),
        __('Multidisciplinary Team Management', 'rickmanu'),
        __('Project Management', 'rickmanu'),
        __('Backlog Management', 'rickmanu'),
        __('Decision Making', 'rickmanu'),
        __('Technical Mentoring', 'rickmanu'),
        __('Scrum & Agile', 'rickmanu'),
        __('Continuous Improvement', 'rickmanu'),
    ];
}

/**
 * Selected projects from the Project post type (inc/projects.php), ordered by
 * the "Order" attribute in the editor. The image is the featured image URL and
 * is empty when none is set.
 *
 * Optional fields (year, description, stack, github) are only shown in the
 * project dialog when they are not empty.
 *
 * @return array<int, array{title: string, type: string, image: string, url: string, year: string, description: string, stack: string[], github: string}>
 */
function rickmanu_get_projects(): array
{
    $posts = get_posts([
        'post_type'      => RICKMANU_PROJECT_POST_TYPE,
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        'no_found_rows'  => true,
    ]);

    $types = rickmanu_get_project_types();

    return array_map(
        static function (WP_Post $post) use ($types): array {
            $type  = (string) get_post_meta($post->ID, 'type', true);
            $stack = array_filter(array_map('trim', explode(',', (string) get_post_meta($post->ID, 'stack', true))));

            return [
                'title'       => $post->post_title,
                'type'        => $types[$type] ?? '',
                'image'       => (string) get_the_post_thumbnail_url($post, 'large'),
                'url'         => (string) get_post_meta($post->ID, 'url', true),
                'year'        => (string) get_post_meta($post->ID, 'year', true),
                'description' => (string) get_post_meta($post->ID, 'description', true),
                'stack'       => array_values($stack),
                'github'      => (string) get_post_meta($post->ID, 'github', true),
            ];
        },
        $posts
    );
}
