<?php include('main.php');?>
<?php
include('dbcon.php');
class publisher{
    public function addpublisher()
    {
      global $conn;
      // Retrieve form data
      $pub_name = $_POST['pubname'];
      $pub_id = $_POST['pubid'];
      $pub_year = $_POST['pubyear'];
      // SQL query to insert staff details
      $sql = "INSERT INTO publishers (publisher_ID,publisher_name,year_of_publication) VALUES ($pub_id,'$pub_name',$pub_year)";
      $conn->query($sql);
    }
    public function displaypublisher()
    {
      global $conn;
      $sql = "SELECT * FROM Publishers";
      $result = $conn->query($sql);
      // Display data in a table
      if ($result->num_rows > 0) 
      {
       echo "<table>";
       echo "<tr><th>Publisher ID</th><th>Publisher Name</th><th>Year of Publication</th></tr>";
       while ($row = $result->fetch_assoc()) 
       {
          echo "<tr><td>".$row["publisher_ID"]."</td><td>".$row["publisher_name"]."</td><td>".$row  ["year_of_publication"]."</td></tr>";
       }
      echo "</table>";
      }
    else
    echo "0 results";
         
    }
}

$obj = new publisher;

if(isset($_POST['addpub'])) {
    $obj->addpublisher();
}
?>

<link rel="stylesheet" href="css/display.css">
<button onclick="openLoginForm()"> Add Publisher </button>
<div class="add-box" style="display:none">

<button class="btn-close" onclick="closeLoginForm()">&times;</button>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table>
           <tr rowspan="2"> <h2>Add publisher :</h2></tr>
            <tr>
            <td><label for="patid">Publisher ID : </label></td>
            <td><input type="text" id="pubid" name="pubid" placeholder="publisher id" required></td>
            </tr>
            <tr>
            <td><label for="patpass">Publisher Name : </label></td>
            <td><input type="text" id="pubname" name="pubname" placeholder="publisher name" required></td>
            </tr>
            <tr>
            <td><label for="patpass">Year of Publication: </label></td>
            <td><input type="number" id="pubyear" name="pubyear" placeholder="year of publication" required></td>
            </tr>
            </table>
            <button type="submit" name='addpub'>Submit</button>
        </form>
</div>

<div id="publishetable">
        <?php 
           $obj->displaypublisher();
        ?>
</div>









