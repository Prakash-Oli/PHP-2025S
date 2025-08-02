<?php
session_start();
require_once "include/header.php";
require_once "include/user.php";
require_once "include/database.php";

$db = Database::getInstance();;
$user = new User($db);
$error = '';
$usernameOrEmail = '';




if($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = trim($_POST['usernameOrEmail']??'');
    $password = trim($_POST['password']??'');

    if(empty($usernameOrEmail) || empty($password)) {
        $error = "Username or password is required.";
    }else{
        $authUser = $user->login($usernameOrEmail, $password);
        if($authUser) {
            $_SESSION['user_id'] = $authUser['id'];
            $_SESSION['username'] = $authUser['username'];
            $redirect = $_GET['redirect']?? 'index.php';
            $allowedPages = ['index.php', 'create.php', 'update.php', 'delete.php', 'login.php'];
            if(!in_array(basename($redirect), $allowedPages)) {
                $redirect = 'index.php';
            }
            header("Location: $redirect");
            exit;
        }else{
            $error = "Username or password is incorrect.";
        }
    }

}
?>

<section class="login_section">
    <h1>
        Login Page
    </h1>
    <?php
    if(!empty($error)):?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif;

    ?>

    <form action="login.php" method="post" novalidate>
        <label for="UsernameOrEmail">Username Or Email:</label>
        <input
            type="text"
            id="UsernameOrEmail"
            name="usernameOrEmail"
            placeholder="Please enter your username or email address"
            size="50"
            required
            value="<?= htmlspecialchars($usernameOrEmail) ?>"
            ><br><br>
        <label for="Password">Password:</label>
        <input
        type="password"
        id="Password"
        name="password"
        placeholder="Please enter your password"
        size="40"
        required
        ><br><br>
        <button type="submit">Login</button>
    </form>

</section>
<?php require_once "include/footer.php" ?>
