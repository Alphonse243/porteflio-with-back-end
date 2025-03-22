<?php
namespace Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        // Add base URL to data
        $data['baseUrl'] = defined('BASE_URL') ? BASE_URL : '';
        extract($data);
        
        $viewsDir = __DIR__ . '/../Views';
        $viewPath = $viewsDir . '/' . $view . '.php';
        $headerPath = $viewsDir . '/layouts/header.php';
        $footerPath = $viewsDir . '/layouts/footer.php';
        
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("Vue introuvable: $view");
        }
        
        if (file_exists($headerPath)) {
            require $headerPath;
        }
        
        require $viewPath;
        
        if (file_exists($footerPath)) {
            require $footerPath;
        }
    }
}
