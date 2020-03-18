<?php
  
    include 'EmailServer.php';

    $error = false;
    $msg = "";
    $email = "";
    $info = "";
    $name = "";
    $tel = "";
    $funct = "";

    try {
        // Get Inputs
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $email = $data['email'];
        $info = $data['information'];   
        $tel = $data['tel'] ;
        $funct = $data['funct'];
    }
    catch(Exception $e) {   
        $data = json_encode(array('status'=>false, 'msg'=>"Cannot get Inputs from POST."));
        echo $data;
        return;
    }
    
    if(!checkInput($email)) {        
        $error = true;
        $msg = "Please enter your email.";
    } else if(!checkInput($info)) {
        $error = true;
        $msg = "Please enter your agenda.";
    } else if (!checkInput($funct)) {
        $error = true;
        $msg = "Function not found.";
    }
    if($error) {
        $data = json_encode(array('status'=>false, 'msg'=>$msg));
        echo $data;
        return;
    }

    // Send email
    try {        
        $mail = new EmailServer($funct, "config.ini");
        $msg = $mail->send($name, $email, $tel, $info);
        
        if($msg === "") {
            $msg = "Mail has been sent.";
            $error = false;
        }
        else {
            $error = true;
        }
        
    }
    catch (Exception $e) {
        $error = true;
        $msg = $e->errorMessage();
    }

    $data = json_encode(array('status'=>!$error, 'msg'=>$msg));
    echo $data;
    return;
    
    

    // ----------------------------- FUNCTIONS ------------------------------//

    // Check whether the input is empty
    function checkInput($input) {
        if(!isset($input) || empty($input) || strlen(trim($input)) == 0) {
            return false;
        }

        return true;
    }

?>