<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    class EmailServer {
        const FUNCT_WB = 'wb';  // Whistle Blowing
        const FUNCT_IR = 'ir';  // IR Contact

        private $_mailFromAddress = "";
        private $_mailFromName = "";
        private $_mailToAddress = "";
        private $_mailToName = "";
        private $_mailSubject = "";
        private $_config;
        
        public $funct = "";
        
        public function __construct($funct, $config) {
            $this->funct = $funct;          // Define which function the mail is for
            $this->_readConfig($config);    // Read configurations
        }

        public function send($name, $email, $tel, $info) {
            $mail = new PHPMailer(TRUE);
            try {

                // Specify SMTP config by the mail's function
                switch ($this->funct) {
                    case EmailServer::FUNCT_WB:
                        $this->_wbMail();
                        break;
                    case EmailServer::FUNCT_IR:
                        $this->_irMail();
                        break;
                    default:
                        return "Error: Function not found.";
                }

                $mail->isSMTP();
                $mail->Host = $this->_config['mail_server']['host'];
                $mail->Username = $this->_config['mail_server']['username'];
                $mail->Password = $this->_config['mail_server']['password'];
                $mail->Port = $this->_config['mail_server']['port'];

                $mail->setFrom($this->_mailFromAddress, $this->_mailFromName);
                $mail->addAddress($this->_mailToAddress, $this->_mailToName);
                $mail->Subject = $this->_mailSubject;
                $mail->msgHTML("<html><body>Name:" . $name . "<br />" .
                        "Email: " . $email . "<br />" .
                        "Tel: " . $tel . "<br />" .
                        "Information: " . $info .
                        "</html>");

                if($mail->send()) {
                    $msg = "";
                    // $error = false;
                } 
                else {
                    $msg = "Mail cannot be sent.";
                    // $error = true;
                }
        
            }
            catch (Exception $e) {
                // PHPMailer exception
                // $error = true;
                $msg = $e->errorMessage();
            }
            catch (Exception $e) {
                // PHP exception
                // $error = true;
                $msg = $e->errorMessage();
            }

            return $msg;
        }

        // Whistle Blowing Mail
        private function _wbMail() {
            $this->_mailFromAddress = $this->_config['wb_mail_content']['from_email'];
            $this->_mailFromName = $this->_config['wb_mail_content']['from_name'];
            $this->_mailToAddress = $this->_config['wb_mail_content']['to_email'];
            $this->_mailToName = $this->_config['wb_mail_content']['to_name'];
            $this->_mailSubject = $this->_config['wb_mail_content']['subject'];
        }

        // IR Contact Mail
        private function _irMail() {
            $this->_mailFromAddress = $this->_config['ir_mail_content']['from_email'];
            $this->_mailFromName = $this->_config['ir_mail_content']['from_name'];
            $this->_mailToAddress = $this->_config['ir_mail_content']['to_email'];
            $this->_mailToName = $this->_config['ir_mail_content']['to_name'];
            $this->_mailSubject = $this->_config['ir_mail_content']['subject'];
        }

        // Read configuration from the config.ini
        private function _readConfig() {
            try {
                $this->_config = parse_ini_file("config.ini", true);                
            }
            catch(Exception $e) {
                $this->_config = "";
            }

            if(empty($this->_config))
                return false;
            else 
                return true;
            
        }

    }
?>