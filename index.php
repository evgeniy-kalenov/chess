<?php

function __autoload($class_name){
	include "class/$class_name.php";
}

$chessboard = Chessboard::init();

$figure = $chessboard->createFigure('Rook', 'b', 5);
$figure2 = $chessboard->createFigure('Rook', 'a', 2);
$figure3 = $chessboard->createFigure('Rook', 'f', 3);

$chessboard->deleteFigure($figure2);

echo '<pre>';
print_r($chessboard->getCondition());