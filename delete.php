<?php
include('connection.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM `employee` WHERE id = $id";
    $result = $conn->query($sql);
    if($result == TRUE){
        echo"<script>
        alert('Employee Deleted Successfully');
        window.location.href = 'index.php';
        </script>";
    }else{
        echo"<script>
        alert('Failed to Delete');
        window.location.href = 'index.php';
        </script>";
    }
}
?>