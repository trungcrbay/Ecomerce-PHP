<?php
include('../connect/connect.php');
if (isset($_POST['update_user'])) {
    $role = $_POST['role'];
    $email = $_POST['email'];
    $update_query = "update `users` set role='$role' where email ='$email'";
    $result_query = mysqli_query($connect, $update_query);
    if ($result_query) {
        echo "<script>alert('Cập nhật thành công!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
    <div>
        <h1 class="text-center">Quyền truy cập tài khoản</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-4 w-50 m-auto">
                <!--Role-->
                <label for="role" class="form-label">Quyền</label>
                <input type="text" name="role" id="role" class="form-control " placeholder="Nhập quyền"
                    autocomplete="off" required="required">

                <!--Email-->
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" class="form-control " placeholder="Nhập email"
                    autocomplete="off" required="required">
                <div class="form-outline mb-4 w-50 m-auto my-5">
                    <input type="submit" name="update_user" class="btn btn-primary mx-auto d-block " value="Cập nhật">
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
</body>

</html>