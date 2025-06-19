<?php
// controllers/ProductController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Database.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    // Obtener todos los productos (array de arrays asociativos)
    public function getAllProducts()
    {
        return $this->productModel->getAllProducts();
    }

    // Crear un nuevo producto
    // $data: array con claves: product_code, product_name, location, price, stock,
    // category_id, supplier_id, unit_id, currency_id, subcategory_id, desired_stock, status, etc.
    public function createProduct(array $data)
    {
        // Delegamos al modelo Product->createProduct y retornamos su resultado
        return $this->productModel->createProduct($data);
    }

    // Actualizar un producto existente
    // $data: array que debe contener 'product_id' y los demás campos a actualizar
    public function updateProduct(array $data)
    {
        return $this->productModel->updateProduct($data);
    }

    // Eliminar un producto por su ID
    public function deleteProduct(int $productID)
    {
        return $this->productModel->deleteProduct($productID);
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