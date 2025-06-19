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

    public function getAllProducts()
    {
        // Si quieres hacer JOINs para mostrar nombres de categoría, etc,
        // puedes extender este método. Por simplicidad devolvemos todo.
        return $this->productModel->getAllProducts();
    }

    public function createProduct($data)
    {
        // $data incluye image_url si vino imagen
        return $this->productModel->createProduct($data);
    }

    public function updateProduct($id, $data)
    {
        // $data puede incluir image_url si se subió nueva imagen
        // Ajusta método si tu ProductController recibe distinto parámetro
        // (en el endpoint usamos updateProduct($id, $data)).
        return $this->productModel->updateProduct(array_merge(['product_id'=>$id], $data));
    }

    public function deleteProduct($id)
    {
        return $this->productModel->deleteProduct($id);
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