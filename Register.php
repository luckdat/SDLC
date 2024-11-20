<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .form-group select {
            height: 35px;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Register</h2>
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
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your Email" name="email" required>
            </div>
            <button type="submit" class="btn btn-success btn-block">Register</button>
            <div class="register-link">
                <p>Sign in to your account? <a href="Login.php">Login Now</a></p>
            </div>
        </form>
    </div>
    <?php
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "attendancesystem";

    // Kết nối
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("<script>alert('Connect Error !')</script>");
    } else {
    }

    // Lấy dữ liệu từ form

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        // Câu truy vấn
        $sql = "INSERT INTO user (role, username, password, email) VALUES ( '$role','$username', '$password', '$email')";

        // Thực thi truy vấn
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Add successfully !')</script>";
        } else {
            echo "<script>alert('Add Error !')</script>";
        }

        // Đóng kết nối
        mysqli_close($conn);
    }
    ?>
</body>

</html>