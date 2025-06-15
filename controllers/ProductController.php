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
        // Validar campos obligatorios
        $required = ['product_code', 'product_name', 'location', 'price', 'stock', 'category_id', 'supplier_id', 'unit_id', 'currency_id', 'subcategory_id'];
        foreach ($required as $field) {
            if (empty($data[$field]) && $data[$field] !== '0') {
                return ['success' => false, 'message' => "Campo '$field' es obligatorio."];
            }
        }
        // Validar tipos numéricos
        if (!is_numeric($data['price']) || !is_numeric($data['stock'])) {
            return ['success' => false, 'message' => "Precio y stock deben ser numéricos."];
        }
        try {
            $sql = "INSERT INTO products 
                (product_code, product_name, location, price, stock, registration_date, category_id, supplier_id, unit_id, currency_id, image_url, subcategory_id, desired_stock, status, sale_price, weight, height, length, width, diameter)
                VALUES
                (:product_code, :product_name, :location, :price, :stock, NOW(), :category_id, :supplier_id, :unit_id, :currency_id, :image_url, :subcategory_id, :desired_stock, :status, :sale_price, :weight, :height, :length, :width, :diameter)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':product_code', $data['product_code']);
            $stmt->bindParam(':product_name', $data['product_name']);
            $stmt->bindParam(':location', $data['location']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
            $stmt->bindParam(':supplier_id', $data['supplier_id'], PDO::PARAM_INT);
            $stmt->bindParam(':unit_id', $data['unit_id'], PDO::PARAM_INT);
            $stmt->bindParam(':currency_id', $data['currency_id'], PDO::PARAM_INT);
            // Opcional: image_url
            $image_url = $data['image_url'] ?? null;
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':subcategory_id', $data['subcategory_id'], PDO::PARAM_INT);
            $desired_stock = $data['desired_stock'] ?? null;
            $stmt->bindParam(':desired_stock', $desired_stock, PDO::PARAM_INT);
            $status = isset($data['status']) ? (int)$data['status'] : 1;
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $sale_price = $data['sale_price'] ?? null;
            $stmt->bindParam(':sale_price', $sale_price);
            $weight = $data['weight'] ?? null;
            $stmt->bindParam(':weight', $weight);
            $height = $data['height'] ?? null;
            $stmt->bindParam(':height', $height);
            $length = $data['length'] ?? null;
            $stmt->bindParam(':length', $length);
            $width = $data['width'] ?? null;
            $stmt->bindParam(':width', $width);
            $diameter = $data['diameter'] ?? null;
            $stmt->bindParam(':diameter', $diameter);

            $stmt->execute();
            $id = $db->lastInsertId();
            // Traer el registro insertado con JOINs
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
            $newProd = $stmt2->fetch(PDO::FETCH_ASSOC);
            return ['success' => true, 'product' => $newProd];
        } catch (\PDOException $e) {
            error_log("Error al crear producto: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear producto.'];
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