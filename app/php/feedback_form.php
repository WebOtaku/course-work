<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">

        <title>Cool Study</title>

        <meta name="keyword" content="">
        <meta name="description" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon"/>
    </head>
    <body>

        <header class="page_header">
            <div class="header_top">
                <button class="hamburger"><img src="../img/arrow.png"></button>
                <nav class="main_nav">
                    <ul>
                        <li class="main_nav__link link-blue"><a href="../index.php"><img src="../img/home.png" alt="Главная"></a></li>
                        <li class="main_nav__link link-orange"><a href="../php/possibilities.php">Возможности</a></li>
                        <li class="main_nav__link link-yellow"><a href="../php/documentation.php">Документация</a></li>
                        <li class="main_nav__link link-purple" title="active"><a href="../php/feedback_form.php">Обратная связь</a></li>
                        <li class="main_nav__link link-green"><a href="../php/about_us.php">О нас</a></li>
                        <li class="main_nav__link link-brown"><a href="#">Перейти к системе</a></li>
                        <?
                            if (!isset($_COOKIE['id'])) {
                                echo '<li class="main_nav__link link-red"><a href="account/authorization.php">Войти</a></li>';
                            }
                            else {
                                echo '<li class="main_nav__link link-red"><a href="account/sign_out.php">Выйти</a></li>';
                            }
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="header_bottom">
                <div class="header_bottom__logo">
                    <img src="../img/logo.png" alt="Cool Study">
                    <h1>Обратная связь</h1>
                </div>
            </div>
        </header>

        <main>
            <div class="work_in_progress">
                <img src="../img/funct.png" alt="Мир">
                <span>Ведуться работы</span>
            </div>
        </main>

        <footer class="page_footer">
            <nav class="footer_nav">
                <ul>
                    <li class="footer_nav__link link-purple"><a href="../php/feedback_form.php">Обратная связь</a></li>
                    <?
                        if (!isset($_COOKIE['id'])) {
                            echo '<li class="footer_nav__link link-red"><a href="account/authorization.php">Войти</a></li>';
                        }
                        else {
                            echo '<li class="footer_nav__link link-red"><a href="../index.php">Войти</a></li>';
                        }
                    ?>
                    <li class="footer_nav__link link-red"><a href="account/registration.php">Зарегистрироваться</a></li>
                </ul>
            </nav>
            <div class="footer_copyright">
                &copy 2017 Овсянников Владислав
            </div>
        </footer>

    <link rel="stylesheet" type="text/css" href="../css/styles.min.css"/>
    <script src="../js/scripts.min.js" async></script>
    </body>
</html>