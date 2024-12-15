<?php include('main.php');include('session.php');?>
<?php
include('dbcon.php');

class librarystaffs
{
    public function addstaff()
    {
        global $conn;
        // Retrieve form data
        $staff_name = $_POST['staffname'];
        $staff_phon=$_POST["staffph"];
        // SQL query to insert staff details
        $sql = "INSERT INTO Library_Staffs (staff_name,phone_no) VALUES ('$staff_name','$staff_phon')";
        $conn->query($sql);
    }

    public function displaystaff()
    {
        global $conn;
        $sql = "SELECT * FROM Library_Staffs";
        $result = $conn->query($sql);

        // Display data in a table
        if ($result->num_rows > 0) 
        {
            echo "<table>";
            echo "<tr><th>Staff_ID</th><th>Staff_name</th><th>Staff Phone No</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["staff_ID"]."</td><td>".$row["staff_name"]."</td><td>".$row["phone_no"]."</td></tr>";
            }
            echo "</table>";
        } 
        else
            echo "0 results";
    }
}

$obj = new librarystaffs;

if(isset($_POST['addsta'])) {
    $obj->addstaff();
}
?>


<link rel="stylesheet" href="css/display.css">
<button onclick="openLoginForm()"> Add Library staff </button>
<div class="add-box" style="display:none">
    <button class="btn-close" onclick="closeLoginForm()">&times;</button>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr><h2>Add Library Staff:</h2></tr>
            <tr>
                <td><label for="staffname">Staff Name:</label></td>
                <td><input type="text" id="staffname" name="staffname" placeholder="Staff Name" required></td>
            </tr>
            <tr>
                <td><label for="staffph">Staff Phone no:</label></td>
                <td><input type="text" id="staffph" name="staffph" placeholder="Staff Phone number" required></td>
            </tr>
        </table>
        <button type="submit" name="addsta">Submit</button>
    </form>
</div>
<div id="stafftable">
        <?php 
           $obj->displaystaff();
        ?>
</div>
