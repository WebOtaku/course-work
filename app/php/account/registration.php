<?php
    session_start();

    require_once("config.inc.php");


    if (isset($_POST['submit'])){

        unset($_SESSION['error']);
        unset($_SESSION['message']);

        if(empty($_POST['login'])) {
            $_SESSION['error'] = '<span class="err">Введите логин!</span>';
        }
        elseif (!preg_match("/^\w{3,}$/", $_POST['login'])) {
            $_SESSION['error'] = '<span class="err">В поле "Логин" введены недопустимые символы! Только буквы, цифры и подчеркивание!</span>';
        }
        elseif(empty($_POST['password'])) {
            $_SESSION['error'] = '<span class="err">Введите пароль!</span>';
        }
        elseif (!preg_match("/\A(\w){6,20}\Z/", $_POST['password'])) {
            $_SESSION['error'] = '<span class="err">Пароль слишком короткий! Пароль должен быть не менее 6 символов!</span>';
        }
        elseif(empty($_POST['password_repeat'])) {
            $_SESSION['error'] = '<span class="err">Введите подтверждение пароля!</span>';
        }
        elseif($_POST['password'] != $_POST['password_repeat']) {
            $_SESSION['error'] = '<span class="err">Введенные пароли не совпадают!</span>';
        }
        elseif(empty($_POST['email'])) {
            $_SESSION['error'] = '<span class="err">Введите E-mail!</span>';
        }
        elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email'])) {
            $_SESSION['error'] = '<span class="err">E-mail имеет недопустимий формат! Например, name@gmail.com!</span>';
        }
        else {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $mdPassword = md5($password);
            $email = $_POST['email'];
            $reg_date = date("Y-m-d");
            $name = $_POST['name'];
            $last_name = $_POST['last_name'];
            $status = $_POST['status'];
            $rights = 'user';

            $query = ("SELECT id FROM user WHERE login='$login'");
            $result = $db->query($query) or die('Ошибка: '. $db->error);

            if ($result->num_rows > 0) {
                $_SESSION['error'] = '<span class="err">Пользователь с таким логином зарегистрирован!</span>';
            }
            else {
                $query = ("SELECT id FROM user WHERE email='$email'");
                $result = $db->query($query) or die('Ошибка: '. $db->error);

                if ($result->num_rows > 0) {
                    $_SESSION['error'] = '<span class="err">Пользователь с таким e-mail уже зарегистрирован!</span>';
                }
                else {
                    $query = "INSERT INTO user(login, email, password, name, last_name, reg_date, status, rights)
                                  VALUES ('$login', '$email', '$mdPassword',  '$name', '$last_name', '$reg_date', '$status', '$rights')";

                    $result = $db->query($query) or die('Ошибка: '. $db->error);
                    $_SESSION['message'] = '<span class="msg">Вы успешно зарегистрировались!</span>';
                    //echo "<meta http-equiv='Refresh' content='0, URL=../../index.php'>";
                }
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
                        <li class="main_nav__link link-purple"><a href="../feedback_form.php">Обратная связь</a></li>
                        <li class="main_nav__link link-green"><a href="../about_us.php">О нас</a></li>
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
                    <h1>Регистрация</h1>
                </div>
            </div>
        </header>

        <main>
            <div class="auth">
                <p class="auth__tip">
                    Уже есть учётная запись ?
                    <?
                        if (!isset($_COOKIE['id'])) {
                            echo '<a href="authorization.php">Войти</a>';
                        }
                        else {
                            echo '<a href="../../index.php">Войти</a>';
                        }
                    ?>
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
                <form class="auth__form" action="registration.php" method="post">
                    <div class="auth__form__group">
                        <label for="name">Имя:</label>
                        <input type="text" name="name" id="name" min="2" max="32" required>
                    </div>
                    <div class="auth__form__group">
                        <label for="last_name">Фамилия:</label>
                        <input type="text" name="last_name" id="last_name" min="2" max="32" required>
                    </div>
                    <div class="auth__form__group">
                        <label for="status">Статус:</label>
                        <select name="status" id="status">
                            <option value="1">Студент/ученик</option>
                            <option value="2">Преподаватель/учитель</option>
                        </select>
                    </div>
                    <div class="auth__form__group">
                        <label for="login">Логин:</label>
                        <input type="text" name="login" id="login" min="6" max="32" required>
                    </div>
                    <div class="auth__form__group">
                        <label for="email">Почта:</label>
                        <input type="email" name="email" id="email" min="6" max="32" required>
                    </div>
                    <div class="auth__form__group">
                        <label for="password">Пароль:</label>
                        <input type="password" name="password" id="password" min="6" max="32" required>
                    </div>
                    <div class="auth__form__group">
                        <label for="password_repeat">Повторите пароль:</label>
                        <input type="password" name="password_repeat" id="password_repeat" min="6" max="32" required>
                    </div>
                    <button type="submit" name="submit" class="btn">Зарегистрироваться</button>
                </form>
            </div>
        </main>

        <footer class="page_footer">
            <nav class="footer_nav">
                <ul>
                    <li class="footer_nav__link link-purple"><a href="../feedback_form.php">Обратная связь</a></li>
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