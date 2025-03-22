<?php
// Créer une image par défaut de 800x600
$image = imagecreatetruecolor(800, 600);
$bgColor = imagecolorallocate($image, 240, 240, 240);
$textColor = imagecolorallocate($image, 100, 100, 100);
imagefill($image, 0, 0, $bgColor);
imagestring($image, 5, 300, 280, "No Image Available", $textColor);
imagepng($image, __DIR__ . '/../assets/images/default-project.jpg');
imagedestroy($image);
