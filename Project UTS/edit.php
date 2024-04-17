<?php
$all_themeData = array();

if(isset($_COOKIE['allData'])) {
    $all_themeData = unserialize($_COOKIE['allData']);
}

// Function to get theme data by theme name
function getThemeData($themeName, $all_themeData) {
    if(is_array($all_themeData)) {
        foreach($all_themeData as $themeData) {
            if(isset($themeData['themeName']) && $themeData['themeName'] === $themeName) {
                return $themeData;
            }
        }
    }
    return null; // Theme not found
}

// Initialize $allInputs as an empty array
$allInputs = array();

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
            'themeName' => $theme,
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

        // Add the new theme data to $all_themeData
        $all_themeData[] = $inputArray;

        // Serialize $all_themeData and store it in the 'allData' cookie
        setcookie('allData', serialize($all_themeData), time() + (60 * 5), '/'); // Cookie expires in 5 minutes
    }

    // Check if a theme is selected
    if(isset($_POST['theme'])) {
        // Get the selected theme data
        $selectedThemeData = getThemeData($_POST['theme'], $all_themeData);
        
        // If theme data exists, apply styles
        if($selectedThemeData) {
            $bgColor = $selectedThemeData['bgColor'];
            $h1Color = $selectedThemeData['h1Color'];
            $pColor = $selectedThemeData['pColor'];
            $alignment = $selectedThemeData['alignment'];
            $fontSize = $selectedThemeData['fontSize'];
        }
    }
}

// Check if a theme is selected for editing
if(isset($_POST['edit_theme'])) {
    $editThemeName = $_POST['theme'];
    // Get the selected theme data
    $editThemeData = getThemeData($editThemeName, $all_themeData);
}

// Update the theme
if(isset($_POST['update'])) {
    $editThemeName = $_POST['theme'];
    // Retrieve input values from the form
    $bgColor = $_POST['bg'];
    $h1Color = $_POST['h1'];
    $alignment = $_POST['align'];
    $pColor = $_POST['p'];
    $fontSize = $_POST['font_size'];

    // Find the index of the theme in $all_themeData array
    $index = array_search($editThemeName, array_column($all_themeData, 'themeName'));
    if($index !== false) {
        // Update the theme data
        $all_themeData[$index]['bgColor'] = $bgColor;
        $all_themeData[$index]['h1Color'] = $h1Color;
        $all_themeData[$index]['alignment'] = $alignment;
        $all_themeData[$index]['pColor'] = $pColor;
        $all_themeData[$index]['fontSize'] = $fontSize;

        // Update the 'allData' cookie
        setcookie('allData', serialize($all_themeData), time() + (60 * 5), '/'); // Cookie expires in 5 minutes

        // Redirect back to test.php after updating theme
        header("Location: test.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Theme</title>
</head>
<body>
    <?php if(isset($editThemeData)): ?>
    <h1>Edit Theme</h1>
    <form method="POST" action="">
        <input type="hidden" name="theme" value="<?php echo $editThemeName; ?>">
        <div>
            <label for="theme_name"> Name of your theme : </label>
            <input type="text" id="theme_name" name="theme_name" value="<?php echo $editThemeData['themeName']; ?>"><br><br>
            <label for="bg_color"> Color of your background : </label>
            <input type="color" id="bg_color" name="bg" value="<?php echo $editThemeData['bgColor']; ?>"><br><br>
            <label for="h1_color"> Color of heading 1 : </label>
            <input type="color" id="h1_color" name="h1" value="<?php echo $editThemeData['h1Color']; ?>"><br><br>
            <label for="alignment"> Allignment for heading 1 </label>
            <select name="align" id="align">
                <option value="def">--Choose the alignment--</option>
                <option value="left" <?php if($editThemeData['alignment'] === 'left') echo 'selected'; ?>>left</option>
                <option value="right" <?php if($editThemeData['alignment'] === 'right') echo 'selected'; ?>>right</option>
                <option value="center" <?php if($editThemeData['alignment'] === 'center') echo 'selected'; ?>>center</option>
                <option value="justify" <?php if($editThemeData['alignment'] === 'justify') echo 'selected'; ?>>justify</option>
            </select><br><br>
            <label for="p_color"> Color of paragraph : </label>
            <input type="color" id="p_color" name="p" value="<?php echo $editThemeData['pColor']; ?>"><br><br>
            <label for="font"> Font size of paragraph : </label>
            <input type="text" id="font_size" name="font_size" value="<?php echo $editThemeData['fontSize']; ?>"><br><br>

            <button type="submit" name="update">Update Theme</button>
        </div>
    </form>
    <?php endif; ?>
</body>
</html>
