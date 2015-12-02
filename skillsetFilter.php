<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","brownand-db","AAWTd6Bpl6KKvN5c","brownand-db");
if($mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<body>
<div>
	<table>
        <tr>
            <td> Employees </td>
        </tr>
        <tr>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Age</td>
            <td>Position</td>
            <td>Office</td>
            <td>Skill Set</td>
          </tr>
<?php
if(!($stmt = $mysqli->prepare("SELECT employee.first_name, employee.last_name, employee.age, employee.position, office.city, s.name
                               FROM employee
                               INNER JOIN office ON employee.cid = office.id
                               LEFT JOIN employee_skills es ON employee.id = es.eid
                               LEFT JOIN skillSet s ON s.id = es.sid
                               WHERE s.id = ? "))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!($stmt->bind_param("i",$_POST['skillset']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($first_name, $last_name, $age, $position, $office, $skill)){
    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 	echo "<tr>\n<td>\n" . $first_name . "\n</td>\n<td>\n" . $last_name . "\n</td>\n<td>\n"  . $age . "\n</td>\n<td>\n"  . $position . "\n</td>\n<td>\n" . $office . "\n</td>\n<td>\n" . $skill . "\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>

</body>
</html>