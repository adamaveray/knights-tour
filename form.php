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

    <button type="submit">Calculate</button>
</form>