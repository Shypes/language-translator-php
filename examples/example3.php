<?php

require_once("../language.php");

$LangParser = new language();

$LangParser->setBaseDir(getcwd());

function testTranslate ($language, $message) {

   global $LangParser;

   $LangParser->init($language);

   $translated = $LangParser->text($message);

   $data = [
      "message" => $translated,
      "language" => $language
  ];

  var_dump($data);
};

testTranslate('ar' , 'success');

testTranslate('ar' , 'something_went_wrong');

testTranslate('ar' , 'missing_required_validation');

testTranslate('ar' , 'email_phone_validation');

?>
