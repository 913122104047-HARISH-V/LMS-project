
<?php include('main.php');?>
<?php
include('dbcon.php');
class readers 
{
    public function addreader()
    {
        global $conn;
        // Retrieve form data
        $name = $_POST['readername'];
        $phone_no = $_POST['phoneno'];
        $address = $_POST['address'];
        // SQL query to insert reader details
        $sql = "INSERT INTO Readers (name, phone_no, address) VALUES ('$name', '$phone_no', '$address')";
        $conn->query($sql);
    }
    public function displayreader()
    {
        global $conn;
        $sql = "SELECT * FROM Readers";
        $result = $conn->query($sql);

        // Display data in a table
        if ($result->num_rows > 0) 
        {
            echo "<table>";
            echo "<tr><th>User ID</th><th>Name</th><th>Phone Number</th><th>Address</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["user_ID"]."</td><td>".$row["name"]."</td><td>".$row["phone_no"]."</td><td>".$row["address"]."</td></tr>";
            }
            echo "</table>";
        } 
        else
            echo "0 results";
    }
}

$obj = new readers;

if(isset($_POST['addred'])) {
    $obj->addreader();
}
?>
    <link rel="stylesheet" href="css/display.css">
    <button onclick="openLoginForm()">Add Readers</button>
    
    <div class="add-box" style="display:none">
        <button class="btn-close" onclick="closeLoginForm()">&times;</button>
        <form id="addReaderForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Add Reader:</h2>
            <table>
                <tr>
                    <td><label for="readername">Reader Name:</label></td>
                    <td><input type="text" id="readername" name="readername" placeholder="Reader Name" required></td>
                </tr>
                <tr>
                    <td><label for="phoneno">Phone Number:</label></td>
                    <td><input type="text" id="phoneno" name="phoneno" placeholder="Phone Number" required></td>
                </tr>
                <tr>
                    <td><label for="address">Address:</label></td>
                    <td><input type="text" id="address" name="address" placeholder="Address" required></td>
                </tr>
            </table>
            <button type="submit" name="addred">Submit</button>
        </form>
    </div>

    <div id="readerTable">
        <?php 
           $obj->displayreader();
        ?>
    </div>






