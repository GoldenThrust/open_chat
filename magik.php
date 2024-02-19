<?php
function camelToSnake(string $camel): string
{
    $snake = [];
    for ($i = 0; $i < strlen($camel); $i++) {
        if (ord($camel[$i]) >= 65 && ord($camel[$i]) <= 90 && $i != 0) {
            array_push($snake, '_');
        }
        array_push($snake, strtolower($camel[$i]));
    }

    return implode($snake);
}

if ($argc > 1) {
    print(camelToSnake($argv[1]));
}
