<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adding Book Testing</title>
</head>
<body>

<form action="searchBook.php" method="get">
    <label for="Category"></label>
    <select id="Category" name="Category" class="form-control">
        <option value="Title">Title</option>
        <option value="ISBN">ISBN</option>
        <option value="Author">Author</option>
        <option value="Series">Series</option>
        <option value="PubHouse">Publisher</option>
        <option value="Country">Country</option>
    </select>
    <label for="Keywords"></label>
    <input type="text" id="Keywords" name="Keywords" placeholder="Input keywords here" size="100">
    <input type="submit" id="Submit" value="Search Book">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $detailsList = array('Title', 'ISBN', 'Author', 'Cover', 'Abstract', 'Series', 'PubHouse', 'PubDate', 'Country',
        'DatePosted');

    // Check if the user already pressed "Search book" submit button
    if (isset($_GET['Category']) & isset($_GET['Keywords'])) {
        $category = $_GET['Category'];
        $keywords = $_GET['Keywords'];

        //Connection to SQL
        $sqlconnect = mysqli_connect('localhost','root','');
        if(!$sqlconnect){
            die();
        }

        //Database init
        $selectDB = mysqli_select_db($sqlconnect,'bookrepo');
        if(!$selectDB){
            die("Database not connected." . mysqli_error());
        }

        $searchQuery = "SELECT * FROM books WHERE $category LIKE '%$keywords%';";
        $results = mysqli_query($sqlconnect, $searchQuery);

        // Testing of the search output
        while ($arr = mysqli_fetch_array($results)) {
            for ($i = 0; $i < 10; $i++) {
                echo $arr[$detailsList[$i]];
                echo "<br>";
            }
            echo "-----------------------------------------------";
            echo "<br>";
        }
    }
}
?>
</body>
</html>
