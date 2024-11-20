<?php
// Kết nối đến file cấu hình để thiết lập kết nối với cơ sở dữ liệu
include "Check_Login.php";
$username = $password = "";
$username_err = $password_err = "";

// Kiểm tra xem form đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem trường 'username' có trống không
    if (empty(trim($_POST["username"]))) {
        $username_err = "Vui lòng nhập tên đăng nhập.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Kiểm tra xem trường 'password' có trống không
    if (empty(trim($_POST["password"]))) {
        $password_err = "Vui lòng nhập mật khẩu.";
    } else {
        $password = trim($_POST["password"]);
    }
    // Kiểm tra lỗi trước khi xử lý đăng nhập
    if (empty($username_err) && empty($password_err)) {
        // Chuẩn bị câu lệnh SQL để truy vấn thông tin người dùng
        $sql = "SELECT userId, username, password FROM user WHERE username = ?";
        
        // Chuẩn bị statement để thực thi câu lệnh
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Gắn giá trị biến vào statement đã chuẩn bị
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Đặt giá trị cho biến $param_username
            $param_username = $username;

            // Thực thi câu lệnh đã chuẩn bị
            if (mysqli_stmt_execute($stmt)) {
                // Lưu kết quả trả về
                mysqli_stmt_store_result($stmt);

                // Kiểm tra xem username có tồn tại không, nếu có thì kiểm tra mật khẩu
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Gắn kết quả vào các biến
                    mysqli_stmt_bind_result($stmt, $userId, $username, $hashed_password);

                    // Lấy dữ liệu từ kết quả
                    if (mysqli_stmt_fetch($stmt)) {
                        // Kiểm tra xem mật khẩu nhập vào có khớp với mật khẩu đã mã hóa trong cơ sở dữ liệu không
                        if (password_verify($password, $hashed_password)) {
                            // Nếu mật khẩu đúng, bắt đầu phiên đăng nhập mới
                            session_start();
                            $_SESSION["userId"] = $userId; // Đổi $userId thành $id
                            $_SESSION["username"] = $username;

                            // Chuyển hướng người dùng đến trang chính
                            header("location: main.php");   
                            exit();
                        } else {
                            // Thông báo lỗi nếu mật khẩu không đúng
                            $password_err = "Mật khẩu bạn nhập không hợp lệ.";
                        }
                    }
                } else {
                    // Thông báo lỗi nếu tên đăng nhập không tồn tại
                    $username_err = "Không tìm thấy tài khoản với tên đăng nhập này.";
                }
            } else {
                echo "Lỗi! Vui lòng thử lại sau.";
            }

            // Đóng statement
            mysqli_stmt_close($stmt);
        }
    }

    // Đóng kết nối
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
</style>

<body>
    <div class="container">
        <h2>Vertical (basic) form</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="username" class="form-control" id="username" placeholder="Enter username" name="username">
                <span class="text-danger"> <?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                <span class="text-danger"> <?php echo $password_err; ?></span>
            </div>
            <button class="btn btn-success">Submit</button>
            <p>Don't have an account?</p> <a href="Register.php">Register here</a>
        </form>
    </div>
</body>

</html>


