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
    // Mostrar errores en desarrollo:
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    header('Content-Type: application/json');

    // Conexión y controlador
    require_once __DIR__ . '/../models/Database.php';
    $db = (new Database())->getConnection();
    require_once __DIR__ . '/../controllers/ProductController.php';
    $productController = new ProductController();

    // Recoger campos de $_POST
    // NOTA: el front-end debe enviar FormData, no JSON.
    $data = [];
    // Campos obligatorios y opcionales:
    if (isset($_POST['product_code']))   $data['product_code'] = trim($_POST['product_code']);
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
    // Si hay más campos (sale_price, weight...), recoger de la misma forma:
    // if (isset($_POST['sale_price'])) $data['sale_price'] = $_POST['sale_price'];
    // ...

    // Validar campos básicos antes de insertar:
    // Por ejemplo, product_code y product_name no vacíos:
    if (empty($data['product_code']) || empty($data['product_name'])) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'Código y nombre son obligatorios']);
        exit;
    }
    // Validar FK existentes, numéricos, etc., si lo deseas aquí.

    // 1) Insertar sin imagen para obtener product_id
    // En el ProductController puedes tener un método createProductSinImagen que inserte sin image_url.
    // Pero aquí, para simplicidad, usaremos directamente PDO:
    try {
        // Construir SQL dinámico de INSERT sin image_url:
        $fields = ['product_code','product_name','location','price','stock','registration_date','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'];
        $placeholders = [':product_code',':product_name',':location',':price',':stock','NOW()',':category_id',':supplier_id',':unit_id',':currency_id',':subcategory_id',':desired_stock',':status'];
        $values = [
            ':product_code'=>$data['product_code'],
            ':product_name'=>$data['product_name'],
            ':location'=>$data['location'] ?? null,
            ':price'=>$data['price'] ?? null,
            ':stock'=>$data['stock'] ?? null,
            ':category_id'=>$data['category_id'] ?? null,
            ':supplier_id'=>$data['supplier_id'] ?? null,
            ':unit_id'=>$data['unit_id'] ?? null,
            ':currency_id'=>$data['currency_id'] ?? null,
            ':subcategory_id'=>$data['subcategory_id'] ?? null,
            ':desired_stock'=>$data['desired_stock'] ?? null,
            ':status'=>$data['status'] ?? 1,
        ];
        // Nota: si registration_date en BD tiene default CURRENT_TIMESTAMP, no hace falta incluirlo. 
        // Si quieres usar default, quita 'registration_date' de fields y placeholders.
        // Ajusta según tu esquema: si registration_date se define automáticamente, no lo incluyas aquí.
        // Asumiremos que la columna registration_date tiene default NOW(). Entonces:
        // $fields = ['product_code','product_name','location','price','stock','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'];
        // $placeholders = [':product_code',':product_name',':location',':price',':stock',':category_id',':supplier_id',':unit_id',':currency_id',':subcategory_id',':desired_stock',':status'];
        // Y $values igual.

        // Si registration_date auto, usa:
        $fields = ['product_code','product_name','location','price','stock','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'];
        $placeholders = [':product_code',':product_name',':location',':price',':stock',':category_id',':supplier_id',':unit_id',':currency_id',':subcategory_id',':desired_stock',':status'];
        // $values ya definido apropiadamente.

        $sql = "INSERT INTO products (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $db->prepare($sql);
        // Bind de valores:
        $stmt->bindValue(':product_code', $data['product_code'], PDO::PARAM_STR);
        $stmt->bindValue(':product_name', $data['product_name'], PDO::PARAM_STR);
        $stmt->bindValue(':location', $data['location'] ?? null, $data['location']!==null?PDO::PARAM_STR:PDO::PARAM_NULL);
        $stmt->bindValue(':price', $data['price'] !== null ? $data['price'] : null, $data['price']!==null?PDO::PARAM_STR:PDO::PARAM_NULL);
        $stmt->bindValue(':stock', $data['stock'] !== null ? (int)$data['stock'] : null, $data['stock']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':category_id', $data['category_id'] !== null ? (int)$data['category_id'] : null, $data['category_id']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':supplier_id', $data['supplier_id'] !== null ? (int)$data['supplier_id'] : null, $data['supplier_id']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':unit_id', $data['unit_id'] !== null ? (int)$data['unit_id'] : null, $data['unit_id']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':currency_id', $data['currency_id'] !== null ? (int)$data['currency_id'] : null, $data['currency_id']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':subcategory_id', $data['subcategory_id'] !== null ? (int)$data['subcategory_id'] : null, $data['subcategory_id']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':desired_stock', $data['desired_stock'] !== null ? (int)$data['desired_stock'] : null, $data['desired_stock']!==null?PDO::PARAM_INT:PDO::PARAM_NULL);
        $stmt->bindValue(':status', isset($data['status']) ? (int)$data['status'] : 1, PDO::PARAM_INT);

        $stmt->execute();
        $newId = (int)$db->lastInsertId();
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(['success'=>false,'message'=>'Error al insertar producto: '.$e->getMessage()]);
        exit;
    }

    // 2) Procesar imagen subida (si existe)
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image_file']['tmp_name'];
        $originalName = basename($_FILES['image_file']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg','jpeg','png','gif'];
        if (!in_array($ext, $allowedExt)) {
            // Opcionalmente: eliminar el registro recién creado si la imagen es obligatoria
            http_response_code(400);
            echo json_encode(['success'=>false,'message'=>'Extensión de imagen no permitida.']);
            exit;
        }
        $uploadDir = __DIR__ . '/../assets/images/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        // Nombre fijo: product_{id}.{ext}
        $newName = "product_{$newId}.{$ext}";
        $fullPath = $uploadDir . $newName;
        if (!move_uploaded_file($tmp_name, $fullPath)) {
            // Opcional: eliminar registro si no quieres producto sin imagen
            http_response_code(500);
            echo json_encode(['success'=>false,'message'=>'Error al guardar la imagen.']);
            exit;
        }
        // Ruta relativa a guardar en BD:
        $relativePath = 'assets/images/products/' . $newName;
        // Actualizar la fila:
        try {
            $stmtUpd = $db->prepare("UPDATE products SET image_url = :img WHERE product_id = :id");
            $stmtUpd->bindValue(':img', $relativePath, PDO::PARAM_STR);
            $stmtUpd->bindValue(':id', $newId, PDO::PARAM_INT);
            $stmtUpd->execute();
        } catch (PDOException $e) {
            // Fallo al actualizar la ruta en BD; opcional: borrar archivo
            error_log("Error al actualizar image_url: ".$e->getMessage());
        }
    }

    // 3) Recuperar el producto recién creado (incluyendo image_url)
    try {
        $stmt2 = $db->prepare("SELECT * FROM products WHERE product_id = :id");
        $stmt2->bindValue(':id', $newId, PDO::PARAM_INT);
        $stmt2->execute();
        $product = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Si falla, devolvemos al menos success true con ID
        echo json_encode(['success'=>true,'product'=>['product_id'=>$newId]]);
        exit;
    }

    // 4) Responder con el producto completo
    echo json_encode(['success'=>true,'product'=>$product]);
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
