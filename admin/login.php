<?php
// admin/login.php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once '../db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    } else {
        $error = 'Isi username dan password dulu.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login Admin — Warteg Sabili</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Nunito', sans-serif;
            background: #1a1a2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 36px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-brand i { font-size: 2rem; color: #FEA116; }
        .login-brand h1 { font-size: 1.4rem; font-weight: 700; color: #222; margin-top: 8px; }
        .login-brand p { font-size: 0.85rem; color: #888; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #444; margin-bottom: 6px; }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: 'Nunito', sans-serif;
            transition: border-color 0.2s;
        }
        .form-group input:focus { outline: none; border-color: #FEA116; }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #FEA116;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-login:hover { background: #e8920a; }
        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 18px;
            border-left: 3px solid #dc2626;
        }
        .back-link { text-align: center; margin-top: 18px; font-size: 0.85rem; }
        .back-link a { color: #FEA116; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <i class="fa fa-utensils"></i>
            <h1>Warteg Sabili</h1>
            <p>Panel Admin</p>
        </div>
        <?php if ($error): ?>
            <div class="alert-error"><i class="fa fa-exclamation-circle me-1"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        <div class="back-link">
            <a href="../index.html"><i class="fa fa-arrow-left"></i> Kembali ke website</a>
        </div>
    </div>
</body>
</html>
