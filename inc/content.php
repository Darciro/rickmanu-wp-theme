<?php

/**
 * Static portfolio content rendered by the front page template parts.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Career history, most recent first.
 *
 * @return array<int, array{period: string, company: string, group: string, role: string, summary: string, current: bool}>
 */
function rickmanu_get_experience(): array
{
    return [
        [
            'period'  => __('Oct 2025 — Current', 'rickmanu'),
            'company' => 'Merkle',
            'group'   => __('(Dentsu Group)', 'rickmanu'),
            'role'    => __('Smart Integrations Engineer', 'rickmanu'),
            'summary' => __('Tailor-made solutions for international clients, focused on web applications and system integrations through APIs and web services, within a multidisciplinary team distributed across Europe and Central Asia.', 'rickmanu'),
            'current' => true,
        ],
        [
            'period'  => __('Sep 2024 — Sep 2025', 'rickmanu'),
            'company' => 'Doutor Finanças',
            'group'   => '',
            'role'    => __('Software Engineer / Scrum Master', 'rickmanu'),
            'summary' => __('Full-stack development with PHP (Laravel) and WordPress, building dynamic Gutenberg blocks in JavaScript. As Scrum Master, facilitated agile ceremonies and managed backlogs for news portals, hotsites and landing pages.', 'rickmanu'),
            'current' => false,
        ],
        [
            'period'  => __('Oct 2019 — Sep 2024', 'rickmanu'),
            'company' => 'Integer Consulting',
            'group'   => '',
            'role'    => __('Innovation Center Manager / Project Manager & Tech Leader', 'rickmanu'),
            'summary' => __('Started as an external consultant in Germany (PHP/Laravel, React), then progressed internally to Tech Lead, Scrum Master and Project Manager — leading teams on CRM, logistics and web projects across multiple industries.', 'rickmanu'),
            'current' => false,
        ],
        [
            'period'  => __('Oct 2017 — Oct 2019', 'rickmanu'),
            'company' => 'Hepta Tecnologia e Informática',
            'group'   => '',
            'role'    => __('Software Engineer', 'rickmanu'),
            'summary' => __('Worked directly for the Ministry of Culture: WordPress/Joomla websites, Laravel systems and legacy maintenance. Technical lead on the migration and update of legacy systems.', 'rickmanu'),
            'current' => false,
        ],
        [
            'period'  => __('Apr 2015 — Oct 2017', 'rickmanu'),
            'company' => 'Talk2',
            'group'   => '',
            'role'    => __('Software Developer', 'rickmanu'),
            'summary' => __('PHP systems across several frameworks, web and hybrid mobile apps with React/React Native and Angular, and front-end solutions for multiple industries.', 'rickmanu'),
            'current' => false,
        ],
        [
            'period'  => __('Oct 2014 — Apr 2015', 'rickmanu'),
            'company' => 'Basis Tecnologia da Informação S.A.',
            'group'   => '',
            'role'    => __('Software Developer', 'rickmanu'),
            'summary' => __('Maintained PHP web systems for the Ministry of Defence and built APIs to connect to web services.', 'rickmanu'),
            'current' => false,
        ],
        [
            'period'  => __('Aug 2012 — Jun 2014', 'rickmanu'),
            'company' => 'Cast Informática S.A.',
            'group'   => '',
            'role'    => __('Software Developer', 'rickmanu'),
            'summary' => __('PHP web systems with HTML5, CSS3 (Bootstrap, Semantic UI) and JavaScript (Ajax, Vanilla, jQuery); MySQL/PostgreSQL databases; WordPress/Drupal themes and plugins.', 'rickmanu'),
            'current' => false,
        ],
    ];
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
 * Selected projects. Images live in assets/images/projects/.
 *
 * @return array<int, array{title: string, type: string, image: string, url: string}>
 */
function rickmanu_get_projects(): array
{
    return [
        [
            'title' => 'Mined Underwater',
            'type'  => __('Game', 'rickmanu'),
            'image' => 'mined-underwater.png',
            'url'   => 'https://play.google.com/store/apps/details?id=com.galdartech.minedunderwater',
        ],
        [
            'title' => 'WordPress Meetup',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'wp-meetup.png',
            'url'   => 'https://www.meetup.com/pt-br/wordpress-brasilia/',
        ],
        [
            'title' => 'Monitor de Sustentabilidade',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'monitor-sustentabilidade.png',
            'url'   => 'https://monitor.gppesalq.agr.br/',
        ],
        [
            'title' => 'Portas abertas para direitos',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'portas-abertas.png',
            'url'   => 'https://portasabertasparadireitos.com.br/',
        ],
        [
            'title' => 'O Mediador',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'mediador.png',
            'url'   => 'https://omediador.pt/',
        ],
        [
            'title' => 'Geografia da fome',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'geografia-da-fome.png',
            'url'   => 'https://geografiadafome.fsp.usp.br/',
        ],
        [
            'title' => 'Que estado queremos',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'que-estado-queremos.png',
            'url'   => 'https://queestadoqueremos.org/',
        ],
        [
            'title' => 'Prêmio Profissionais da Música',
            'type'  => __('Web', 'rickmanu'),
            'image' => 'ppm.png',
            'url'   => 'https://ppm.art.br',
        ],
    ];
}
