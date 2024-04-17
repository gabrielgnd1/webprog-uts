<?php
    // Initialize $allInputs as an empty array
    $allInputs = array();

    // Check if the form has been submitted
    if(isset($_POST['submit'])) {
        // Retrieve input values from the form
        $theme = $_POST['theme'];
        $bgColor = $_POST['bg'];
        $h1Color = $_POST['h1'];
        $alignment = $_POST['align'];
        $pColor = $_POST['p'];
        $fontSize = $_POST['font_size'];

        // Construct an array containing the input values
        $inputArray = array(
            'theme' => $theme,
            'bgColor' => $bgColor,
            'h1Color' => $h1Color,
            'alignment' => $alignment,
            'pColor' => $pColor,
            'fontSize' => $fontSize
        );

        // Check if the 'inputs' cookie exists
        if(isset($_COOKIE['inputs'])) {
            // Unserialize the existing cookie value and assign it to $allInputs
            $allInputs = unserialize($_COOKIE['inputs']);
        }

        // Append the new input array to $allInputs
        $allInputs[] = $inputArray;

        // Serialize $allInputs and store it in the 'inputs' cookie
        setcookie('inputs', serialize($allInputs), time() + (60 * 5), '/'); // Cookie expires in 5 minutes

        // Output the contents of $allInputs for debugging purposes
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new theme</title>
</head>
<body>
        <form  method="POST" action = "test.php">
        <div>
            <label for="theme_name"> Name of your theme : </label>
            <input type="text" id="theme_name" name="theme"><br><br>
            <label for="bg_color"> Color of your background : </label>
            <input type="color" id="bg_color" name="bg"><br><br>
            <label for="h1_color"> Color of heading 1 : </label>
            <input type="color" id="h1_color" name="h1"><br><br>
            <label for="alignment"> Allignment for heading 1 </label>
            <select name="align" id = "align">
                <option value = "def">--Choose the alignment--</option>
                <option value = "left">left</option>
                <option value = "right">right</option>
                <option value = "center">center</option>
                <option value = "justify">justify</option>

            </select><br><br>
            <label for="p_color"> Color of paragraph : </label>
            <input type="color" id="p_color" name="p"><br><br>
            <label for="font"> Font size of paragraph : </label>
            <input type="text" id="font_size" name="font_size"><br><br>

            <input type="submit" name="submit" value="Send">
        </div>
        </form>
        





</body>
</html>