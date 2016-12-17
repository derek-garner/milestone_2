
<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>

  <script language="javascript">
    function funcName()
    {
      //alert("Here in funcName");
    }
    
  </script>

</head>

<body>

<?php

$dbcon = mysqli_connect('fdb12.awardspace.net','2259205_usuquiz','Derek22USU','2259205_usuquiz');
if (!$dbcon) {
    die('Could not connect to Scores db: ' . mysqli_error($dbcon));
}

$sqlC="INSERT INTO Scores (FirstName, LastName, School, Score)
VALUES
('$_POST[fFirstName]', '$_POST[fLastName]', '$_POST[fSchoolComp]', '$_POST[fScore]')";
 
 
if (mysqli_query($dbcon, $sqlC)) {
    echo "You Quiz score has been recored, click Display Scores to view rankings";
} else {
    echo "Error: " . $sqlC . "<br>" . mysqli_error($dbcon);
}
 

mysqli_close($dbcon);
?>
<br />

<div id="footer-right">
  <ul>
    <li><a href="index.html">Home</a></li>
    <li><a href="displayScores.html">Display Scores</a></li>
  </ul>
</div>



</body>
</html>

