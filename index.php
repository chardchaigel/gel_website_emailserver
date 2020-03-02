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
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $email = $data['email'];
        $info = $data['information'];   
        $tel = $data['tel'] ;
        $funct = $data['funct'];
        // print_r($data);
        // return;
        // echo "data";
        // return;
    }
    catch(Exception $e) {   
        // echo "error";
        // echo $e->errorMessage();
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
        // echo $e->getMessage();
    }

    $data = json_encode(array('status'=>!$error, 'msg'=>$msg));
    echo $data;
    return;
    
    

    // // ----------------------------- FUNCTIONS ------------------------------//
    function checkInput($input) {
        if(!isset($input) || empty($input) || strlen(trim($input)) == 0) {
            return false;
        }

        return true;
    }





  
?>