<?php 
include_once "../../config.php";
if(!isset($_SESSION[$appID."operater"])){
  header('location:'.$pathAPP.'logout.php');
} 

?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
  <?php include_once "../../template/head.php"; ?>
  </head>
  <body>

  <?php include_once "../../template/navigation.php"; ?><br>

    <!-- prepare sql query, execute, fetch as object and display the result  -->
  <?php
   $query =  $conn->prepare("select b.firstName, b.lastName, b.email, a.phoneNumber, d.depName
                              from employees a 
                              inner join person b on a.person = b.id
                              inner join department d on a.department = d.id"); 
   $query->execute(); 
   $result = $query->fetchAll(PDO::FETCH_OBJ); 
    
  ?>

 <div class="container">
    <h3>Employees</h3><hr>
    <a href="new.php" class="btn btn-success mb-3">Create new</a>

    <table class="table">
          <thead>
            <tr>
              <th>First name</th>
              <th>Last name</th>
              <th>Email</th>
              <th>Phone number</th>
              <th>Department</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($result as $row): ?>
              <tr>
                <td><?php echo $row->firstName; ?></td>
                <td><?php echo $row->lastName; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->phoneNumber; ?></td>
                <td><?php echo $row->depName; ?></td>
                <td>
                  <a onclick="return confirm('Delete -><?php echo $row->serviceName; ?>?')" href="delete.php?id=<?php echo $row->id; ?>">
                  <i class="fas fa-2x fa-trash-alt text-danger"></i>
                </a>  
                  <a href="rewrite.php?id=<?php echo $row->id; ?>"><i class="fas fa-2x text-dark fa-edit"></i></a>
                </td>
              </tr>
          <?php endforeach; ?>
          </tbody>
      </table>
</div>
    <?php include_once "../../template/scripts.php"; ?>

    <?php include_once "../../template/footer.php"; ?>
  
  </body>
</html>