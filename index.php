<?php 
$error_message = '';
$other_message = '';

if (isset($_POST['submit'])) {

	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	if (empty($name)) {
		$error_message = 'Name field cannot be empty';
	} else if (empty($email)) {
		$error_message = 'Email field cannot be empty';
	} else if (empty($password)) {
		$error_message = 'Password field cannot be empty';
	} else {
		if (file_exists('users.json')) {
			$json_current_data = file_get_contents("users.json");

			//converting current JSON data to array
			$current_data_array = json_decode($json_current_data, true);

			//converting the newly inserted data into an array
			$new_data = array(
				'name' => $name,
				'email' => $email,
				'password' => $password
			);

			//adding new data to existing JSON data
			$current_data_array[] = $new_data;

			//encoding the data into JSON file
			$prepared_data = json_encode($current_data_array);
			if (file_put_contents('users.json', $prepared_data)) {
				$other_message = "Account Created Successfully!";
			} else {
				$error_message = "Account could not be created!";
			}

		} else {
			$error_message = "JSON file does not exist!";
		}
	}
}

?>

<!DOCTYPE html>

<html>
<head>
	<title>Working with JSON</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h3 style="margin: 30px 0px 30px;">
  			User Registration
  			<small class="text-muted">Details to be stored in a json file</small>
		</h3>
		<?php 
		if (!empty($other_message)) { ?>
			<div class="alert alert-dismissible alert-success">
  				<?php echo $other_message; ?>
			</div> <?php
		} ?>
	<form method="POST">
  <fieldset>
    <legend>Basic Information</legend>
       <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" class="form-control" id="name" aria-describedby="name" placeholder="Enter name" name="name" required autofocus>
      <div style="color: red;"><?php echo $error_message; ?></div>
    	</div>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      <div style="color: red;"><?php echo $error_message; ?></div>
    </div>
        <div class="form-group">	
      <label for="exampleInputPassword1">Password</label>
      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
      <div style="color: red;"><?php echo $error_message; ?></div>
    </div>
    <button type="submit"  name="submit" class="btn btn-primary">REGISTER</button>
  </fieldset>
</form>
</div>


<?php 

$err_message = '';
$user = FALSE;
$message = '';

if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	if (empty($email)) {
		$err_message = 'Email field cannot be empty';
	} else if (empty($password)) {
		$err_message = 'Password field cannot be empty';
	} else {
		if (file_exists('users.json')) {
			$json_current_data = file_get_contents("users.json");

			//converting current JSON data to array
			$current_data_array = json_decode($json_current_data, true);


			if ($current_data_array) {
			    foreach ($current_data_array as $record_header => $record_details) {
			    	if ($record_details['email'] == $email && $record_details['password'] == $password) {
			    		$user = TRUE;
			    		$message = 'Welcome '.$record_details['name'].' You\'re logged in!'; 
			    	}
				}
			}

			if ($user == false) { 
				$message = 'User not found! Kindly register or try again.';
			}
		} else {
			$err_message = "JSON file does not exist!";
		}
	}
}
?>

<div class="container">
<form method="POST">
			<?php 
		if (!empty($message)) { ?>
			<script type="text/javascript">alert("<?php echo $message; ?>");</script>
			<?php
		} ?>
  <fieldset>
    <legend style="margin: 30px 0px 10px;">Login Panel</legend>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
      <div style="color: red;"><?php echo $err_message; ?></div>
    </div>
        <div class="form-group">	
      <label for="exampleInputPassword1">Password</label>
      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
      <div style="color: red;"><?php echo $err_message; ?></div>
    </div>
    <button type="submit" class="btn btn-primary" name="login">LOG IN</button>
  </fieldset>
</form>
</form>

</div>
</body>
</html>