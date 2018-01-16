<?php

class Ajax
{
    public static function returnJson($message, $messageType)
    {
        $jsonArray = array();
        $jsonArray['messageType'] = $messageType;
        $jsonArray['message'] = $message;
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($jsonArray);
    }
}
