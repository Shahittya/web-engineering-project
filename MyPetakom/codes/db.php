<?php 
$host="localhost";
$username="root";
$password="";
$database="MyPetakom";



$conn=new mysqli($host,$username,$password,$database);
if($conn->connect_error){
    die("Cannot Establish Conection".$conn->connect_error);

}
?>
