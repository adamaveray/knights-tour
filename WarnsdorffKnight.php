<?php
class WarnsdorffKnight extends Knight {
	protected function find_next_steps(\Board $board){
		// Calculate distances to center
		$dimensions	= $board->get_dimensions();
		$width_center	= ($dimensions['width']-1)/2;
		$height_center	= ($dimensions['height']-1)/2;

		$steps	= array();
		foreach($this->moves as $move){
			$x	= $this->x + $move[0];
			$y	= $this->y + $move[1];

			if(!$board->position_exists($x, $y) || $board->get_state_for_position($x, $y) === true){
				// Invalid position
				continue;
			}

			$step	= array($x, $y);

			// Count available next moves
			$next_moves	= 0;
			foreach($this->moves as $submove){
				$next_x	= $x + $submove[0];
				$next_y	= $y + $submove[1];

				if(($next_x == $this->x && $next_y == $this->y) || !$board->position_exists($next_x, $next_y) || $board->get_state_for_position($x, $y) === true){
					// Invalid position
					continue;
				}

				$next_moves++;
			}
			$step['moves']	= $next_moves;

			// Measure distance to center
			$distance_x	= abs($width_center - $x);
			$distance_y	= abs($height_center - $y);
			$step['distance']	= sqrt(pow($distance_x, 2) + pow($distance_y, 2));

			$steps[]	= $step;
		}

		usort($steps, function($a, $b){
			if($a['moves'] == $b['moves']){
				// Equal number of moves - compare distances
				if($a['distance'] == $b['distance']){
					return 0;
				}
				return ($a['distance'] < $b['distance']) ? -1 : 1;
			}

			return ($a['moves'] < $b['moves']) ? -1 : 1;
		});

		return $steps;
	}
};