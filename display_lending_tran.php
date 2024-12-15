
<?php include('main.php');include('session.php');?>
<link rel="stylesheet" href="css/display.css">

<button onclick="openLoginForm()"> Add Publisher </button>
<div class="add-box" style="display:none">
    <button class="btn-close" onclick="closeLoginForm()">&times;</button>
    <form>
        <table>
            <tr><h2>Add Lending Transaction:</h2></tr>
            <tr>
                <td><label for="transactionid">Transaction ID:</label></td>
                <td><input type="text" id="transactionid" name="transactionid" placeholder="Transaction ID" required></td>
            </tr>
            <tr>
                <td><label for="userid">User ID:</label></td>
                <td><input type="text" id="userid" name="userid" placeholder="User ID" required></td>
            </tr>
            <tr>
                <td><label for="bookname">Book Name:</label></td>
                <td><input type="text" id="bookname" name="bookname" placeholder="Book Name" required></td>
            </tr>
            <tr>
                <td><label for="quantity">Quantity:</label></td>
                <td><input type="number" id="quantity" name="quantity" placeholder="Quantity" required></td>
            </tr>
            <tr>
                <td><label for="issuedate">Issue Date:</label></td>
                <td><input type="date" id="issuedate" name="issuedate" required></td>
            </tr>
            <tr>
                <td><label for="duedate">Due Date:</label></td>
                <td><input type="date" id="duedate" name="duedate" required></td>
            </tr>
            <tr>
                <td><label for="fine">Fine:</label></td>
                <td><input type="text" id="fine" name="fine" placeholder="Fine" required></td>
            </tr>
        </table>
        <button type="submit">Submit</button>
    </form>
</div>

<?php
include('dbcon.php');
// Query to retrieve data from the lending_Transaction table
$sql = "SELECT * FROM lending_Transaction";
$result = $conn->query($sql);
// Display data in a table
if ($result->num_rows > 0) 
{
    echo "<table>";
    echo "<tr><th>Transaction ID</th><th>User ID</th><th>Book Name</th><th>Quantity</th><th>Issue Date</th><th>Due Date</th><th>Fine</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["Transaction_ID"]."</td><td>".$row["User_ID"]."</td><td>".$row["book_name"]."</td><td>".$row["Quantity"]."</td><td>".$row["Issue_date"]."</td><td>".$row["Due_date"]."</td><td>".$row["Fine"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>



