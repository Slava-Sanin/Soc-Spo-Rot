<?php
///////////////////////////////////////////////////////////////////////////////////
//      send_the_mail
///////////////////////////////////////////////////////////////////////////////////
function send_the_mail()
{
    global $error;
    global $linked_user_email;
    global $token;
    global $host;
    global $user_login;

    $error = $_SESSION['error'] = "<span style='color: #299629;'>The link for password changing was sended to your email!</span>";

    // mb_send_mail($_POST['user_email'],'Passwor recovering','Please choose your new password for loging in in soc-spo-rot.com!','soc-spo-rot@gmail.com');
    //$result = mail($linked_user_email, 'Password recovering', 'Please choose your new password for loging in into Soc-Spo-Rot.com!', 'From: soc-spo-rot@gmail.com \r\n', '-fsoc-spo-rot@gmail.com');

    //$headers = 'From: '.$linked_user_email . "\r\n" .'Content-type: text/plain; charset="windows-1251"' . "\r\n";
    $headers = 'From: ' . $linked_user_email . "\r\n" ."MIME-Version: 1.0" . "\r\n" .'Content-type: text/html; charset="utf-8"' . "\r\n";
    $mess = 'Please choose your new password for loging in into Soc-Spo-Rot.com! <br> <a href="http://'.$host.'/Support/changepass.php?username='.$user_login.'&token='.$token.'">Change the password</a>';
    $title = 'Password recovering';
    $result = mail($linked_user_email, $title, $mess, $headers);
    if ($result)
    {
    //     echo 'все путем';
    }
    else
    {
    //     echo 'что-то не так';
    }
}
///////////////////////////////////////////////////////////////////////////////////
/////////////////////////////
//    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
//    $mail->SMTPAuth = true;                               // Enable SMTP authentication
//    $mail->Username = 'slava.sanin@gmail.com';                 // SMTP username
//    $mail->Password = 'pisces9292';                           // SMTP password
//    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//    $mail->Port = 587; //2525; //465; //25; //26;  //587;                   // TCP port to connect to
/////////////////////////////
//    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
//    $mail->SMTPAuth = true;                               // Enable SMTP authentication
//    $mail->Username = 'slava.sanin@gmail.com';                 // SMTP username
//    $mail->Password = 'pisces9292';                           // SMTP password
//    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//    $mail->Port = 587; //2525; //465; //25; //26;  //587;                   // TCP port to connect to
/////////////////////////////
$config['smtp_host'] = 'ssl://smtp.gmail.com';  //сервер для отправки почты
$config['smtp_username'] = 'slava.sanin@gmail.com';  //Смените на адрес своего почтового ящика.
$config['smtp_port'] = '465'; // Порт работы.
$config['smtp_password'] = 'pisces9292';  //Измените пароль
$config['smtp_debug'] = true;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
$config['smtp_charset'] = 'utf-8';    //кодировка сообщений. (windows-1251 или utf-8, итд)
$config['smtp_from'] = 'gmail.com'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
/////////////////////////////
$config['smtp_host'] = 'mail.smtp2go.com';  // Specify main and backup SMTP servers
$config['smtp_username'] = 'slava.sanin@gmail.com';                 // SMTP username
$config['smtp_port'] = 2525; //465; //25; //26;  //587;                                 // TCP port to connect to
$config['smtp_password'] = 'pisces9494';                           // SMTP password
$config['smtp_debug'] = true;                               // Enable SMTP authentication
$config['smtp_charset'] = 'utf-8';
$config['smtp_secure'] = 'tls';                            // Enable TLS encryption, `ssl` also accepted
/////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
//    send_the_PHPMailer_mail
///////////////////////////////////////////////////////////////////////////////////
function send_the_PHPMailer_mail($who, $to_email, $subject, $text)
{
    global $config;
    global $error;
    global $linked_user_email;
    global $token;
    global $host;
    global $user_login;

    // mb_send_mail($_POST['user_email'],'Passwor recovering','Please choose your new password for loging in in soc-spo-rot.com!','soc-spo-rot@gmail.com');

    //$result = mail($linked_user_email, 'Password recovering', 'Please choose your new password for loging in into Soc-Spo-Rot.com!', 'From: soc-spo-rot@gmail.com \r\n', '-fsoc-spo-rot@gmail.com');

    //$headers = 'From: '.$linked_user_email . "\r\n" .'Content-type: text/plain; charset="windows-1251"' . "\r\n";

    date_default_timezone_set('Etc/UTC');
    //require_once "../vendor/autoload.php";
    require '../PHPMailer/PHPMailerAutoload.php';
    //require_once '../PHPMailer/class.phpmailer.php';

    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
 // $mail->isMail();                                      // Set mailer to use ...
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    // $mail->SMTPAutoTLS = true;
    //$mail->Host = 'server191.web-hosting.com';  // Specify main and backup SMTP servers

    $mail->Host = $config['smtp_host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $config['smtp_username'];                 // SMTP username
    $mail->Password = $config['smtp_password'];                           // SMTP password
    $mail->SMTPSecure = $config['smtp_secure'];                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $config['smtp_port'];                                 // TCP port to connect to

    $mail->setFrom('socsporot@gmail.com', 'Soc-Spo-Rot.com');
    // $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
    $mail->addAddress($to_email);               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(false);                                  // Set email format to HTML
    //$title = 'Password recovering';
    $mail->Subject = $subject;
    //$mess = 'Please choose your new password for loging in into Soc-Spo-Rot.com! <br> <a href="http://'.$host.'/Support/changepass.php?username='.$user_login.'&token='.$token.'">Change the password</a>';
    $mail->Body = $text;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->AltBody = $text;
    $mail->CharSet = $config['smtp_charset'];
    //$headers = 'From: '.$linked_user_email . "\r\n" ."MIME-Version: 1.0" . "\r\n" .'Content-type: text/html; charset="utf-8"' . "\r\n";

    if(!$mail->send())
    {
       $error = $_SESSION['error'] = 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
        return 0;
    } else {
                $error = $_SESSION['error'] = "<span style='color: #299629'>Message has been sent</span>";
                return 1;
           }
}
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
//      send_MailSmtpClass
///////////////////////////////////////////////////////////////////////////////////
function send_MailSmtpClass($who, $to_email, $subject, $text)
{
    global $error;
    global $linked_user_email;
    global $token;
    global $host;
    global $user_login;

    $error = $_SESSION['error'] = "<span style='color: #299629;'>The link for password changing was sended to your email!</span>";

    require_once "../SendMailSmtpClass.php"; // подключаем класс

    //$mailSMTP = new SendMailSmtpClass('slava.sanin1974@yandex.ru', 'pentagon9999', 'smtp.yandex.ru', 'soc-spo-rot.com', 465); // создаем экземпляр класса
    $mailSMTP = new SendMailSmtpClass('socsporot@gmail.com', 'pisces9393', 'ssl://smtp.gmail.com', 'Soc-Spo-Rot.com', 465); // создаем экземпляр класса
    //$mailSMTP = new SendMailSmtpClass('socsporot@gmail.com', 'pisces9393', 'smtp.gmail.com', 'soc-spo-rot.com', 465); // создаем экземпляр класса
    //$mailSMTP = new SendMailSmtpClass('логин', 'пароль', 'хост', 'имя отправителя');

    // заголовок письма
    $headers= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
    $headers .= "From: Soc-Spo-Rot.com <socsporot@gmail.com>\r\n"; // от кого письмо
    //$mess = 'Please choose your new password for loging in into Soc-Spo-Rot.com! <br> <a href="http://'.$host.'/Support/changepass.php?username='.$user_login.'&token='.$token.'">Change the password</a>';
    $result =  $mailSMTP->send($to_email, $subject, $text, $headers); // отправляем письмо
    // $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Заголовки письма');
    if($result === true)
    {
       //echo "Письмо успешно отправлено";
       $error = $_SESSION['error'] = "<span style='color: #299629'>Message has been sent</span>";
       return 1;
    }else{
            //echo "Письмо не отправлено. Ошибка: " . $result;
            $error = $_SESSION['error'] = 'Message could not be sent.';
            return 0;
         }
}
///////////////////////////////////////////////////////////////////////////////////

//Источник материала: http://i-leon.ru/smtp-php/
///////////////////////////////////////////////////////////////////////////////////

?>