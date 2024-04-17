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

        // Append the new input array to $allInputs
        $allInputs[] = $inputArray;

        // Check if the 'inputs' cookie exists
        if(isset($_COOKIE['inputs'])) {
            // Unserialize the existing cookie value and assign it to $allInputs
            $allInputs = unserialize($_COOKIE['inputs']);
        }

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Main Page</title>
    <style>
        <?php if(isset($bgColor)) echo "body { background-color: $bgColor; }"; ?>
        <?php if(isset($h1Color)) echo "h1 { color: $h1Color; }"; ?>
        <?php if(isset($pColor)) echo "#paragraph p { color: $pColor; }"; ?>
        <?php if(isset($fontSize)) echo "#paragraph p { font-size: $fontSize; }";?>
       
        <?php if(isset($alignment)) echo "#paragraph p { text-align: $alignment; }"; ?>
    </style>
</head>
<body>
    <div id="box1">
        <h1>Project UTS GabReyRam</h1>
        <form method="POST" action="test.php">
            <label for="theme">Theme: </label>
            <select name="theme" id="theme">
                <option value="" disable hidden>--Select your theme--</option>
                <?php
                    // Loop through each theme in $all_themeData and add it as an option
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
        <form method="POST" action="edit.php">
            <input type="hidden" name="theme" value="<?php echo isset($_POST['theme']) ? $_POST['theme'] : ''; ?>">
            <button type="submit" name="edit_theme">Edit the theme</button>
        </form>
        <a href="reset.php">Reset</a> <br>
        <hr>
    </div>

    <div id="paragraph">
        <h1>Heading 1</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur maiores ipsam ex ipsum doloribus magni veritatis nemo velit fuga! Odit, fugiat autem facilis delectus aliquid suscipit iusto quisquam pariatur repudiandae ullam voluptatibus, itaque debitis quae rerum ipsa molestias hic rem aperiam laboriosam voluptas a nobis! Impedit pariatur nihil fugit. Expedita itaque dignissimos dolorem blanditiis, aspernatur assumenda maiores hic iure laborum explicabo ipsam molestias atque dolore voluptatum qui doloribus minus. Corporis explicabo asperiores officiis repellendus nam, numquam iure perferendis accusamus, sapiente maxime cupiditate alias quisquam consectetur minus quo dolores at. Consequatur.</p>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos sapiente aspernatur inventore aliquam iusto deleniti natus esse, quam saepe repellendus autem debitis ex odio modi voluptate illum ab excepturi facere eaque fugit quas impedit ipsam. Repudiandae
    </div>
</body>
</html>
