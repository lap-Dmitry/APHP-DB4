<?php

declare(strict_types=1);

namespace OrderProduct;

use DatabaseWrapper\DatabaseWrapper;

class OrderProduct implements DatabaseWrapper
{
    public object $pdo;
    public array $arr;
    public string $sql;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(array $tableColumns, array $values): array
    {
        [$order, $product, $price] = $tableColumns;
        $this->sql = "INSERT INTO order_product ($order, $product, $price) values (?, ?)";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from order_product") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function update(int $id, array $values): array
    {
        $this->sql = "UPDATE order_product SET 'order'=?, product=?, price=? WHERE id = $id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from order_product") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function find(int $id): array
    {
        $this->sql = "SELECT * from order_product WHERE id = $id";
        foreach($this->pdo->query($this->sql) as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM order_product WHERE id = :id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
