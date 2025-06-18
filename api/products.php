<?php
// api/products.php

// Mostrar errores en desarrollo:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Incluir configuración y controlador:
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$action = $_GET['action'] ?? '';

$productController = new ProductController();

switch ($action) {
    case 'get':
        $products = $productController->getAllProducts();
        echo json_encode($products);
        break;

    case 'create':
        // Lee body JSON:
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'JSON inválido: '. json_last_error_msg()]);
            exit;
        }

        // Esperamos { productData: {...} }
        if (!isset($payload['productData']) || !is_array($payload['productData'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Datos de producto faltantes']);
            exit;
        }
        $data = $payload['productData'];

        // Llamar al método de creación en ProductController
        $result = $productController->createProduct($data); 
        // Asegúrate de tener createProduct en ProductController que inserte y devuelva ['success'=>..., 'product'=>...]
        if ($result['success']) {
            echo json_encode(['success' => true, 'product' => $result['product']]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        break;

    case 'update':
        // Similar al create, lee JSON, valida product_id y productData
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'JSON inválido']);
            exit;
        }
        if (!isset($payload['product_id']) || !isset($payload['productData'])) {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'Faltan parámetros para actualización']);
            exit;
        }
        $id = (int)$payload['product_id'];
        $data = $payload['productData'];
        $result = $productController->updateProduct($id, $data);
        if ($result['success']) {
            echo json_encode(['success'=>true, 'product'=>$result['product']]);
        } else {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>$result['message']]);
        }
        break;

    case 'delete':
        $raw = file_get_contents('php://input');
        $payload = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'JSON inválido']);
            exit;
        }
        if (!isset($payload['product_id'])) {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'Falta product_id']);
            exit;
        }
        $id = (int)$payload['product_id'];
        $result = $productController->deleteProduct($id);
        if ($result['success']) {
            echo json_encode(['success'=>true]);
        } else {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>$result['message']]);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'Acción no definida']);
}
exit;
