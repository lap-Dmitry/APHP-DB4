<?php

declare(strict_types=1);

namespace Customer;

use DatabaseWrapper\DatabaseWrapper;

class Customer implements DatabaseWrapper
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
        [$name, $phone] = $tableColumns;
        $this->sql = "INSERT INTO customer ($name, $phone) values (?, ?)";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query('SELECT * from customer') as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function update(int $id, array $values): array
    {
        $this->sql = "UPDATE customer SET name=?, phone=? WHERE id = $id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query('SELECT * from customer') as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function find(int $id): array
    {
        $this->sql = "SELECT * from customer WHERE id = $id";
        foreach($this->pdo->query($this->sql) as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM customer WHERE id = :id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}