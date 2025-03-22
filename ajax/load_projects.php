<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../includes/functions.php';

    // Définir systemUrl
    $systemUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
                "://" . $_SERVER['HTTP_HOST'] . 
                dirname(dirname($_SERVER['PHP_SELF'])) . '/';

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 6;
    $offset = ($page - 1) * $perPage;

    // Requête pour obtenir les projets paginés
    $stmt = $pdo->prepare("SELECT * FROM projects ORDER BY id DESC LIMIT :limit OFFSET :offset");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête");
    }
    
    $bindLimit = $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $bindOffset = $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    if (!$bindLimit || !$bindOffset) {
        throw new Exception("Erreur de liaison des paramètres");
    }

    $execute = $stmt->execute();
    if (!$execute) {
        throw new Exception("Erreur d'exécution de la requête");
    }

    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($projects === false) {
        throw new Exception("Erreur de récupération des données");
    }

    // Requête pour le compte total
    $total = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();

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
                     alt="' . sanitizeOutput($project['title']) . '"
                     onerror="this.src=\'' . $systemUrl . $defaultImage . '\'">
                <div class="card-body">
                    <h5 class="card-title">' . sanitizeOutput($project['title']) . '</h5>
                    <p class="card-text">' . nl2br(sanitizeOutput($project['description'])) . '</p>
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
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    error_log("General Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
    exit;
}
