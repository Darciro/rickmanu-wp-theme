<?php get_header(); ?>

<main class="bg-[#073C3F]">

    <section id="intro" class="m-0 md:min-h-screen flex items-center justify-center overflow-hidden relative">
        <div id="logo" class="relative w-182 h-193.5 flex items-center justify-center overflow-hidden absolute">

            <div class="absolute w-87.5 h-87.5 bg-[#004D52] shadow-2xl"></div>

            <div class="absolute w-1.5 h-38.75 bg-[#C9A06F] rotate-45 top-41.25 left-126.25"></div>

            <div class="absolute w-1.5 h-38.75 bg-[#C9A06F] rotate-45 top-113.75 left-54.5"></div>

            <div class="relative z-10 flex flex-col items-center">
                <h1 class="font-feature text-[#C9A06F] text-[70px] md:text-[84px] leading-none">
                    Rick Manu
                </h1>

                <p class="font-main-text text-[#C9A06F] text-[16px] mt-6">
                    &lt;<span id="role">developer</span>/&gt;
                </p>
            </div>

        </div>

        <div class="absolute bottom-0 left-0 w-full flex flex-col items-center hidden md:flex">
            <nav class="w-full">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'depth'          => 1,
                    'container'      => '',
                    'menu_id'        => 'main-navigation',
                    'menu_class'     => 'flex gap-6 w-full justify-end p-6',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                ));
                ?>
            </nav>
        </div>
    </section>

    <section id="about-me" class="rick-section container mx-auto py-8 md:py-16 px-4 sm:px-6">
        <h1 class="font-feature text-[#C9A06F] border-b border-b-[#C9A06F] text-[32px] md:text-[64px] pb-3 mb-12">About me</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[350px_1fr_300px] gap-6">
            <div class="border border-[#004D52] p-6">
                <img class="grayscale w-100 mb-5 max-w-64" src="<?php echo get_template_directory_uri(); ?>/assets/images/rick-manu.jpg" />
                <h2 class="font-feature text-[#C9A06F] text-[24px]">Ricardo Carvalho</h2>
                <h3 class="font-feature text-[#C9A06F] mb-5">whoami</h3>
                <p class="text-white leading-relaxed">
                    I'm a software developer who began my career in 2011 as an engineer and have since specialized as a fullstack
                    developer with strong expertise in PHP, C#, React, React Native, and Angular. I have designed and implemented
                    scalable web and mobile applications, built robust back-end architectures, and crafted intuitive front-end
                    experiences. My work spans projects such as internal CRM systems (including commercial modules and
                    invoicing), commercial and logistics solutions for the food industry, and web platforms for the property and
                    training sectors.
                </p>

                <h3 class="font-feature text-[#C9A06F] mb-5 mt-8">Education</h3>
                <p class="text-white leading-relaxed">
                    I hold a degree in Information Technology Management from UNIP and a postgraduate degree in Software Engineering from IESB. This background strengthened my foundation in software development, systems analysis, project management, and software quality.
                </p>
                </p>

                <h3 class="font-feature text-[#C9A06F] mb-5 mt-8">Certifications</h3>
                <p class="text-white leading-relaxed">
                    I am certified as a Professional Scrum Master I and II by Scrum.org. These certifications reinforce my knowledge of Scrum, agile practices, team facilitation, backlog management, and continuous improvement in software delivery.
                </p>
            </div>
            <div class="border border-[#004D52] p-6">
                <h2 class="font-feature text-[#C9A06F] text-[24px]">Professional work experience</h2>
                <ul role="list" class="divide-y divide-white/5">
                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Merkle (Dentsu Group)</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Smart Integrations Engineer</p>
                                <p class="mt-1 text-white">As a Smart Integrations Engineer, I develop tailor-made
                                    solutions for international clients, focusing on web applications
                                    and system integrations through APIs and web services. I design
                                    solutions aligned with client requirements and collaborate within
                                    a multidisciplinary team distributed across Europe and Central
                                    Asia.
                                </p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Oct 2025 - Current</p>
                            <!-- <p class="mt-1 text-sm text-gray-400">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p> -->
                        </div>
                    </li>

                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Doutor Finanças</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Software Engineer/ Scrum Master</p>
                                <p class="mt-1 text-white">I worked as a full-stack developer and Scrum Master, using PHP
                                    (Laravel) and WordPress to create dynamic Gutenberg blocks in
                                    JavaScript. As Scrum Master, I facilitated agile ceremonies,
                                    managed backlogs, and promoted agile practices, focusing on
                                    the news portals, hotsites, and landing pages.</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Sep 2024 - Sep 2025</p>
                            <!-- <p class="mt-1 text-sm text-gray-400">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p> -->
                        </div>
                    </li>

                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Integer Consulting</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Innovation Center Manager/Project Manager & Tech Leader</p>
                                <p class="mt-1 text-white">Started as an external consultant working in Germany as a
                                    software engineer (PHP/Laravel, React), later integrated
                                    internally as a developer, progressing to Tech Lead, Scrum
                                    Master, and Project Manager, leading teams on CRM, logistics,
                                    and web development projects across multiple industries</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Oct 2019 - Sep 2024</p>
                            <!-- <p class="mt-1 text-sm text-gray-400">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p> -->
                        </div>
                    </li>

                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Hepta Tecnologia e Informática</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Software Engineer</p>
                                <p class="mt-1 text-white">I worked directly for the client - Ministry of Culture, developing
                                    software and maintaining legacy systems. Part of my
                                    responsibilities was creating websites using the
                                    WordPress/Joomla CMS and developing systems using the
                                    Laravel framework (PHP). I was technical lead on a project to
                                    migrate and update legacy systems.</p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Oct 2017 - Oct 2019</p>
                        </div>
                    </li>

                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Talk2</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Software Developer</p>
                                <p class="mt-1 text-white">Developed PHP-based systems using various frameworks, built
                                    web and hybrid mobile apps with React/React Native and
                                    Angular, and delivered front-end solutions across multiple
                                    industries.
                                </p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Apr 2015 - Oct 2017</p>
                        </div>
                    </li>

                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Basis Tecnologia da Informação S.A.</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Software Developer</p>
                                <p class="mt-1 text-white">My main activities were maintaining web systems in PHP for the
                                    Ministry of Defence and creating APIs to connect to web
                                    services.
                                </p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Oct 2014 - Apr 2015</p>
                        </div>
                    </li>

                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="font-semibold text-[#C9A06F]">Cast Informática S.A.</p>
                                <p class="mt-1 truncate text-sm text-gray-400">Software Developer</p>
                                <p class="mt-1 text-white">Developed PHP-based web systems using HTML5, CSS3
                                    (Bootstrap, Semantic UI), and JavaScript (Ajax, Vanilla, jQuery),
                                    while managing MySQL/PostgreSQL databases and building
                                    WordPress/Drupal themes and plugins
                                </p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-[#C9A06F]">Aug 2012 - Jun 2014</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="border border-[#004D52] p-6">
                <h2 class="font-feature text-[#C9A06F] text-[24px] mb-5">Hard skills</h2>
                <?php
                $hardSkills = [
                    'back_end_php' => [
                        'PHP',
                        'Laravel',
                        'Symfony',
                        'Zend Framework',
                        // 'CakePHP',
                        'Composer',
                        'OOP',
                        'MVC Architecture',
                        'REST APIs',
                        'SOAP Web Services',
                        'API Integration',
                    ],

                    'cms_ecommerce' => [
                        'WordPress',
                        // 'Gutenberg',
                        'Drupal',
                        'Joomla',
                        // 'CS-Cart',
                        // 'CMS Customization',
                        'Institutional Portals',
                        'Hotsites',
                        'Landing Pages',
                        'WCAG Accessibility',
                    ],

                    'front_end' => [
                        'JavaScript ES6+',
                        'TypeScript',
                        'React',
                        'Angular',
                        // 'jQuery',
                        // 'AJAX',
                        // 'HTML5',
                        // 'CSS3',
                        'Sass / SCSS',
                        'TailwindCSS',
                        // 'Bootstrap',
                        // 'Semantic UI',
                        'Webpack',
                        'Gulp',
                        // 'API Integration',
                    ],

                    'mobile_cross_platform' => [
                        'React Native',
                        'Expo',
                        'Unity',
                    ],

                    'databases' => [
                        'MySQL',
                        'MariaDB',
                        'PostgreSQL',
                        'SQLite',
                        'MongoDB',
                        'NoSQL',
                        'Firebase',
                        'SQL',
                        // 'Data Modeling',
                    ],

                    'testing_quality' => [
                        'PHPUnit',
                        'Cypress',
                        'PHPStan',
                        // 'Unit Testing',
                        // 'Test Coverage',
                        // 'Debugging',
                        // 'Code review',
                    ],

                    'devops_tools' => [
                        'Docker',
                        'Git',
                        // 'Tortoise SVN',
                        'Node.js',
                        'NPM',
                        'CI/CD',
                        // 'AWS',
                        // 'Azure',
                        // 'Google Cloud Platform',
                        // 'Jira',
                        // 'Linux',
                        // 'Windows',
                    ],
                ];

                foreach ($hardSkills as $category => $skills) {
                    foreach ($skills as $skill) {
                        echo '<span class="inline-flex items-center rounded-md bg-gray-400/10 px-2 py-1 font-medium text-gray-400 inset-ring inset-ring-gray-400/20 mr-2 mb-2">' . $skill . '</span>';
                    }
                }
                ?>

                <h2 class="font-feature text-[#C9A06F] text-[24px] mb-5 mt-8">Soft skills</h2>
                <?php
                $softSkills = [
                    'leadership_management' => [
                        'Technical Leadership',
                        'Multidisciplinary Team Management',
                        'Project Management',
                        'Backlog Management',
                        'Decision Making',
                        // 'Task Delegation',
                        // 'Delivery Tracking',
                        'Technical Mentoring',
                    ],

                    'agile_scrum' => [
                        'Scrum',
                        'Agile',
                        // 'Agile Ceremony Facilitation',
                        // 'Sprint Planning',
                        // 'Backlog Refinement',
                        // 'Impediment Tracking',
                        'Continuous Improvement',
                        // 'Focus on Value Delivery',
                    ],

                    /* 'communication' => [
                        'Clear Communication',
                        'Stakeholder Communication',
                        'International Client Communication',
                        'Technical Solution Presentation',
                        'Process Documentation',
                        'Alignment Between Technical and Non-Technical Areas',
                        'Active Listening',
                    ],

                    'teamwork_collaboration' => [
                        'Teamwork',
                        'Collaboration with Distributed Teams',
                        'Multidisciplinary Collaboration',
                        'Interpersonal Skills',
                        'Developer Support',
                        'Knowledge Sharing',
                        'Consensus Building',
                    ],

                    'problem_solving' => [
                        'Critical Thinking',
                        'Problem Solving',
                        'Root Cause Analysis',
                        'Logical Reasoning',
                        'Analytical Thinking',
                        'Technical Problem Diagnosis',
                        'Solution Proposal',
                    ],

                    'adaptability' => [
                        'Adaptability',
                        'Continuous Learning',
                        'Flexibility',
                        'International Environment Experience',
                        'Ability to Handle Change',
                        'Evolution Between Technical and Management Roles',
                        'Experience Across Different Market Segments',
                    ],

                    'ownership_delivery' => [
                        'Sense of Responsibility',
                        'Autonomy',
                        'Organization',
                        'Proactivity',
                        'Commitment to Deadlines',
                        'Results Orientation',
                        'Quality Delivery',
                        'Product Vision',
                    ], */
                ];

                foreach ($softSkills as $category => $skills) {
                    foreach ($skills as $skill) {
                        echo '<span class="inline-flex items-center rounded-md bg-gray-400/10 px-2 py-1 font-medium text-gray-400 inset-ring inset-ring-gray-400/20 mr-2 mb-2">' . $skill . '</span>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <section id="projects" class="rick-section py-8 md:py-16 px-4 sm:px-6">
        <h1 class="font-feature text-[#C9A06F] container mx-auto border-b border-b-[#C9A06F] text-[32px] md:text-[64px] pb-3 md:mb-12">Projects</h1>
        <div class="text-center">
            <!-- Swiper -->
            <div class="swiper projects-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/mined-underwater.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">Mined Underwater</h3>
                            <!-- <p class="text-gray-400 text-sm">https://play.google.com/store/apps/details?id=com.galdartech.minedunderwater</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/wp-meetup.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">WordPress Meetup</h3>
                            <!-- <p class="text-gray-400 text-sm">https://www.meetup.com/pt-br/wordpress-brasilia/</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/monitor-sustentabilidade.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">Monitor de Sustentabilidade</h3>
                            <!-- <p class="text-gray-400 text-sm">https://monitor.gppesalq.agr.br/</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/portas-abertas.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">Portas abertas para direitos</h3>
                            <!-- <p class="text-gray-400 text-sm">https://portasabertasparadireitos.com.br/</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/mediador.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">O Mediador</h3>
                            <!-- <p class="text-gray-400 text-sm">https://omediador.pt/</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/geografia-da-fome.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">Geografia da fome</h3>
                            <!-- <p class="text-gray-400 text-sm">https://geografiadafome.fsp.usp.br/</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/que-estado-queremos.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">Que estado queremos</h3>
                            <!-- <p class="text-gray-400 text-sm">https://queestadoqueremos.org/</p> -->
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img class="grayscale" src="<?php echo get_template_directory_uri(); ?>/assets/images/projects/ppm.png" />
                        <div class="project-meta absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent text-left">
                            <h3 class="text-white text-[18px] font-semibold">Prêmio Profissionais da Música (PPM)</h3>
                            <!-- <p class="text-gray-400 text-sm">https://ppm.art.br</p> -->
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 mt-16 gap-6">
                    <div class="text-left">
                        <button class="projects-swiper-button-prev border-t border-t-[#C9A06F] py-3 w-100 max-w-40 text-right transition-[padding] duration-300 ease-in-out hover:pr-[10px]">
                            Prev
                        </button>
                    </div>
                    <div class="text-right">
                        <button class="projects-swiper-button-next border-t border-t-[#C9A06F] py-3 w-100 max-w-40 text-left transition-[padding] duration-300 ease-in-out hover:pl-[10px]">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>