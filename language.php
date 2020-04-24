<?php

class language {

    var $LanguageData = array();
    var $FolderLanguage = array();
    var $safe_load = true;

    function __construct($options = array()) {
        $this->reset($options);
    }

    private function setOptions ($options){
        $this->option = array_merge($this->default, $options);
    }

    private function reset ($options){
        $this->default = [
            "default_lang" => "en",
            "__basedir" => "./",
            "ext" => ".json",
            "langFolder" => 'lang',
        ];
        $this->setOptions($options);
        $this->active_lang = $this->option['default_lang'];
        $this->loaded = false;
        $this->load_from_file = true;
        $this->setPath();
    }

    public function setActiveLang($language){
        $language = ($language && $language != '' && gettype($language) == 'string')  ? $language : false;
        if($language) $this->active_lang = trim($language);
    }

    public function setExtention($ext){
        $this->option['ext'] = $ext;
    }

    public function setLoadFromFile($is_load){
        $this->load_from_file = !$is_load ? false : true;
    }

    public function setBaseDir($directory){
        $this->option['__basedir'] = $directory;
        $this->setPath();
    }

    public function setlanguageDir($directory){
        if($this->option['langFolder'] != $directory){
            $this->option['langFolder'] = $directory;
            $this->setPath();
            $this->init($this->active_lang);
            foreach($this->FolderLanguage[$this->option['langFolder']] as $language => $data){
                $this->load($language, $data);
            }
        }
    }

    public function setDefaultLang($language){
        $this->option['default_lang'] = $language;
        $this->loaded = false;
    }

    private function setPath(){
        $this->langPath = $this->option['__basedir'] .'/'. $this->option['langFolder'];
        if (!array_key_exists($this->option['langFolder'], $this->FolderLanguage)){
            $this->FolderLanguage[$this->option['langFolder']] = array();
        }
    }

    public function set_safe_load($is_safe){
        $this->safe_load = !$is_safe ? false : true;
    }

    public function getPath(){
        return $this->langPath;
    }

    public function text($text, $language = false,  $param=array()){
        $language = ($language && $language != '' &&  gettype($language) == 'string')  ? $language : $this->active_lang;
        if (array_key_exists($language, $this->LanguageData)) {
            if (array_key_exists($text, $this->LanguageData[$language])) {
                if(count($param) == 0)
                    return $this->LanguageData[$language][$text];
                else
                    return $this->renderString($language, $this->LanguageData[$language][$text], $param);
            }
        }
        return $text;
    }

    public function gettext($text, $language = false,  $param=array()){
        return $this->text($text, $language,  $param);
    }

    private function renderString($language, $template, $variables) {
        return preg_replace_callback('/\${(.+?)}/',
                 function($matches) use ($variables) {
            return   $this->gettext($variables[$matches[1]]);
        }, $template);
    }

    public function translate ($text, $language=false, $param=array()){
        $this->init($language);
        return $this->text($text, $language, $param);
    }

    function get($text, $language=false, $param=array()){
        return $this->translate($text, $language, $param);
    }

    public function init ($language){
        $this->setActiveLang($language);
        $this->loadDefaultLang();
        $this->loadActiveLang();
    }

    private function loadDefaultLang(){
        if($this->loaded == false){
            $this->loadLanguage($this->option['default_lang']);
        }
        $this->loaded = true;
    }

    private function loadActiveLang(){
        $this->loadLanguage($this->active_lang);
    }

    private function hasLoadedLanguage($language){
        return array_key_exists($language, $this->FolderLanguage[$this->option['langFolder']]);
    }

    private function canLoad($language){
        $file_path = $this->getPath();
        return is_file("${file_path}/{$language}{$this->option['ext']}");
    }

    private function markAsLoaded($language){
        $this->loadFolderLanguage($language);
    }

    private function loadFolderLanguage($language, $data =array()){
        if(is_array($data)){
            $this->setPath();
            $this->FolderLanguage[$this->option['langFolder']][$language] = $data;
        }
    }

    private function getFolderLanguage($language){
        if (array_key_exists($this->option['langFolder'],$this->FolderLanguage)) {
            if (array_key_exists($language, $this->FolderLanguage[$this->option['langFolder']])) {
                return $this->FolderLanguage[$this->option['langFolder']][$language];
            }
        }
        return array();
    }

    private function getFile($language){
        $file_path = $this->getPath();
        $data =  @json_decode(file_get_contents("${file_path}/{$language}{$this->option['ext']}"),true);
        if (json_last_error() === 0) {
            return $data;
        }
        @error_log("Could not load language file: ${file_path}/{$language}{$this->option['ext']}", 0);
        if ($this->safe_load == false)
            echo "Could not load language file: ${file_path}/{$language}{$this->option['ext']}";die;
        return array();
    }

    private function loadLanguage($language){
        if ($this->load_from_file 
        && !$this->hasLoadedLanguage($language)
        ) {
            if($this->canLoad($language)){ 
                $this->loadFolderLanguage($language, $this->getFile($language));
                $this->load($language, $this->getFolderLanguage($language));
            }else{
                $this->markAsLoaded($language);
            }
        }
    }

    public function load($language, $data){
        if(is_array($data) && count($data) > 0){
            if (!array_key_exists($language, $this->LanguageData)) {
                $this->LanguageData[$language] = $data;
            }else{
                $this->LanguageData[$language] = array_merge(
                    $this->LanguageData[$language], 
                    $data
                );
            }
        }
    }
}
?>