<?php
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;

    // require 'PHPMailer/PHPMailer.php';
    // require 'PHPMailer/SMTP.php';
    // require 'PHPMailer/Exception.php';

    class EmailServer {
        const FUNCT_WB = 'wb';
        const FUNCT_ir = 'ir';

        private string $_mailFromAddress = "";
        private string $_mailFromName = "";
        private string $_mailToAddress = "";
        private string $_mailToName = "";
        private string $_mailSubject = "";
        
        public string $funct = "";
        public $config;
        

        public function __construct($funct, $config) {
            // $this->funct = $funct;
            // $this->_readConfig($config);

            // echo "Func: " . $this->funct;
            // echo "Config: " . $this->_readConfig;
        }

        // public function send($name, $email, $tel, $info) {
        //     $mail = new PHPMailer(TRUE);
        //     try {

        //         case ($this->funct) {
        //             case FUNCT_WB:
        //                 _wbMail();
        //                 break;
        //             case FUNCT_IR:
        //                 _irMail();
        //                 break;
        //         }

        //         $mail->isSMTP();
        //         $mail->Host = $config['mail_server']['host'];
        //         $mail->Username = $config['mail_server']['username'];
        //         $mail->Password = $config['mail_server']['password'];
        //         $mail->Port = $config['mail_server']['port'];

        //         $mail->setFrom($this->_mailFromAddress, $this->_mailFromName);
        //         $mail->addAddress($this->_mailToAddress, $this->_mailToName);
        //         $mail->Subject = $this->_mailSubject;
        //         $mail->msgHTML("<html><body>Name:" . $name . "<br />" .
        //                 "Email: " . $email . "<br />" .
        //                 "Tel: " . $tel . "<br />" .
        //                 "Information: " . $info .
        //                 "</html>");
        //         //echo $mail->Body;
        
        //         if($mail->send()) {
        //             $msg = "Mail has been sent.";
        //         }
        
        //     }
        //     catch (Exception $e) {
        //         // PHPMailer exception
        //         $error = true;
        //         $msg = $e->errorMessage();
        //         //echo $e->errorMessage();
        //     }
        //     catch (Exception $e) {
        //         // PHP exception
        //         $error = true;
        //         $msg = $e->errorMessage();
        //         //echo $e->getMessage();
        //     }
        // }


        // private function _wbMail() {
        //     $this->_mailFromAddress = $this->config['wb_mail_content']['from_email'];
        //     $this->_mailFromName = $this->config['wb_mail_content']['from_name'];
        //     $this->_mailToAddress = $this->config['wb_mail_content']['to_email'];
        //     $this->_mailToName = $this->config['wb_mail_content']['to_name'];
        //     $this->_mailSubject = $this->config['wb_mail_content']['subject'];
        // }

        // private function _irMail() {
        //     $this->_mailFromAddress = $this->config['ir_mail_content']['from_email'];
        //     $this->_mailFromName = $this->config['ir_mail_content']['from_name'];
        //     $this->_mailToAddress = $this->config['ir_mail_content']['to_email'];
        //     $this->_mailToName = $this->config['ir_mail_content']['to_name'];
        //     $this->_mailSubject = $this->config['ir_mail_content']['subject'];
        // }

        private function _readConfig() {
            try {
                $this->config = parse_ini_file("config.ini", true);                
            }
            catch($e) {
                $this->config = "";
            }

            if(empty($this->config))
                return false;
            else 
                return true;
            
        }

    }
?>