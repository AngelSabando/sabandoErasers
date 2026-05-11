<?php

// Requerir el autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'pgsql',
    'host'      => 'aws-1-us-west-1.pooler.supabase.com',
    'database'  => 'postgres',
    'username'  => 'postgres.dwvgwqgqhuezeagdwxdw',
    'password'  => '20052010Dan@!12',
    'port'      => '5432',
    'charset'   => 'utf8',
    'prefix'    => '',
    'schema'    => 'public',
]);

// Make this Capsule instance available globally via static methods...
$capsule->setAsGlobal();

// Setup the Eloquent ORM...
$capsule->bootEloquent();

// Intentar conectar para capturar errores de conexión y mantener compatibilidad con tu código actual
try {
    $capsule->getConnection()->getPdo();
} catch (\Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

?>
