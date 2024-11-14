<?php
include('connection.php');
$id="";
$f_name="";
$l_name="";
$email="";
$address="";
$c_code="";
$mobile="";
$gender="";
$hobbies="";
if($_SERVER["REQUEST_METHOD"]=='GET'){
    if(!isset($_GET['id'])){
        header("location: index.php");
        exit;
    }
    $id = $_GET['id'];
    $sql = "select * from  employee where id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    while(!$row){
        header("location: index.php");
        exit;
    }

  
    $f_name=$row['first_name'];
    $l_name=$row['last_name'];
    $email=$row['email_id'];
    $address=$row['address'];
    $c_code=$row['country_code'];
    $mobile=$row['mobile'];
    $gender=$row['gender'];
    $hobbie=$row['hobbies'];
    $image=$row['image'];
    $created_at=$row['created_at'];
    $status=$row['status'];

}else{

    $idd = $_POST['e_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email_id = $_POST['email'];
    $country_code = $_POST['country_code'];
    $mobile_no = $_POST['mobile'];
    $Add = $_POST['address'];
    $genders = $_POST['gender'];
    $hobby = implode(",",$_POST['hobby']);
    $status = $_POST['status'];
    $c_at = $_POST['c_date'];
    $existing_image = $_POST['exsting_image'];
    $newImagePath = $existing_image;

    if(isset($_FILES['doc']) && $_FILES['doc']['error'] === UPLOAD_ERR_OK){
        $filesTempPath = $_FILES['doc']['tmp_name'];
        $fileName = $_FILES['doc']['name'];
        $upload_dir = 'images/';
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('img_',true);

        $allowedExt = ['jpg','jpeg','png'];
        if(!in_array(strtolower($fileExt),$allowedExt)){
            die("invalid File Type");

        }
        if(move_uploaded_file($filesTempPath,$upload_dir.$newFileName)){
            if(!empty($existing_image) && file_exists($existing_image)){
                unlink($existing_image);
            }
            $newImagePath = $newFileName;
        }else{
            die("Error Uploading File");
        }
    }

    $sql = "UPDATE `employee` SET `first_name`='$first_name',`last_name`='$last_name',`email_id`='$email_id',`country_code`='$country_code',`mobile`='$mobile_no',`address`='$Add',`gender`='$genders',`hobbies`='$hobby',`image`='$newImagePath',`status`='$status',`created_at`='$c_at',`updated_at`= NOW() WHERE id='$idd'";
    $result = $conn->query($sql);
    // echo $sql;
    if($result == TRUE){
        echo"<script>
        alert('Employee Updated Successfully');
        window.location.href = 'index.php';
        </script>";
    }else{
        echo"<script>
        alert('Failed to Update Employee');
        window.location.href = 'update.php';
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

    <title>UPDATE EMPLOYEE</title>
  </head>
  <?php include('header.php'); ?>
<body>
<form action="#" method="POST" enctype="multipart/form-data" style="margin-left: 400px;" id="myForm" onsubmit="validateForm()">
    <input type="hidden" name="e_id" value="<?php echo $id; ?>">
    <input type="hidden" name="c_date" value="<?php echo $created_at; ?>">
    <input type="hidden" name="exsting_image" value="<?php echo $image; ?>">

    <h4>UPDATE Employee</h4>

    <label>First Name</label>
    <input type="text" name="first_name" value="<?php echo $f_name ?>"><br>

    <label>Last Name</label>
    <input type="text" name="last_name" value="<?php echo $l_name ?>"><br>

    <label>Email</label>
    <input type="text" name="email" id="email" value="<?php echo $email ?>">
    <span id="emailError" class="error"></span><br>

    <label>Country Code</label>
    <select name="country_code">
        <option value="+1" <?php if($c_code == '+1') echo 'selected'; ?>>+1 (USA)</option>
        <option value="+44" <?php if($c_code == '+44') echo 'selected'; ?>>+44 (UK)</option>
        <option value="+91" <?php if($c_code == '+91') echo 'selected'; ?>>+91 (INDIA)</option>
    </select>

    <label>Mobile Number:</label>
    <input type="number" name="mobile" id="mobile" value="<?php echo $mobile ?>">
    <span id="mobileError" class="error"></span><br>

    <label>Address:</label>
    <textarea name="address" ><?php echo $address ?></textarea><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="Male" <?php if($gender == 'Male') echo 'checked'; ?>>Male
    <input type="radio" name="gender" value="Female" <?php if($gender == 'Female') echo 'checked'; ?>>Female<br>

    <label>Hobbies:</label>
    <input type="checkbox" name="hobby[]" value="Reading" <?php if($hobbie== 'Reading') echo 'checked'; ?>> Reading
    <input type="checkbox" name="hobby[]" value="Traveling" <?php if($hobbie== 'Traveling') echo 'checked'; ?>> Traveling
    <input type="checkbox" name="hobby[]" value="Cooking" <?php if($hobbie == 'Cooking') echo 'checked'; ?>> Cooking
    <input type="checkbox" name="hobby[]" value="Adventure" <?php if($hobbie== 'Adventure') echo 'checked'; ?>> Adventure<br>
    <label>Current Image:</label>
    <img src="images/<?php echo $image?>" style="max-width: 50px; max-height:50px"><br>

    <label>Photo:</label>
    <input type="file" name="doc" accept="image/*" ><br>

    <label>Status:</label>
    <label for="status">Select Status</label>
    <select name="status" id="status">
        <option value="0" <?php if($status == '0') echo 'selected'; ?>> ACTIVE</option>
        <option value="1" <?php if($status == '1') echo 'selected'; ?>> DEACTIVE</option>
    </select>
    
    <button type="submit" name="submit"> UPDATE Employee</button>
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