<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","brownand-db","AAWTd6Bpl6KKvN5c","brownand-db");
if($mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/*prepares SQL statement*/
if(!($stmt = $mysqli->prepare("INSERT INTO employee(first_name, last_name, age, position, cid) VALUES (?,?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

/*Binds parameters from Employee and Project HTML items as two strings, integer, string, and integer*/
if(!($stmt->bind_param("ssisi",$_POST['FirstName'],$_POST['LastName'],$_POST['Age'],$_POST['Position'],$_POST['Office']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to employee.";
}
?>

<FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>