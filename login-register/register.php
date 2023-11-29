<?php
include('../connect/connect.php');
include('../function/common_function.php');
include('../sendMail.php');
global $connect;
if (isset($_POST['insert-user'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_query = "select * from `users` where email='$email'";
    $check_result = mysqli_query($connect, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email đã tồn tại trong cơ sở dữ liệu. Vui lòng chọn email khác.')</script>";
        echo "<script>window.location.href='http://localhost/ecommerce/login-register/register.php';</script>";
        exit();
    } else {
        $insert_query = "insert into `users`(email,password,role) VALUES ('$email','$hashed_password','user')";
        $result_query = mysqli_query($connect, $insert_query);
        if ($result_query) {
            echo "<script>alert('Tạo mới người dùng thành công !')</script>";
        } else {
            echo "<script>alert('Đã xảy ra lỗi khi đăng ký!')</script>";
            echo "<script>window.location.href='http://localhost/ecommerce/login-register/login.php';</script>";
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>Ecommerce Website</title>
</head>

<body>
    <form class="form-login" action="" method="POST" enctype="multipart/form-data">
        <h2>Đăng ký</h2>
        <div class="form-group input-box">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Email">
            <p class="error">Nhập đúng định dạng email</p>
        </div>
        <div class="form-group input-box">
            <label for="password">Mật khẩu</label>
            <input type="password" minlength="6" class="form-control " id="password" name="password"
                placeholder="Mật khẩu">
            <p class="error">Nhập ít nhất 6 ký tự</p>
            <i class="fa-solid fa-eye showHidePass"></i>

        </div>
        <button type="submit" name="insert-user" class="btn btn-primary button-form">Đăng ký</button>
        <div class="form-action">
            <span>Đã có tài khoản?</span>
            <a href="./login.php">Đăng nhập</a>
        </div>
    </form>

    <script src="../js/action.js"></script>
    <script src="../bootstrap/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>