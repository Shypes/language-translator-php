<?php

require_once("../language.php");

use Shypes\language;

$LangParser = new language();

$LangParser->setBaseDir(getcwd());

$LangParser->setActiveLang('ar');

$LangParser->setLoadFromFile(false);

$LangParser->load('en', [
   "success"=> "Success!",
   "email_phone_validation"=> "Email and phone cannot be empty",
   "something_went_wrong"=> "Something went wrong!",
   "missing_required_validation"=> "Missing required fields",
   "missing_truck"=> "Truck Request Pool has already been set to ${status}", 
   "deliver_code"=>"Hello ${name}, here is your otp code ${code}",
   "John"=> "John",
]);

$LangParser->load('ar', [
   "success"=> "نجاح",
   "email_phone_validation"=> "لا يمكن أن يكون البريد الإلكتروني والهاتف فارغين",
   "something_went_wrong"=> "هناك خطأ ما!",
   "missing_required_validation"=> "الحقول المطلوبة مفقودة",
   "missing_truck"=> "تم تعيين تجمع طلبات الشاحنات بالفعل على ${status}",
   "deliver_code"=>"مرحبًا ${name} ، إليك رمز otp ${code}",
   "John"=> "نجاح",
]);

$translated = $LangParser->translate('deliver_code', 'ar', ['name'=>"John", 'code'=> 343923] );

var_dump($translated);

$translated = $LangParser->translate('deliver_code', 'en', ['name'=>"John", 'code'=> 343923] );

var_dump($translated);
?>