<?php
// api/products.php

// Mostrar errores en desarrollo (retirar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$action = $_GET['action'] ?? '';
$productController = new ProductController();

// Caso paginación remota:
if ($action === 'list') {
    require_once __DIR__ . '/../models/Database.php';
    $db = (new Database())->getConnection();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $size = isset($_GET['size']) ? (int)$_GET['size'] : 20000;
    if ($page < 1) $page = 1;
    if ($size < 1) $size = 2000;
    $offset = ($page - 1) * $size;
    try {
        $totalStmt = $db->query("SELECT COUNT(*) FROM products");
        $total = (int)$totalStmt->fetchColumn();
        $stmt = $db->prepare("
            SELECT 
                product_id, product_code, barcode, product_name, product_description, location, price, stock, registration_date,
                category_id, supplier_id, unit_id, currency_id, image_url, subcategory_id,
                desired_stock, status
            FROM products
            ORDER BY product_id DESC
            LIMIT :offset, :size
        ");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':size', $size, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            // `last_page` es el número total de páginas:
            "last_page" => ceil($total / $size),
            // `data` es el array de registros de esta página
            "data"      => $rows
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "last_page" => 0,
            "data"      => [],
            "error"     => $e->getMessage(),
        ]);
    }
    exit;
}


switch ($action) {

    
   case 'get':
    $products = $productController->getAllProducts();
    echo json_encode($products);
    break;


    case 'create':
    header('Content-Type: application/json');
    // Conexión y controlador
    require_once __DIR__ . '/../models/Database.php';
    $db = (new Database())->getConnection();
    require_once __DIR__ . '/../controllers/ProductController.php';
    $productController = new ProductController();

    // 1) Recoger $_POST campos en $data...
    $data = [];
    if (isset($_POST['product_code']))   $data['product_code'] = trim($_POST['product_code']);
    if (isset($_POST['barcode']))        $data['barcode'] = trim($_POST['barcode']);
    if (isset($_POST['product_name']))   $data['product_name'] = trim($_POST['product_name']);
    if (isset($_POST['product_description'])) $data['product_description'] = trim($_POST['product_description']);
    if (isset($_POST['location']))       $data['location'] = trim($_POST['location']);
    if (isset($_POST['price']))          $data['price'] = $_POST['price'];
    if (isset($_POST['stock']))          $data['stock'] = $_POST['stock'];
    if (isset($_POST['category_id']))    $data['category_id'] = $_POST['category_id'];
    if (isset($_POST['supplier_id']))    $data['supplier_id'] = $_POST['supplier_id'];
    if (isset($_POST['unit_id']))        $data['unit_id'] = $_POST['unit_id'];
    if (isset($_POST['currency_id']))    $data['currency_id'] = $_POST['currency_id'];
    if (isset($_POST['subcategory_id'])) $data['subcategory_id'] = $_POST['subcategory_id'];
    if (isset($_POST['desired_stock']))  $data['desired_stock'] = $_POST['desired_stock'];
    if (isset($_POST['status']))         $data['status'] = $_POST['status'];
    // Validaciones básicas:
    if (empty($data['product_code']) || empty($data['product_name'])) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'Código y nombre son obligatorios']);
        exit;
    }
    // 2) Insert inicial sin imagen
    try {
        $fields = ['product_code','barcode', 'product_name','product_description','location','price','stock','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'];
        $placeholders = [':product_code',':barcode',':product_name',':product_description',':location',':price',':stock',':category_id',':supplier_id',':unit_id',':currency_id',':subcategory_id',':desired_stock',':status'];
        $sql = "INSERT INTO products (".implode(',', $fields).") VALUES (".implode(',', $placeholders).")";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':product_code', $data['product_code'], PDO::PARAM_STR);
        $stmt->bindValue(':barcode', $data['barcode'], PDO::PARAM_STR);
        $stmt->bindValue(':product_name', $data['product_name'], PDO::PARAM_STR);
        $stmt->bindValue(':product_description', isset($data['product_description']) ? $data['product_description'] : null, isset($data['product_description']) ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':location', isset($data['location']) ? $data['location'] : null, isset($data['location'])?PDO::PARAM_STR:PDO::PARAM_NULL);
        $stmt->bindValue(':price', isset($data['price']) ? $data['price'] : null, isset($data['price'])?PDO::PARAM_STR:PDO::PARAM_NULL);
        $stmt->bindValue(':stock', isset($data['stock']) ? (int)$data['stock'] : null, isset($data['stock'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':category_id', isset($data['category_id']) ? (int)$data['category_id'] : null, isset($data['category_id'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':supplier_id', isset($data['supplier_id']) ? (int)$data['supplier_id'] : null, isset($data['supplier_id'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':unit_id', isset($data['unit_id']) ? (int)$data['unit_id'] : null, isset($data['unit_id'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':currency_id', isset($data['currency_id']) ? (int)$data['currency_id'] : null, isset($data['currency_id'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':subcategory_id', isset($data['subcategory_id']) ? (int)$data['subcategory_id'] : null, isset($data['subcategory_id'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':desired_stock', isset($data['desired_stock']) ? (int)$data['desired_stock'] : null, isset($data['desired_stock'])?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':status', isset($data['status']) ? (int)$data['status'] : 1, PDO::PARAM_INT);
        $stmt->execute();
        $newId = (int)$db->lastInsertId();
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'Error al insertar producto: '.$e->getMessage()]);
        exit;
    }
    // 3) Procesar imagen subida
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
        $uploadDir = __DIR__ . '/../assets/images/products/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $newName = "product_{$newId}.{$ext}";
        $fullPath = $uploadDir . $newName;
        if (!move_uploaded_file($tmp_name, $fullPath)) {
            http_response_code(500);
            echo json_encode(['success'=>false,'message'=>'Error al guardar la imagen.']);
            exit;
        }
        $relativePath = 'assets/images/products/' . $newName;
        try {
            $stmtUpd = $db->prepare("UPDATE products SET image_url = :img WHERE product_id = :id");
            $stmtUpd->bindValue(':img', $relativePath, PDO::PARAM_STR);
            $stmtUpd->bindValue(':id', $newId, PDO::PARAM_INT);
            $stmtUpd->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar image_url: ".$e->getMessage());
        }
    }
    // 4) Recuperar producto completo con image_version
    try {
        $stmt2 = $db->prepare("SELECT * FROM products WHERE product_id = :id");
        $stmt2->bindValue(':id', $newId, PDO::PARAM_INT);
        $stmt2->execute();
        $product = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo json_encode(['success'=>true,'product'=>['product_id'=>$newId]]);
        exit;
    }
    // Añadir image_version
    if (!empty($product['image_url'])) {
        $filePath = __DIR__ . '/../' . $product['image_url'];
        $product['image_version'] = file_exists($filePath) ? filemtime($filePath) : null;
    } else {
        $product['image_version'] = null;
    }
    echo json_encode(['success'=>true,'product'=>$product]);
    break;



   case 'update':
    header('Content-Type: application/json');
    require_once __DIR__ . '/../models/Database.php';
    $db = (new Database())->getConnection();
    require_once __DIR__ . '/../controllers/ProductController.php';
    $productController = new ProductController();

    $product_id = $_POST['product_id'] ?? null;
    if (!$product_id || !is_numeric($product_id)) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'product_id inválido']);
        exit;
    }
    $product_id = (int)$product_id;
    $data = [];
    if (isset($_POST['product_code']))   $data['product_code'] = trim($_POST['product_code']);
    if (isset($_POST['barcode']))        $data['barcode'] = trim($_POST['barcode']);
    if (isset($_POST['product_name']))   $data['product_name'] = trim($_POST['product_name']);
    if (isset($_POST['location']))       $data['location'] = trim($_POST['location']);
    if (isset($_POST['price']))          $data['price'] = $_POST['price'];
    if (isset($_POST['stock']))          $data['stock'] = $_POST['stock'];
    if (isset($_POST['category_id']))    $data['category_id'] = $_POST['category_id'];
    if (isset($_POST['supplier_id']))    $data['supplier_id'] = $_POST['supplier_id'];
    if (isset($_POST['unit_id']))        $data['unit_id'] = $_POST['unit_id'];
    if (isset($_POST['currency_id']))    $data['currency_id'] = $_POST['currency_id'];
    if (isset($_POST['subcategory_id'])) $data['subcategory_id'] = $_POST['subcategory_id'];
    if (isset($_POST['desired_stock']))  $data['desired_stock'] = $_POST['desired_stock'];
    if (isset($_POST['status']))         $data['status'] = $_POST['status'];
    if (isset($_POST['product_description'])) $data['product_description'] = trim($_POST['product_description']);

    // Otros opcionales...

    // Procesar imagen subida
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
        $uploadDir = __DIR__ . '/../assets/images/products/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        // Eliminar imagen previa si existe
        try {
            $stmtOld = $db->prepare("SELECT image_url FROM products WHERE product_id = :id");
            $stmtOld->bindParam(':id', $product_id, PDO::PARAM_INT);
            $stmtOld->execute();
            $old = $stmtOld->fetch(PDO::FETCH_ASSOC);
            if ($old && !empty($old['image_url'])) {
                $oldPath = __DIR__ . '/../' . $old['image_url'];
                if (file_exists($oldPath)) @unlink($oldPath);
            }
        } catch (PDOException $e) {
            error_log("Error obteniendo imagen previa: ".$e->getMessage());
        }
        // Mover nueva con nombre fijo
        $newName = "product_{$product_id}.{$ext}";
        $fullPath = $uploadDir . $newName;
        if (!move_uploaded_file($tmp_name, $fullPath)) {
            http_response_code(500);
            echo json_encode(['success'=>false,'message'=>'Error al guardar imagen.']);
            exit;
        }
        $data['image_url'] = 'assets/images/products/' . $newName;
    }

    // Llamar al controlador -> modelo
    $result = $productController->updateProduct($product_id, $data);
    if ($result['success']) {
        // Recuperar registro actualizado
        try {
            $stmt2 = $db->prepare("SELECT * FROM products WHERE product_id = :id");
            $stmt2->bindValue(':id', $product_id, PDO::PARAM_INT);
            $stmt2->execute();
            $product = $stmt2->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(['success'=>true,'product'=>['product_id'=>$product_id]]);
            exit;
        }
        // Añadir image_version
        if (!empty($product['image_url'])) {
            $filePath = __DIR__ . '/../' . $product['image_url'];
            $product['image_version'] = file_exists($filePath) ? filemtime($filePath) : null;
        } else {
            $product['image_version'] = null;
        }
        echo json_encode(['success'=>true,'product'=>$product]);
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
