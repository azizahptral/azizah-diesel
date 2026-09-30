<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') die('Request tidak valid.');
$token = $_POST['csrf_token'] ?? '';
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) die('CSRF token tidak valid.');

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) die('ID produk tidak valid.');

$pdo->prepare('DELETE FROM products WHERE id = ?')->execute([$id]);

header('Location: index.php');
exit;