<?php

namespace Database\Seeders;

use App\Core\Assets\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Seed 100 skills across multiple domains with varied tags.
     * Uses firstOrCreate() to be idempotent on re-run.
     */
    public function run(): void
    {
        $skills = [
            // Web Development (10)
            ['title' => 'HTML & CSS Fundamentals',       'tags' => ['html', 'css', 'frontend', 'web'],             'description' => 'Learn the building blocks of the web with HTML5 and CSS3.'],
            ['title' => 'JavaScript Essentials',          'tags' => ['javascript', 'frontend', 'web'],               'description' => 'Master core JavaScript concepts: variables, functions, DOM manipulation.'],
            ['title' => 'React.js for Beginners',         'tags' => ['javascript', 'react', 'frontend', 'web'],      'description' => 'Build modern single-page applications with React.js.'],
            ['title' => 'Vue.js Fundamentals',            'tags' => ['javascript', 'vue', 'frontend', 'web'],        'description' => 'Learn Vue.js from scratch - reactive components and routing.'],
            ['title' => 'Angular Developer Guide',        'tags' => ['javascript', 'angular', 'frontend', 'web'],    'description' => 'Enterprise-grade frontend development with Angular.'],
            ['title' => 'CSS Grid & Flexbox Mastery',     'tags' => ['css', 'frontend', 'layout', 'web'],            'description' => 'Master modern CSS layout techniques with Grid and Flexbox.'],
            ['title' => 'TypeScript Deep Dive',           'tags' => ['typescript', 'javascript', 'frontend'],        'description' => 'Type-safe JavaScript with TypeScript - interfaces, generics, and more.'],
            ['title' => 'Next.js Full-Stack',             'tags' => ['javascript', 'react', 'nextjs', 'fullstack'],  'description' => 'Server-side rendering and static site generation with Next.js.'],
            ['title' => 'Web Accessibility (a11y)',       'tags' => ['html', 'css', 'a11y', 'frontend'],             'description' => 'Build inclusive web experiences that work for everyone.'],
            ['title' => 'Progressive Web Apps (PWA)',     'tags' => ['javascript', 'pwa', 'frontend', 'mobile'],     'description' => 'Turn your web app into an installable, offline-capable PWA.'],

            // Backend Development (10)
            ['title' => 'PHP with Laravel',               'tags' => ['php', 'laravel', 'backend', 'web'],            'description' => 'Build robust web applications with the Laravel framework.'],
            ['title' => 'Node.js API Development',        'tags' => ['nodejs', 'javascript', 'backend', 'api'],      'description' => 'Create RESTful and GraphQL APIs with Node.js and Express.'],
            ['title' => 'Python Django Framework',        'tags' => ['python', 'django', 'backend', 'web'],          'description' => 'Build data-driven web apps with Python and Django.'],
            ['title' => 'Ruby on Rails',                  'tags' => ['ruby', 'rails', 'backend', 'web'],             'description' => 'Convention-over-configuration web development with Ruby on Rails.'],
            ['title' => 'Go Language Basics',             'tags' => ['go', 'golang', 'backend', 'systems'],          'description' => 'Learn Go - a statically typed, compiled language for scalable services.'],
            ['title' => 'C# .NET Core',                   'tags' => ['csharp', 'dotnet', 'backend', 'web'],          'description' => 'Cross-platform web APIs and services with .NET Core.'],
            ['title' => 'Java Spring Boot',               'tags' => ['java', 'spring', 'backend', 'enterprise'],     'description' => 'Enterprise Java development with Spring Boot microservices.'],
            ['title' => 'RESTful API Design',             'tags' => ['api', 'rest', 'backend', 'architecture'],      'description' => 'Best practices for designing scalable and maintainable REST APIs.'],
            ['title' => 'GraphQL from Zero to Hero',      'tags' => ['graphql', 'api', 'backend', 'web'],            'description' => 'Query language for your API - learn schemas, resolvers, and mutations.'],
            ['title' => 'Authentication & Authorization', 'tags' => ['security', 'auth', 'backend', 'web'],          'description' => 'Implement OAuth2, JWT, SAML, and RBAC in your applications.'],

            // Database & Storage (10)
            ['title' => 'SQL & Relational Databases',     'tags' => ['sql', 'database', 'backend', 'data'],          'description' => 'Master SQL queries, joins, indexing, and normalization.'],
            ['title' => 'MySQL Performance Tuning',       'tags' => ['sql', 'mysql', 'database', 'performance'],     'description' => 'Optimize MySQL queries, schema design, and server configuration.'],
            ['title' => 'PostgreSQL Advanced',            'tags' => ['sql', 'postgresql', 'database', 'backend'],    'description' => 'Advanced PostgreSQL features: JSONB, full-text search, window functions.'],
            ['title' => 'MongoDB NoSQL Database',         'tags' => ['nosql', 'mongodb', 'database', 'backend'],     'description' => 'Document-oriented NoSQL database design and aggregation pipelines.'],
            ['title' => 'Redis Caching & Queues',         'tags' => ['redis', 'cache', 'database', 'performance'],   'description' => 'In-memory data structure store for caching, sessions, and message queues.'],
            ['title' => 'Elasticsearch Search Engine',    'tags' => ['elasticsearch', 'search', 'database', 'data'], 'description' => 'Full-text search and analytics at scale with Elasticsearch.'],
            ['title' => 'Database Design Principles',     'tags' => ['sql', 'database', 'design', 'architecture'],   'description' => 'Entity-relationship modeling, normalization, and schema design.'],
            ['title' => 'Data Warehousing & ETL',         'tags' => ['data', 'etl', 'warehouse', 'analytics'],       'description' => 'Design data warehouses and build ETL pipelines for analytics.'],
            ['title' => 'SQLite for Mobile & Embedded',   'tags' => ['sql', 'sqlite', 'database', 'mobile'],         'description' => 'Lightweight embedded database for mobile and desktop applications.'],
            ['title' => 'Cassandra Distributed DB',       'tags' => ['nosql', 'cassandra', 'database', 'scalability'],'description' => 'Wide-column NoSQL database designed for high-availability and scalability.'],

            // DevOps & Cloud (10)
            ['title' => 'Docker Containers',              'tags' => ['docker', 'devops', 'containers', 'cloud'],      'description' => 'Containerize your applications with Docker for consistent deployments.'],
            ['title' => 'Kubernetes Orchestration',       'tags' => ['kubernetes', 'devops', 'containers', 'cloud'],  'description' => 'Orchestrate containerized applications at scale with Kubernetes.'],
            ['title' => 'AWS Cloud Practitioner',         'tags' => ['aws', 'cloud', 'devops', 'infrastructure'],     'description' => 'Core AWS services: EC2, S3, Lambda, RDS, and IAM.'],
            ['title' => 'Azure Fundamentals',             'tags' => ['azure', 'cloud', 'devops', 'infrastructure'],   'description' => 'Microsoft Azure cloud services: VMs, App Service, and Azure Functions.'],
            ['title' => 'Google Cloud Platform',          'tags' => ['gcp', 'cloud', 'devops', 'infrastructure'],     'description' => 'GCP services: Compute Engine, Cloud Storage, BigQuery, and GKE.'],
            ['title' => 'CI/CD Pipelines (GitLab CI)',    'tags' => ['devops', 'cicd', 'automation', 'gitlab'],       'description' => 'Automate builds, tests, and deployments with GitLab CI/CD.'],
            ['title' => 'GitHub Actions',                 'tags' => ['devops', 'cicd', 'github', 'automation'],       'description' => 'Automate workflows directly from your GitHub repositories.'],
            ['title' => 'Terraform Infrastructure as Code','tags' => ['devops', 'terraform', 'iac', 'cloud'],         'description' => 'Provision and manage cloud infrastructure declaratively with Terraform.'],
            ['title' => 'Linux System Administration',    'tags' => ['linux', 'sysadmin', 'devops', 'server'],        'description' => 'Manage Linux servers: shell scripting, permissions, and process management.'],
            ['title' => 'Nginx Web Server',               'tags' => ['nginx', 'web', 'devops', 'server'],             'description' => 'Configure Nginx as a reverse proxy, load balancer, and web server.'],

            // Mobile Development (5)
            ['title' => 'React Native Mobile Apps',       'tags' => ['javascript', 'react-native', 'mobile', 'ios'],  'description' => 'Build cross-platform mobile apps with React Native.'],
            ['title' => 'Flutter & Dart',                 'tags' => ['dart', 'flutter', 'mobile', 'cross-platform'],  'description' => 'Google UI toolkit for building natively compiled mobile apps.'],
            ['title' => 'iOS Swift Development',          'tags' => ['swift', 'ios', 'mobile', 'apple'],              'description' => 'Build iOS apps with Swift programming language and UIKit.'],
            ['title' => 'Android Kotlin Development',     'tags' => ['kotlin', 'android', 'mobile', 'jetpack'],       'description' => 'Modern Android development with Kotlin and Jetpack Compose.'],
            ['title' => 'Mobile UI/UX Design',            'tags' => ['mobile', 'ui', 'ux', 'design'],                 'description' => 'Design principles and patterns for mobile user interfaces.'],

            // Programming Languages (5)
            ['title' => 'Python for Everyone',            'tags' => ['python', 'programming', 'scripting', 'data'],   'description' => 'Learn Python programming from basics to advanced concepts.'],
            ['title' => 'Rust Systems Programming',       'tags' => ['rust', 'systems', 'programming', 'performance'],'description' => 'Safe, concurrent, and performant systems programming with Rust.'],
            ['title' => 'C++ Fundamentals',               'tags' => ['cpp', 'programming', 'systems', 'performance'], 'description' => 'Master C++ pointers, memory management, STL, and templates.'],
            ['title' => 'C Programming Language',         'tags' => ['c', 'programming', 'systems', 'embedded'],      'description' => 'Foundational systems programming language for operating systems and embedded.'],
            ['title' => 'Java for Beginners',             'tags' => ['java', 'programming', 'oop', 'enterprise'],     'description' => 'Object-oriented programming with Java collections, streams, and more.'],

            // Data Science & AI (10)
            ['title' => 'Python Data Analysis (Pandas)',  'tags' => ['python', 'data', 'pandas', 'analytics'],        'description' => 'Data manipulation and analysis using Pandas and NumPy.'],
            ['title' => 'Machine Learning with Scikit-Learn','tags' => ['python', 'ml', 'scikit-learn', 'ai'],       'description' => 'Supervised and unsupervised learning algorithms with Scikit-Learn.'],
            ['title' => 'Deep Learning (TensorFlow)',     'tags' => ['python', 'deep-learning', 'tensorflow', 'ai'],  'description' => 'Neural networks, CNNs, and RNNs with TensorFlow and Keras.'],
            ['title' => 'Natural Language Processing',    'tags' => ['python', 'nlp', 'ai', 'text'],                  'description' => 'Text processing, sentiment analysis, and language models.'],
            ['title' => 'Computer Vision (OpenCV)',       'tags' => ['python', 'computer-vision', 'opencv', 'ai'],    'description' => 'Image processing, object detection, and face recognition.'],
            ['title' => 'Data Visualization (Matplotlib)','tags' => ['python', 'visualization', 'matplotlib', 'data'],'description' => 'Create compelling charts, plots, and dashboards with Matplotlib and Seaborn.'],
            ['title' => 'Statistics for Data Science',    'tags' => ['statistics', 'data', 'analytics', 'math'],      'description' => 'Probability, hypothesis testing, regression, and Bayesian inference.'],
            ['title' => 'Big Data with Apache Spark',     'tags' => ['spark', 'bigdata', 'python', 'data'],           'description' => 'Distributed data processing and analytics with Apache Spark.'],
            ['title' => 'SQL for Data Analysis',          'tags' => ['sql', 'data', 'analytics', 'database'],         'description' => 'Write complex SQL queries for data exploration and reporting.'],
            ['title' => 'Tableau Data Visualization',     'tags' => ['tableau', 'visualization', 'data', 'analytics'],'description' => 'Build interactive dashboards and visual analytics with Tableau.'],

            // Cybersecurity (5)
            ['title' => 'Ethical Hacking & Pentesting',   'tags' => ['security', 'hacking', 'pentest', 'cybersecurity'],'description' => 'Learn ethical hacking techniques to identify and fix vulnerabilities.'],
            ['title' => 'Network Security Fundamentals',  'tags' => ['security', 'network', 'cybersecurity', 'tcpip'],'description' => 'Secure network architectures, firewalls, and intrusion detection.'],
            ['title' => 'Web Application Security',       'tags' => ['security', 'web', 'owasp', 'cybersecurity'],    'description' => 'Protect web apps from OWASP Top 10 vulnerabilities.'],
            ['title' => 'Cryptography Basics',            'tags' => ['security', 'cryptography', 'math', 'protocols'],'description' => 'Symmetric/asymmetric encryption, hashing, and digital signatures.'],
            ['title' => 'Cloud Security Best Practices',  'tags' => ['security', 'cloud', 'aws', 'compliance'],       'description' => 'Secure your cloud infrastructure: IAM, encryption, and monitoring.'],

            // Software Architecture (8)
            ['title' => 'Microservices Architecture',     'tags' => ['architecture', 'microservices', 'backend', 'design'],'description' => 'Design and implement microservice-based systems.'],
            ['title' => 'Domain-Driven Design (DDD)',     'tags' => ['architecture', 'ddd', 'design', 'backend'],     'description' => 'Model complex business domains using strategic and tactical DDD patterns.'],
            ['title' => 'Clean Architecture & SOLID',     'tags' => ['architecture', 'solid', 'design', 'best-practices'],'description' => 'Build maintainable and testable software with Clean Architecture.'],
            ['title' => 'Design Patterns in PHP',         'tags' => ['php', 'design-patterns', 'oop', 'architecture'],'description' => 'Implement Gang of Four design patterns in a PHP context.'],
            ['title' => 'Event-Driven Architecture',      'tags' => ['architecture', 'events', 'messaging', 'backend'],'description' => 'Build loosely coupled systems using events and message brokers.'],
            ['title' => 'API Gateway & Service Mesh',     'tags' => ['architecture', 'api', 'microservices', 'cloud'],'description' => 'Manage microservices traffic with API gateways and service meshes.'],
            ['title' => 'CQRS & Event Sourcing',          'tags' => ['architecture', 'cqrs', 'events', 'database'],   'description' => 'Separate reads from writes and capture all changes as events.'],
            ['title' => 'System Design Interview Prep',   'tags' => ['architecture', 'system-design', 'scalability', 'interview'],'description' => 'Learn to design large-scale distributed systems.'],

            // Testing & Quality (5)
            ['title' => 'PHPUnit Testing (Laravel)',      'tags' => ['php', 'testing', 'phpunit', 'laravel'],         'description' => 'Write unit, feature, and browser tests for Laravel applications.'],
            ['title' => 'Jest & React Testing Library',   'tags' => ['javascript', 'testing', 'jest', 'react'],       'description' => 'Test your React components with Jest and React Testing Library.'],
            ['title' => 'Behavior-Driven Development',    'tags' => ['testing', 'bdd', 'cucumber', 'quality'],        'description' => 'Collaborate on requirements using Gherkin and BDD frameworks.'],
            ['title' => 'Performance Testing (JMeter)',   'tags' => ['testing', 'performance', 'jmeter', 'devops'],   'description' => 'Load test and benchmark your applications with Apache JMeter.'],
            ['title' => 'Code Reviews & Quality Metrics', 'tags' => ['quality', 'code-review', 'best-practices', 'team'],'description' => 'Effective code review techniques and code quality measurements.'],

            // Version Control (2)
            ['title' => 'Git & GitHub Advanced',          'tags' => ['git', 'github', 'version-control', 'devops'],   'description' => 'Advanced Git: branching strategies, rebase, hooks, and workflows.'],
            ['title' => 'Open Source Contribution Guide', 'tags' => ['git', 'open-source', 'github', 'community'],    'description' => 'Learn how to find, fork, and contribute to open source projects.'],

            // Soft Skills & Management (3)
            ['title' => 'Agile & Scrum Fundamentals',     'tags' => ['agile', 'scrum', 'management', 'team'],         'description' => 'Master Agile principles and Scrum ceremonies for effective delivery.'],
            ['title' => 'Technical Project Management',   'tags' => ['management', 'project', 'leadership', 'team'],  'description' => 'Plan, execute, and deliver technical projects on time and on budget.'],
            ['title' => 'Engineering Leadership',         'tags' => ['leadership', 'management', 'career', 'team'],   'description' => 'Lead engineering teams: mentoring, hiring, and technical strategy.'],

            // Game Development (2)
            ['title' => 'Unity Game Engine (C#)',         'tags' => ['csharp', 'unity', 'gamedev', '3d'],             'description' => 'Create 2D and 3D games with Unity and C#.'],
            ['title' => 'Unreal Engine 5 (Blueprints)',   'tags' => ['unreal', 'gamedev', '3d', 'blueprints'],        'description' => 'Build stunning games with Unreal Engine 5 visual scripting.'],

            // Emerging Technologies (4)
            ['title' => 'Blockchain & Web3 Development',  'tags' => ['blockchain', 'web3', 'solidity', 'crypto'],     'description' => 'Smart contracts, dApps, and Ethereum development.'],
            ['title' => 'IoT & Embedded Systems',         'tags' => ['iot', 'embedded', 'c', 'hardware'],             'description' => 'Connect devices and build IoT solutions with microcontrollers.'],
            ['title' => 'AR/VR Development (Unity)',      'tags' => ['ar', 'vr', 'unity', '3d'],                      'description' => 'Build augmented and virtual reality experiences.'],
            ['title' => 'Quantum Computing Basics',       'tags' => ['quantum', 'computing', 'physics', 'math'],      'description' => 'Introduction to quantum computing principles and algorithms.'],

            // Additional Backend & Tools (6)
            ['title' => 'RabbitMQ Message Queues',        'tags' => ['rabbitmq', 'messaging', 'backend', 'architecture'],'description' => 'Message brokering with RabbitMQ for async communication.'],
            ['title' => 'API Documentation (Swagger)',    'tags' => ['api', 'swagger', 'openapi', 'documentation'],   'description' => 'Document your APIs with OpenAPI/Swagger specifications.'],
            ['title' => 'WebSockets & Real-Time Apps',    'tags' => ['websockets', 'real-time', 'javascript', 'backend'],'description' => 'Build real-time features with WebSockets (Socket.io, Laravel Echo).'],
            ['title' => 'SEO Fundamentals for Developers','tags' => ['seo', 'web', 'marketing', 'frontend'],          'description' => 'Optimize your web applications for search engines.'],
            ['title' => 'Technical Writing & Docs',       'tags' => ['documentation', 'writing', 'technical', 'communication'],'description' => 'Write clear, concise technical documentation and API references.'],
            ['title' => 'Bash Scripting & Automation',    'tags' => ['bash', 'shell', 'automation', 'linux'],         'description' => 'Automate tasks with Bash shell scripting on Linux/macOS.'],

            // Final batch (5) to reach 100
            ['title' => 'Monitoring & Observability (Grafana)','tags' => ['monitoring', 'grafana', 'devops', 'observability'],'description' => 'Monitor applications and infrastructure with Grafana and Prometheus.'],
            ['title' => 'Algorithms & Data Structures',   'tags' => ['algorithms', 'data-structures', 'programming', 'interview'],'description' => 'Master core algorithms, Big O notation, and data structure fundamentals.'],
            ['title' => 'Functional Programming (Haskell)','tags' => ['haskell', 'functional', 'programming', 'math'],'description' => 'Pure functional programming with Haskell - monads, functors, and type classes.'],
            ['title' => 'Command Line & PowerShell',      'tags' => ['powershell', 'shell', 'automation', 'windows'],'description' => 'Automate Windows administration tasks with PowerShell scripting.'],
            ['title' => 'Software Licensing & Compliance', 'tags' => ['licensing', 'compliance', 'legal', 'business'],'description' => 'Understand open-source licenses, GPL, MIT, Apache, and compliance requirements.'],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['title' => $skill['title']],
                [
                    'tags' => $skill['tags'],
                    'description' => $skill['description'],
                    'content' => 'Full course content for ' . $skill['title'] . '. This covers beginner to advanced topics with hands-on exercises.',
                    'resource_link' => null,
                ]
            );
        }
    }
}
