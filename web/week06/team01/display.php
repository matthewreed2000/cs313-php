<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

	require("dbConnect.php");
	$db = get_db();
?>
	<body>
		<div class="container">
         <?php
            $personId = $_GET['personId'];
            $statement = $db->prepare("SELECT * FROM w6_user WHERE Id = :personId");
            $statement->bindValue(':personId', $personId);
            $statement->execute();

            $food = 0;
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
              $id = $row['id'];
              $first = $row['first_name'];
              $last = $row['last_name'];
              $food_id = $row['food_type'];

              $foods = $db->prepare("SELECT * FROM w6_food WHERE Id = :food_id");
              $foods->bindValue(':food_id', $food_id);
              $foods->execute();
              while ($food_row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $food = $food_row['food'];
              }
              echo "<h1>$first $last's favorite food is $food</h1>"
            }
            // retrieve url parameter
            // execute query to pull up data from that id
            // execute another query to get food data
            // display name and favorite food
         ?>

		</div>
	</body>
</html>