<?php

class Mail
{

    public $mail = array();

    function send($mail)
    {
        $this->mail = $mail;

        if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == 'dev') {
            $this->devMail();
        } else {
            $this->zendMail();
        }
    }

    function zendMail()
    {
        require_once 'Zend/Loader.php';

        Zend_Loader::loadClass('Zend_Mail');

        $html2text = new Html2Text($this->mail['body'], 80);
        $body_text = $html2text->convert();

        $email = new Zend_Mail('UTF-8');
        $email->setBodyText($body_text);
        $email->setBodyHtml($this->mail['body']);
        $email->setFrom($this->mail['from_email'], $this->mail['from_name']);
        $email->addTo($this->mail['to_email'], $this->mail['to_name']);
        $email->setSubject($this->mail['subject']);

        if (isset($this->mail['unsubscribe_url']) && ! empty($this->mail['unsubscribe_url'])) {
            $email->addHeader('List-Unsubscribe', $this->mail['unsubscribe_url']);
        }

        $email->send();

    }

    function devMail() {

        $to = $this->mail['to_name'] . ' <' . $this->mail['to_email'] . '>';
        $from =  $this->mail['from_name'] . ' <'. $this->mail['from_email'] . '>';
        $subject = $this->mail['subject'];
        $body = $this->mail['body'];

        $url = 'http://localhost/mail/post.php';
        $useragent = 'Fast Browser 1.0';
        $post_data = 'to=' . urlencode($to) . '&' .
                     'from=' . urlencode($from) . '&' .
                     'subject=' . urlencode($subject) . '&' .
                     'body=' . urlencode($body);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result= curl_exec ($ch);
        curl_close($ch);
    }

}
