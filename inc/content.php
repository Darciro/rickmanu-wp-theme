<?php

/**
 * Portfolio content rendered by the front page template parts.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_CONTACT_EMAIL = 'rickmanu@gmail.com';

/**
 * Career history from the Experience post type (inc/experience.php),
 * ordered by the "Order" attribute in the editor, most recent first.
 *
 * Several template parts read it on the same request, so the result is
 * kept for the rest of the request.
 *
 * @return array<int, array{period: string, company: string, group: string, role: string, summary: string, current: bool}>
 */
function rickmanu_get_experience(): array
{
    static $experience = null;

    if (null !== $experience) {
        return $experience;
    }

    $posts = get_posts([
        'post_type'      => RICKMANU_EXPERIENCE_POST_TYPE,
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        'no_found_rows'  => true,
    ]);

    $experience = array_map(
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

    return $experience;
}

/**
 * Position flagged as "Current position" in the editor, falling back to the
 * most recent one. Null when there is no experience at all.
 *
 * @return array{period: string, company: string, group: string, role: string, summary: string, current: bool}|null
 */
function rickmanu_get_current_position(): ?array
{
    $experience = rickmanu_get_experience();

    foreach ($experience as $position) {
        if ($position['current']) {
            return $position;
        }
    }

    return $experience[0] ?? null;
}

/**
 * Year the career started: the earliest four-digit year found in the
 * experience periods, so every "since" mention stays in sync with the
 * career history. Empty when no period has a year.
 */
function rickmanu_get_career_start_year(): string
{
    $years = [];

    foreach (rickmanu_get_experience() as $position) {
        if (preg_match_all('/\b(?:19|20)\d{2}\b/', $position['period'], $matches)) {
            array_push($years, ...array_map('intval', $matches[0]));
        }
    }

    return $years ? (string) min($years) : '';
}

/**
 * Services shown in the "How I can help" section, with their icon markup.
 *
 * @return array<int, array{title: string, text: string, icon: string}>
 */
function rickmanu_get_services(): array
{
    return [
        [
            'title' => __('Web application development', 'rickmanu'),
            'text'  => __('Building and evolving applications, digital platforms and enterprise systems, with attention to architecture, integrations and maintainability.', 'rickmanu'),
            'icon'  => '<rect x="3" y="4" width="18" height="16" rx="2"></rect><path d="M3 9h18"></path><path d="M9 14l-2 2 2 2"></path><path d="M15 14l2 2-2 2"></path>',
        ],
        [
            'title' => __('System modernization', 'rickmanu'),
            'text'  => __('Evolving legacy systems, reviewing existing structures and implementing technical improvements that support growth and easier maintenance.', 'rickmanu'),
            'icon'  => '<path d="M21 12a9 9 0 0 1-15.5 6.2"></path><path d="M3 12a9 9 0 0 1 15.5-6.2"></path><path d="M18 2v4h-4"></path><path d="M6 22v-4h4"></path>',
        ],
        [
            'title' => __('APIs & integrations', 'rickmanu'),
            'text'  => __('Designing and integrating services that connect systems, automate workflows and make data flow between platforms.', 'rickmanu'),
            'icon'  => '<circle cx="5" cy="12" r="2.5"></circle><circle cx="19" cy="5" r="2.5"></circle><circle cx="19" cy="19" r="2.5"></circle><path d="M7.3 11l9.4-4.8"></path><path d="M7.3 13l9.4 4.8"></path>',
        ],
        [
            'title' => __('Tech leadership & support', 'rickmanu'),
            'text'  => __('Supporting development teams with architecture decisions, ways of working, engineering best practices and better delivery processes.', 'rickmanu'),
            'icon'  => '<circle cx="9" cy="8" r="3.5"></circle><path d="M2.5 20a6.5 6.5 0 0 1 13 0"></path><path d="M17 4.5a3.5 3.5 0 0 1 0 7"></path><path d="M19 14a6.5 6.5 0 0 1 3 6"></path>',
        ],
    ];
}

/**
 * Contact e-mail address and mailto links with a subject per audience, so
 * project and job inquiries are easy to tell apart in the inbox.
 *
 * @param string $audience "project", "job" or empty for no subject.
 */
function rickmanu_get_contact_mailto(string $audience = ''): string
{
    $subjects = [
        /* translators: E-mail subject used by the "Talk about a project" links. */
        'project' => __('Project inquiry — rickmanu.dev', 'rickmanu'),
        /* translators: E-mail subject used by the "Discuss an opportunity" links. */
        'job'     => __('Job opportunity — rickmanu.dev', 'rickmanu'),
    ];

    $mailto = 'mailto:' . RICKMANU_CONTACT_EMAIL;

    if (isset($subjects[$audience])) {
        $mailto .= '?subject=' . rawurlencode($subjects[$audience]);
    }

    return $mailto;
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
 * Optional fields (year, description, case study, stack, github) are only
 * shown in the project dialog when they are not empty.
 *
 * @return array<int, array{title: string, type: string, image: string, url: string, year: string, description: string, context: string, contribution: string, challenges: string, results: string, stack: string[], github: string}>
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
                'title'        => $post->post_title,
                'type'         => $types[$type] ?? '',
                'image'        => (string) get_the_post_thumbnail_url($post, 'large'),
                'url'          => (string) get_post_meta($post->ID, 'url', true),
                'year'         => (string) get_post_meta($post->ID, 'year', true),
                'description'  => (string) get_post_meta($post->ID, 'description', true),
                'context'      => (string) get_post_meta($post->ID, 'context', true),
                'contribution' => (string) get_post_meta($post->ID, 'contribution', true),
                'challenges'   => (string) get_post_meta($post->ID, 'challenges', true),
                'results'      => (string) get_post_meta($post->ID, 'results', true),
                'stack'        => array_values($stack),
                'github'       => (string) get_post_meta($post->ID, 'github', true),
            ];
        },
        $posts
    );
}
