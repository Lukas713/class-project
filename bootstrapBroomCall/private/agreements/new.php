<?php
include_once "../../config.php";
if(!isset($_SESSION[$appID."admin"])){
  header('location:'.$pathAPP.'logout.php');
} 


if(isset($_POST["add"])){

    $error = array(); 
    $error["firstName"] =  inputErrorHandling($_POST, "firstName");
    $error["lastName"] =  inputerrorHandling($_POST, "lastName");
    $error["email"] =  inputErrorHandling($_POST, "email");
    $error["city"] =  inputErrorHandling($_POST, "city");
    $error["adress"] =  inputerrorHandling($_POST, "adress");
    $error["serviceDate"] =  DateErrorHandling($_POST, "serviceDate");

    if($_POST["cleanlevel"] === "0"){
        $error["cleanlevel"] = "Please select the clean level";
    }else {
        $query = $conn->prepare("select count(id) from cleanlevel where id=:id");
        $query ->execute(array(
            "id"=>$_POST["cleanlevel"]
        ));
        $result = $query->fetchColumn(); 
        if($result == 0){
            $error["cleanlevel"] = "rofl"; 
        }
    }


    if($_POST["services"] === "0"){
        $error["services"] = "Please select services";
    }else {
        $query = $conn->prepare("select count(id) from services where id=:id");
        $query ->execute(array(
            "id"=>$_POST["services"]
        ));
        $result = $query->fetchColumn(); 
        if($result == 0){
            $error["services"] = "rofl"; 
        }
    }


    if(empty($error["firstName"]) && empty($error["lastName"]) 
       && empty($error["serviceDate"]) && empty($error["services"])
       && empty($error["city"]) && empty($error["adress"])
       && empty($error["cleanlevel"]) && empty($error["email"]) 
       && $error["serviceDate"] == 0){
            
            try{ //try - catch logic, if breaks in try, deals with exeption in catch

                $conn->beginTransaction();
                $query = $conn->prepare("insert into person(firstName, lastName, email)
                                        values (:firstName, :lastName, :email)");
                $query->execute(array(
                    "firstName" => $_POST["firstName"],
                    "lastName" => $_POST["lastName"],
                    "email" => $_POST["email"]
                ));
    
            
                $personID = $conn->lastInsertId();
                $query = $conn->prepare("insert into users(person) values (:person)");
                
                $query->execute(array(
                    "person"=>$personID
                ));
                $userID = $conn->lastInsertId();

                $query = $conn->prepare("insert into agreement(serviceDate, city, adress, squad, users, cleanlevel, services) values
                (:serviceDate, :city, :adress, :squad, :users, :cleanlevel, :services)");

                $query->execute(array(
                    "serviceDate" => $_POST["serviceDate"],
                    "city"=> $_POST["city"],
                    "adress"=> $_POST["adress"],
                    "users"=> $userID,
                    "cleanlevel" => $_POST["cleanlevel"],
                    "services" => $_POST["services"]
                ));

    
                $conn->commit(); //close beginTransaction()
                header("location: index.php"); 
    
             } catch(PDOexeption $e){
                    $query->rollBack(); 
                }
                
    }
}

?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
  <?php include_once "../../template/head.php"; ?>
  </head>
  <body>

  <?php include_once "../../template/navigation.php"; ?><br>
  <!-- Form for creating new  employee-->
  <div class="container">
  <h3>New agreement</h3><hr>
      <div class="row justify-content-md-center"> 
      <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

        <div class="form-group">
            <label for="firstName">First name</label>
            <input type="text" id="firstName" name="firstName" <?php echo empty($error["firstName"]) ?  'class="form-control"' : ' class="form-control is-invalid" ' ;?>>
            <?php echo empty($error["firstName"])? "" : ' <div class="invalid-feedback"> '.$error["firstName"].'</div>' ;?>
        </div>


        <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" id="lastName" name="lastName" <?php echo empty($error["lastName"])? ' class="form-control" ' : ' class="form-control is-invalid" ' ;?>>
            <?php echo empty($error["lastName"])?  "" : ' <div class="invalid-feedback"> '.$error["lastName"].'</div>' ;?>
        </div>

<div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" <?php echo empty($error["email"])? ' class="form-control" ' : ' class="form-control is-invalid" ' ;?>>
            <?php echo empty($error["email"])?  "" : ' <div class="invalid-feedback"> '.$error["email"].'</div>' ;?>
        </div>


        <div class="form-group">
            <label for="serviceDate">Date</label>
            <input type="date" id="serviceDate" name="serviceDate" <?php echo empty($error["serviceDate"])? ' class="form-control" ' : ' class="form-control is-invalid" ' ;?>>
            <?php echo empty($error["serviceDate"])?  "" : ' <div class="invalid-feedback"> '.$error["serviceDate"].'</div>' ;?>
        </div>


        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" <?php echo empty($error["city"])? ' class="form-control" ' : ' class="form-control is-invalid" ' ;?>>
            <?php echo empty($error["city"])?  "" : ' <div class="invalid-feedback"> '.$error["city"].'</div>' ;?>
        </div>


       <div class="form-group">
            <label for="adress">Adress</label>
            <input type="text" id="adress" name="adress" <?php echo empty($error["adress"])? ' class="form-control" ' : ' class="form-control is-invalid" ' ;?>>
            <?php echo empty($error["adress"])?  "" : ' <div class="invalid-feedback"> '.$error["adress"].'</div>' ;?>
        </div>


        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="cleanlevel">Clean level</label>
                    <select class="form-control <?php if(isset($error["cleanlevel"]))
                    echo ' is-invalid'; ?>" id="cleanlevel" name="cleanlevel">
                        <option value="0">Levels:</option>
                        <?php
                         $query = $conn->prepare("SELECT * from cleanlevel"); 
                         $query->execute();
                         $result = $query->fetchAll(PDO::FETCH_OBJ);
                         foreach($result as $row):?>
                         <option
                         <?php
                              if(isset($_POST["cleanlevel"]) && $_POST["cleanlevel"]==$row->id){
                                 echo ' selected="selected" ';
                              }
                         ?>
                         value="<?php echo $row->id ?>"><?php echo $row->levelName ?></option>  
                         <?php endforeach; ?>
                 </select>
                 <?php  if(isset($error["cleanlevel"])){
                     echo '<div class="invalid-feedback">'.$error["cleanlevel"].'</div>'; 
                 }  ?>
            </div>
                <div class="form-group col-md-4">
                    <label for="services">Service</label>
                    <select class="form-control <?php if(isset($error["services"]))
                    echo ' is-invalid'; ?>" id="services" name="services">
                        <option value="0">Services:</option>
                            <?php
                            $query = $conn->prepare("SELECT * from services");
                            $query->execute(); 
                            $result = $query->fetchAll(PDO::FETCH_OBJ);
                        foreach($result as $row):?>
                            <option 
                            <?php
                                 if(isset($_POST["services"]) && $_POST["services"]==$row->id){
                                    echo ' selected="selected" ';
                                 }
                            ?>
                            value="<?php echo $row->id ?>"><?php echo $row->serviceName.",  ".$row->price." €"; ?></option>  
                            <?php endforeach; ?>
                    </select>
                    <?php  if(isset($error["services"])){
                     echo '<div class="invalid-feedback">'.$error["services"].'</div>'; 
                 }  ?>
                </div>
                
        </div>
        <input type="submit" class="btn btn-primary" value="Submit" name="add">
        <a href="index.php" class="btn btn-danger">Cancel</a>
    </form>
      </div>
  </div>
  <?php include_once "../../template/scripts.php"; ?>

  <?php include_once "../../template/footer.php"; ?>
  
  </body>
</html>
