<?php

declare(strict_types=1);

namespace Product;

use DatabaseWrapper\DatabaseWrapper;

class Product implements DatabaseWrapper
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
        [$name, $price, $count] = $tableColumns;
        $this->sql = "INSERT INTO product ($name, $price, $count) values (?, ?)";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from product") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function update(int $id, array $values): array
    {
        $this->sql = "UPDATE product SET name=?, price=?, count=? WHERE id = $id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from product") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function find(int $id): array
    {
        $this->sql = "SELECT * from product WHERE id = $id";
        foreach($this->pdo->query($this->sql) as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM product WHERE id = :id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}