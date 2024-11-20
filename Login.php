<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url(https://lvgames.net/wallpaper/hinh-anh-nen-florentino-ba-vuong-am-nhac-lien-quan-mobile-29-5-1920-lvgames.net.jpg);
        }

        .login-container {
            width: 370px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            background-color: #aeb2f9;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            font-weight: 600;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="username" class="form-control" id="username" placeholder="Enter your Username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-block">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="Register.php">Register here</a></p>
            </div>
        </form>
    </div>
    <?php
    $conn = mysqli_connect('localhost', 'root', '', 'attendancesystem');
    if (!$conn) {
        echo "Kết nối thất bại";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        // buoc 2: Lựa từ bảng user cột username = username nhập từ form và cột password có giá trị bằng giá trị nhập từ form
        $sql = "select * from user where username='$username' AND password=$password AND role = '$role'";
        // buoc 3: Thực thi truy vấn từ database
        $result = mysqli_query($conn, $sql);
        // bước 4: Xử lý kết quả truy vấn: đếm số lượng hàng trong kết quả truy vấn
        $check_login = mysqli_num_rows($result);
        if ($check_login == 0) {
            echo "<script>alert('Password or username, Role is incorrect, please try again!')</script>";
            exit();
        }
        if ($check_login > 0) {
            echo "<script>alert('You have logged in successfully !')</script>";
            header("location: main1.php");   
        }
    }
    ?>
</body>

</html>