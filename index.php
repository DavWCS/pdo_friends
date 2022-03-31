<?php 
require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO FRIENDS QUEST</title>
</head>
<body>
<h1>List of my dearest friends :</h1>

<?php

//Création liste HTML de tous les friends :

foreach($friends as $friend) {
?>
<div>
    <?php echo $friend['firstname'] . ' ' . $friend['lastname']; ?>
</div>
<?php
}
?>
<br><br>
<h2>Add a friend !</h2>

<form method="post">
    <div>
      <label  for="firstname">firstname :</label>
      <input  type="text"  id="firstname"  name="firstname">
        <p>
            <?php
            if (empty($_POST['firstname']))
            {
            echo 'Please, tell Your firstname';
            }
            ?>
        </p>
    </div>
    <div>
      <label  for="lastname">lastname :</label>
      <input  type="text"  id="lastname"  name="lastname">
        <p>
            <?php
            if (empty($_POST['lastname']))
            {
            echo 'Please, tell Your lastname';
            }
            ?>
        </p>
    </div>
    <div  class="button">
      <button  type="submit">Add a new friend</button>
    </div>
</form>
    <?php

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    if ( !empty($firstname) && !empty($lastname)) {
        if (strlen($firstname) < 45 && strlen($lastname) < 45) {
            $newQuery = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
            $statement = $pdo->prepare($newQuery);

            $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
            $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

            $statement->execute();
        }
    }
    ?>
</body>
</html>

