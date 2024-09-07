
<?php
include('dbcon.php');

// Retrieve form data
$id = $_POST['readerid'];
$name = $_POST['readername'];
$phone_no = $_POST['phoneno'];
$address = $_POST['address'];

// SQL query to insert reader details
$sql = "INSERT INTO Readers (User_ID, Name, Phone_no, Address) VALUES ('$id','$name', '$phone_no', '$address')";

// Perform the insertion
if ($conn->query($sql) === TRUE) {
    // If insertion is successful, call the display() function in displayreaders.php
    header("Location: display_readers.php?readerid=$id&readername=$name&phoneno=$phone_no&address=$address");
    exit();
} else {
    // If insertion fails, display a pop-up message
    echo "<script>alert('Insertion failed! $conn->error');</script>";
}

// Close database connection
$conn->close();
?>
