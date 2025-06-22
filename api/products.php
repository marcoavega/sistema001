<?php
// api/products.php

// Mostrar errores en desarrollo (retirar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';            // Debe definir BASE_URL, etc.
require_once __DIR__ . '/../controllers/ProductController.php';

$action = $_GET['action'] ?? '';
$productController = new ProductController();

switch ($action) {
    case 'get':
        $products = $productController->getAllProducts();
        echo json_encode($products);
        break;

    case 'create':
        // Detectar Content-Type
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $data = [];
        $imageUploaded = false;
        $imageTempPath = null;
        $originalFilename = null;

        if (stripos($contentType, 'application/json') !== false) {
            // JSON puro: { "productData": { ... } }
            $raw = file_get_contents('php://input');
            $payload = json_decode($raw, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'JSON inválido: '. json_last_error_msg()]);
                exit;
            }
            if (!isset($payload['productData']) || !is_array($payload['productData'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Datos de producto faltantes']);
                exit;
            }
            $data = $payload['productData'];
            // No imagen en este caso
        }
        elseif (stripos($contentType, 'multipart/form-data') !== false) {
            // multipart/form-data: leer de $_POST y $_FILES
            // Campos esperados en el formulario:
            $data = [];
            // Lectura de campos obligatorios (ajusta nombres si difieren):
            $data['product_code']   = $_POST['product_code']   ?? '';
            $data['product_name']   = $_POST['product_name']   ?? '';
            $data['location']       = $_POST['location']       ?? '';
            $data['price']          = $_POST['price']          ?? '';
            $data['stock']          = $_POST['stock']          ?? '';
            $data['category_id']    = $_POST['category_id']    ?? '';
            $data['supplier_id']    = $_POST['supplier_id']    ?? '';
            $data['unit_id']        = $_POST['unit_id']        ?? '';
            $data['currency_id']    = $_POST['currency_id']    ?? '';
            $data['subcategory_id'] = $_POST['subcategory_id'] ?? '';
            // Opcionales:
            if (isset($_POST['desired_stock'])) {
                $data['desired_stock'] = $_POST['desired_stock'];
            }
            if (isset($_POST['status'])) {
                $data['status'] = $_POST['status'];
            }
            // Procesar imagen subida:
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                    $imageUploaded = true;
                    $imageTempPath = $_FILES['image_file']['tmp_name'];
                    $originalFilename = $_FILES['image_file']['name'];
                } else {
                    http_response_code(400);
                    echo json_encode(['success'=>false,'message'=>'Error al subir la imagen. Código error: '.$_FILES['image_file']['error']]);
                    exit;
                }
            }
        }
        else {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'Content-Type no soportado. Usa JSON o multipart/form-data.']);
            exit;
        }

        // Si vino imagen en multipart, procesarla:
        if (!empty($imageUploaded) && $imageTempPath !== null) {
            // Sanitizar base del nombre: usar product_code o product_name
            $baseRaw = $data['product_code'] ?: $data['product_name'];
            // limitar longitud y sustituir caracteres no válidos
            $baseName = preg_replace('/[^A-Za-z0-9_-]/', '_', substr($baseRaw, 0, 50));
            // Extensión:
            $ext = pathinfo($originalFilename, PATHINFO_EXTENSION);
            $ext = strtolower($ext);
            $allowedExts = ['jpg','jpeg','png','gif'];
            if (!in_array($ext, $allowedExts)) {
                http_response_code(400);
                echo json_encode(['success'=>false,'message'=>'Extensión de imagen no permitida. Solo JPG/PNG/GIF.']);
                exit;
            }
            // Directorio físico donde guardar:
            $uploadDir = __DIR__ . '/../assets/images/products/';
            if (!is_dir($uploadDir)) {
                // intentar crear carpeta con permisos
                mkdir($uploadDir, 0755, true);
            }
            // Nuevo nombre con timestamp o uniqid
            $newFilename = $baseName . '_' . time() . '.' . $ext;
            $destinationPath = $uploadDir . $newFilename;
            if (!move_uploaded_file($imageTempPath, $destinationPath)) {
                http_response_code(500);
                echo json_encode(['success'=>false,'message'=>'No se pudo mover la imagen subida.']);
                exit;
            }
            // Generar URL pública:
            // Asumimos que BASE_URL termina con slash: e.g. "http://localhost/sistema001/"
            //$data['image_url'] = rtrim(BASE_URL, '/') . '/assets/images/products/' . $newFilename;
            $data['image_url'] = 'assets/images/products/' . $newFilename;

        }

        // Llamar al controlador
        $result = $productController->createProduct($data);
        if ($result['success']) {
            echo json_encode(['success' => true, 'product' => $result['product']]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $result['message']]);
        }
        break;

   case 'update':
    // No usamos json_decode sino $_POST y $_FILES
    header('Content-Type: application/json');

    // Verificar que venga product_id
    $product_id = $_POST['product_id'] ?? null;
    if (!$product_id || !is_numeric($product_id)) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'product_id inválido']);
        exit;
    }
    $product_id = (int)$product_id;

    // Recoger campos
    $data = [];
    if (isset($_POST['product_code']))    $data['product_code'] = trim($_POST['product_code']);
    if (isset($_POST['product_name']))    $data['product_name'] = trim($_POST['product_name']);
    if (isset($_POST['location']))        $data['location'] = trim($_POST['location']);
    if (isset($_POST['price']))           $data['price'] = $_POST['price'];
    if (isset($_POST['stock']))           $data['stock'] = $_POST['stock'];
    if (isset($_POST['category_id']))     $data['category_id'] = $_POST['category_id'];
    if (isset($_POST['supplier_id']))     $data['supplier_id'] = $_POST['supplier_id'];
    if (isset($_POST['unit_id']))         $data['unit_id'] = $_POST['unit_id'];
    if (isset($_POST['currency_id']))     $data['currency_id'] = $_POST['currency_id'];
    if (isset($_POST['subcategory_id']))  $data['subcategory_id'] = $_POST['subcategory_id'];
    if (isset($_POST['desired_stock']))   $data['desired_stock'] = $_POST['desired_stock'];
    if (isset($_POST['status']))          $data['status'] = $_POST['status'];
    // Si añades más campos opcionales (sale_price, weight, etc.) captúralos aquí

    // Conexión para posible uso de eliminación previa
    require_once __DIR__ . '/../models/Database.php';
    $db = (new Database())->getConnection();

    // Manejar imagen si se subió
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image_file']['tmp_name'];
        $originalName = basename($_FILES['image_file']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowedExt)) {
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'Extensión de imagen no permitida.']);
            exit;
        }

        // Directorio absoluto donde se guardan las imágenes
        $uploadDir = __DIR__ . '/../assets/images/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Antes de subir la nueva, eliminar la anterior (si existe)
        // Obtener la ruta previa desde BD:
        try {
            $stmtOld = $db->prepare("SELECT image_url FROM products WHERE product_id = :id");
            $stmtOld->bindParam(':id', $product_id, PDO::PARAM_INT);
            $stmtOld->execute();
            $old = $stmtOld->fetch(PDO::FETCH_ASSOC);
            if ($old && !empty($old['image_url'])) {
                // image_url en BD es ruta relativa, ej. 'assets/images/products/product_12.jpg'
                $oldPath = __DIR__ . '/../' . $old['image_url'];
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
        } catch (PDOException $e) {
            // Si falla la consulta, continuamos: no letal
            error_log("Error obteniendo imagen previa: " . $e->getMessage());
        }

        // Nombrar la nueva imagen con un nombre fijo: product_{id}.ext
        $newName = "product_{$product_id}.{$ext}";
        $fullPath = $uploadDir . $newName;

        if (!move_uploaded_file($tmp_name, $fullPath)) {
            http_response_code(500);
            echo json_encode(['success'=>false,'message'=>'Error al guardar imagen.']);
            exit;
        }
        // Guardamos en $data la ruta relativa para BD
        // Guardamos sin BASE_URL, solo ruta relativa desde la raíz pública, por ejemplo:
        $data['image_url'] = 'assets/images/products/' . $newName;
    }

    // Llamar al controlador para actualizar
    require_once __DIR__ . '/../controllers/ProductController.php';
    $productController = new ProductController();

    // Ajustar el método updateProduct para aceptar signature: updateProduct($id, $data)
    $result = $productController->updateProduct($product_id, $data);
    if ($result['success']) {
        echo json_encode(['success'=>true, 'product'=>$result['product']]);
    } else {
        http_response_code(400);
        echo json_encode(['success'=>false, 'message'=>$result['message']]);
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
