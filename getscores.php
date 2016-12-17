<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 70%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>

<body>

<?php

$dbcon = mysqli_connect('fdb12.awardspace.net','2259205_usuquiz','Derek22USU','2259205_usuquiz');
if (!$dbcon) {
    die('Could not connect to Scores db: ' . mysqli_error($dbcon));
}

$sql="SELECT * FROM Scores";
$result = mysqli_query($dbcon,$sql);


if (!$result) {
    printf("Database Error: %s\n", mysqli_error($dbcon));
    exit();
}

echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>School</th>
<th>Score</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['FirstName'] . "</td>";
    echo "<td>" . $row['LastName'] . "</td>";
    echo "<td>" . $row['School'] . "</td>";
    echo "<td>" . $row['Score'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($dbcon);
?>
</body>
</html>