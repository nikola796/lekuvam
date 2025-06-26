<?php

namespace App\Controllers;


// use App\Core\App;
// use app\models\User;
// use Connection;
//use DateTime;
//use StoPasswordReset;
//use Swift_Mailer;
//use Swift_Message;
//use Swift_SmtpTransport;

class AuthController
{
    public function logout()
    {

        session_destroy();
        redirect(uri());
    }

    /**
     * START SESSION
     */
    public function session_start()
    {
        if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] != 1) {
            redirect(uri());
            exit();
        }

    }

    /**
     * FORGOT PASSWORD. PREPARE TOKEN AND SEND MAIL TO USER.
     */
    // public function forgot_password()
    // {
    //     $user_email = array('email' => $_POST['email']);
    //     $user = new User();
    //     $is_user_pass_exist = $user->check_password($user_email);

    //     if (isset($is_user_pass_exist[0]['id']) && $is_user_pass_exist[0]['id'] > 0) {
    //         // Generate a new token with its hash
    //         StoPasswordReset::generateToken($tokenForLink, $tokenHashForDatabase);

    //         $user->savePasswordResetToDatabase($tokenHashForDatabase, $is_user_pass_exist[0]['id'], $is_user_pass_exist[0]['email']);

    //         // Send link with the original token
    //         $emailLink = 'Направена е заявка за промяна на Вашата парола. От линка по-долу може да промените паролата си. 
    //     В случай, че не сте направили заявка игнорирайте това съобщение!
    //     Потребителско име: '.$is_user_pass_exist[0]['name'].'.
    //     Линк за възстановяване: ' . url() . 'reset_password?' . $tokenForLink;
    //         $res = static::send_mail($user_email['email'], $emailLink, 'Възстановяване на парола');
    //         if (intval($res) > 0) {
    //             echo 'На посочения от Вас имейл бе изпратен код за възстановяване. Кодът ще е активен през следващите 8 часа!';
    //         } else {
    //             echo 'Възникна проблем при възстановяването на Вашата парола. Моля опитайте по-късно.';
    //         }
    //     } else {
    //         echo 'Посочената от Вас поща не е открита!';
    //     }
    // }

    /**
     * RESET USER PASSWORD
     * @param $tok
     * @return mixed
     */
    // public function reset_password($tok)
    // {

    //     // Validate the token
    //     if (!isset($tok) || !StoPasswordReset::isTokenValid($tok)) {
    //         $response = 'The token is invalid.';
    //     }

    //     // Search for the token hash in the database, retrieve UserId and creation date
    //     $tokenHashFromLink = StoPasswordReset::calculateTokenHash($tok);
    //     $user = new User();


    //     if (!$user->loadPasswordResetFromDatabase($tokenHashFromLink, $userId, $creationDate)) {
    //         $response = 'The token does not exist or has already been used.';
    //     }

    //     // Check whether the token has expired
    //     if (StoPasswordReset::isTokenExpired($creationDate)) {
    //         $response = 'The token has expired.';
    //     }

    //     $user->letUserChangePassword($userId);

    //     return view('reset_password', compact('response', 'userId'));

    // }


    /**
     * SEND PASSWORD RECOVER MAIL TO USER
     * @param $mail
     * @param $text
     * @param null $subject
     * @return int
     */
    // public static function send_mail($mail, $text, $subject = null)
    // {

    //     require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';

    //     // Create the Transport
    //     $transport = Swift_SmtpTransport::newInstance(HOST, 25)
    //         ->setUsername(MAIL_USER)
    //         ->setPassword(MAIL_PASS);

    //     /*
    //     You could alternatively use a different transport such as Sendmail:

    //     // Sendmail
    //     $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
    //     */

    //     // Create the Mailer using your created Transport
    //     $mailer = Swift_Mailer::newInstance($transport);

    //     // Create a message

    //     $message = Swift_Message::newInstance($subject)
    //         ->setFrom(array('intranet@customs.bg' => 'Интранет'))
    //         ->setTo(array($mail))
    //         ->setBody($text)
    //         ->addBcc('vladislav.andreev@customs.bg');

    //     // Send the message
    //     try{
    //         $result = $mailer->send($message);
    //         return $result;
    //     } catch (\Swift_TransportException $e){
    //         print_r($e);
    //         print_r('Bad username / password');
    //     }

    // }

}