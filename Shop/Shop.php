<?php

declare(strict_types=1);

namespace Shop;

use DatabaseWrapper\DatabaseWrapper;

class Shop implements DatabaseWrapper
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
        [$name, $address] = $tableColumns;
        $this->sql = "INSERT INTO shop ($name, $address) values (?, ?)";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from shop") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function update(int $id, array $values): array
    {
        $this->sql = "UPDATE shop SET name=?, address=? WHERE id = $id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute($values);
        foreach ($this->pdo->query("SELECT * from shop") as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function find(int $id): array
    {
        $this->sql = "SELECT * from shop WHERE id = $id";
        foreach($this->pdo->query($this->sql) as $row) {
            $this->arr[] = $row;
            print_r($row);
        }
        return $this->arr;
    }

    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM shop WHERE id = :id";
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}