<?php
// models/Product.php

require_once __DIR__ . '/../config/config.php';

class Product {
    /**
     * @var PDO
     */
    private $db;

    public function __construct(){
        require_once __DIR__ . '/Database.php';
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Obtiene todos los productos.
     * @return array Lista de productos (cada elemento es array asociativo).
     */
    public function getAllProducts(): array {
        try {
            $stmt = $this->db->query("
                SELECT 
                    product_id,
                    product_code,
                    product_name,
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

    /**
     * Obtiene un producto por su ID.
     * @param int $id
     * @return array|null Retorna el producto como array asociativo o null si no existe.
     */
    public function getProductById(int $id): ?array {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    product_id,
                    product_code,
                    product_name,
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

    /**
     * Crea un nuevo producto.
     * @param array $data Array con claves:
     *   - product_code, product_name, location, price, stock,
     *     category_id, supplier_id, unit_id, currency_id, subcategory_id,
     *   - desired_stock (opcional), status (opcional), sale_price, weight, height, length, width, diameter, image_url (opcional).
     * @return array Resultado: ['success'=>bool, 'product'=>array|null, 'message'=>string?]
     */
    public function createProduct(array $data): array {
        // Validaciones básicas de campos obligatorios
        $required = ['product_code', 'product_name', 'location', 'price', 'stock', 'category_id', 'supplier_id', 'unit_id', 'currency_id', 'subcategory_id'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '' || $data[$field] === null) {
                return [
                    'success' => false,
                    'message' => "El campo '$field' es obligatorio."
                ];
            }
        }
        try {
            $sql = "
                INSERT INTO products (
                    product_code, product_name, location, price, stock,
                    registration_date, category_id, supplier_id, unit_id, currency_id,
                    image_url, subcategory_id, desired_stock, status, sale_price,
                    weight, height, length, width, diameter
                ) VALUES (
                    :product_code, :product_name, :location, :price, :stock,
                    NOW(), :category_id, :supplier_id, :unit_id, :currency_id,
                    :image_url, :subcategory_id, :desired_stock, :status, :sale_price,
                    :weight, :height, :length, :width, :diameter
                )
            ";
            $stmt = $this->db->prepare($sql);

            // Bind requeridos
            $stmt->bindParam(':product_code', $data['product_code'], PDO::PARAM_STR);
            $stmt->bindParam(':product_name', $data['product_name'], PDO::PARAM_STR);
            $stmt->bindParam(':location', $data['location'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
            $stmt->bindParam(':supplier_id', $data['supplier_id'], PDO::PARAM_INT);
            $stmt->bindParam(':unit_id', $data['unit_id'], PDO::PARAM_INT);
            $stmt->bindParam(':currency_id', $data['currency_id'], PDO::PARAM_INT);
            $stmt->bindParam(':subcategory_id', $data['subcategory_id'], PDO::PARAM_INT);

            // Bind opcionales con valor por defecto si no vienen
            // image_url
            if (isset($data['image_url'])) {
                $stmt->bindParam(':image_url', $data['image_url'], PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':image_url', null, PDO::PARAM_NULL);
            }
            // desired_stock
            if (isset($data['desired_stock']) && $data['desired_stock'] !== '') {
                $stmt->bindParam(':desired_stock', $data['desired_stock'], PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':desired_stock', null, PDO::PARAM_NULL);
            }
            // status (por defecto 1)
            $status = isset($data['status']) ? (int)$data['status'] : 1;
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            // sale_price
            if (isset($data['sale_price']) && $data['sale_price'] !== '') {
                $stmt->bindParam(':sale_price', $data['sale_price']);
            } else {
                $stmt->bindValue(':sale_price', null, PDO::PARAM_NULL);
            }
            // weight
            if (isset($data['weight']) && $data['weight'] !== '') {
                $stmt->bindParam(':weight', $data['weight']);
            } else {
                $stmt->bindValue(':weight', null, PDO::PARAM_NULL);
            }
            // height
            if (isset($data['height']) && $data['height'] !== '') {
                $stmt->bindParam(':height', $data['height']);
            } else {
                $stmt->bindValue(':height', null, PDO::PARAM_NULL);
            }
            // length
            if (isset($data['length']) && $data['length'] !== '') {
                $stmt->bindParam(':length', $data['length']);
            } else {
                $stmt->bindValue(':length', null, PDO::PARAM_NULL);
            }
            // width
            if (isset($data['width']) && $data['width'] !== '') {
                $stmt->bindParam(':width', $data['width']);
            } else {
                $stmt->bindValue(':width', null, PDO::PARAM_NULL);
            }
            // diameter
            if (isset($data['diameter']) && $data['diameter'] !== '') {
                $stmt->bindParam(':diameter', $data['diameter']);
            } else {
                $stmt->bindValue(':diameter', null, PDO::PARAM_NULL);
            }

            $stmt->execute();
            $newId = (int)$this->db->lastInsertId();

            // Obtener el producto recién creado
            $created = $this->getProductById($newId);
            return [
                'success' => true,
                'product' => $created
            ];
        } catch (PDOException $e) {
            error_log("Product::createProduct Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al crear producto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Actualiza un producto existente.
     * @param array $data Debe incluir 'product_id' (int) y el resto de campos a actualizar.
     * @return array Resultado: ['success'=>bool, 'product'=>array|null, 'message'=>string?]
     */
    public function updateProduct(array $data): array {
        if (!isset($data['product_id']) || !is_numeric($data['product_id'])) {
            return ['success' => false, 'message' => 'product_id es obligatorio para actualización.'];
        }
        $id = (int)$data['product_id'];

        // Construir dinámicamente campos a actualizar
        $fields = [];
        $allowed = [
            'product_code', 'product_name', 'location', 'price', 'stock',
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
                    // Campos enteros/nulos
                    if (in_array($field, ['stock','category_id','supplier_id','unit_id','currency_id','subcategory_id','desired_stock','status'])) {
                        if ($value === '' || $value === null) {
                            $stmt->bindValue(":$field", null, PDO::PARAM_NULL);
                        } else {
                            $stmt->bindValue(":$field", (int)$value, PDO::PARAM_INT);
                        }
                    } else {
                        // Strings o decimales
                        if ($value === '' || $value === null) {
                            $stmt->bindValue(":$field", null, PDO::PARAM_NULL);
                        } else {
                            $stmt->bindValue(":$field", $value, PDO::PARAM_STR);
                        }
                    }
                }
            }
            $stmt->bindValue(':product_id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener actualizado
            $updated = $this->getProductById($id);
            return [
                'success' => true,
                'product' => $updated
            ];
        } catch (PDOException $e) {
            error_log("Product::updateProduct Error: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al actualizar producto: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina un producto por su ID.
     * @param int $id
     * @return array ['success'=>bool, 'message'=>string?]
     */
    public function deleteProduct(int $id): array {
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $executed = $stmt->execute();
            if ($executed) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'No se pudo eliminar el producto.'];
            }
        } catch (PDOException $e) {
            error_log("Product::deleteProduct Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar producto: ' . $e->getMessage()];
        }
    }
}
