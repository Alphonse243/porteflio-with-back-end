<?php

// Vérification de l'existence de l'autoloader de Composer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    die("Please run 'composer install' first");
}

$faker = Faker\Factory::create('fr_FR');

// Configuration de la base de données
$host = 'localhost';
$dbname = 'tutolabpro';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vider les tables existantes
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
    $pdo->exec('TRUNCATE TABLE comments');
    $pdo->exec('TRUNCATE TABLE users');
    $pdo->exec('TRUNCATE TABLE profile');
    $pdo->exec('TRUNCATE TABLE projects');
    $pdo->exec('TRUNCATE TABLE skills');
    $pdo->exec('TRUNCATE TABLE experience');
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');

    // Seeding profile
    $stmt = $pdo->prepare("INSERT INTO profile (name, title, description, location, email, website, github_username, linkedin_url, twitter_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $faker->name,
        $faker->jobTitle,
        $faker->text(200),
        $faker->city . ', ' . $faker->country,
        $faker->email,
        $faker->url,
        $faker->userName,
        'https://linkedin.com/in/' . $faker->userName,
        'https://twitter.com/' . $faker->userName
    ]);

    // Seeding projects (10 projets)
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, image_url, project_url, is_featured) VALUES (?, ?, ?, ?, ?)");
    
    // Liste des images disponibles
    $projectImages = [
        'assets/images/projects/project-1.jpg',
        'assets/images/projects/project-2.jpg',
        'assets/images/projects/project-3.jpg',
        'assets/images/projects/project-4.jpg',
        'assets/images/projects/project-5.jpg',
        'assets/images/projects/project-6.jpg',
        'assets/images/projects/project-7.jpg',
        'assets/images/projects/project-8.jpg',
        'assets/images/projects/project-9.jpg',
        'assets/images/projects/project-featured.jpg'
    ];

    // Insertion des projets avec les images existantes
    $projectData = [
        ['Launch - Template SaaS', 'Un template Bootstrap parfait pour les produits SaaS', $projectImages[9], 'https://example.com/launch', 1],
        ['CoderPro - Template Startup', 'Template Bootstrap pour projets logiciels', $projectImages[0], 'https://example.com/coderpro', 0],
        ['WebApp - Application Web', 'Application web moderne et responsive', $projectImages[1], 'https://example.com/webapp', 0],
        ['MobileApp - App Mobile', 'Application mobile cross-platform', $projectImages[2], 'https://example.com/mobileapp', 0],
        ['E-commerce Platform', 'Plateforme e-commerce complète', $projectImages[3], 'https://example.com/ecommerce', 0],
        ['CMS System', 'Système de gestion de contenu', $projectImages[4], 'https://example.com/cms', 0],
        ['Portfolio Theme', 'Thème portfolio professionnel', $projectImages[5], 'https://example.com/portfolio', 0],
        ['Blog Platform', 'Plateforme de blog moderne', $projectImages[6], 'https://example.com/blog', 0],
        ['Admin Dashboard', 'Interface d\'administration', $projectImages[7], 'https://example.com/admin', 0],
        ['API Service', 'Service API RESTful', $projectImages[8], 'https://example.com/api', 0]
    ];

    foreach ($projectData as $project) {
        $stmt->execute($project);
    }

    // Seeding skills (15 compétences)
    $categories = ['Frontend', 'Backend', 'DevOps', 'Mobile', 'Database'];
    $stmt = $pdo->prepare("INSERT INTO skills (name, level, category) VALUES (?, ?, ?)");
    for ($i = 0; $i < 15; $i++) {
        $stmt->execute([
            $faker->randomElement(['PHP', 'JavaScript', 'Python', 'Java', 'C#', 'React', 'Vue.js', 'Angular', 'Node.js', 'Laravel', 'Django', 'Docker', 'Kubernetes', 'AWS', 'Azure']),
            $faker->numberBetween(60, 100),
            $faker->randomElement($categories)
        ]);
    }

    // Seeding experience (5 expériences)
    $stmt = $pdo->prepare("INSERT INTO experience (title, company, location, start_date, end_date, description) VALUES (?, ?, ?, ?, ?, ?)");
    for ($i = 0; $i < 5; $i++) {
        $startDate = $faker->dateTimeBetween('-10 years', '-1 year');
        $endDate = $faker->optional(0.7)->dateTimeBetween($startDate, 'now'); // 30% de chances d'être le poste actuel
        
        $stmt->execute([
            $faker->jobTitle,
            $faker->company,
            $faker->city . ', ' . $faker->country,
            $startDate->format('Y-m-d'),
            $endDate ? $endDate->format('Y-m-d') : null,
            $faker->paragraphs(2, true)
        ]);
    }

    // Seeding users (5 utilisateurs)
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    for ($i = 0; $i < 5; $i++) {  // Correction ici : i++ au lieu de i++
        $stmt->execute([
            $faker->userName,
            $faker->email,
            password_hash('password123', PASSWORD_DEFAULT)
        ]);
    }

    // Seeding comments (20 commentaires)
    $stmt = $pdo->prepare("INSERT INTO comments (project_url, user_id, content) VALUES (?, ?, ?)");
    $projectUrls = $pdo->query("SELECT project_url FROM projects")->fetchAll(PDO::FETCH_COLUMN);
    $userIds = $pdo->query("SELECT id FROM users")->fetchAll(PDO::FETCH_COLUMN);
    
    for ($i = 0; $i < 20; $i++) {
        $stmt->execute([
            $faker->randomElement($projectUrls),
            $faker->randomElement($userIds),
            $faker->paragraph
        ]);
    }

    echo "Seeding completed successfully!\n";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
