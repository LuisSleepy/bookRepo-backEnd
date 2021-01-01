<?php
$bookIndex =$_GET['bookID'];

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

$deleteQuery = "DELETE FROM books WHERE bookID = $bookIndex";
mysqli_query($sqlconnect, $deleteQuery);

mysqli_close($sqlconnect);
?>