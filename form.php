<form action="" method="get">
    <fieldset>
        <legend>Board</legend>

        <label for="input_width">Width</label>
        <input id="input_width" name="width" type="number" value="<?php echo $width;?>" />

        <label for="input_height">Height</label>
        <input id="input_height" name="height" type="number" value="<?php echo $height;?>" />
    </fieldset>

    <fieldset>
        <legend>Knight</legend>

        <label for="input_y">Row</label>
        <input id="input_y" name="y" type="number" value="<?php echo $y+1;?>" />

        <label for="input_x">Column</label>
        <input id="input_x" name="x" type="number" value="<?php echo $x+1;?>" />
    </fieldset>

    <fieldset>
		<legend>Algorithm</legend>

        <input id="input_algorithm_std" name="algorithm" type="radio" value="std"<?php if($algorithm == 'std'){ echo ' checked'; }?> />
        <label for="input_algorithm_std">Standard</label>

		<input id="input_algorithm_warnsdorff" name="algorithm" type="radio" value="warnsdorff"<?php if($algorithm == 'warnsdorff'){ echo ' checked'; }?> />
        <label for="input_algorithm_warnsdorff">Warnsdorff</label>
	</fieldset>

	<?php if(!$safe_request){?>
		<p>The board size requested will take the selected algorithm some time to calculate. Are you sure you want to calculate this board?</p>

		<input type="hidden" name="safety" value="off" />
    	<button type="submit">Confirm</button>
	<?php } else {?>
    	<button type="submit">Calculate</button>
	<?php }?>
</form>