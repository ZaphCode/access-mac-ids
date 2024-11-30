
<?php

class ProductStorage
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createProduct($name, $price, $description, $image_src, $category, $rating, $stock)
    {
        $sql = "INSERT INTO products (name, price, description, image_src, category, rating, stock) 
                VALUES (:name, :price, :description, :image_src, :category, :rating, :stock)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description,
            ':image_src' => $image_src,
            ':category' => $category,
            ':rating' => $rating,
            ':stock' => $stock
        ]);
        $id = $this->pdo->lastInsertId();

        return $id;
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $name, $price, $description, $image_src, $category, $rating, $stock)
    {
        $sql = "UPDATE products 
                SET name = :name, price = :price, description = :description, 
                    image_src = :image_src, category = :category, rating = :rating, stock = :stock 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':description' => $description,
            ':image_src' => $image_src,
            ':category' => $category,
            ':rating' => $rating,
            ':stock' => $stock,
            ':id' => $id
        ]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>