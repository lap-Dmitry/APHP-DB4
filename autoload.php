<?php

function load($className)
{
    $path = '.' . DIRECTORY_SEPARATOR . $className . '.php';
    if (is_file($path)) {
        require_once ($path);
    } else {
        echo "Файл не найден";
    }
}

spl_autoload_register('load');