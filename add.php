<?php
include('connection.php');
if(isset($_POST['submit'])){

    if ($_FILES['doc']['name'] == ""){
        $doc = '';
    }else{
        $imgFile = $_FILES['doc']['name'];
        $tmp_dir = $_FILES['doc']['tmp_name'];
        $imgSize = $_FILES['doc']['size'];

        $upload_dir = 'images/';
        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
        $valid_extension = array('jpg', 'jpeg', 'png');
        $doc = $imgFile;
        if(in_array($imgExt,$valid_extension)){
            move_uploaded_file($tmp_dir,$upload_dir . $doc);
        } else{
            $msg = 'ext';
            echo json_encode($msg);
        }
    }
    $f_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email_id = $_POST['email'];
    $c_code = $_POST['country_code'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $hobbies = implode(",", $_POST['hobby']);
    $sql = "INSERT INTO `employee`( `first_name`, `last_name`, `email_id`, `country_code`, `mobile`, `address`, `gender`, `hobbies`, `image`, `created_at`) VALUES ('$f_name','$last_name','$email_id','$c_code','$mobile','$address','$gender','$hobbies','$doc',NOW())";
    $query = mysqli_query($conn,$sql);
    if($query == TRUE){
        echo"<script>
        alert('Employee Added Successfully');
        window.location.href = 'index.php';
        </script>";
    }else{
        echo"<script>
        alert('Failed to Add Employee');
        window.location.href = 'add.php';
        </script>";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>ADD EMPLOYEE</title>
  </head>
  <?php include('header.php'); ?>
<body>
<form action="#" method="POST" enctype="multipart/form-data" style="margin-left: 400px;" id="myForm" onsubmit="validateForm()">
    <h4>Add New Employee</h4>

    <label>First Name</label>
    <input type="text" name="first_name" required><br>

    <label>Last Name</label>
    <input type="text" name="last_name" required><br>

    <label>Email</label>
    <input type="text" name="email" id="email" required>
    <span id="emailError" class="error"></span><br>

    <label>Country Code</label>
    <select name="country_code">
        <option value="+1">+1 (USA)</option>
        <option value="+44">+44 (UK)</option>
        <option value="+91">+91 (INDIA)</option>
    </select>

    <label>Mobile Number:</label>
    <input type="number" name="mobile" id="mobile" required>
    <span id="mobileError" class="error"></span><br>

    <label>Address:</label>
    <textarea name="address" required></textarea><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="Male" required>Male
    <input type="radio" name="gender" value="Female" required>Female<br>

    <label>Hobbies:</label>
    <input type="checkbox" name="hobby[]" value="Reading"> Reading
    <input type="checkbox" name="hobby[]" value="Traveling"> Traveling
    <input type="checkbox" name="hobby[]" value="Cooking"> Cooking
    <input type="checkbox" name="hobby[]" value="Adventure"> Adventure<br>

    <label>Photo:</label>
    <input type="file" name="doc" accept="image/*" ><br>
    
    <button type="submit" name="submit"> Add Employee</button>
</form>
<script>
    function validateEmail(email){
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
    }

    function validateMobile(mobile){
        const mobilePattern = /^\+?\d{10}$/;
        return mobilePattern.test(mobile);
    }

    function validateForm(){
        const email = document.getElementById("email").value.trim();
        const mobile = document.getElementById("mobile").value.trim();

        const emailError = document.getElementById("emailError");
        const mobileError = document.getElementById("mobileError");

        emailError.textContent = "";
        mobileError.textContent = "";

        let isValid = true;

        if(!validateEmail(email)){
            emailError.textContent = "Invalid Email Format Please enter valid Format";
            isValid = false;
        }
        if(!validateMobile(mobile)){
            mobileError.textContent = "Invalid Mobile Number Please enter 10 digit mobile number";
            isValid = false;
        }
        return isValid;

    }
</script>
</body>
</html>