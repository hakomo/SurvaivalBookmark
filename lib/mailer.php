<?php

class Mailer {

    private $_message = "";
    private $_tempDir;
    const EXT = ".txt";

    public function __construct($templateDir){
        $this->_tempDir = $templateDir;
    }

    // テンプレートをセット
    public function setTemplate($fileName, $tempDir = ""){
        $dir = empty($tempDir) ? $this->_tempDir : $tempDir;
        $this->_message = file_get_contents($dir . $fileName . self::EXT);
        return $this;
    }

    public function setVar($name, $value){
        $this->_message = preg_replace("/{" . $name . "}/" , $value, $this->_message);
        return $this;
    }

    // メール送信
    public function sendMail($to, $subject, $message = ""){
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        if($message=="") $message = $this->_message;

        return mb_send_mail($to, $subject, $message);
    }

}