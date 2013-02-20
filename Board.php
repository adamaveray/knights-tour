<?php
class Board {
	const OUTPUT_EMPTY	= ' ';
	const OUTPUT_USED	= '.';
	const OUTPUT_KNIGHT	= 'K';

	protected $board;
	protected $width;
	protected $height;
	protected $size;

	public function __construct($width, $height){
		$this->board	= $this->build_board($width, $height);

		$this->width	= $width;
		$this->height	= $height;

		$this->size	= $width*$height;
	}

	protected function build_board($width, $height){
		$board	= array();
		for($y = 0; $y < $height; $y++){
			$board[$y]	= array_pad(array(), $width, false);
		}

		return $board;
	}

	public function position_exists($x, $y){
		if($x < 0 || $y < 0){
			// Out of bounds
			return false;
		}
		if($x >= $this->width || $y >= $this->height){
			// Out of bounds
			return false;
		}

		// Valid position
		return true;
	}

	public function get_state_for_position($x, $y){
		if(!$this->position_exists($x, $y)){
			throw new \OutOfRangeException('Position ['.$x.','.$y.'] does not exist in board of '.$this->width.'x'.$this->height);
		}

		return $this->board[$y][$x];
	}

	public function set_state_for_position($x, $y, $state){
		if(!$this->position_exists($x, $y)){
			throw new \OutOfRangeException('Position ['.$x.','.$y.'] does not exist in board of '.$this->width.'x'.$this->height);
		}

		$this->board[$y][$x]	= $state;
	}

	public function get_size(){
		return $this->size;
	}

	public function is_solved(){
		for($y = 0; $y < $this->height; $y++){
			for($x = 0; $x < $this->width; $x++){
				if($this->board[$y][$x] === false){
					echo "[$y, $x]";
					return false;
				}
			}
		}

		return true;
	}

	public function output_demo($moves){
		$initial	= array_shift($moves);
		$knight	= new \Knight($initial[0], $initial[1]);
		$this->set_state_for_position($initial[0], $initial[1], true);

		echo '1: '.($initial[0]+1).','.($initial[1]+1).PHP_EOL;
		echo $this->build_string($knight);

		foreach($moves as $i => $move){
			echo PHP_EOL.($i+2).': '.($move[0]+1).','.($move[1]+1).PHP_EOL;
			$knight->move_to_position($this, $move[0], $move[1]);
			echo $this->build_string($knight);
		}
	}

	public function build_string($knight = null){
		$knight_position	= isset($knight) ? $knight->get_position() : null;

		$hr		= str_repeat('-', ($this->width * 4)+1).PHP_EOL;

		$string	= '';
		for($y = 0; $y < $this->height; $y++){
			$string .= $hr;
			$string .= '| ';
			for($x = 0; $x < $this->width; $x++){
				if(isset($knight_position) && $knight_position[0] == $x && $knight_position[1] == $y){
					$string	.= self::OUTPUT_KNIGHT;
				} elseif($this->board[$y][$x] === true){
					$string	.= self::OUTPUT_USED;
				} else {
					$string	.= self::OUTPUT_EMPTY;
				}
				$string	.= ' | ';
			}
			$string	.= PHP_EOL;
		}
		$string .= $hr;

		return $string;
	}

	public function __toString(){
		return $this->build_string();
	}
};