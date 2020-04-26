<?php

require_once("../language.php");

use Shypes\language;

$Language = new language([
    "default_lang" => "en",
    "__basedir" =>  getcwd()
]);

 
$Language->load('ar', [
    "data"=> "البيانات",
    "message"> "رسالة",
]);

function testTranslate ($res, $content, $message) {
    global $Language;

    $responseData = ["message" => "", "param" => ""];

    if(gettype(message) == 'string'){
        $responseData['message'] = message;
        $message = array();
    }

    $responseData = array_merge($responseData,$message);

    $translated = $Language->get($responseData['message'], $res['language'], $responseData['param']);

    $lang_key = !$res['lang_key'] ? false : true;

    $response_key = [
        'data'=> $lang_key ? $Language->text('data') : 'data',
        'message'=> $lang_key ? $Language->text('message') : 'message',
        'success'=> $lang_key ? $Language->text('success') : 'success'
    ];

    $data = array();
    $data[$response_key['success']] =  true;
    $data[$response_key['message']] =  $translated;
    $data[$response_key['data']] =  $content;

    var_dump($data);
};

$res = [
    'language'=>'ar',
    'lang_key' => true
];

testTranslate($res, [], 'success');

testTranslate($res, [], 'something_went_wrong');

testTranslate($res, [], 'missing_required_validation');

testTranslate($res, [], 'email_phone_validation');

?>