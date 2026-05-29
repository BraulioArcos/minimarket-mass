<?php
declare(strict_types=1);
require_once 'clases/Producto.php';

// Crear el objeto
$incaKola = new Producto();

// Asignar valores a sus propiedades con el operador ->
$incaKola->codigo = 'INC500';
$incaKola->nombre = 'Inca Kola 500ml';
$incaKola->precio = 3.50;
$incaKola->stock  = 48;

// Leer las propiedades igual: con ->
echo $incaKola->nombre;   // Inca Kola 500ml
echo $incaKola->precio;   // 3.5
?>