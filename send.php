<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Формирование самого письма
$title = "Нове повідомлення з сайту";
$body = "
<h2>Нове повідомлення</h2>
<b>Ім'я:</b> $name<br>
<b>Пошта:</b> $email<br><br>
<b>Телефон:</b> $phone<br><br>
<b>Про бізнес:</b><br>$message
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
    };

    // Настройки вашей почты
    $mail->Host = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username = 'mr.sokolsergey@gmail.com'; // Логин на почте
    $mail->Password = 'igvz ujem nbth aeqi'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Port = 465;
    $mail->setFrom('mr.sokolsergey@gmail.com', 'Тест Тест'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('mr.sokolsergey@gmail.com');
    //$mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отравленность сообщения
    if ($mail->send()) {
        $result = "success";
    } else {
        $result = "error";
    }

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
//echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
header('Location: mail.php');