<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","brownand-db","AAWTd6Bpl6KKvN5c","brownand-db");
if($mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

/*prepares SQL statement*/
if(!($stmt = $mysqli->prepare("DELETE FROM employee_project WHERE eid=? AND pid=?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

/*Binds parameters from Employee and Project HTML items as TWO INTEGERS*/
if(!($stmt->bind_param("ii",$_POST['Employee'],$_POST['Project']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Removed " . $stmt->affected_rows . " rows from employee_project.";
}
?>

<FORM><INPUT Type="button" VALUE="Back" onClick="history.go(-1);return true;"></FORM>