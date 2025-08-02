<?php

session_start();

$pageTitle = "Register";
$pageDescription = "Create a new account";
require_once './include/header.php';
require_once './include/user.php';
require_once './include/database.php';

$db = Database::getInstance();

$user = new user($db);
$error = '';
$username = '';
$email = '';

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');

if(empty($username) || empty($email) || empty($password) || empty($password_confirm)){
    $error = "All fields are required";

}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "Invalid email format";
}elseif($password != $password_confirm){
    $error = "Passwords do not match";
}elseif(strlen($password) < 8){
    $error = "Password too short";
}else {
    $created = $user->register($username, $email, $password);
    if ($created) {
        header("Location: login.php?msg=" . urldecode("Registered successfully!"));
        exit;
    } else {
        $error = "There was an error creating your account";
    }
}
}
?>

<section class="new_register">
    <h1>Register</h1>
</section>
<section class="new_register">
    <?php if(!empty($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <label>Username</label><br>
        <label>
            <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    required
                    value="<?=htmlspecialchars($username) ?>"
            autocomplete="username">
        </label><br>
        <label>Email</label><br>
        <label>
            <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    value="<?= htmlspecialchars($email) ?>"
                    required>
        </label><br>
        <label>Password</label><br>
        <label>
            <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required >
        </label><br>
        <label>Confirm Password</label><br>
        <label>
            <input
                    type="password"
                    name="password_confirm"
                    placeholder="Confirm Password"
                    required >
        </label>
        <button type="submit">Register</button>
    </form>
</section>
<?php require_once './include/footer.php'; ?>