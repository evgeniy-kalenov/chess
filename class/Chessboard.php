<?php

class Chessboard
{
	private static $instance;

	private $condition = [
		'a' => [],
		'b' => [],
		'c' => [],
		'd' => [],
		'e' => [],
		'f' => [],
		'g' => [],
		'h' => [],
	];

	private function __construct(){}

	public static function init()
	{
		return empty(self::$instance) ? new ChessBoard() : self::$instance;
	}

	/*
	 * Возращает текущее состояние доски
	 */
	public function getCondition()
	{
		return $this->condition;
	}
	
	/*
	 * Загружает состояние доски из файла
	 * 
	 * @param json
	 */
	public function import($condition)
	{
		$data = json_decode($condition);
		$this->condition = $data;
	}

	/*
	 * Выгружает состояние доски в файл/хранилище
	 */
	public function export()
	{
		$data = json_encode($this->condition);
		/* TODO */
	}

	/*
	 * Создает фигуру на доске
	 *
	 * @param string $type
	 * @param string $x
	 * @param integer $y
	 *
	 * @return mixed
	 */
	public function createFigure($type, $x, $y)
	{
		$type_key = array_search($type, Figure::getTypes());
		if($type_key !== false){
			$class_name = Figure::getTypes()[$type_key] . 'Figure';
			if(class_exists($class_name)){
				$figure = new $class_name;
				$figure->type = $type;
				$figure->coord_x = $x;
				$figure->coord_y = $y;
				if($this->moveFigure($figure, $x, $y)){
					return $figure;
				}
			}
		}
		return false;
	}

	/*
	 * Удаляет фигуру с доски
	 *
	 * @param Figure
	 *
	 * @return boolean
	 */
	public function deleteFigure($figure)
	{
		if(array_key_exists($figure->coord_y, $this->condition[$figure->coord_x])){
			$figure_data = $this->condition[$figure->coord_x][$figure->coord_y];
			if(is_array($figure_data) && $figure_data['id'] == $figure->id){
				$figure->setDeleted();
				unset($this->condition[$figure->coord_x][$figure->coord_y]);
			}
		}
	}

	/*
	 * Передвигает фигуру по доске
	 *
	 * @param Figure
	 * @param string $x
	 * @param integer $y
	 *
	 * @return boolean
	 */
	public function moveFigure($figure, $x, $y)
	{
		if($this->checkSpace($x, $y) && $figure->checkMove($x, $y)){
			$figure->coord_x = $x;
			$figure->coord_y = $y;
			$this->condition[$figure->coord_x][$figure->coord_y] = [
				'type' => $figure->type,
				'id' => $figure->id
			];
			return true;
		}
		return false;
	}

	/*
	 * Проверяет клетку доски на пустоту
	 *
	 * @param string $x
	 * @param integer $y
	 *
	 * @return boolean
	 */
	public function checkSpace($x, $y)
	{
		if(array_key_exists($x, $this->condition) && $y <= 7){
			if(empty($this->condition[$x][$y])){
				return true;
			}
		}
		return false;
	}
}