<?php

declare(strict_types=1);

use Customer\Customer;
use Order\Order;
use OrderProduct\OrderProduct;
use Product\Product;
use Shop\Shop;

include_once './autoload.php';

$pdo = new PDO("sqlite:bd4.sqlite");

$Customer = new Customer($pdo);
$Order = new Order($pdo);
$OrderProduct = new OrderProduct($pdo);
$Product = new Product($pdo);
$Shop = new Shop($pdo);

$Product->find(2);
$Customer->update(2, ['Иван Петров', '89008005050']);
$Shop->insert(['name', 'address'], ['Эльдорадо', 'Самара']);
$Shop->delete(6);
