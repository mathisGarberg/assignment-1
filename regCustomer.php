<?php require_once('classes.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Registration Form</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  </head>
  <body>
    <?php

    // Define global arrays
    $errors = array();
    $row = array();

    //Fix user input
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    // Check if the form is submited
    if(isset($_POST['submit'])) {

      // Check if field(s) are empty
      if (!empty($_POST)) {
        // This array does absolutely nothing
		$required = array('firstname'=>$_POST['firstname'], 'surname'=>$_POST['surname'], 'address'=>$_POST['address'], 'email'=>$_POST['email']);
        foreach($_POST as $key=>$value) {
          test_input($value);
          if(empty($value)) {
            $errors["$key"] = "Field can't be empty!";
          }
        }

        // Check for firstname for pattert
        if(!preg_match("/^[a-zA-Z ]*$/",$required['firstname'])) {
          $errors['firstname'] = "Only letters and white space allowed";
        }
        // Check surname for pattern
        if(!preg_match("/^[a-zA-Z ]*$/",$required['surname'])) {
          $errors['surname'] = "Only letters and white space allowed";
        }
        // Check if email is valid
        if(!filter_var($required['email'], FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = "The email isn't valid!";
        }
        // Check if email is taken
        foreach($customers->customer_arr as $c) {
          if($c['email'] == $required['email']) {
            $errors['email'] = "The email is already taken!";
          }
        }
      }

      //Add new user if no errors are provided
      if(!count($errors) > 0) {

        if(isset($_POST['submit'])) {
            $row[] = uniqid();
            $row[] = test_input($_POST['firstname']);
            $row[] = test_input($_POST['surname']);
            $row[] = test_input($_POST['address']);
            $row[] = test_input($_POST['email']);
        }

        if (count($row) > 0) {
          $customers->addC($row);
          $customers->writecsv();
        }

        //Redirect user to successpage
        header("Location: customers.php");
        exit();
      }

    }

    print_r($errors);

    ?>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <header>
          	<h1>Registration Form</h1>
            <p>Please fill in the form below</p>
            <hr>
          </header>
          <form class="form-horizontal" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label class="col-sm-4 control-label">Firstname<span class="form_required">*</span>:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="firstname" placeholder="John" value="<?php if(isset($_POST['firstname'])){ echo $_POST['firstname']; } ?>">
                    <span class="form_required"><?php if(isset($errors['firstname'])){ echo $errors['firstname']; } ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Surname<span class="form_required">*</span>:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="surname" placeholder="Doe" value="<?php if(isset($_POST['surname'])){ echo $_POST['surname']; } ?>">
                    <span class="form_required"><?php if(isset($errors['surname'])){ echo $errors['surname']; } ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Address<span class="form_required">*</span>:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="address" placeholder="21 Jump Street" value="<?php if(isset($_POST['address'])){ echo $_POST['address']; } ?>">
                    <span class="form_required"><?php if(isset($errors['address'])){ echo $errors['address']; } ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Email<span class="form_required">*</span>:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" name="email" placeholder="example@domain.com" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
                    <span class="form_required"><?php if(isset($errors['email'])){ echo $errors['email']; } ?></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-4">
                    <input name="submit" type="submit" value="Send Form">
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>
  </body>
</html>
