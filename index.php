<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","brownand-db","AAWTd6Bpl6KKvN5c","brownand-db");
if($mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
echo "THIS WORKS";
?>

<!--web.engr.oregonstate.edu/~brownand/index.php-->


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <table>
        <tr>
            <td> Employees </td>
        </tr>
        <tr>
            <td>Name</td>
            <td>Age</td>
            <td>Position</td>
            <td>Base Office</td>
        </tr>
        <tr>
            <td>Hank Bronson</td>
            <td>30</td>
            <td>Game Designer</td>
            <td><a href="planet.php?id=1">London</a></td><!--FIX THIS LATER-->
        </tr>
    </table>

</div>

<div class="container">
    <form method="post" action="index.html"> <!--Change this later-->
        <fieldset>
            <legend>Name</legend>
            <p>First Name: <input type="text" name="FirstName"/></p>
            <p>Last Name: <input type="text" name="LastName"/></p>
        </fieldset>
        <fieldset>
            <legend>Age</legend>
            <p>First Name: <input type="text" name="Age"/></p>
        </fieldset>
        <fieldset>
            <legend>Office Locations</legend>
            <select>
                <option value="1">London</option>
                <option value="2">Los Angeles</option>
                <option value="3">Montreal</option>
                <option value="4">Houston</option>
                <option value="4">Boston</option>
            </select>
        </fieldset>
            <p><input type="submit"/></p>
    </form>
</div>

<div class="container">
    <form method="post" action="index.html"> <!--Change this later-->
        <fieldset>
            <legend>Office Location</legend>
            <p>City: <input type="text" name="PName"/></p>
        </fieldset>
    </form>
    <form method="post" action="index.html"> <!--Change this later-->
        <fieldset>
            <legend>Office Info</legend>
            <p>Planet Specialization: <input type="text" name="PPopulation"/></p>
        </fieldset>
        <input type="submit" name="add" value="Add Planet"/>
        <input type="submit" name="update" value="Update"/>
    </form>
</div>



</body>
</html>