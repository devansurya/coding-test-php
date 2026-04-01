<?php
// Soal 2 - Front Controller (single entry point)
// Semua request diproses melalui parameter ?action=xxx

require_once __DIR__ . '/core/App.php';

$app = new App();
$app->run();
