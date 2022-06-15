<?php

declare(strict_types=1);

namespace Order;

use DatabaseWrapper\DatabaseWrapper;

class Order implements DatabaseWrapper
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
        [$created_at, $shop, $customer] = $tableColumns;
        $this->sql = "INSERT INTO 'order' ($created_at, $shop, $customer) values (?, ?)";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from 'order'") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function update(int $id, array $values): array
    {
        $this->sql = "UPDATE 'order' SET created_at=?, shop=?, customer=? WHERE id = $id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from 'order'") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function find(int $id): array
    {
        $this->sql = "SELECT * from 'order' WHERE id = $id";
        foreach($this->pdo->query($this->sql) as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM 'order' WHERE id = :id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
