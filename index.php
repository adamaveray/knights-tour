<?php
ini_set('max_execution_time', 60*2);	// Needs a while!

require_once('Board.php');
require_once('Knight.php');
require_once('WarnsdorffKnight.php');

function get_input($name, $fallback = null, $filter = FILTER_VALIDATE_INT){
	$val	= filter_input(INPUT_GET, $name, ($filter === null ? FILTER_SANITIZE_STRING : $filter));
	return (isset($val) && $val !== false) ? $val : $fallback;
}

$width	= get_input('width', 7);
$height	= get_input('height', 7);

$x = get_input('x', 1)-1;	// 0-indexed
$y = get_input('y', 1)-1;	// 0-indexed

$algorithm	= get_input('algorithm', 'warnsdorff', null);
switch($algorithm){
	case 'warnsdorff':
		$knight_class	= '\\WarnsdorffKnight';
		break;

	case 'std':
	default:
		$algorithm	= 'std';
		$knight_class	= '\\Knight';
		break;
}

// Initialise environment
$board	= new \Board($width, $height);
$knight	= new $knight_class($x, $y);

// Solve board
$result	= $knight->solve_board($board);



include('form.php');

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
