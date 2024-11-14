<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>VIEW EMPLOYEE</title>
  </head>
  <?php include('header.php'); ?>
<body>
<table class="table table-bordered" style="margin-top: 10px;">
<thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">NAME</th>
        <th scope="col">EMAIL</th>
        <th scope="col">MOBILE</th>
        <th scope="col">ADDRESS</th>
        <th scope="col">GENDER</th>
        <th scope="col">HOBBIES</th>
        <th scope="col">IMAGES</th>
        <th scope="col">STATUS</th>
        <th scope="col">ACTION</th>
    </tr>
</thead>
<tbody>
    <?php
    include('connection.php');
    $sql = "select * from employee";
    $result = $conn->query($sql);
    if(!$result){
        die("invalid query!");
    }
    while($row=$result->fetch_assoc()){
        echo "<tr>
        <th scope='row'>$row[id]</th>
        <td>$row[first_name] $row[last_name]</td>";
        echo "<td>$row[email_id]</td>";
        echo "<td>$row[country_code] $row[mobile]</td>";
        echo "<td>$row[address]</td>";
        echo "<td>$row[gender]</td>";
        echo "<td>$row[hobbies]</td>";
        echo "<td><img src='images/$row[image]' alt='Employee Image' style='height: 50px; width: 50px;'></td>";
        if($row['status'] == '0'){
            echo "<td> ACTIVE </td>";
        }else{
            echo "<td> DEACTIVE </td>";
        }
        echo "<td><a class='btn btn-success' href='update.php?id=$row[id]'>EDIT</a><a class='btn btn-danger' href='delete.php?id=$row[id]'>DELETE</a></td>
        </tr>";
    }
    ?>
</tbody>

</table>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>