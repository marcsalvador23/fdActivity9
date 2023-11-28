<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
    body {
        background-color: #ffc77d ;
        font-family: Arial, sans-serif;
    }

    form {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form p {
        margin-bottom: 10px;
    }

    form input {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    form button {
        background-color: green;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    table {
      color: black;
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
      color: black;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color:#ffcb69;
        color: black;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    a {
        text-decoration: none;
        margin-right: 10px;
    }

</style>

</head>
<body>
    <!-- Your PHP and HTML code here -->
</body>
</html>

<?php
session_start();
include('connection_db.php');
include('global.php');
$id = null;
$fname = null;
$email = null;
$phone = null;
$title = null;
$created = null;

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE `id`='$id'";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result, "", "");
    header("Location: /activity9/");
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {

    $fname = $_GET['fname'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $title = $_GET['title'];
    $created = $_GET['created'];
    
    $id = $_GET['id'];
}

if (isset($_POST['fname'])  && !isset($id)) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $created = $_POST['created'];
  
    $sql = "INSERT INTO users (fname, email, phone, title, created) 
    VALUES ('$fname', '$email', '$phone', '$title', '$created')";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result, "create", $fname);
    header("Location: /activity9/");
}

if (isset($_POST['fname'])  && isset($id)) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_GET['title'];
    $created = $_GET['created'];
    $id = $_GET['id'];
    $sql = "UPDATE users SET fname='$fname',email='$email', phone='$phone', title='$title', created='$created' WHERE id='$id'";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result, "update", $fname);
}

?>
<form method="POST" action="">
    <p>Name <input name="fname" value="<?= isset($fname) ? $fname : '' ?>"> </p>
    <p>E-Mail <input name="email" value="<?= isset($email) ? $email : '' ?>"> </p>
    <p>Phone <input name="phone" value="<?= isset($phone) ? $phone : '' ?>"> </p>
    <p>Title <input name="title" value="<?= isset($title) ? $title : '' ?>"> </p>
    <p>Created <input name="created" type="date" value="<?= isset($created) ? $created : '' ?>"> </p>
    <br> <br>
    <?php if (isset($id)) { ?>
        <a href="/activity9/">Cancel</a>
        <button>Update</button>
    <?php } else { ?>
        <button>Save</button>
    <?php } ?>
</form>

List Of users

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Phone</th>
            <th>Title</th>
            <th>Created</th>
            <th>Actions</th>
            
        </tr>
    </thead>

    <tbody>
        <?php
        $sql = "SELECT * FROM users";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td width="200"> <a style="color: red" href="?action=delete&id=<?= $row['id'] ?>"> DELETE </a>
                    <a href="?action=edit&id=<?= $row['id'] ?>&fname=<?= $row['fname'] ?>&email=<?= $row['email']?>&phone=<?= $row['phone']?>&title=<?= $row['title'] ?>&created=<?= $row['created'] ?>"> EDIT </a>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>