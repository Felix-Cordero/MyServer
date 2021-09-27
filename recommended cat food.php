<?php
$servername = "127.0.0.1";
$username = "iydbyrse_Felix";
$password = "felix123!@#";
$dbname = "iydbyrse_wp1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
echo "Server Localhost connection Problem !";
?>
<!Doctype html>
<html>
<head>
<title>Cat Food</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
    box-sizing: border-box;
}
html,body {
    margin: 0;
    padding: 0;
}
.main-container {
    overflow: auto;
}
.product:nth-child(even) {
    background-color: rgb(240,240,240);
}
.product:nth-child(odd) {
    background-color: rgb(250,250,250);
}
.product {
    min-height: 60vh;
    margin: 8px 0;
    padding: 0;
    overflow: auto;
}
.product p {
    margin: 0;
    padding: 0;
}
.product-name {
    padding: 8px;
    text-align: center;
}
.image-container img {
    width: 50%;
    display: block;
    margin: auto;
    background-color: transparent;
}
.image-container {
    padding: 16px;
}   
.modal {
    width: 100%;
    height: 100%;
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(0,0,0,0.8);
    overflow: auto;
    z-index: 1;
}
.details {
    width: 50%;
    margin: 2% auto;
    display: block;
    background-color: white;
}
.details p {
    margin: 0;
    padding: 8px;
    font-size: 1.2em;
}
.details p:nth-child(even) {
    background-color: rgb(250,250,250);
}
.showButton {
    padding: 8px;
    margin: 0;
}
.showButton button {
    padding: 12px 14px;
    margin: 0 auto;
    display: block;
    border: none;
    background-color: lightblue;
    cursor: pointer;
}
.close {
    margin-right: 8px;
    float: right;
    color: white;
    font-size: 2em;
    cursor: pointer;
}
.backButton {
    width: 80px;
    overflow: auto;
}
.backButton a {
    padding: 14px 16px;
    display: block;
    background-color: lightgray;
    text-align: center;
    color: black;
    text-decoration: none;
}
[class*="col-"] {
	width: 100%;
	float: left;
}
@media only screen and (min-width: 768px) {
	.col-1 {width: 8.33%;}
	.col-2 {width: 16.66%;}
	.col-3 {width: 25%;}
	.col-4 {width: 33.33%;}
	.col-5 {width: 41.66%;}
	.col-6 {width: 50%;}
	.col-7 {width: 58.33%;}
	.col-8 {width: 66.66%;}
	.col-9 {width: 75%;}
	.col-10 {width: 83.33%;}
	.col-11 {width: 91.66%;}
	.col-12 {width: 100%;}
}
</style>
</head>
<body>

<div class="main-container">
	<div class="col-12" style="text-align:center;">
		<h1>Cat Food Recommendations</h1>
	</div>
	<?php displayIngredients(); ?>
</div>

<script>
function showDetails(n) {
	var modal = document.getElementsByClassName("modal");
	if (modal[n].style.display == "block") {
		modal[n].style.display = "none";
	} else {
		modal[n].style.display = "block";
	}
}

function closeDetails(n) {
	var modal = document.getElementsByClassName("modal");
	if (modal[n].style.display == "block") {
		modal[n].style.display = "none";
	} else {
		modal[n].style.display = "block";
	}
}
</script>
</body>
</html>

