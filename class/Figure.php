<?php

abstract class Figure
{
	private static $types = ['Rook', 'Pawn', 'Knight'];			// массив возможных фигур

	public $id;
	public $type;
	public $coord_x;
	public $coord_y;
	private $_deleted = false;
	
	function __construct()
	{
		$this->id = rand(1,9999);
	}
	
	/*
	 * Устанавливает флаг, что фигура была удалена
	 * 
	 * @return void
	 */
	function setDeleted()
	{
		$this->_deleted = true;
	}

	/*
	 * Возвращает возможые типы фигур
	 * 
	 * @return array
	 */
	public static function getTypes()
	{
		return self::$types;
	}
	
	/*
	 * Проверяет может ли фигура быть перемещена с клетки где находится на запрашиваемую клетку
	 * (можно ли осуществить такой ход)
	 * 
	 * @return boolean
	 */
	abstract function checkMove($x, $y);
}