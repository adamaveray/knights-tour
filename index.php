<?php
ini_set('max_execution_time', 60*2);	// Needs a while!

require_once('Board.php');
require_once('Knight.php');
require_once('WarnsdorffKnight.php');

$width	= 5;
$height	= 6;

$x = 0;
$y = 0;

// Initialise environment
$board	= new \Board($width, $height);
$knight	= new \WarnsdorffKnight($x, $y);

// Solve board
$result	= $knight->solve_board($board);

// Show results
$iterations	= $knight->get_iterations();
$iterations_line	= '(tried '.$iterations.' '.($iterations == 1 ? 'move' : 'moves').')';
if($result === false){
	echo 'Could not solve board '.$iterations_line;
} else {
	echo 'Solved board '.$iterations_line.PHP_EOL.PHP_EOL;
	$demo_board	= new \Board($width, $height);

	?><pre><?php
	$demo_board->output_demo($result);
	?></pre><?php
}
