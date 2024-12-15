<?php 
include("main.php"); 
include('session.php');
?>
<link rel="stylesheet" href="css/display.css">

<?php
include("dbcon.php");
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") 
{
    // Check if transaction ID is set
    if(isset($_GET['transaction_id'])) 
    {
        // Retrieve transaction ID from form
        $transactionID = $_GET['transaction_id'];

        // Update due date and status in lending_transaction table
        $updateQuery = "UPDATE lending_transaction SET return_date = CURDATE(), status = 'Returned' WHERE transaction_id = $transactionID";
        if ($conn->query($updateQuery) === TRUE) 
        {
            echo "Record updated successfully";
        } 
        else 
        {
            echo "Error updating record: " . $conn->error;
        }
    }
}

// Query to retrieve data from the lending_Transaction table
$sql = "SELECT transaction_id,isbn,user_ID,issue_date,due_date,return_date,status FROM lending_Transaction";
$result = $conn->query($sql);
if (!$result) 
{
    // Handle query error
    die("Error: " . $conn->error);
}

// Display data in a table
if ($result->num_rows > 0) 
{
    echo "<table>";
    echo "<tr><th>Transaction ID</th><th>ISBN</th><th>USER_ID</th><th>Issue Date</th><th>Due Date</th><th>Return Date</th><th>Status</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) 
    {
        echo "<tr><td>".$row["transaction_id"]."</td><td>".$row["isbn"]."</td><td>".$row["user_ID"]."</td><td>".$row["issue_date"]."</td><td>".$row["due_date"]."</td><td>".$row["return_date"]."</td><td>".$row["status"]."</td><td>";
        // Adding the form with the return button
        echo "<form method='get'><input type='hidden' name='transaction_id' value='".$row["transaction_id"]."'><button type='submit'>Return</button></form>";
        echo "</td></tr>";
    }
    echo "</table>";
} 
else 
{
    echo "0 results";
}

// Close connection
$conn->close();
?>
