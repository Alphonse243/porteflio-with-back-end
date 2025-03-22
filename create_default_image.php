<?php
// Vérifier si GD est installé
if (!extension_loaded('gd')) {
    die('GD extension is not loaded');
}

// Créer le dossier s'il n'existe pas
$directory = __DIR__ . '/assets/images';
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
}

// Créer une image par défaut
$width = 800;
$height = 600;
$image = imagecreatetruecolor($width, $height);

// Couleurs
$bgColor = imagecolorallocate($image, 245, 245, 245);  // Gris clair
$textColor = imagecolorallocate($image, 100, 100, 100); // Gris foncé

// Remplir le fond
imagefill($image, 0, 0, $bgColor);

// Ajouter le texte
$text = "No Image Available";
$font = 5; // Taille de police intégrée
$textWidth = imagefontwidth($font) * strlen($text);
$textHeight = imagefontheight($font);

// Calculer la position du texte et convertir explicitement en entiers
$x = (int)(($width - $textWidth) / 2);
$y = (int)(($height - $textHeight) / 2);

imagestring($image, $font, $x, $y, $text, $textColor);

// Sauvegarder l'image
$imagePath = $directory . '/default-project.jpg';
imagejpeg($image, $imagePath, 90);
imagedestroy($image);

echo "Image par défaut créée avec succès : $imagePath";
