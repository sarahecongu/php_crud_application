









<?php
session_start();
include('./controller/config.php');
include('./controller/searchhandler.php');


if (!isset($_SESSION['id'])) { // Check if the session id is not set
    header('Location: login.php?error=login_required');
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <style>
        /* Your CSS styles here */
    </style>
</head>

<body class="bg-dark text-white">

    <h3>Welcome to our app <?php echo ucfirst($_SESSION['first_name']) ?></h3>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <?php if (isset($_SESSION['message'])): ?>
                    <h5 class="alert alert-success">
                        <?= $_SESSION['message']; ?>
                    </h5>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="index.php" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" required value="<?php if (isset($_GET['search'])) { echo $_GET['search']; } ?>" placeholder="search" name="search">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <span class="col-2">
                                <a href="employee_add.php" class="btn btn-primary float-end"><i class="bi bi-person-plus-fill"></i> ADD</a>
                            </span>
                            <span class="col-2">
                                <a href="./controller/logout.php?logout=true" class="btn btn-danger float-end" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  if (empty($searchedRecords)) {
                                    $query = "SELECT * FROM members ORDER BY id DESC";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                    $searchedRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
                               
                                // if empty
                                    if (!empty($searchedRecords)) {
                                        foreach ($searchedRecords as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= ucfirst($row['first_name']); ?></td>
                                            <td><?= ucwords(substr($row['last_name'], 0, 2)) . strtolower(substr($row['last_name'], 2)); ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><?= $row['created_at']; ?></td>
                                            <td><?= $row['updated_at']; ?></td>
                                            <td>
                                                <a href="employee_update.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm float-end">
                                                    <i class="bi bi-pencil-square"></i> EDIT
                                                </a>
                                            </td>
                                            <td>
                                                <form action="./controller/formhandler.inc.php" method="POST">
                                                    <button type="submit" name="delete_employee" class="btn btn-danger btn-sm float-end" value="<?= $row['id']; ?>">
                                                        <i class="bi bi-trash3"></i> DELETE
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="8">No Record</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
