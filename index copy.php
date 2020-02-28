<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    $error = false;
    $msg = "";
    $email = "";
    $info = "";
    $name = "";
    $tel = "";
    $funct = "";
 
    define('FUNCT_WB', 'wb');
    define('FUNCT_ir', 'ir');

    /*
    if(checkInput($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $error = true;
    }

    if(checkInput($_POST['information'])) {
        $info = $_POST['information'];        
    } else {
        $error = true;
    }

    if(checkInput($_POST['name'])) {
        $name = $_POST['name'];        
    }

    
    */

    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $email = $data['email'];
    $info = $data['information'];   
    $tel = $data['tel'] ;
    $funct = $data['funct'];
    // return;

    
    if(!checkInput($email)) {        
        $error = true;
        $msg = "Please enter your email.";
    } else if(!checkInput($info)) {
        $error = true;
        $msg = "Please enter your agenda.";
    }

    if($error) {
        $data = json_encode(array('status'=>false, 'msg'=>$msg));
        echo $data;
        return;
    }

    // $data = json_encode(array('status'=>true, 'msg'=>'Success'));
    // echo $data;
    //return;
    
    $config = parse_ini_file("config.ini", true);

    switch($func) {
        case FUNCT_WB:
            break;
        case FUNCT_IR:
            break;
    }

    $mail = new PHPMailer(TRUE);
    try {
        $mail->isSMTP();
        $mail->Host = $config['mail_server']['host'];
        $mail->Username = $config['mail_server']['username'];
        $mail->Password = $config['mail_server']['password'];
        $mail->Port = $config['mail_server']['port'];

        $mail->setFrom($config['wb_mail_content']['from_email'], $config['wb_mail_content']['from_name']);
        $mail->addAddress($config['wb_mail_content']['to_email'], $config['wb_mail_content']['to_name']);
        $mail->Subject = $config['wb_mail_content']['subject'];
        $mail->msgHTML("<html><body>Name:" . $name . "<br />" .
                "Email: " . $email . "<br />" .
                "Tel: " . $tel . "<br />" .
                "Information: " . $info .
                "</html>");
        //echo $mail->Body;

        if($mail->send()) {
            $msg = "Mail has been sent.";
        }

    }
    catch (Exception $e) {
        // PHPMailer exception
        $error = true;
        $msg = $e->errorMessage();
        //echo $e->errorMessage();
    }
    catch (Exception $e) {
        // PHP exception
        $error = true;
        $msg = $e->errorMessage();
        //echo $e->getMessage();
    }

    $data = json_encode(array('status'=>true, 'msg'=>$msg));
    echo $data;

    return;
    
    
    
    function sendEmail() {
        $config = parse_ini_file("config.ini", true);
    }
    
    
    function checkInput($input) {

        if(!isset($input) || empty($input) || strlen(trim($input)) == 0) {
            return false;
        }

        return true;

    }


    

    // function getInput($input) {
    //     $input = trip($input);

    //     return strip_tags($input);
    // }
    
  
?>