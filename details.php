<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
.card-container {
    display: flex;
    justify-content: space-around;
    margin: 20px;
}

.card {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    width: 250px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
}

.icon {
    font-size: 40px;
    color: #007bff;
    margin-bottom: 15px;
}

.content h3 {
    font-size: 18px;
    margin: 10px 0;
    color: #333;
}

.content p {
    font-size: 14px;
    color: #555;
}
</style>
<?php
include('main.php'); // Assuming this contains some necessary includes or session handling
include('dbcon.php'); // Database connection

// Queries to fetch count from each table
$books_query = "SELECT COUNT(*) as count FROM books";
$readers_query = "SELECT COUNT(*) as count FROM readers";
$staffs_query = "SELECT COUNT(*) as count FROM library_staffs";
$publishers_query = "SELECT COUNT(*) as count FROM publishers";

// Execute queries
$books_result = mysqli_query($conn, $books_query);
$readers_result = mysqli_query($conn, $readers_query);
$staffs_result = mysqli_query($conn, $staffs_query);
$publishers_result = mysqli_query($conn, $publishers_query);

// Fetch counts
$books_count = mysqli_fetch_assoc($books_result)['count'];
$readers_count = mysqli_fetch_assoc($readers_result)['count'];
$staffs_count = mysqli_fetch_assoc($staffs_result)['count'];
$publishers_count = mysqli_fetch_assoc($publishers_result)['count'];
?>

<div class="card-container">
    <div class="card">
        <div class="icon">
            <i class="fas fa-book"></i> <!-- Font Awesome icon for books -->
        </div>
        <div class="content">
            <h3>Books</h3>
            <p><?php echo $books_count; ?> books available</p>
        </div>
    </div>
    <div class="card">
        <div class="icon">
            <i class="fas fa-user"></i> <!-- Font Awesome icon for readers -->
        </div>
        <div class="content">
            <h3>Readers</h3>
            <p><?php echo $readers_count; ?> registered readers</p>
        </div>
    </div>
    <div class="card">
        <div class="icon">
            <i class="fas fa-users"></i> <!-- Font Awesome icon for staffs -->
        </div>
        <div class="content">
            <h3>Staffs</h3>
            <p><?php echo $staffs_count; ?> staff members</p>
        </div>
    </div>
    <div class="card">
        <div class="icon">
            <i class="fas fa-building"></i> <!-- Font Awesome icon for publishers -->
        </div>
        <div class="content">
            <h3>Publishers</h3>
            <p><?php echo $publishers_count; ?> publishers</p>
        </div>
    </div>
</div>

<?php
?>



