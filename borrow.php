<?php include("main.php"); ?>
<?php include("dbcon.php"); ?>

<link rel="stylesheet" href="css/display.css">
<style>
label, select, input[type="date"], input[type="checkbox"], input[type="submit"] {
    display: block;
    margin-bottom: 10px;
    margin: 25px;
}

input[type="submit"], input[type="date"] {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.form_len {
    display: flex;
    flex-direction: row;
    padding: 20px 10px;
}

select {
    margin-bottom: 10px;
    margin-top: 10px;
    background: #007bff;
    color: white;
    border: 1px solid;
    padding: 4px;
    border-radius: 9px;
}
</style>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lenderID = $_POST["len"];
    $dueDate = $_POST["duedate"];
    $issueDate = date("Y-m-d");

    if (!isset($_POST['selectedisbn']) || count($_POST['selectedisbn']) != 1) {
        echo "<script>alert('Only one book can be selected per lending!'); window.history.back();</script>";
        exit();
    }

    $isbn = $_POST['selectedisbn'][0];

    $checkUserQuery = "SELECT COUNT(*) as active FROM lending_transaction 
                       WHERE user_ID = '$lenderID' AND status IN ('issued', 'not returned', 'overdue')";
    $userResult = $conn->query($checkUserQuery);

    if (!$userResult) {
        die("User check failed: " . $conn->error);
    }

    $userRow = $userResult->fetch_assoc();
    if ($userRow['active'] > 0) {
        echo "<script>alert('User already has a borrowed book! Only one active lend allowed.'); window.history.back();</script>";
        exit();
    }

    $checkBookQuery = "SELECT quantity FROM Books WHERE ISBN = '$isbn'";
    $bookResult = $conn->query($checkBookQuery);

    if (!$bookResult || $bookResult->num_rows == 0) {
        echo "<script>alert('Book not found in library!'); window.history.back();</script>";
        exit();
    }

    $bookRow = $bookResult->fetch_assoc();
    if ($bookRow['quantity'] <= 0) {
        echo "<script>alert('No copies of the book are available to issue.'); window.history.back();</script>";
        exit();
    }


    $insertQuery = "INSERT INTO lending_transaction 
                    (user_ID, isbn, issue_date, due_date, status) 
                    VALUES ('$lenderID', '$isbn', '$issueDate', '$dueDate', 'issued')";

    if ($conn->query($insertQuery)) {
        $updateQuantityQuery = "UPDATE Books SET quantity = quantity - 1 WHERE ISBN = '$isbn'";
        $conn->query($updateQuantityQuery);

        echo "<script>alert('Book issued successfully!'); window.location.href='display_lending_tran.php';</script>";
    } else {
        echo "<script>alert('Error occurred while issuing book: " . $conn->error . "'); window.history.back();</script>";
    }
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

        <label for="datePicker"><b>Due Date :</b></label>
        <input type="date" id="datePicker" name="duedate">
        <input type="submit" value="Add Lender"><br>
    </div>
    <div>
        <?php 
        $sql = "SELECT ISBN, book_name, author_name, categories, edition FROM Books";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>ISBN</th><th>Book_name</th><th>Author Name</th><th>Categories</th><th>Edition</th><th>Select</th></tr>";
            while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $row['ISBN']; ?></td>
            <td><?php echo $row['book_name']; ?></td>
            <td><?php echo $row ['author_name']; ?></td> 
            <td><?php echo $row['categories']; ?></td> 
            <td><?php echo $row['edition']; ?></td>
            <td><input type="checkbox" name="selectedisbn[]" value="<?php echo $row['ISBN'] ?>"></td>
        </tr>
        <?php }
            echo "</table>";
        } else {
            echo "0 results"; 
        }
        ?>
    </div>
</form>

<script>
const checkboxes = document.querySelectorAll('input[type="checkbox"]');
checkboxes.forEach(cb => {
    cb.addEventListener('change', function () {
        checkboxes.forEach(other => {
            if (other !== this) other.checked = false;
        });
    });
});

function validateForm() {
    const lender = document.getElementById('len').value;
    const dueDate = document.getElementById('datePicker').value;
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let isChecked = false;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) isChecked = true;
    });

    if (lender === "" || dueDate === '' || !isChecked) {
        alert("Please enter the lender name, select a due date, and choose one book.");
        return false;
    }
    return true;
}

document.querySelector('.form_len').addEventListener('submit', function (event) {
    if (!validateForm()) event.preventDefault();
});

document.getElementById('datePicker').setAttribute('min', new Date().toISOString().split('T')[0]);
</script>