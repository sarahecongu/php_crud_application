<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']) ) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
      
        // email validation

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($password == $password) {
              
                $sql = "SELECT * FROM members WHERE email = :email ";
                $handle = $pdo->prepare($sql);
                $params = ['email' => $email];
                $handle->execute($params);
                if ($handle->rowCount() > 0) {
                    $getRow = $handle->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $getRow['pwd'])) {
                        unset($getRow['password']);
                        $_SESSION = $getRow;
                        header('location:./index.php');
                        exit();
                    } else {
                        $errors[] = "Wrong Email or Password";
                    }
                } else {
                    $errors[] = "Wrong Email or Password";
                }
            }
        } else {
            $errors[] = "Email address is not valid";
        }
    } else {
        $errors[] = "Email, Password are required";
    }
}