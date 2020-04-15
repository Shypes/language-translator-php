<?php

require_once("../language.php");

$Language = new language([
   "default_lang" => "en",
   "__basedir" =>  getcwd()
]);

$Language->load('ar', [
    "deliver_code"=>"مرحبًا ${name} ، إليك رمز otp ${code}"
]);

$Language->load('en', [
    "deliver_code"=>"Hello ${name}, here is your otp code ${code}"
]);

$translated = $Language->get('deliver_code', 'ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

?>