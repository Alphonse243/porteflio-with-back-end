<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Project;
use App\Helper\OutputHelper;

header('Content-Type: application/json');

try {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 6;

    $projectModel = new Project();
    $projects = $projectModel->getPaginated($page, $perPage);
    $total = $projectModel->getTotal();

    // Définir systemUrl
    $systemUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
                "://" . $_SERVER['HTTP_HOST'] . 
                dirname(dirname($_SERVER['PHP_SELF'])) . '/';

    $output = '';
    foreach ($projects as $project) {
        $imageUrl = $project['image_url'] ?? '';
        $defaultImage = 'assets/images/default-project.jpg';
        
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . parse_url($imageUrl, PHP_URL_PATH);
        if (empty($imageUrl) || !file_exists($fullPath)) {
            $imageUrl = $defaultImage;
        }

        $output .= '<div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <img class="card-img-top" 
                     src="' . $systemUrl . $imageUrl . '" 
                     alt="' . OutputHelper::sanitize($project['title']) . '"
                     onerror="this.src=\'' . $systemUrl . $defaultImage . '\'">
                <div class="card-body">
                    <h5 class="card-title">' . OutputHelper::sanitize($project['title']) . '</h5>
                    <p class="card-text">' . nl2br(OutputHelper::sanitize($project['description'])) . '</p>
                    <a href="project.php?url=' . urlencode($project['project_url']) . '" 
                       class="btn btn-primary">Voir plus</a>
                </div>
            </div>
        </div>';
    }

    echo json_encode([
        'html' => $output,
        'hasMore' => ($page * $perPage) < $total
    ]);
} catch (Exception $e) {
    error_log("General Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
    exit;
}
