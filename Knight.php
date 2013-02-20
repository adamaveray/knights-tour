<?php
class Knight {
	protected $x;
	protected $y;
	protected $moves;

	protected $iterations;

	public function __construct($initial_x, $initial_y){
		$this->x	= $initial_x;
		$this->y	= $initial_y;

		$this->moves	= array(
			array(-2,-1),
			array(-2,1),
			array(2,-1),
			array(2,1),
			array(-1,-2),
			array(-1,2),
			array(1,-2),
			array(1,2)
		);
	}

	public function get_position(){
		return array($this->x, $this->y);
	}

	public function solve_board(\Board $board){
		if(!$board->position_exists($this->x, $this->y)){
			throw new \InvalidArgumentException('Board does not have position ['.$this->x.','.$this->y.']');
		}

		$this->iterations	= 0;
		$moves	= array();
		$result	= $this->solve_step($board, $moves, $this->x, $this->y);
		if(!$result){
			return false;
		}

		return $moves;
	}

	protected function solve_step(\Board $board, &$moves, $x, $y){
		$this->iterations++;

		$moves[]	= array($x, $y);
		$board->set_state_for_position($x, $y, true);

		$this->x	= $x;
		$this->y	= $y;

		if(count($moves) == $board->get_size()){
			// Solved
			return true;
		}

		$next_steps	= $this->find_next_steps($board);
		foreach($next_steps as $step){
			$result	= $this->solve_step($board, $moves, $step[0], $step[1]);
			if($result){
				return true;
			}
		}

		// No valid moves - undo
		$board->set_state_for_position($x, $y, false);
		array_pop($moves);
		$this->x	= $x;
		$this->y	= $y;

		return false;
	}

	protected function find_next_steps(\Board $board){
		$steps	= array();
		foreach($this->moves as $move){
			$x	= $this->x + $move[0];
			$y	= $this->y + $move[1];

			if(!$board->position_exists($x, $y) || $board->get_state_for_position($x, $y) === true){
				// Invalid position
				continue;
			}

			$steps[]	= array($x, $y);
		}

		return $steps;
	}


	public function move_to_position(\Board $board, $x, $y, $validate = true){
		if($validate){
			$valid	= false;
			foreach($this->moves as $move){
				if($this->x + $move[0] == $x && $this->y + $move[1] == $y){
					$valid = true;
					break;
				}
			}

			if(!$board->position_exists($x, $y) || $board->get_state_for_position($x, $y) === true){
				$valid = false;
			}

			if(!$valid){
				throw new \Exception('Invalid move (['.$this->x.','.$this->y.'] -> ['.$x.','.$y.'])');
			}
		}

		$board->set_state_for_position($x, $y, true);

		$this->x	= $x;
		$this->y	= $y;
	}

	public function get_iterations(){
		return $this->iterations;
	}
};