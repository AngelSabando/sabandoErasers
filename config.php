<?php

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

$capsule->setAsGlobal();

$capsule->bootEloquent();

try {
    $capsule->getConnection()->getPdo();
} catch (\Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

?>
