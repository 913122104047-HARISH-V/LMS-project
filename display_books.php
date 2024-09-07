
<?php include('main.php');?>
<?php
include('dbcon.php');

class books
{

public function addbook()
{
    global $conn;
    // Retrieve form data
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author_no = $_POST['author'];
    $pubid=$_POST['pubid'];
    $categories = $_POST['categories'];
    $edition = $_POST['edition'];
    $price = $_POST['price'];
    $sql = "INSERT INTO books (ISBN, book_name,author_name,publisher_ID,categories,edition,price) VALUES ($isbn,'$title','$author_no',$pubid,'$categories',$edition, $price)";
     if($conn->query($sql)===TRUE)
       echo "super";
     else
       echo "not".$conn->error;
}

public function displaybook()
{
// Query to retrieve data from the Books table
global $conn;
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
// Display data in a table
if ($result->num_rows > 0) 
{
    echo "<table>";
    echo "<tr><th>ISBN</th><th>Book_title</th><th>Author Name</th><th>Publisher_ID</th><th>Categories</th><th>Edition</th><th>Price</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ISBN"]."</td><td>".$row["book_name"]."</td><td>".$row["author_name"]."</td><td>".$row["publisher_ID"]."</td><td>".$row["categories"]."</td><td>".$row["edition"]."</td><td>".$row["price"]."</td></tr>";
    }
    echo "</table>";
} 
else {
    echo "0 results";
}
}

}
$obj = new books;
if(isset($_POST['addboo'])) {
    $obj->addbook();
}
?>

<link rel="stylesheet" href="css/display.css">
<button onclick="openLoginForm()"> Add Books </button>
<div class="add-box" style="display:none">
    <button class="btn-close" onclick="closeLoginForm()">&times;</button>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr><h2>Add Book:</h2></tr>
            <tr>
                <td><label for="isbn">ISBN:</label></td>
                <td><input type="number" id="isbn" name="isbn" placeholder="ISBN" required></td>
            </tr>
            <tr>
                <td><label for="title">Title:</label></td>
                <td><input type="text" id="title" name="title" placeholder="Title" required></td>
            </tr>
            <tr>
                <td><label for="author">Author:</label></td>
                <td><input type="text" id="author" name="author" placeholder="Author" required></td>
            </tr>
            <tr>
                <td><label for="pubid">Publisher ID:</label></td>
                <td><input type="number" id="pubid" name="pubid" placeholder="Publisher ID" required></td>
            </tr>
            <tr>
                <td><label for="categories">Categories:</label></td>
                <td><input type="text" id="categories" name="categories" placeholder="Categories" required></td>
            </tr>
            <tr>
                <td><label for="edition">Edition:</label></td>
                <td><input type="number" id="edition" name="edition" placeholder="Edition" required></td>
            </tr>
            <tr>
                <td><label for="price">Price:</label></td>
                <td><input type="number" id="price" name="price" placeholder="Price" required></td>
            </tr>
        </table>
        <button type="submit" name="addboo">Submit</button>
    </form>
</div>


<div id="bookTable">
        <?php 
           $obj->displaybook();
        ?>
</div>



