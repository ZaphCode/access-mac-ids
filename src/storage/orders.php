<?php

class OrderStorage
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $orderData)
    {
        $sql = "INSERT INTO orders (user_id, total, products, payment_method, shipping_address, status) 
                VALUES (:user_id, :total, :products, :payment_method, :shipping_address, :status)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':user_id' => $orderData['user_id'],
            ':total' => $orderData['total'],
            ':products' => json_encode($orderData['products']),
            ':payment_method' => $orderData['payment_method'],
            ':shipping_address' => $orderData['shipping_address'],
            ':status' => $orderData['status'] ?? 'pending',
        ]);

        return [
            'id' => $this->pdo->lastInsertId(),
            ...$orderData,
        ];
    }

    public function getFromUserID(int $userId)
    {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($order) {
            $order['products'] = json_decode($order['products'], true);
            return $order;
        }, $orders);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM orders";
        $stmt = $this->pdo->query($sql);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($order) {
            $order['products'] = json_decode($order['products'], true);
            return $order;
        }, $orders);
    }

    // Eliminar una orden por su ID
    public function delete(int $id)
    {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount() > 0; // Devuelve true si se eliminó algo
    }
}
