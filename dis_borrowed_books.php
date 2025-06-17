<?php 
include("main.php"); 
include("session.php");
?>
<link rel="stylesheet" href="css/display.css">

<?php
include("dbcon.php");

// 1. Automatically update overdue status
$conn->query("UPDATE lending_transaction 
              SET status = 'overdue' 
              WHERE status = 'issued' AND CURDATE() > due_date AND return_date IS NULL");

// 2. Handle return button click
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['transaction_id'])) {
    $transactionID = $_GET['transaction_id'];

    // Get due date and fine per day
    $fetchQuery = "SELECT due_date, default_fine_per_day FROM lending_transaction WHERE transaction_id = $transactionID";
    $result = $conn->query($fetchQuery);
    $fine = 0;

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $due_date = $row['due_date'];
        $fine_per_day = $row['default_fine_per_day'];
        $today = date("Y-m-d");

        if ($today > $due_date) {
            $delay = (strtotime($today) - strtotime($due_date)) / (60 * 60 * 24);
            $fine = $delay * $fine_per_day;
        }
    }

    // Update lending transaction
    $updateQuery = "UPDATE lending_transaction 
                    SET return_date = CURDATE(), status = 'returned', fine = $fine 
                    WHERE transaction_id = $transactionID";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<p style='color:green;'>Book returned successfully. Fine: ₹$fine</p>";
    } else {
        echo "<p style='color:red;'>Error updating record: " . $conn->error . "</p>";
    }
}

// 3. Display all lending transactions
$sql = "SELECT transaction_id, isbn, user_ID, issue_date, due_date, return_date, status, fine 
        FROM lending_transaction 
        ORDER BY issue_date DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h2>Borrowed Books Record</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Transaction ID</th>
            <th>ISBN</th>
            <th>User ID</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Fine (₹)</th>
            <th>Action</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        $isReturned = ($row['status'] === 'returned');

        echo "<tr>
                <td>{$row['transaction_id']}</td>
                <td>{$row['isbn']}</td>
                <td>{$row['user_ID']}</td>
                <td>{$row['issue_date']}</td>
                <td>{$row['due_date']}</td>
                <td>" . ($row['return_date'] ?? '-') . "</td>
                <td>{$row['status']}</td>
                <td>" . ($row['fine'] ?? '0') . "</td>
                <td>";

        // If not returned, show active return button
        if (!$isReturned) {
            echo "<form method='get'>
                    <input type='hidden' name='transaction_id' value='{$row['transaction_id']}'>
                    <button type='submit'>Return</button>
                  </form>";
        } else {
            // Show disabled button or dash
            echo "<button disabled>Returned</button>";
        }

        echo "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No borrowed records found.</p>";
}

$conn->close();
?>
