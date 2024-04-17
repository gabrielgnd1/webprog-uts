<?php

$all_themeData = array();

if(isset($_COOKIE['allData'])) {
    $all_themeData = unserialize($_COOKIE['allData']);
}

// Function to get theme data by theme name
function getThemeData($themeName, $all_themeData) {
    foreach($all_themeData as $themeData) {
        if($themeData['themeName'] === $themeName) {
            return $themeData;
        }
    }
    return null; // Theme not found
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
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
            
            // Set CSS styles inline
            echo "<style>
                    body {
                        background-color: $bgColor;
                    }
                    h1 {
                        color: $h1Color;
                    }
                    p {
                        color: $pColor;
                        font-size: $fontSize;
                        text-align: $alignment;
                    }
                </style>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Main Page</title>
</head>
<body>
    <div id="box1">
        <h1>Project UTS GabReyRam</h1>
        <form method="POST" action="index.php">
            <label for="theme">Theme: </label>
            <select name="theme" id="theme">
                <option value="" disable selected hidden>--Select your theme--</option>
                <?php
                    foreach($all_themeData as $themeData) {
                        echo "<option value='".$themeData['themeName']."'>".$themeData['themeName']."</option>";
                    }
                ?>
            </select>
            <button type="submit" name="choose_theme">Choose the Theme</button>
        </form>
        <form method="POST" action="addnew.php">
            <button type="submit">Add new theme</button>
        </form>
        <form method="POST" action="index.php">
            <button type="submit" name="edit_theme">Edit the theme</button>
        </form>
        <a href="reset.php">Reset</a> <br>
        <hr>
    </div>

    <div id="paragraph">
        <h1>Heading 1</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur maiores ipsam ex ipsum doloribus magni veritatis nemo velit fuga! Odit, fugiat autem facilis delectus aliquid suscipit iusto quisquam pariatur repudiandae ullam voluptatibus, itaque debitis quae rerum ipsa molestias hic rem aperiam laboriosam voluptas a nobis! Impedit pariatur nihil fugit. Expedita itaque dignissimos dolorem blanditiis, aspernatur assumenda maiores hic iure laborum explicabo ipsam molestias atque dolore voluptatum qui doloribus minus. Corporis explicabo asperiores officiis repellendus nam, numquam iure perferendis accusamus, sapiente maxime cupiditate alias quisquam consectetur minus quo dolores at. Consequatur.</p>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos sapiente aspernatur inventore aliquam iusto deleniti natus esse, quam saepe repellendus autem debitis ex odio modi voluptate illum ab excepturi facere eaque fugit quas impedit ipsam. Repudiandae quibusdam, ullam debitis sapiente qui a aspernatur veritatis, blanditiis voluptatum porro, maxime reprehenderit cum!</p>
    </div>
</body>
</html>
