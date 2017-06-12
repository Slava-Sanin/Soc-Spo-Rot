<?php

$config['smtp_username'] = 'slava.sanin@gmail.com';  //Смените на адрес своего почтового ящика.
$config['smtp_port'] = '465'; // Порт работы.
$config['smtp_host'] = 'ssl://smtp.gmail.com';  //сервер для отправки почты
$config['smtp_password'] = 'pisces9292';  //Измените пароль
$config['smtp_debug'] = true;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
$config['smtp_charset'] = 'utf-8';    //кодировка сообщений. (windows-1251 или utf-8, итд)
$config['smtp_from'] = 'gmail.com'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"

$to = 'username';
$mail_to = 'slava.sanin@gmail.com';
$subject = 'Password recovering';
$message = 'Change password please!';
$headers = '';

$SEND = "Date: " . date("D, d M Y H:i:s") . " UT\r\n";
$SEND .= "Subject: " . base64_encode($subject) . "\r\n";

if ($headers) $SEND .= $headers . "\r\n\r\n";
else {
    $SEND .= "Reply-To: " . $config['smtp_username'] . "\r\n";
    $SEND .= "To: " . base64_encode($to) . "<$mail_to>\r\n";
    $SEND .= "MIME-Version: 1.0\r\n";
    $SEND .= "Content-Type: text/html; charset=" . $config['smtp_charset'] . "\r\n";
    $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
    $SEND .= "From: Soc-Spo-Rot.com " . base64_encode($config['smtp_from']) . "\r\n";
    $SEND .= "X-Priority: 3\r\n\r\n";
}
$SEND .= $message . "\r\n";

echo $SEND;