<?php
function productId() {
    static $i = -1;
    $i = $i + 1;
    return $i;
}
function productCloseId() {
    static $j = -1;
    $j = $j + 1;
    return $j;
}
function displayIngredients() {
    if (!empty($_POST["food"])) {
        $value = $_POST["food"];
        $food = "WHERE Food_Ingredients NOT LIKE '%$value[0]%'";
        $len = count($_POST["food"]);
        for ($i = 1; $i < $len; $i++) {
            $food .= " AND Food_Ingredients NOT LIKE '%$value[$i]%'";
        }
    } else {
        $food = "";
    }
    
    global $conn;
    $sql = "SELECT * FROM cat_food_recommendation " . $food . " LIMIT 15";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product col-4'>";
                echo "<div class='image-container col-12'>";
                    echo "<img src='images/img_icon.png' alt='dog food image'>";
                echo "</div>";
                echo "<div class='product-name col-12'>";
                    echo "<p>" . $row["Food_Name"] . "</p>";
                echo "</div>";
                echo "<div class='showButton col-12'>";
                    echo "<button onclick='showDetails(" . productId() . ")'>Learn More</button>";
                echo "</div>";
                echo "<div class='modal' id='" . $row["ID"] . "'>";
                    echo "<span class='close' onclick='closeDetails(" . productCloseId() . ")'>×</span>";
                    echo "<div style='max-width:500px; margin:auto;'>";
                        echo "<div class='details col-12'>";
                            echo "<p>Product No: " . $row["ID"] . "</p>";
                            echo "<p>Food Name: " . $row["Food_Name"] . "</p>";
                            echo "<p>Food Brand: " . $row["Food_Brand"] . "</p>";
                            echo "<p>Link: <a href='" . $row["URL_To_Purchase"] . "'>" . $row["URL_To_Purchase"] . "</a></p>";
                            echo "<p>Food Type: " . $row["Food_Type"] . "</p>";
                            echo "<p>First Ingredients: " . $row["First_Ingredients"] . "</p>";
                            echo "<p>Food Ingredients: " . $row["Food_Ingredients"] . "</p>";
                            echo "<p>Puppy Age: " . $row["Puppy_Age"] . "</p>";
                            echo "<p>Crude Protein: " . $row["Crude_Protein"] . "</p>";
                            echo "<p>Crude Fat: " . $row["Crude_Fat"] . "</p>";
                            echo "<p>Crude Fiber: " . $row["Crude_Fiber"] . "</p>";
                            echo "<p>Moisture: " . $row["Moisture"] . "</p>";
                            echo "<p>Ash: " . $row["Ash"] . "</p>";
                            echo "<p>Calcium: " . $row["Calcium"] . "</p>";
                            echo "<p>Phosphorus: " . $row["Phosphorus"] . "</p>";
                            echo "<p>Omega 6 Fatty Acids: " . $row["Omega_6_Fatty_Acids"] . "</p>";
                            echo "<p>Omega 3 Fatty Acids: " . $row["Omega_3_Fatty_Acids"] . "</p>";
                            echo "<p>DHA: " . $row["DHA"] . "</p>";
                            echo "<p>EPA: " . $row["EPA"] . "</p>";
                            echo "<p>Glucosamine: " . $row["Glucosamine"] . "</p>";
                            echo "<p>Chondroitin: " . $row["Chondroitin"] . "</p>";
                            echo "<p>Calorie: " . $row["Calorie"] . "</p>";
                            echo "<p>Bacillus Coagulan: " . $row["Bacillus_Coagulan"] . "</p>";
                            echo "<p>Lactobacillus Acidophilus: " . $row["Lactobacillus_Acidophilus"] . "</p>";
                            echo "<p>Vitamin E: " . $row["Vitamin_E"] . "</p>";
                            echo "<p>Zinc: " . $row["Zinc"] . "</p>";
                            echo "<p>Vitamin C: " . $row["Vitamin_C"] . "</p>";
                            echo "<p>Selenium: " . $row["Selenium"] . "</p>";
                            echo "<p>Billion: " . $row["Billion"] . "</p>";
                            echo "<p>Taurine: " . $row["Taurine"] . "</p>";
                            echo "<p>Vitamin A: " . $row["Vitamin_A"] . "</p>";
                            echo "<p>Vitamin D: " . $row["Vitamin_D"] . "</p>";
                            echo "<p>Thiamin B1: " . $row["Thiamin_B1"] . "</p>";
                            echo "<p>Niacin B3: " . $row["Niacin_B3"] . "</p>";
                            echo "<p>Choline: " . $row["Choline"] . "</p>";
                            echo "<p>Folic Acid: " . $row["Folic_Acid"] . "</p>";
                            echo "<p>Biotin: " . $row["Biotin"] . "</p>";
                            echo "<p>Iodine: " . $row["Iodine"] . "</p>";
                            echo "<p>Copper: " . $row["Copper"] . "</p>";
                            echo "<p>L Carnitine: " . $row["L_Carnitine"] . "</p>";
                            echo "<p>Cellulase: " . $row["Cellulase"] . "</p>";
                            echo "<p>Magnesium: " . $row["Magnesium"] . "</p>";
                            echo "<p>Sugars: " . $row["Sugars"] . "</p>";
                            echo "<p>Dietary Starch: " . $row["Dietary_Starch"] . "</p>";
                            echo "<p>Manganese: " . $row["Manganese"] . "</p>";
                            echo "<p>Beta Carotene: " . $row["Beta_Carotene"] . "</p>";
                            echo "<p>Microorganism: " . $row["Microorganism"] . "</p>";
                            echo "<p>Iron: " . $row["Iron"] . "</p>";
                            echo "<p>Sodium: " . $row["Sodium"] . "</p>";
                            echo "<p>Potassium: " . $row["Potassium"] . "</p>";
                            echo "<p>Carbohydrates: " . $row["Carbohydrates"] . "</p>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
    }
}
?>