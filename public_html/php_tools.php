<?php	
$SERVER_NAME = "localhost";
$DATABASE_USERNAME = "201501_471_02";
$DATABASE_PASSWORD = "cade&stefano";
$DATABASE = "db201501_471_g02";

/**
 * Get a connection to the database.
 * @return PDO	a connection to the Best-Book-Buy database
 */
function getDatabaseConnection () {
	try {
		$conn = new PDO("mysql:host=$SERVER_NAME;dbname=$DATABASE", $DATABASE_USERNAME, $DATABASE_PASSWORD);
    		// set the PDO error mode to exception
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	} catch(PDOException $e) {
    		echo "Connection failed: " . $e->getMessage();
    		return null;
    	}
	return $conn;
}
?>