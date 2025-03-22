<?php  
    define("DB_NAME", 'tutolabpro');
    define("DB_USER", 'root');
    define("DB_PASSWORD", '');
    define("DB_HOST", 'localhost');
    define("DB_PORT", '3306');
    define("SYS_URL", 'http://192.168.176.207/porteflie-with-back/porteflio-with-back-end/');
    //define("SYS_URL", 'http://localhost/porteflie-with-back/porteflio-with-back-end/');
    define("DEBUGGING", false);
    define("DEFAULT_LOCALE", 'en_fr');
    define("LICENCE_KEY", 'Dontka243');

/**
 * Vérifie si une image existe et retourne une URL de placeholder si nécessaire
 */
function getImageUrl($imagePath, $title = '') {
    if (empty($imagePath) || !file_exists($_SERVER['DOCUMENT_ROOT'] . parse_url($imagePath, PHP_URL_PATH))) {
        return "https://via.placeholder.com/800x600?text=" . urlencode($title ?: 'Project Image');
    }
    return $imagePath;
}
