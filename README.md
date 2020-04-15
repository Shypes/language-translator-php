# @shypes/language-translator-php

[![GitHub issues](https://img.shields.io/github/issues/Shypes/language-translator)](https://img.shields.io/github/issues/Shypes/language-translator)

## Introduction

This is a simple light weight language parser to help with language key translation built for speed using in-memory caching optimization technique.

Language file only get loaded once during your application life cycle

## Install

```$
require_once("language.php");
```

## Usage

Follow the set by step guide below

## Language Folder Setup

Create a dedicated folder to store your language template file.

Default folder is `lang` from your base directory configuration, 

You will see how to set up your **base directory** below

Create the different sample files below in the language folder

**ar.json**

```json
{
    "success": "نجاح",
    "email_phone_validation": "لا يمكن أن يكون البريد الإلكتروني والهاتف فارغين",
    "something_went_wrong": "هناك خطأ ما!",
    "missing_required_validation": "الحقول المطلوبة مفقودة",
    "missing_truck": "تم تعيين تجمع طلبات الشاحنات بالفعل على ${status}",
    "deliver_code":"مرحبًا ${name} ، إليك رمز otp ${code}"
}
```

**en.json**

```json
{
    "success": "Success!",
    "email_phone_validation": "Email and phone cannot be empty",
    "something_went_wrong": "Something went wrong!",
    "missing_required_validation": "Missing required fields",
    "missing_truck": "Truck Request Pool has already been set to ${status}", 
    "deliver_code":"Hello ${name}, here is your otp code ${code}"
}
```

## Initilaise the Application

```php
$Language = new language();
```


```pgp
$Language = new language([
    "__basedir" => "./",
    "langFolder" => 'lang'
]);
```

Loading with optional parameters

```php
$Language = new language([
    "default_lang" => "en",
    "ext" => ".json",
    "__basedir" => "./",
    "langFolder" => 'lang'
]);
```

## Some Basic Configuration - Optional


```php
// set your base directory
$Language->setBaseDir("./"));

// set your base directory
$Language->setLanguageDir('src/lang');

// set your default language
$Language->setDefaultLang('en');

// set the extention for yout language file, default is .json
$Language->setExtention(".txt");
```

## Translation begin here


```php
// set the language in which you need

$Language->setActiveLang('ar');

// get the text base on the defined language key

$translated = $Language->get('email_phone_validation')

var_dump($translated);

// get the text base on the defined language key

$translated = Language.get('email_phone_validation', 'ar')

var_dump($translated);
```

## Using a function

```php

$Language = new language();

function testTranslate($language, $message) {

    global $Language;

    $translated =  $LangParser->translate($message, $language);
    $data = [
        "message" => $translated,
        "language" => $language
    ];

    var_dump($data);
};

testTranslate('ar','something_went_wrong')

testTranslate('en','missing_required_validation')

testTranslate('ar','email_phone_validation')
```

In line Langauge Loading Supported, this help you load your language data directly with a file

```php

const data = {
    "success": "نجاح",
    "email_phone_validation": "لا يمكن أن يكون البريد الإلكتروني والهاتف فارغين",
    "something_went_wrong": "هناك خطأ ما!",
    "missing_required_validation": "الحقول المطلوبة مفقودة",
    "missing_truck": "تم تعيين تجمع طلبات الشاحنات بالفعل على ${status}",
    "deliver_code":"مرحبًا ${name} ، إليك رمز otp ${code}"
}

$Language->load('ar', data)


```

## Dynamic language template

It also support **templated** json strings

```json
{
    "deliver_code":"مرحبًا ${name} ، إليك رمز otp ${code}"
}
```

```php
$translated = Lang.get('deliver_code', 'ar', {'name':"John", 'code': 343923} )

var_dump($translated);
```

Output:

```json
مرحبًا John ، إليك رمز otp 343923
```

Check out the [sample files](https://github.com/Shypes/language-translator/tree/master/examples) in the test directory

## License

[MIT](LICENSE) © Tosin Adesipe
