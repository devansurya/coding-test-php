<?php
// Class View - merender template dengan data
class View
{
    private string $viewPath;

    public function __construct(string $viewPath)
    {
        $this->viewPath = rtrim($viewPath, '/\\');
    }

    // Render template view
    public function render(string $template, array $data = []): void
    {
        $file = $this->viewPath . DIRECTORY_SEPARATOR . $template . '.php';

        if (!file_exists($file)) {
            throw new RuntimeException("View template tidak ditemukan: {$template}");
        }

        extract($data, EXTR_SKIP);
        require $file;
    }

    // Escape output untuk mencegah XSS
    public static function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
