<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","brownand-db","AAWTd6Bpl6KKvN5c","brownand-db");
if($mysqli->connect_errno){
echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
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

<!--DISPLAYS THE DATA SHEET -->
<div class="container">
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
            <td>Project</td>
            <td>Skill Set</td>
        </tr>

        <tr>
            <td>Hank</td>
            <td>Bronson</td>
            <td>32</td>
            <td>Game Designer</td>
            <td><a href="officeFilter.php?id=1">London</a></td><!--FIX THIS LATER-->
            <td>Dire Doomlord 2</td>

        </tr>

        <!--PHP TO RETRIEVE DATA FROM TABLES, PULLS DATA FROM ACROSS FOUR TABLES-->
<?php
if(!($stmt = $mysqli->prepare("SELECT employee.first_name, employee.last_name, employee.age, employee.position, office.city, p.name FROM employee INNER JOIN office on employee.cid = office.id
                                                                  LEFT JOIN employee_project ep on ep.eid = employee.id
                                                                  LEFT JOIN project p ON ep.pid = p.id"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
    echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($first_name, $last_name, $age, $position, $office, $project)){
    echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
 echo "<tr>\n<td>\n" . $first_name . "\n</td>\n<td>\n" . $last_name . "\n</td>\n<td>\n"  . $age . "\n</td>\n<td>\n"  . $position . "\n</td>\n<td>\n" . $office . "\n</td>\n<td>\n" . $project . "\n</td>\n</tr>";
}
$stmt->close();

?>
    </table>
</div>


<!--ADD PERSON TO TABLE-->
<div class="container">
    <form method="post" action="addperson.php">
        <fieldset>
            <legend>New Employee</legend>
            <p>First Name: <input type="text" name="FirstName"/></p>
            <p>Last Name: <input type="text" name="LastName"/></p>
            <p> Age:
                        <select name = "Age">
                        <?php
                            for ($i=18; $i<=100; $i++)
                            {
                                ?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php
                            }
                        ?>
                        </select>
            </p>
            <p>Job Title: <input type="text" name="Position"/></p>
            <p>Office:
                        <select name="Office">
                            <!--PHP RETRIEVES LIST OF OFFICES FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                            <!--IT ALSO STORES THE OFFICE.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                            <?php
                            if(!($stmt = $mysqli->prepare("SELECT office.name, office.id FROM office"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }

                            if(!$stmt->execute()){
                                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            if(!$stmt->bind_result($office, $id)){
                                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            while($stmt->fetch()){
                             echo "\n<option value= \" $id \">\n" . $office . "\n</option>\n";
                            }
                            $stmt->close();

                            ?>
                        </select>
            </p>
        </fieldset>
        <p><input type="submit"/></p>
    </form>
</div>

<!--ADD EMPLOYEE TO PROJECT-->
<div class="container">
    <form method="post" action="addToProject.php">
        <fieldset>
            <legend>Add Employee to Project</legend>
            <p>Employee:
                        <select name="Employee">
                            <!--PHP RETRIEVES LIST OF EMPLOYEES FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                            <!--IT ALSO STORES THE EMPLOYEE.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                            <?php
                            if(!($stmt = $mysqli->prepare("SELECT employee.first_name, employee.last_name, employee.position, employee.id FROM employee"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }

                            if(!$stmt->execute()){
                                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            if(!$stmt->bind_result($fname, $lname, $position, $id)){
                                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            while($stmt->fetch()){
                             echo "\n<option value= \" $id \">\n" . $lname . ", " . $fname . " ($position)" .  "\n</option>\n";
                            }
                            $stmt->close();

                            ?>
                        </select>
            </p>

            <p>Project:
                        <select name="Project">
                            <!--PHP RETRIEVES LIST OF PROJECTS FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                            <!--IT ALSO STORES THE PROJECT.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                            <?php
                            if(!($stmt = $mysqli->prepare("SELECT project.name, project.id FROM project"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }

                            if(!$stmt->execute()){
                                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            if(!$stmt->bind_result($project, $id)){
                                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            while($stmt->fetch()){
                             echo "\n<option value= \" $id \">\n" . $project . "\n</option>\n";
                            }
                            $stmt->close();

                            ?>
                        </select>
            </p>
        </fieldset>
        <p><input type="submit"/></p>
    </form>
</div>


<!--REMOVE EMPLOYEE FROM PROJECT-->
<div class="container">
    <form method="post" action="removeFromProject.php">
        <fieldset>
            <legend>Remove Employee From Project</legend>
            <p>Employee:
                        <select name="Employee">
                            <!--PHP RETRIEVES LIST OF EMPLOYEES FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                            <!--IT ALSO STORES THE EMPLOYEE.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                            <?php
                            if(!($stmt = $mysqli->prepare("SELECT employee.first_name, employee.last_name, employee.position, employee.id FROM employee"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }

                            if(!$stmt->execute()){
                                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            if(!$stmt->bind_result($fname, $lname, $position, $id)){
                                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            while($stmt->fetch()){
                             echo "\n<option value= \" $id \">\n" . $lname . ", " . $fname . " ($position)" .  "\n</option>\n";
                            }
                            $stmt->close();

                            ?>
                        </select>
            </p>

            <p>Project:
                        <select name="Project">
                            <!--PHP RETRIEVES LIST OF PROJECTS FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                            <!--IT ALSO STORES THE PROJECT.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                            <?php
                            if(!($stmt = $mysqli->prepare("SELECT project.name, project.id FROM project"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }

                            if(!$stmt->execute()){
                                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            if(!$stmt->bind_result($project, $id)){
                                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            while($stmt->fetch()){
                             echo "\n<option value= \" $id \">\n" . $project . "\n</option>\n";
                            }
                            $stmt->close();

                            ?>
                        </select>
            </p>
        </fieldset>
        <p><input type="submit"/></p>
    </form>
</div>

<!--MOVE EMPLOYEE TO NEW OFFICE-->
<div class="container">
    <form method="post" action="moveEmployee.php">
        <fieldset>
            <legend>Move Employee to New Office</legend>
            <p>Employee:
                        <select name="Employee">
                            <!--PHP RETRIEVES LIST OF EMPLOYEES FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                            <!--IT ALSO STORES THE EMPLOYEE.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                            <?php
                            if(!($stmt = $mysqli->prepare("SELECT employee.first_name, employee.last_name, employee.position, employee.id FROM employee"))){
                                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                            }

                            if(!$stmt->execute()){
                                echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            if(!$stmt->bind_result($fname, $lname, $position, $id)){
                                echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                            }
                            while($stmt->fetch()){
                             echo "\n<option value= \" $id \">\n" . $lname . ", " . $fname . " ($position)" .  "\n</option>\n";
                            }
                            $stmt->close();

                            ?>
                        </select>
            </p>

            <p>Office:
                <select name="Office">
                    <!--PHP RETRIEVES LIST OF OFFICES FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                    <!--IT ALSO STORES THE OFFICE.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                    <?php
                    if(!($stmt = $mysqli->prepare("SELECT office.name, office.id FROM office"))){
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($office, $id)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                     echo "\n<option value= \" $id \">\n" . $office . "\n</option>\n";
                    }
                    $stmt->close();

                    ?>
                </select>
            </p>
        </fieldset>
        <p><input type="submit"/></p>
    </form>
</div>


<!--FILTER BY OFFICE -->
<div class = "container">
	<form method="post" action="officeFilter.php">
		<fieldset>
			<legend>Filter By Office</legend>
                <select name="Office">
                    <!--PHP RETRIEVES LIST OF OFFICES FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                    <!--IT ALSO STORES THE OFFICE.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                    <?php
                    if(!($stmt = $mysqli->prepare("SELECT office.name, office.id FROM office"))){
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($office, $id)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                     echo "\n<option value= \" $id \">\n" . $office . "\n</option>\n";
                    }
                    $stmt->close();

                    ?>
                </select>
		</fieldset>
		<input type="submit" value="Run Filter" />
	</form>
</div>

<!--FILTER BY PROJECT-->
<div class = "container">
	<form method="post" action="projectFilter.php">
		<fieldset>
			<legend>Filter By Project</legend>
                <select name="Project">
                    <!--PHP RETRIEVES LIST OF PROJECTS FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                    <!--IT ALSO STORES THE PROJECT.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                    <?php
                    if(!($stmt = $mysqli->prepare("SELECT project.name, project.id FROM project"))){
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($project, $id)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                     echo "\n<option value= \" $id \">\n" . $project . "\n</option>\n";
                    }
                    $stmt->close();

                    ?>
                </select>
		</fieldset>
		<input type="submit" value="Run Filter" />
	</form>
</div>

<!--FILTER BY SKILLSET -->
<div class = "container">
	<form method="post" action="skillsetFilter.php">
		<fieldset>
			<legend>Filter By Skill Set</legend>
                <select name="skillset">
                    <!--PHP RETRIEVES LIST OF PROJECTS FROM DATABASE AND DISPLAYS THEM IN DROP DOWN -->
                    <!--IT ALSO STORES THE PROJECT.ID AS THE OPTION VALUE SO THE CORRECT INFORMATION WILL BE PASSED TO TABLE-->
                    <?php
                    if(!($stmt = $mysqli->prepare("SELECT skillSet.name, skillSet.id FROM skillSet"))){
                        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                        echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($skill, $id)){
                        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                     echo "\n<option value= \" $id \">\n" . $skill . "\n</option>\n";
                    }
                    $stmt->close();

                    ?>
                </select>
		</fieldset>
		<input type="submit" value="Run Filter" />
	</form>
</div>

</body>
</html>