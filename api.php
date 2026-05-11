<?php
// api.php - Controlador REST usando Eloquent ORM
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Obtener todos los profesores usando el ORM
    try {
        // Eloquent: Obtener todos ordenados por id descendente
        $professors = Professor::orderBy('id', 'desc')->get();
        echo json_encode($professors);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($method === 'POST') {
    // Insertar un nuevo profesor usando el ORM
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        http_response_code(400);
        echo json_encode(['error' => 'No data provided']);
        exit;
    }

    try {
        // Eloquent: Crear un nuevo registro
        // Como nuestras llaves del JSON vienen en camelCase (ej. fullName) 
        // pero Postgres usa minúsculas (ej. fullname), mapeamos el arreglo
        $professorData = [
            'fullname' => $data['fullName'],
            'age' => $data['age'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'salary' => $data['salary'],
            'department' => $data['department'],
            'hiredate' => $data['hireDate'], // Importante: hiredate minúscula para bd, hireDate del json
            'officelocation' => $data['officeLocation'] ?? null
        ];

        Professor::create($professorData);
        
        http_response_code(201);
        echo json_encode(['message' => 'Professor created successfully via ORM!']);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
