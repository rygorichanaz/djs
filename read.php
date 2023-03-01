<?php 
session_start();
require_once "includes/db.inc.php";
?>
<html>
<body>

<?php
// Draw header
include('includes/header.php');
?>

<!-- Draw heading after the header -->
<h1>Products</h1>
<p>Our juices are the greatest in the world! Made with homemade techniques and packaged in renewable biodegradable packaging!</p>
<p>---------</p>
<a href='?order=name'>Sort by Name</a> | <a href='?order=price'>Sort by Price Ascending</a> | <a href='?order=price DESC'>Sort by Price Descending</a>
<br />
<p>---------</p>

<form action="<?php echo "?".$_SERVER['QUERY_STRING']."&search=$search";?>" method="post">
<center>
	<input type="text" name="search">
	<input type="submit" value="Search">
</center>
</form>

<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// collect value of search field
	//$search = $_REQUEST['search'];
//}
$search = $_REQUEST['search'];
$order = $_REQUEST['order'];

if (empty($order)) {
	$order = 'name';
}

// Connect to db
$sql = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY $order";

// This is the procedural style to query the database
$result = mysqli_query($mysqli, $sql);

// START table to hold product entries
echo "<table>";

// Note: Add function to only show update/delete while logged in
// *DONE*
while($row = mysqli_fetch_array($result)) {
	// START a new cell
	echo "<td style='padding-right: 40px' width=400px>";
	// Display 'name' from db as h2 header
	echo "<h2>{$row['name']}</h2><br />";
	// Write 'description' from db to screen
	echo "{$row['description']}<br />";
	// Display 'image' using url from db
	echo "<img src='img/{$row['image']}' height=140px /><br />";
	// Write 'price' from db to screen
	echo "\${$row['price']}<br />";
	// Create a "Buy Now" button
	echo "<button onclick='alert('Thanks for purchasing Orange Juice')'>Buy Now</button>";
	
	// Check if user is logged in to admin acct -- If yes, display "update" and "delete" links
	if($_SESSION['username'] != NULL) {
		echo "<br />";
		echo "<a href='/admin/update.php?id={$row['id']}'>update</a> ";
		echo " <a href='/admin/delete.php?id={$row['id']}'>delete</a>";
	}

	// END cell
	echo "</td>";
}
// END table
echo "</table>";
?>

</body>
</html>