<?php
// Archivo: api/products.php

// Asegurarse de que la respuesta sea JSON
header('Content-Type: application/json');

// Incluir configuración y controlador de productos
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Obtener la acción enviada por GET, p.ej. ?action=get|create|update|delete
$action = $_GET['action'] ?? '';

$productController = new ProductController();

// Función auxiliar para leer body JSON
function getJsonInput() {
    $input = file_get_contents("php://input");
    if (empty($input)) {
        return [];
    }
    $data = json_decode($input, true);
    return is_array($data) ? $data : [];
}

switch ($action) {
    case 'get':
        // Obtener todos los productos
        try {
            $products = $productController->getAllProducts();
            echo json_encode($products);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener productos: ' . $e->getMessage(),
            ]);
        }
        break;

    case 'create':
        // Crear nuevo producto
        // Esperamos el JSON con clave "productData", por ejemplo:
        // { "productData": { "product_code": "...", "product_name": "...", ... } }
        $input = getJsonInput();
        $data = $input['productData'] ?? [];

        // Validaciones básicas (puedes extender en el controlador/modelo)
        if (empty($data)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'No se recibieron datos de producto para crear.'
            ]);
            break;
        }

        // Llamar al controlador
        $result = $productController->createProduct($data);
        // Se espera que createProduct devuelva ['success'=>bool, 'product'=>[...] ] o ['success'=>false,'message'=>...]
        if (!empty($result['success'])) {
            // Devolver el nuevo producto
            echo json_encode([
                'success' => true,
                'newProduct' => $result['product']
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $result['message'] ?? 'No se pudo crear el producto.'
            ]);
        }
        break;

    case 'update':
        // Actualizar un producto existente
        // Esperamos JSON con clave "productData", que incluya al menos 'product_id'
        // { "productData": { "product_id": 123, "product_name": "...", ... } }
        $input = getJsonInput();
        $data = $input['productData'] ?? [];

        if (empty($data) || empty($data['product_id'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'No se proporcionó product_id o datos insuficientes para actualizar.'
            ]);
            break;
        }

        // Llamar al controlador
        $result = $productController->updateProduct($data);
        // Se espera que updateProduct devuelva ['success'=>bool, 'product'=>[...] ] o ['success'=>false,'message'=>...]
        if (!empty($result['success'])) {
            echo json_encode([
                'success' => true,
                'updatedProduct' => $result['product']
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $result['message'] ?? 'No se pudo actualizar el producto.'
            ]);
        }
        break;

    case 'delete':
        // Eliminar un producto por ID
        $input = getJsonInput();
        $productID = $input['product_id'] ?? null;

        if ($productID === null || !is_numeric($productID)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Product ID no proporcionado o inválido.'
            ]);
            break;
        }
        $productID = (int)$productID;

        $result = $productController->deleteProduct($productID);
        // Se espera que deleteProduct devuelva ['success'=>bool] o ['success'=>false,'message'=>...]
        if (!empty($result['success'])) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $result['message'] ?? 'No se pudo eliminar el producto.'
            ]);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Acción no definida.'
        ]);
        break;
}

exit();
