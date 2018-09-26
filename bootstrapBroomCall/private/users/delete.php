<?php 
include_once "../../config.php";
if(!isset($_SESSION[$appID."admin"])){
  header('location:'.$pathAPP.'logout.php');
} 

if(!isset($_GET["id"])){
    header("location: " . $pathAPP . "logout.php");
  }

  

   try{ //try - catch logic, if breaks in try, deals with exeption in catch

        $conn->beginTransaction();

        $query = $conn->prepare("select person from users where id = :id");
        $query->execute($_GET);
        $personID = $query->fetchColumn();

     
        $query = $conn->prepare("delete from users where id = :id");
        $query->execute($_GET);

        $query = $conn->prepare("delete from person where id = :id");
        $query->execute(array(
            "id"=>$personID
        ));

        $conn->commit(); //close beginTransaction() 
   } catch(PDOexeption $e){
       $query->rollBack(); 
   }

   header("location: index.php");
?>

