
<?php
include('./controller/config.php');

$searchedRecords = [];

if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search =$_POST['search'];
    $query = "SELECT * FROM members WHERE first_name= :search OR last_name= :search OR email= :search ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->execute();
    $searchedRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else {
     //   if no one is searching display all the records
     if (empty($searchedRecords)) {
        $query = "SELECT * FROM members ORDER BY id DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $searchedRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    
   
    }
}