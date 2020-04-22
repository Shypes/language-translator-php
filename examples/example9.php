<?php

require_once("../language.php");

$Language = new language([
   "default_lang" => "en",
   "__basedir" =>  getcwd()
]);

$Language->setLoadFromFile(false);

$Language->load('ar', [
    "deliver_code"=>"why مرحبًا ${name} ، إليك رمز me ${code}"
]);

$Language->load('en', [
    "deliver_code"=>"why ${name}, here is your me code ${code}"
]);

// var_dump($Language->getPath());

$translated = $Language->get('deliver_code', 'ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$Language->setLoadFromFile(true);

$Language->setlanguageDir("lang/email");

// var_dump($Language->getPath());

$translated = $Language->get('deliver_code', 'ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$Language->setlanguageDir("lang");

// var_dump($Language->getPath());

$translated = $Language->get('deliver_code','ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$Language->setlanguageDir("lang/email");

// var_dump($Language->getPath());

$translated = $Language->get('deliver_code','ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$Language->load('ar', [
    "deliver_code"=>"مرحبًا ${name} ، إليك رمز fuck ${code}"
]);

$Language->load('en', [
    "deliver_code"=>"Hello ${name}, here is your me fuck ${code}"
]);

$translated = $Language->get('deliver_code','ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$Language->setlanguageDir("lang");

// var_dump($Language->getPath());

$translated = $Language->get('deliver_code','ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$Language->setlanguageDir("lang/email");

// var_dump($Language->getPath());

$translated = $Language->get('deliver_code','ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code_me','ar', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);

$translated = $Language->get('deliver_code_me','en', ['name'=>"John", 'code'=> 343923]);

var_dump($translated);


?>