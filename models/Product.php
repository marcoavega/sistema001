<?php
// models/Product.php

require_once __DIR__ . '/../config/config.php';

class Product {
    private $db;

    public function __construct(){
        require_once __DIR__ . '/Database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllProducts(): array {
        try {
            $stmt = $this->db->query("
                SELECT 
                    product_id,
                    product_code,
                    barcode,
                    product_name,
                    product_description,
                    location,
                    price,
                    stock,
                    registration_date,
                    category_id,
                    supplier_id,
                    unit_id,
                    currency_id,
                    image_url,
                    subcategory_id,
                    desired_stock,
                    status,
                    sale_price,
                    weight,
                    height,
                    length,
                    width,
                    diameter
                FROM products
                ORDER BY product_id DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Product::getAllProducts Error: " . $e->getMessage());
            return [];
        }
    }

    public function getProductById(int $id): ?array {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    product_id,
                    product_code,
                    barcode,
                    product_name,
                    product_description,
                    location,
                    price,
                    stock,
                    registration_date,
                    category_id,
                    supplier_id,
                    unit_id,
                    currency_id,
                    image_url,
                    subcategory_id,
                    desired_stock,
                    status,
                    sale_price,
                    weight,
                    height,
                    length,
                    width,
                    diameter
                FROM products
                WHERE product_id = :id
                LIMIT 1
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product !== false ? $product : null;
        } catch (PDOException $e) {
            error_log("Product::getProductById Error: " . $e->getMessage());
            return null;
        }
    }

    public function createProduct(array $data): array {
        // Validaciones básicas
        $required = ['product_code', 'barcode', 'product_name', 'product_description', 'location', 'price', 'stock', 'category_id', 'supplier_id', 'unit_id', 'currency_id', 'subcategory_id'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                return ['success' => false, 'message' => "El campo '$field' es obligatorio."];
            }
        }
        try {
            $sql = "
                INSERT INTO products (
                    product_code, barcode, product_name, product_description, location, price, stock,
                    registration_date, category_id, supplier_id, unit_id, currency_id,
                    image_url, subcategory_id, desired_stock, status, sale_price,
                    weight, height, length, width, diameter
                ) VALUES (
                    :product_code, :barcode, :product_name, :product_description, :location, :price, :stock,
                    NOW(), :category_id, :supplier_id, :unit_id, :currency_id,
                    :image_url, :subcategory_id, :desired_stock, :status, :sale_price,
                    :weight, :height, :length, :width, :diameter
                )
            ";
            $stmt = $this->db->prepare($sql);

            // Bind requeridos
            $stmt->bindParam(':product_code', $data['product_code'], PDO::PARAM_STR);
            $stmt->bindParam(':barcode', $data['barcode'], PDO::PARAM_STR);
            $stmt->bindParam(':product_name', $data['product_name'], PDO::PARAM_STR); 
            $stmt->bindParam(':product_description', $data['product_description'], PDO::PARAM_STR);
            $stmt->bindParam(':location', $data['location'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
            $stmt->bindParam(':supplier_id', $data['supplier_id'], PDO::PARAM_INT);
            $stmt->bindParam(':unit_id', $data['unit_id'], PDO::PARAM_INT);
            $stmt->bindParam(':currency_id', $data['currency_id'], PDO::PARAM_INT);
            $stmt->bindParam(':subcategory_id', $data['subcategory_id'], PDO::PARAM_INT);

            // Bind opcionales con valor por defecto o NULL
            $image_url = $data['image_url'] ?? null;
            $stmt->bindParam(':image_url', $image_url, $image_url !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $desired_stock = $data['desired_stock'] ?? null;
            $stmt->bindParam(':desired_stock', $desired_stock, $desired_stock !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);

            $status = isset($data['status']) ? (int)$data['status'] : 1;
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);

            $sale_price = $data['sale_price'] ?? null;
            $stmt->bindParam(':sale_price', $sale_price, $sale_price !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $weight = $data['weight'] ?? null;
            $stmt->bindParam(':weight', $weight, $weight !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $height = $data['height'] ?? null;
            $stmt->bindParam(':height', $height, $height !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $length = $data['length'] ?? null;
            $stmt->bindParam(':length', $length, $length !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $width = $data['width'] ?? null;
            $stmt->bindParam(':width', $width, $width !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $diameter = $data['diameter'] ?? null;
            $stmt->bindParam(':diameter', $diameter, $diameter !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);

            $stmt->execute();
            $newId = (int)$this->db->lastInsertId();
            $created = $this->getProductById($newId);
            return ['success' => true, 'product' => $created];
        } catch (PDOException $e) {
            error_log("Product::createProduct Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear producto: ' . $e->getMessage()];
        }
    }

    public function updateProduct(array $data): array {
        if (!isset($data['product_id']) || !is_numeric($data['product_id'])) {
            return ['success' => false, 'message' => 'product_id es obligatorio para actualización.'];
        }
        $id = (int)$data['product_id'];

        // Construir dinámicamente campos a actualizar
        $fields = [];
        $allowed = [
            'product_code', 'barcode', 'product_name', 'product_description', 'location', 'price', 'stock',
            'category_id', 'supplier_id', 'unit_id', 'currency_id',
            'image_url', 'subcategory_id', 'desired_stock', 'status',
            'sale_price', 'weight', 'height', 'length', 'width', 'diameter'
        ];
        foreach ($allowed as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
            }
        }
        if (empty($fields)) {
            return ['success' => false, 'message' => 'No hay campos para actualizar.'];
        }
        $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE product_id = :product_id";
        try {
            $stmt = $this->db->prepare($sql);
            // Bind dinámico
            foreach ($allowed as $field) {
                if (array_key_exists($field, $data)) {
                    $value = $data[$field];
                    if (in_array($field, ['stock','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'])) {
                        $stmt->bindValue(":$field", $value !== null ? (int)$value : null, $value !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
                    } else {
                        $stmt->bindValue(":$field", $value !== null ? $value : null, $value !== null ? PDO::PARAM_STR : PDO::PARAM_NULL);
                    }
                }
            }
            $stmt->bindValue(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $updated = $this->getProductById($id);
            return ['success' => true, 'product' => $updated];
        } catch (PDOException $e) {
            error_log("Product::updateProduct Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar producto: ' . $e->getMessage()];
        }
    }

    public function deleteProduct(int $id): array {
    try {
        // 1) Obtener ruta de la imagen
        $stmtImg = $this->db->prepare("SELECT image_url FROM products WHERE product_id = :id");
        $stmtImg->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtImg->execute();
        $row = $stmtImg->fetch(PDO::FETCH_ASSOC);
        if ($row && !empty($row['image_url'])) {
            $imageUrl = $row['image_url']; // e.g. 'assets/images/products/product_12.jpg'
            // Construir ruta absoluta: asumiendo que este archivo está en project_root/models/Product.php
            $absolutePath = __DIR__ . '/../' . $imageUrl;
            if (file_exists($absolutePath) && is_writable($absolutePath)) {
                if (!@unlink($absolutePath)) {
                    error_log("Product::deleteProduct: fallo al eliminar imagen: $absolutePath");
                }
            } else {
                error_log("Product::deleteProduct: imagen no encontrada o no escribible: $absolutePath");
            }
        }
        // 2) Borrar registro
        $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $executed = $stmt->execute();
        if ($executed) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'No se pudo eliminar el producto de la BD.'];
        }
    } catch (PDOException $e) {
        error_log("Product::deleteProduct Error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error al eliminar producto: ' . $e->getMessage()];
    }
}

}
