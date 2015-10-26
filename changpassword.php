<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("SYSTEM", "Tlee2537", "//LOCALHOST/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Changing Password
<hr>
<?PHP

	if (isset($_POST['submit']))
		{
			//check field
			$oldpassword = trim($_POST['oldpassword']);
			$newpassword = trim($_POST['newpassword']);
			$repeatpassword = trim($_POST['repeatpassword']);
			$id = $_SESSION['ID'];
			//check password againt db
			//connect db
	
	$query1 = "SELECT password FROM AA_LOGIN WHERE id='$id'";
	$parseRequest1 = oci_parse($conn, $query1);
	oci_execute($parseRequest1);
	// Fetch each row in an associative array
	$row = oci_fetch_array($parseRequest1, OCI_RETURN_NULLS+OCI_ASSOC);
	
	
	$old_password = $row['PASSWORD'];
	
	if($old_password == $oldpassword)
	{
		if($newpassword == $repeatpassword)
		{
		$query = "UPDATE AA_LOGIN SET password ='$newpassword' WHERE
		password ='$oldpassword' and id='$id'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		
		die( '<script>window.location = "MemberPage.php";</script>');
		}
		else { echo "Invalid new password repeat again! <br><br> ";}
					
	}
	else {echo "Invalid Old Password!!<br><br>";}
	}
	
?>

<form action='changpassword.php' method='post'>
			Old password: <input type='text' name='oldpassword'><p>
			New password: <input type='password' name='newpassword'><br>
			Repeat password: <input type='password' name='repeatpassword'><br>
			<input type='submit' name='submit' value='Chang password' >
</form>