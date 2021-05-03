<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
header("Content-Type: application/json; charset=UTF-8");

$allProducts = json_decode(file_get_contents("./products.json"), true);

renderJson($allProducts);

function renderJson($array) {
    shuffle($array);
    $json = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo $json; 
}