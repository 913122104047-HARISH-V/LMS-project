
<?php include("main.php"); ?>
<?php include("dbcon.php");?>

<link rel="stylesheet" href="css/display.css">
<style>
    /* Style the form container */
/*hello world/
/* Style the label and select elements */
label,select, input[type="date"], input[type="checkbox"], input[type="submit"] 
{
    display: block;
    margin-bottom: 10px;
    margin:25px;
}

/* Style the submit button */
input[type="submit"],input[type="date"] 
{
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover 
{
    background-color: #0056b3;
}

.form_len{
    display:flex;
    flex-direction: row;
    padding:20px 10px;
}

select {
        margin-bottom: 10px;
        margin-top: 10px;
        background: #007bff;
        color: white;
        border: 1px solid ;
        padding: 4px;
        border-radius: 9px;
      }
</style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Retrieve form data
    $lenderID = $_POST['len'];
    $dueDate = $_POST['duedate'];

    // Check if selectedisbn array is set and not empty
    if(isset($_POST['selectedisbn']) && !empty($_POST['selectedisbn'])) 
    {
        // Loop through each selected ISBN
        $selectedBooks = $_POST['selectedisbn'];
        foreach ($selectedBooks as $isbn) 
        {
            // Insert data into lender_transaction table
            $insertQuery = "INSERT INTO lending_transaction (user_ID, isbn, issue_date, due_date, status) 
                VALUES ('$lenderID', '$isbn', CURDATE(), STR_TO_DATE('$dueDate', '%Y-%m-%d'), 'not returned')";
            $conn->query($insertQuery);
        }
    }
    else 
        echo "No books selected.";

}
?>


        <form class="form_len" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="len"><b>Choose Lender name:</b> </label>

            <select id="len" name="len"> 
                <option value="">Select Reader name</option>
                <?php $result = mysqli_query($conn,"SELECT user_ID, name FROM readers") or die(mysqli_error()); 
                while ($row = mysqli_fetch_array($result)) { ?>
                    <option value="<?php echo $row['user_ID']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>

            <label for="due"><b>Due Date :</b></label>
            <input type="date" id="datePicker" name="duedate" min="<?php echo date('Y-m-d'); ?>"> 
            <input type="submit" value="Add Lender"><br>
        </div>
         <div> 
                <?php 
                $sql = "SELECT ISBN, book_name, author_name, categories, edition FROM Books";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
                    echo "<table>";
                    echo "<tr><th>ISBN</th><th>Book_name</th><th>Author Name</th><th>Categories</th><th>Edition</th><th>Add</th></tr>";
                    while ($row = $result->fetch_assoc()) 
                    {
                        ?>
                        <tr>
                            <td><?php echo $row['ISBN']; ?></td>
                            <td><?php echo $row['book_name']; ?></td>
                            <td><?php echo $row ['author_name']; ?></td> 
                            <td><?php echo $row['categories']; ?></td> 
                            <td><?php echo $row['edition']; ?></td>
                            <td>  <input type="checkbox" name="selectedisbn[]" value="<?php echo $row['ISBN'] ?>"> </td>
                        </tr>
                        <?php
                    }
                    echo "</table>";
                } 
                else {
                    echo "0 results"; 
                }
                ?>
            </div>
        </form>



     <script>
            // Get all checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            // Initialize counter for selected books
            let selectedBooks = 0;
            // Add event listener to checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() 
                {
                    // If checkbox is checked, increment selectedBooks counter
                    if (this.checked) {
                        selectedBooks++;
                    }  else { // If checkbox is unchecked, decrement selectedBooks counter
                        selectedBooks--;
                    }
                    // If selectedBooks exceeds 3, prevent further selection
                    if (selectedBooks > 3) {
                        this.checked = false;
                        selectedBooks--; // Decrement counter to maintain correct count
                        alert("You can only select up to 3 books.");
                    }

                });
            });
            // Function to validate the form before submission
            function validateForm() 
            {
                // Get the lender name value
                const lender = document.getElementById('len').value;
                // Get the due date value
                const dueDate = document.getElementById('due').value;
                // Get all checkbox inputs
                const checkboxes = document.querySelectorAll('input[type="checkbox"]');
                let isChecked = false;

                // Check if at least one checkbox is checked
                checkboxes.forEach(checkbox => 
                {
                    if (checkbox.checked) {
                        isChecked = true;
                    }
                });
                // Check if lender name, due date, and at least one book are selected
                if ( lender=="" || dueDate === '' || !isChecked) {
                    alert("Please enter the lender name, select a due date, and choose at least one book.");
                    return false; // Prevent form submission
                }
                return true; // Allow form submission

            }

            // Add event listener to the form submission
            document.querySelector('.form_len').addEventListener('submit', function(event) {
                // Prevent default form submission if validation fails
                if (!validateForm()) {
                    event.preventDefault();
                }
            });
            // Get the current date
            var currentDate = new Date().toISOString().split('T')[0];
            // Set the minimum date for the input element
            document.getElementById('datePicker').setAttribute('min', currentDate);


    </script>
        


         

