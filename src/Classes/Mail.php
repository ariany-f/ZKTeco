<?php
namespace Src\Classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


use Src\Classes\Storage\File;

class Mail{
    /** @var string */
    private static $to = null;

    /** @var string */
    private static $name = null;

    /** @var string */
    private static $subject = null;

    /** @var string */
    private static $message = null;

    /** @var string|array */
    private static $from = [];

    /** @var string|array */
    private static $cc = [];

    /** @var string|array */
    private static $bcc = [];

    /** @var string */
    private static $charset = 'utf-8';

    /** @var string */
    private static $contentType = 'text/plain';

    /** @var string */
    private static $header = null;

    /** @var string */
    private static $boundary = null;

    /** @var array */
    private static $attachments = [];

    /**
     * Method informs message subject
     * 
     * @param string
     * 
     * @return \Src\Classes\Mail
     */
    public static function subject(string $subject) : Mail{
        self::$subject = $subject;

        return new static;
    }

    /**
     * Method that informs the email message
     * 
     * @param string|array
     * 
     * @return \Src\Classes\Mail
     */
    public static function message(string $message) : Mail{
        self::$message = $message;

        return new static;
    }

    /**
     * Method that informs who the sender will be
     * 
     * @param string
     * @param string
     * 
     * @return \Src\Classes\Mail
     */
    public static function addFrom(string $email, string $name) : Mail{
        self::$from[$name] = $email;

        return new static;
    }

    /**
     * Method that tells who will receive a copy of that email
     * 
     * @param string
     * @param string
     * 
     * @return \Src\Classes\Mail
     */
    public static function addCc(string $email, string $name) : Mail{
        self::$cc[$name] = $email;

        return new static;
    }    

    /**
     * Method that tells who will receive a copy of that email
     * 
     * @param string
     * @param string
     * 
     * @return \Src\Classes\Mail
     */
    public static function addBcc(string $email, string $name) : Mail{
        self::$bcc[$name] = $email;

        return new static;
    }

    /**
     * Method that sets the text encoding type
     * 
     * @param string
     * 
     * @return \Src\Classes\Mail
     */
    public static function charset(string $charset) : Mail{
        self::$charset = $charset;

        return new static;
    }

    /**
     * Method that determines whether text will be interpreted as HTML
     * 
     * @param bool
     * 
     * @return \Src\Classes\Mail
     */
    public static function isHtml(bool $html) : Mail{
        if($html)
            self::$contentType = 'text/html';
        else
            self::$contentType = 'text/plain';

        return new static;
    }

    /**
     * Method that sets the page header
     * 
     * @return void
     */
    private static function setHeader() : void{        
        // Format From
        if(is_array(self::$from)){
            foreach(self::$from as $name => $email){
                self::$from[$name] = "{$name} <{$email}>";
            }

            self::$from = implode(', ', self::$from);
        }

        // Format Cc
        if(is_array(self::$cc)){
            foreach(self::$cc as $name => $email){
                self::$cc[$name] = "{$name} <{$email}>";
            }

            self::$cc = implode(', ', self::$cc);
        }

        // Format Bcc
        if(is_array(self::$bcc)){
            foreach(self::$bcc as $name => $email){
                self::$bcc[$name] = "{$name} <{$email}>";
            }

            self::$bcc = implode(', ', self::$bcc);
        }

        // Set Header
        self::$header  = "MIME-Version: 1.0\r\n";
        self::$boundary = 'XYZ-' . md5(date('dmYis')) . '-ZYX';

        if (!empty(self::$attachments)) {
            self::$header .= "Content-Type: multipart/mixed; boundary=". self::$boundary . "\r\n";
        } else {
            self::$header .= "Content-Type: " . self::$contentType . "; charset=\"" . self::$charset . "\"\r\n";
        }

        self::$header .= 'To: ' . self::$name .  ' <' . self::$to . '>' . "\r\n";

        if(!empty(self::$cc))
            self::$header .= 'Cc: ' . self::$cc . "\r\n";

        if(!empty(self::$bcc))
            self::$header .= 'Bcc: ' . self::$bcc . "\r\n";

        if(!empty(self::$from)){
            self::$header .= 'From: ' . self::$from . "\r\n";
            self::$header .= 'Reply-To: ' . self::$from . "\r\n";
        }   

        self::$header .= "X-Mailer: php\r\n";
        self::$header .= self::$boundary . "\r\n";
    }

    /**
     * Method that sets the page message
     * 
     * @return void
     */
    private static function setMessage() : void {
        $message = self::$message;

        self::$message  = '--' . self::$boundary . "\r\n";
        self::$message .= "Content-Transfer-Encoding: 8bits\r\n"; 
        self::$message .= "Content-Type: text/html; charset=\"" . self::$charset . "\"\r\n";
        self::$message .= $message;

        foreach (self::$attachments as $attachment) {
            // Get file content
            $fp = fopen($attachment->tmp_name, 'rb');
            $content = fread( $fp, filesize($attachment->tmp_name));
            $content = chunk_split(base64_encode($content));
            fclose($fp);

            self::$message .= '--' . self::$boundary . "\r\n";
            self::$message .= "Content-Type: ". $attachment->type ."\r\n";
            self::$message .= "Content-Transfer-Encoding: base64\r\n";
            self::$message .= "Content-Disposition: attachment; filename=\"". $attachment->name . "\"\r\n" ;
            self::$message .= "$content\r\n";
        }

        if (!empty(self::$attachments)) {
            self::$message .= '--' . self::$boundary . "--\r\n";
        }
    }

    /**
     * Method that add a file
     * 
     * @param \Src\Classes\Storage\File
     * 
     * @return \Src\Classes\Mail
     */
    public static function addAttachment(File $file) : Mail {
        self::$attachments[] = $file;

        return new static;
    }

    /**
     * Method sends the email
     * 
     * @param string
     * 
     * @return bool
     */
    public static function send(string $to, string $name) : bool{
    
        $mail = new PHPMailer(true);

        self::$to = $to;
        self::$name = $name;
        self::setHeader();
        self::setMessage();

        try {
            $mail->SMTPDebug = true;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->CharSet = "UTF-8";
            $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = '5958e8c336eacc';                     //SMTP username
            $mail->Password   = '27fe2578be44a8';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Server settings
            // $mail->SMTPDebug = true;                      //Enable verbose debug output
            // $mail->isSMTP();                                            //Send using SMTP
            // $mail->CharSet = "UTF-8";
            // $mail->Host       = 'mail.uniebco.com.br';                     //Set the SMTP server to send through
            // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            // $mail->Username   = 'uniebco@uniebco.com.br';                     //SMTP username
            // $mail->Password   = 'uni@ebco123';                               //SMTP password
            // // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            // // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            // $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        
            //Recipients
            $mail->setFrom('uniebco@uniebco.com.br', 'TechScan');
            $mail->addAddress($to);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = self::$subject;
            $mail->Body    = self::$message;
          //  $mail->AltBody = self::$header;
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

       // dd(self::$message);

        return mail(self::$to, self::$subject, self::$message, self::$header);
    }
}