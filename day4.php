<?php
session_start();
// define variables and set to empty values
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = cleanAnyInput($_POST["name"]);
  $email = cleanAnyInput($_POST["email"]);
  $password = cleanAnyInput($_POST["password"]);
  $address = cleanAnyInput($_POST["address"]);
  $linkedin = cleanAnyInput($_POST["linkedin"]);
  $image = cleanAnyInput($_POST["image"]);
  $gender = cleanAnyInput($_POST["gender"]);


  # Validate Name
  if (empty($name)) {
    $errors['Name'] = "Field Required";
  }

  # Validate Email 
  if (empty($email)) {
    $errors['Email'] = "Field Required";
  } elseif ((filter_var($email, FILTER_VALIDATE_EMAIL)) == false) {
    $errors['Email'] = "check email format";
  }

  # Validate Password 
  if (empty($password)) {
    $errors['Password'] = "Field Required";
  } elseif (strlen($password) < 6) {
    $errors['Password'] = "Length must be = 6 chars";
  }


  //validate address
  if (empty($address)) {
    $errors['address'] = "Field Required";
  } elseif (strlen($address) < 10) {
    $errors['address'] = "Length must beequal to or  more than 10 chars";
  }
  //validate linkedin
  $linkedin === strstr($linkedin, "linkedin");
  if (empty($linkedin)) {
    $errors['linkedin'] = "Field Required";
  } elseif (strstr($linkedin, "linkedin") === false) {
    $errors['linkedin'] = "check linkedin format";
  }
  // } elseif ((filter_var($linkedin, FILTER_VALIDATE_URL)) == false) {
  //   $errors['linkedin'] = "check linkedin format";
  // }
  if (!empty($_FILES['image']['name'])) {

    $imgName     = $_FILES['image']['name'];
    $imgTempPath = $_FILES['image']['tmp_name'];
    $imagSize    = $_FILES['image']['size'];
    $imgType     = $_FILES['image']['type'];


    $imgExtensionDetails = explode('.', $imgName);
    $imgExtension        = strtolower(end($imgExtensionDetails));

    $allowedExtensions   = ['png', 'jpg', 'gif', 'JPEG'];

    if (in_array($imgExtension, $allowedExtensions)) {


      $finalName = rand() . time() . '.' . $imgExtension;

      $disPath = './photos/' . $finalName;

      if (move_uploaded_file($imgTempPath, $disPath)) {
        echo 'Image Uploaded';
      } else {
        echo 'Error Try Again';
      }
    } else {
      echo 'Extension Not Allowed';
    }
  } else {
    echo 'Image Field Required';
  }

  # Validate gender
  if (!empty($gender)) {
    $gender = "female";
  }

  if (count($errors) > 0) {
    foreach ($errors as $key => $value) {

      echo '* ' . $key . ' : ' . $value . '<br>';
    }
  } else {

    $_SESSION['name']  = $name;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['address'] = $address;
    $_SESSION['image'] = $image;
    $_SESSION['linkedin'] = $linkedin;
    $_SESSION['gender'] = $gender;


    $_SESSION['user'] = ["name" => $name, "email" => $email, "password" => $password, "address" => $address, "image" => $image, "linkedin" => $linkedin, "gender" => $gender];

    echo 'Data Saved In Session';

    echo 'name :' . $_POST['name'] . " " . 'e_mail :' . $_POST['email'] . " " . 'password :' . $_POST['password'] . " " . 'address :' . $_POST['address'] . " " . 'linkedin :' . $_POST['linkedin'] . " " . "image Uploaded"  . " " . 'gender :' . $_POST['gender'];
  }
}



function cleanAnyInput($input)
{

  // $input = trim($input);
  // $input = filter_var($input, FILTER_SANITIZE_STRING);
  // return $input;

  return  trim(strip_tags(stripslashes($input)));
}



?>







<!DOCTYPE html>
<html lang="en">

<head>
  <title>form_validation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>



  <div class="container">


    <form action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

      <input type="hidden" value="1" name="data">
      <div class="form-group">
        <label for="Name">Name</label>
        <input type="text" class="form-control" id="Name" name="name" aria-describedby="" placeholder="Enter Name" required>
      </div>

      <div class="form-group">
        <label for="email">E_mail</label>
        <input class="form-control" id="email" name="email" aria-describedby="" placeholder="Enter email" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" aria-describedby="" placeholder="Enter password" required>
      </div>

      <div class="form-group">
        <label for="address">address</label>
        <input type="text" class="form-control" id="address" name="address" aria-describedby="" placeholder="Enter address" required>
      </div>

      <div class="form-group">
        <label for="linkedin">LinkedIn URL</label>
        <input type="URL" class="form-control" id="linkedin" name="linkedin" aria-describedby="" placeholder="Enter linked_in url" required>
      </div>
      <!-- gender checkbox -->
      <div class="form-group">
        <label for="address">Gender</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" value="" id="flexCheckDefault" name="gender" value="1">
          <label class="form-check-label" for="flexCheckDefault">
            MALE
          </label>

        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" value="" id="flexCheckChecked" checked name="gender" value="2">
          <label class="form-check-label" for="flexCheckChecked">
            FEMALE
          </label>
        </div>
      </div>

      <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image" name="image" aria-describedby="" required>

        <!-- <input type="file"  name="image"> -->
        <!-- <button type="submit" class="btn btn-primary">Upload</button> -->

      </div>






      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

  </div>
</body>

</html>
?>