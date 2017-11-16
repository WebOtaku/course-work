<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Cool Study</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

        <header class="page_header">
            <div class="header_top">
                <button class="hamburger"><img src="img/hamburger.png"></button>
                <nav class="main_nav">
                    <ul>
                        <li class="main_nav__link link-blue" title="active"><a href="index.php"><img src="img/home.png" alt="Главная"></a></li>
                        <li class="main_nav__link link-orange"><a href="php/possibilities.php">Возможности</a></li>
                        <li class="main_nav__link link-yellow"><a href="php/documentation.php">Документация</a></li>
                        <li class="main_nav__link link-purple"><a href="php/feedback_form.php">Обратная связь</a></li>
                        <li class="main_nav__link link-green"><a href="php/about_us.php">О нас</a></li>
                        <li class="main_nav__link link-brown"><a href="#">Перейти к системе</a></li>
                        <li class="main_nav__link main_nav__link-log_in link-red "><a href="php/authorization_form.php">Войти</a></li>
                    </ul>
                </nav>
            </div>
            <div class="promo">
                <div class="promo__darkness">
                    <div class="promo__slogan">
                        <img src="img/logo.png" alt="Cool Study">
                        <p>Система дистанционного обучения для всех и каждого</p>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="features">
                <h1>Особенности системы</h1>
                <ul>
                    <li class="feature__item">
                        <img src="img/world.png" alt="Мир">
                        <div class="feature__description">
                            <h2>Доступность в любое время, в любом месте</h2>
                            <p>Наш сервис позволяет доступ из любого современного устройства - Mac, PC, планшета или смартфона. Вы можете создать весь курс на планшете и завершить онлайн тест на вашем смартфоне.</p>
                        </div>
                    </li>
                    <li class="feature__item feature__item-right">
                        <img src="img/simple.png" alt="Мир">
                        <div class="feature__description">
                            <h2>Простота использования</h2>
                            <p>Интерфейс и учителя, и ученика прост, не требует никаких специаль-ных навыков.</p>
                        </div>
                    </li>
                    <li class="feature__item">
                        <img src="img/funct.png" alt="Мир">
                        <div class="feature__description">
                            <h2>Функциональность</h2>
                            <p>Вы можете создавать онлайн-курсы с любыми вложениями, онлайн мультимедиа, видео, форумами, домашними заданиями, тестами.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </main>

        <footer class="page_footer">
            <nav class="footer_nav">
                <ul>
                    <li class="footer_nav__link link-purple"><a href="php/feedback_form.php">Обратная связь</a></li>
                    <li class="footer_nav__link link-red"><a href="php/authorization_form.php">Войти</a></li>
                    <li class="footer_nav__link link-red"><a href="php/registration_form.php">Зарегистрироваться</a></li>
                </ul>
            </nav>
            <div class="footer_copyright">
                &copy 2017 Овсянников Владислав
            </div>
        </footer>

        <link rel="stylesheet" type="text/css" href="css/styles.min.css"/>
        <script src="js/scripts.min.js" async></script>
    </body>
</html>