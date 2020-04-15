<?php

require_once("../language.php");

function testTranslate ($language, $message) {

   $LangParser = new language();

   $LangParser->setBaseDir(getcwd());

   $LangParser->setBaseDir(__dirname);

   $translated =  $LangParser->translate($message, $language);

   $data = [
      "message" => $translated,
      "language" => $language
  ];

  var_dump($data);

};

testTranslate('ar', 'success');

testTranslate('ar' , 'something_went_wrong');

testTranslate('ar' , 'missing_required_validation');

testTranslate('ar' , 'email_phone_validation');

?>