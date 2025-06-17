<?php include("main.php"); include("session.php"); ?>
<link rel="stylesheet" href="css/display.css">
<?php include("dbcon.php"); ?>

<h2>Borrowers with Fines</h2>

<?php
// 1. Update status for overdue (no return) and returned
$conn->query("UPDATE lending_transaction 
              SET status = 'overdue' 
              WHERE status = 'issued' AND CURDATE() > due_date AND return_date IS NULL");

$conn->query("UPDATE lending_transaction 
              SET status = 'returned' 
              WHERE return_date IS NOT NULL AND status != 'returned'");

// 2. Update fines for returned books
$conn->query("UPDATE lending_transaction 
              SET fine = DATEDIFF(return_date, due_date) * default_fine_per_day 
              WHERE return_date > due_date");

// 3. Retrieve fine details for both returned late and currently overdue
$sql = "
    SELECT transaction_id, user_ID, isbn, issue_date, due_date, return_date,
           default_fine_per_day,
           CASE 
               WHEN return_date IS NOT NULL THEN DATEDIFF(return_date, due_date)
               ELSE DATEDIFF(CURDATE(), due_date)
           END AS delay_days,
           CASE 
               WHEN return_date IS NOT NULL THEN DATEDIFF(return_date, due_date) * default_fine_per_day
               ELSE DATEDIFF(CURDATE(), due_date) * default_fine_per_day
           END AS fine,
           status
    FROM lending_transaction
    WHERE (return_date > due_date OR (return_date IS NULL AND CURDATE() > due_date))
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>Transaction ID</th>
            <th>User ID</th>
            <th>ISBN</th>
            <th>Issue Date</th>
            <th>Due Date</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Delay (Days)</th>
            <th>Fine/Day</th>
            <th>Total Fine</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['transaction_id']}</td>
                <td>{$row['user_ID']}</td>
                <td>{$row['isbn']}</td>
                <td>{$row['issue_date']}</td>
                <td>{$row['due_date']}</td>
                <td>" . ($row['return_date'] ?? '-') . "</td>
                <td>{$row['status']}</td>
                <td>{$row['delay_days']}</td>
                <td>{$row['default_fine_per_day']}</td>
                <td>{$row['fine']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No fines to display.</p>";
}
$conn->close();
?>
