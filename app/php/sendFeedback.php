<?php
    session_start();

    require_once("config.inc.php");

    if (isset($_POST['submit'])) {
        if (empty($_POST['email'])) {
            $_SESSION['error'] = '<span class="err">Введите E-mail!</span>';
        }
        elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email'])) {
            $_SESSION['error'] = '<span class="err">E-mail имеет недопустимий формат! Например, name@gmail.com!</span>';
        }
        elseif (empty($_POST['subject'])){
            $_SESSION['error'] = '<span class="err">Введите тему сообщения!</span>';
        }
        elseif (!preg_match("#^([ёЁ\sA-zА-я -]*)$#ui", $_POST['subject'])) {
            $_SESSION['error'] = '<span class="err">Тема содержит недопустимые символы!</span>';
        }
        elseif (empty($_POST['msg'])){
            $_SESSION['error'] = '<span class="err">Сообщение слишком короткое!</span>';
        }
        else {
            $email = $_POST["email"];
            $subject = $_POST["subject"];
            $msg = stripcslashes($_POST["msg"]);
            $msg = trim(htmlspecialchars($msg));
            $dateNow = date("Y-m-d");
            $projectName = $_POST["project_name"];
            $formSubject = $_POST["form_subject"];

            $query = "INSERT INTO feedback(email, subject, message, date, status) 
                          VALUES ('$email', '$subject', '$msg', '$dateNow', 1)";

            if ($db->query($query)) {
                $query = "SELECT email FROM user WHERE status = 3";
                $result = $db->query($query);

                if ($result->num_rows > 0) {
                    $adminEmails = $result->fetch_all(MYSQLI_NUM);
                    for ($i = 0; $i < $result->num_rows; $i++) {
                        for ($j = 0; $j < $result->field_count; $j++) {
                            sendEmail($adminEmails[$i][$j], $projectName, $formSubject);
                        }
                    }
                }

                $_SESSION['message'] = '<span class="msg">Спасибо за обращение!</span>';
                echo "<meta http-equiv='Refresh' content='0, URL=feedback.php'>";
            }
            else {
                $_SESSION['error'] = "<span class='err'>Ошибка обращения к базе данных №{$db->error}</span>";
                echo "<meta http-equiv='Refresh' content='0, URL=feedback.php'>";
            }
        }
    }

    function sendEmail($adminEmail, $projectName, $formSubject) {
        $c = true;
        $message = "";

        foreach ($_POST as $key => $value ) {
            if ($value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject") {
                $message .= "
                " . (($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">') . "
                <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
                <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
            </tr>
            ";
            }
        }

        $message = "<table style='width: 100%;'>$message</table>";

        function adopt($text) {
            return '=?UTF-8?B?'.Base64_encode($text).'?=';
        }

        $headers = "MIME-Version: 1.0" . PHP_EOL .
            "Content-Type: text/html; charset=utf-8" . PHP_EOL .
            'From: '.adopt($projectName).' <'.$adminEmail.'>' . PHP_EOL .
            'Reply-To: '.$adminEmail.'' . PHP_EOL .
            'Return-Path:  <no-reply@wartur.ru>' . PHP_EOL;

        mail($adminEmail, adopt($formSubject), $message, $headers);
    }

$db -> close();

