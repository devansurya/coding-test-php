<?php
// App - Front Controller & Bootstrap
class App
{
    // Routing: action => [controller, method]
    private array $routes = [
        'login'       => ['AuthController', 'login'],
        'logout'      => ['AuthController', 'logout'],
        'captcha'     => ['AuthController', 'captcha'],
        'users'       => ['UserController', 'index'],
        'user_add'    => ['UserController', 'create'],
        'user_edit'   => ['UserController', 'edit'],
        'user_delete' => ['UserController', 'delete'],
    ];

    public function __construct()
    {
        $this->loadClasses();
    }

    // Load semua class yang diperlukan
    private function loadClasses(): void
    {
        $base = dirname(__DIR__);

        require_once __DIR__ . '/Session.php';
        require_once __DIR__ . '/Captcha.php';
        require_once __DIR__ . '/View.php';
        require_once __DIR__ . '/Controller.php';

        require_once $base . '/config/db.php';
        require_once $base . '/models/User.php';
        require_once $base . '/controllers/AuthController.php';
        require_once $base . '/controllers/UserController.php';
    }

    // Jalankan routing berdasarkan parameter action
    public function run(): void
    {
        $action = $_GET['action'] ?? 'login';
        $action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

        if (!isset($this->routes[$action])) {
            $action = 'login';
        }

        [$controllerClass, $method] = $this->routes[$action];

        $controller = new $controllerClass();
        $controller->$method();
    }
}
