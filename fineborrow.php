
<?php include("main.php"); include('session.php');?>
<link rel="stylesheet" href="css/display.css">

<?php
include("dbcon.php");

$sql1 = "UPDATE lending_transaction 
        SET fine = DATEDIFF(return_date, due_date) * default_fine_per_day 
        WHERE return_date > due_date";
$conn->query($sql1);
// Retrieve records where return_date > due_date and status is 'not returned'
$sql = "SELECT transaction_id, user_ID, isbn, issue_date, due_date, return_date, status, default_fine_per_day, 
               DATEDIFF(return_date, due_date) AS delay_days,
               DATEDIFF(return_date, due_date) * default_fine_per_day AS fine
        FROM lending_transaction
        WHERE return_date > due_date";
$result = $conn->query($sql);
if (!$result) {
    die("Error: " . $conn->error);
}
// Display data in a table
if ($result->num_rows > 0) 
{
    echo "<table>";
    echo "<tr><th>Transaction ID</th><th>User ID</th><th>ISBN</th><th>Issue Date</th><th>Due Date</th><th>Return Date</th><th>Fine Per Day</th><th>Delay Days</th><th>Fine Amount</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["transaction_id"]."</td><td>".$row["user_ID"]."</td><td>".$row["isbn"]."</td><td>".$row["issue_date"]."</td><td>".$row["due_date"]."</td><td>".$row["return_date"]."</td><td>".$row["default_fine_per_day"]."</td><td>".$row["delay_days"]."</td><td>".$row["fine"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}
// Close connection
$conn->close();
?>
