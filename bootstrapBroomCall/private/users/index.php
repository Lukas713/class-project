<?php 
include_once "../../config.php";
if(!isset($_SESSION[$appID."admin"])){
  header('location:'.$pathAPP.'logout.php');
} 

$pages = 1;
if(isset($_GET["pages"])){
  $pages = $_GET["pages"]; 
}

$query = $conn->prepare("select count(a.id) 
                        from employees a
                        inner join person b 
                        on a.person = b.id"
                      );
$query->execute();
$totalEmployees = $query->fetchColumn();
$totalPages = ceil($totalEmployees / 10); 
if($pages > $totalPages){
  $pages = $totalPages; 
}

if($pages == 0){
  $pages = 1;
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
   $query =  $conn->prepare("select  b.id, a.firstName, a.lastName, a.email, b.phoneNumber, (d.priceCoeficient * e.price) as total
                            from person a 
                            inner join users b on a.id=b.person
                            left outer join agreement c on b.id = c.users
                            left outer join cleanlevel d on d.id = c.cleanlevel
                            left outer join services e on e.id = c.services
                            order by total desc"); 
   $query->execute(); 
   $result = $query->fetchAll(PDO::FETCH_OBJ); 
    
  ?>

 <div class="container">
    <h3>Users</h3><hr>
    <a href="new.php" class="btn btn-success mb-3">Create new</a>

    <table class="table table-striped">
          <thead>
            <tr>
              <th>First name</th>
              <th>Last name</th>
              <th>Email</th>
              <th>Phone number</th>
              <th>Amount spent</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($result as $row): ?>
              <tr>
                <td><?php echo $row->firstName; ?></td>
                <td><?php echo $row->lastName; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->phoneNumber; ?></td>
                <td style="text-align: center;"><?php if($row->total == null){echo "0";} echo $row->total; ?> €</td>
                <td>
                  <a onclick="return confirm('Are you sure?')" href="delete.php?id=<?php echo $row->id; ?>">
                    <i class="fas fa-2x fa-trash-alt text-danger"></i>
                  </a>  
                  <a href="rewrite.php?id=<?php echo $row->id; ?>">
                    <i class="fas fa-2x text-dark fa-edit"></i>
                  </a>
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
