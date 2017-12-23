<?php
    session_start();

    require_once("../config.inc.php");

    if (isset($_POST['submit'])) {

        unset($_SESSION['error']);
        unset($_SESSION['message']);

        if (empty($_POST['email'])) {
            $_SESSION['error'] = '<span class="err">Введите почту!</span>';
        }
        elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email'])) {
            $_SESSION['error'] = '<span class="err">E-mail имеет недопустимий формат! Например, name@gmail.com!</span>';
        }
        elseif (empty($_POST['password'])) {
            $_SESSION['error'] = '<span class="err">Введите пароль!</span>';
        }
        elseif (!preg_match("/\A(\w){6,20}\Z/", $_POST['password'])) {
            $_SESSION['error'] = '<span class="err">Пароль слишком короткий! Пароль должен быть не менее 6 символов!</span>';
        }
        else {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $email = stripslashes($email);
            $email = htmlspecialchars($email);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);

            $email = trim($email);
            $password = trim($password);
            $password = md5($password);

            $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
            $result = $db->query($query);
            $user = $result->fetch_array(MYSQLI_ASSOC);

            if (empty($user['id'])) {
                $_SESSION['error'] = '<span class="err">Извините, введённый вами email или пароль неверный.</span>';
            }
            else {
                setcookie('id', $user['id'], time() + 86400, '/app', 'localhost');
                $_SESSION['message'] = '<span class="msg">Вы успешно вошли в систему!</span>';
                echo "<meta http-equiv='Refresh' content='0, URL=../../index.php'>";
            }
        }
    }

$db -> close();

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">

        <title>Cool Study</title>

        <meta name="keyword" content="">
        <meta name="description" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon"/>
    </head>
    <body>

        <header class="page_header">
            <div class="header_top">
                <button class="hamburger"><img src="../../img/arrow.png"></button>
                <nav class="main_nav">
                    <ul>
                        <li class="main_nav__link link-blue"><a href="../../index.php"><img src="../../img/home.png" alt="Главная"></a></li>
                        <li class="main_nav__link link-orange"><a href="../possibilities.php">Возможности</a></li>
                        <li class="main_nav__link link-yellow"><a href="../documentation.php">Документация</a></li>
                        <li class="main_nav__link link-purple"><a href="../feedback.php">Обратная связь</a></li>
                        <li class="main_nav__link link-green"><a href="../about.php">О нас</a></li>
                        <li class="main_nav__link link-brown"><a href="#">Перейти к системе</a></li>
                        <?
                            if (!isset($_COOKIE['id'])) {
                                echo '<li class="main_nav__link link-red" title="active"><a href="authorization.php">Войти</a></li>';
                            }
                            else {
                                echo '<li class="main_nav__link link-red" title="active"><a href="sign_out.php">Выйти</a></li>';
                            }
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="header_bottom">
                <div class="header_bottom__logo">
                    <img src="../../img/logo.png" alt="Cool Study">
                    <h1>Авторизация</h1>
                </div>
            </div>
        </header>

        <main>
            <div class="auth">
                <p class="auth__tip">
                    У вас ещё нет учётной записи ?
                    <a href="registration.php">Зарегистрироваться</a>.
                </p>
                <?php
                    if (isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    } elseif ($_SESSION['message']) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                ?>
                <form class="form" action="authorization.php" method="post">
                    <div class="form__group">
                        <label for="email">Почта:</label>
                        <input type="email" name="email" id="email" min="6" max="32" autofocus required>
                    </div>
                    <div class="form__group">
                        <label for="password">Пароль:</label>
                        <input type="password" name="password" id="password" min="6" max="32" required>
                    </div>
                    <button type="submit" name="submit" class="btn">Войти</button>
                </form>
            </div>
        </main>

        <footer class="page_footer">
            <nav class="footer_nav">
                <ul>
                    <li class="footer_nav__link link-purple"><a href="../feedback.php">Обратная связь</a></li>
                    <?
                        if (!isset($_COOKIE['id'])) {
                            echo '<li class="footer_nav__link link-red"><a href="authorization.php">Войти</a></li>';
                        }
                        else {
                            echo '<li class="footer_nav__link link-red"><a href="../../index.php">Войти</a></li>';
                        }
                    ?>
                    <li class="footer_nav__link link-red"><a href="registration.php">Зарегистрироваться</a></li>
                </ul>
            </nav>
            <div class="footer_copyright">
                &copy 2017 Овсянников Владислав
            </div>
        </footer>

    <link rel="stylesheet" type="text/css" href="../../css/styles.min.css"/>
    <script src="../../js/scripts.min.js" async></script>
    </body>
</html>