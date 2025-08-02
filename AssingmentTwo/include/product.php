<?php
require_once 'database.php';

class product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(string $name, string $description, float $price,?string $image = null, int|string $created_by): bool
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, image, created_by) VALUES (:name, :description, :price, :image, :created_by)");
        return $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':image' => $image,
            ':created_by' => $created_by]);
    }

    public function readAll(?string $name = null): array
    {
        if ($name !== null) {
            $sql = "SELECT products.*, users.username FROM products 
                LEFT JOIN users ON products.created_by = users.id
                WHERE products.name LIKE :name 
                ORDER BY products.created_by DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':name' => "%$name%"]);
        } else {
            $sql = "SELECT products.*, users.username FROM products 
                LEFT JOIN users ON products.created_by = users.id
                ORDER BY products.created_by DESC";
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByID(int $id): ?array {
                $sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':id' => $id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result === false ? null : $result;
    }

    public function update(int $id, string $name, string $description, float $price, string $image = null): bool {
        try {
            if ($image !== null) {
                $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
                return $stmt->execute([$name, $description, $price, $image, $id]);
            } else {
                $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
                return $stmt->execute([$name, $description, $price, $id]);
            }
        } catch (PDOException $e) {
            return false;
        }
    }


    public function delete(int $id):bool {
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
