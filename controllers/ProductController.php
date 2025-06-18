<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Database.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    // Obtener todos los productos con datos relacionados (JOINs según disponibilidad)
    public function getAllProducts()
    {
        $dbInstance = new Database();
        $pdo = $dbInstance->getConnection();
        try {
            // Ajustar columnas y JOINs según tu esquema de categorías, proveedores, etc.
            $sql = "SELECT 
               *
            FROM products p
           
            ORDER BY p.product_id DESC";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error al obtener productos: " . $e->getMessage());
            return [];
        }
    }

    // Crear un nuevo producto
   public function createProduct($data)
{
    $db = (new Database())->getConnection();
    // Validaciones básicas: por ejemplo, product_code y product_name no vacíos
    if (empty($data['product_code']) || empty($data['product_name'])) {
        return ['success' => false, 'message' => 'Código y nombre de producto son obligatorios'];
    }
    // Más validaciones: price y stock numéricos, category_id existe, etc.
    // Por ejemplo:
    if (isset($data['price']) && !is_numeric($data['price'])) {
        return ['success'=>false, 'message'=>'Precio inválido'];
    }
    if (isset($data['stock']) && !is_numeric($data['stock'])) {
        return ['success'=>false, 'message'=>'Stock inválido'];
    }
    // Completar con los campos opcionales: category_id, supplier_id, unit_id, currency_id, subcategory_id, desired_stock, status, sale_price, weight, height, length, width, diameter, image_url, etc.
    // Preparar la consulta:
    $fields = [];
    $placeholders = [];
    $values = [];
    // Campo obligatorio:
    $fields[] = 'product_code'; $placeholders[] = ':product_code'; $values[':product_code'] = $data['product_code'];
    $fields[] = 'product_name'; $placeholders[] = ':product_name'; $values[':product_name'] = $data['product_name'];
    // Opcionales:
    if (isset($data['location'])) {
        $fields[] = 'location'; $placeholders[] = ':location'; $values[':location'] = $data['location'];
    }
    if (isset($data['price'])) {
        $fields[] = 'price'; $placeholders[] = ':price'; $values[':price'] = $data['price'];
    }
    if (isset($data['stock'])) {
        $fields[] = 'stock'; $placeholders[] = ':stock'; $values[':stock'] = $data['stock'];
    }
    if (isset($data['category_id'])) {
        $fields[] = 'category_id'; $placeholders[] = ':category_id'; $values[':category_id'] = $data['category_id'];
    }
    if (isset($data['supplier_id'])) {
        $fields[] = 'supplier_id'; $placeholders[] = ':supplier_id'; $values[':supplier_id'] = $data['supplier_id'];
    }
    if (isset($data['unit_id'])) {
        $fields[] = 'unit_id'; $placeholders[] = ':unit_id'; $values[':unit_id'] = $data['unit_id'];
    }
    if (isset($data['currency_id'])) {
        $fields[] = 'currency_id'; $placeholders[] = ':currency_id'; $values[':currency_id'] = $data['currency_id'];
    }
    if (isset($data['subcategory_id'])) {
        $fields[] = 'subcategory_id'; $placeholders[] = ':subcategory_id'; $values[':subcategory_id'] = $data['subcategory_id'];
    }
    if (isset($data['desired_stock'])) {
        $fields[] = 'desired_stock'; $placeholders[] = ':desired_stock'; $values[':desired_stock'] = $data['desired_stock'];
    }
    if (isset($data['status'])) {
        $fields[] = 'status'; $placeholders[] = ':status'; $values[':status'] = $data['status'];
    }
    if (isset($data['sale_price'])) {
        $fields[] = 'sale_price'; $placeholders[] = ':sale_price'; $values[':sale_price'] = $data['sale_price'];
    }
    if (isset($data['weight'])) {
        $fields[] = 'weight'; $placeholders[] = ':weight'; $values[':weight'] = $data['weight'];
    }
    if (isset($data['height'])) {
        $fields[] = 'height'; $placeholders[] = ':height'; $values[':height'] = $data['height'];
    }
    if (isset($data['length'])) {
        $fields[] = 'length'; $placeholders[] = ':length'; $values[':length'] = $data['length'];
    }
    if (isset($data['width'])) {
        $fields[] = 'width'; $placeholders[] = ':width'; $values[':width'] = $data['width'];
    }
    if (isset($data['diameter'])) {
        $fields[] = 'diameter'; $placeholders[] = ':diameter'; $values[':diameter'] = $data['diameter'];
    }
    // Si manejas imagen subida, tendrías que procesar archivo aparte; aquí asumimos image_url ya en $data:
    if (isset($data['image_url'])) {
        $fields[] = 'image_url'; $placeholders[] = ':image_url'; $values[':image_url'] = $data['image_url'];
    }

    // Armar SQL dinámico:
    $sql = "INSERT INTO products (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute($values);
        $newId = $db->lastInsertId();
        // Leer el registro insertado:
        $query = $db->prepare("SELECT * FROM products WHERE product_id = :id");
        $query->bindParam(':id', $newId, PDO::PARAM_INT);
        $query->execute();
        $product = $query->fetch(PDO::FETCH_ASSOC);
        return ['success'=>true, 'product'=>$product];
    } catch (PDOException $e) {
        error_log("Error al crear producto: ".$e->getMessage());
        return ['success'=>false, 'message'=>'Error al insertar producto: '.$e->getMessage()];
    }
}

    // Actualizar producto existente
    public function updateProduct($data)
    {
        if (empty($data['product_id']) || !is_numeric($data['product_id'])) {
            return ['success' => false, 'message' => 'product_id inválido'];
        }
        $db = (new Database())->getConnection();
        $id = (int)$data['product_id'];
        // Construir update dinámico según campos presentes
        $fields = [];
        $params = [];
        $allowed = [
            'product_code', 'product_name', 'location', 'price', 'stock',
            'category_id', 'supplier_id', 'unit_id', 'currency_id', 'image_url',
            'subcategory_id', 'desired_stock', 'status', 'sale_price',
            'weight', 'height', 'length', 'width', 'diameter'
        ];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }
        if (empty($fields)) {
            return ['success' => false, 'message' => 'No hay datos para actualizar.'];
        }
        try {
            $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE product_id = :product_id";
            $stmt = $db->prepare($sql);
            foreach ($params as $field => $value) {
                // Tipo de binding: si campos numéricos, forzar
                if (in_array($field, ['stock','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'])) {
                    $stmt->bindValue(':'.$field, (int)$value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':'.$field, $value);
                }
            }
            $stmt->bindValue(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            // Traer registro actualizado con JOINs (mismo SELECT que en create)
            $stmt2 = $db->prepare("SELECT 
                p.product_id,
                p.product_code,
                p.product_name,
                p.location,
                p.price,
                p.stock,
                p.registration_date,
                p.image_url,
                p.category_id,
                c.name AS category_name,
                p.supplier_id,
                s.name AS supplier_name,
                p.unit_id,
                u.name AS unit_name,
                p.currency_id,
                m.code AS currency_code,
                p.subcategory_id,
                sc.name AS subcategory_name,
                p.desired_stock,
                p.status,
                p.sale_price,
                p.weight,
                p.height,
                p.length,
                p.width,
                p.diameter
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
            LEFT JOIN units u ON p.unit_id = u.unit_id
            LEFT JOIN currencies m ON p.currency_id = m.currency_id
            LEFT JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id
            WHERE p.product_id = :product_id");
            $stmt2->bindParam(':product_id', $id, PDO::PARAM_INT);
            $stmt2->execute();
            $updated = $stmt2->fetch(PDO::FETCH_ASSOC);
            return ['success' => true, 'product' => $updated];
        } catch (\PDOException $e) {
            error_log("Error al actualizar producto: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar producto.'];
        }
    }

    // Eliminar producto
    public function deleteProduct($productID)
    {
        $db = (new Database())->getConnection();
        try {
            $stmt = $db->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $productID, PDO::PARAM_INT);
            $stmt->execute();
            return ['success' => true];
        } catch (\PDOException $e) {
            error_log("Error al eliminar producto: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar producto.'];
        }
    }
}


/*
 // Ajustar columnas y JOINs según tu esquema de categorías, proveedores, etc.
            $sql = "SELECT 
                p.product_id,
                p.product_code,
                p.product_name,
                p.location,
                p.price,
                p.stock,
                p.registration_date,
                p.image_url,
                p.category_id,
                c.name AS category_name,
                p.supplier_id,
                s.name AS supplier_name,
                p.unit_id,
                u.name AS unit_name,
                p.currency_id,
                m.code AS currency_code,
                p.subcategory_id,
                sc.name AS subcategory_name,
                p.desired_stock,
                p.status,
                p.sale_price,
                p.weight,
                p.height,
                p.length,
                p.width,
                p.diameter
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
            LEFT JOIN units u ON p.unit_id = u.unit_id
            LEFT JOIN currencies m ON p.currency_id = m.currency_id
            LEFT JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id
            ORDER BY p.product_id DESC";
            */