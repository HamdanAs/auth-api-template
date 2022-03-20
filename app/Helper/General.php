<?php

if(!function_exists('sendResult')){
    function sendResult($error, $data)
    {
        return (object) [
            'error' => $error,
            'result'  => $data
        ];
    }
}
