<?php
include 'pdo.class.php';
$pdo = new myPDO();
$conn = $pdo->conn();
// var_dump($pdo->verify("0001", "123456"));
// var_dump($pdo->select("0001"));
// var_dump($pdo->addmember("1111", "wo", "abcdef", "wojiushiwo"));
// echo $conn->error;
var_dump($pdo->delete('0009'));
var_dump($pdo->affeted_row);
echo "1";

// $pdo->close();