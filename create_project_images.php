<?php
// Vérifier si GD est installé
if (!extension_loaded('gd')) {
    die('GD extension is not loaded');
}

// Configuration
$projectsDir = __DIR__ . '/assets/images/projects';
if (!file_exists($projectsDir)) {
    mkdir($projectsDir, 0777, true);
}

// Dimensions des images
$width = 800;
$height = 600;

// Créer des images de démonstration pour les projets
$projects = [
    'project-featured' => ['Launch - Template SaaS', '#4CAF50'],
    'project-1' => ['CoderPro Template', '#2196F3'],
    'project-2' => ['WebApp Project', '#FF5722'],
    'project-3' => ['Mobile App', '#9C27B0'],
    'project-4' => ['E-commerce', '#F44336'],
    'project-5' => ['CMS System', '#673AB7'],
    'project-6' => ['Portfolio Theme', '#3F51B5'],
    'project-7' => ['Blog Platform', '#00BCD4'],
    'project-8' => ['Admin Dashboard', '#FFC107'],
    'project-9' => ['API Service', '#795548'],
];

foreach ($projects as $filename => $details) {
    list($title, $bgColor) = $details;
    
    // Créer une nouvelle image
    $image = imagecreatetruecolor($width, $height);
    
    // Convertir la couleur hexadécimale en RGB
    $hex = ltrim($bgColor, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Allouer les couleurs
    $backgroundColor = imagecolorallocate($image, $r, $g, $b);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    
    // Remplir le fond
    imagefill($image, 0, 0, $backgroundColor);
    
    // Ajouter le texte
    $text = $title;
    $font = 5; // Taille de police intégrée
    $textWidth = imagefontwidth($font) * strlen($text);
    $textHeight = imagefontheight($font);
    
    // Position du texte centrée
    $x = (int)(($width - $textWidth) / 2);
    $y = (int)(($height - $textHeight) / 2);
    
    // Écrire le texte
    imagestring($image, $font, $x, $y, $text, $textColor);
    
    // Sauvegarder l'image
    $imagePath = $projectsDir . '/' . $filename . '.jpg';
    imagejpeg($image, $imagePath, 90);
    imagedestroy($image);
    
    echo "Image créée : $imagePath\n";
}

echo "\nToutes les images ont été créées avec succès dans le dossier : $projectsDir";
