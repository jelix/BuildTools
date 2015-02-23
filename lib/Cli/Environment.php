<?php
/**
* @author      Laurent Jouanneau
* @contributor Dominique Papin
* @copyright   2006-2015 Laurent Jouanneau
* @copyright   2008 Dominique Päpin
* @link        http://www.jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/
namespace Jelix\BuildTools\Cli;

class Environment {

    static protected $variables_def = array();

    private function __construct(){ }

    /**
     * init the globals variables, by reading the given
     * array which describes all this variables
     *
     *  each build options item should be an array
     *   0: help (or false for hidden options)
     *   1: the default value (string)
     *   2: a preg expression to verify the given value
     *   or
     *   1: a boolean, which indicates that the option is a boolean value
     *      the value of this boolean is the default value
     *    2: no value
     * @param array $build_options the options to create as globals variables
    */
    static public function init($build_options){
        self::$variables_def = $build_options;

        foreach($build_options as $name=>$def){
            // if there isn't a defined default value,
            // let's defining an empty string as default value
            if(!isset($def[1])){
                self::$variables_def[$name][1]='';
            }
            // if the default value is not a boolean, and if there isn't a third
            // parameter in the array, let's define a third parameter
            if(!isset($def[2]) && !is_bool(self::$variables_def[$name][1])){
                self::$variables_def[$name][2]='';
            }
            self::storeValue($name,self::$variables_def[$name][1]);
        }
    }

    static public function getAll($getHiddenOption = true){
        $values =array();
        foreach(self::$variables_def as $name=>$def){
            if($def[0] === false && $getHiddenOption == false){
                continue;
            }
            if(is_bool($def[1])){
                if($GLOBALS[$name] != '0')
                    $values[$name] = true;
                else
                    $values[$name] = false;
            }else{
                $values[$name] = $GLOBALS[$name];
            }
        }

        return $values;
    }

    static public function set($name,$value){
        if(!self::verifyName($name)){
            echo "warning: unknown option name ($name)\n";
        }else{
            self::storeValue($name,$value);
        }
    }

    static public function addIni($file){
        if($arr = parse_ini_file($file,false)){
            foreach($arr as $k=>$v){
                if(self::verifyName($k)){
                    self::storeValue($k,$v);
                }else{
                    echo "warning: unknown option name ($k) in the ini file\n";
                }
            }
        }else{
            throw new \Exception("can't read ini file\n");
        }
    }

    static public function setFromFile($name,$file, $onlyIfNotExists=false){
        if($onlyIfNotExists && isset($GLOBALS[$name]) && $GLOBALS[$name] !='') return;
        if(!self::verifyName($name)){
            echo "warning: unknown option name ($name)\n";
        }else{
            self::storeValue($name,file_get_contents($file));
        }

    }

    static protected function verifyName($name, $verbose=true){
        static $var= array('_ENV','_GET','_POST','_SERVER','GLOBALS','_FILES', '_COOKIE',
        'HTTP_ENV_VARS','HTTP_POST_VARS','HTTP_GET_VARS','HTTP_COOKIE_VARS',
        'HTTP_SERVER_VARS','HTTP_POST_FILES','_REQUEST');

        if(in_array($name,$var )){
            throw new \Exception("forbidden option name ($name)");
        }elseif(!isset(self::$variables_def[$name])){
            return false;
        }else{
            return true;
        }
    }

    static protected function storeValue($name,$value){
        if(is_bool(self::$variables_def[$name][1])){
            if($value == 'true' || $value === true || $value == 1 || $value == 'on' || $value=='yes')
                $value='1';
            else
                $value='0';
        }else{
            if($value == ''){
                if(self::$variables_def[$name][2] != '' && !preg_match(self::$variables_def[$name][2], $value)){
                    $value = self::$variables_def[$name][1];
                }
            }else{
                if(self::$variables_def[$name][2] != ''){
                    if(!preg_match(self::$variables_def[$name][2], $value)){
                        throw new \Exception("bad value setting for the variable $name");
                    }
                }
            }
        }

        $GLOBALS[$name]=$value;
    }

    static public function help($showHiddenOption = false){
        $help="Available build options :\n\n";
        foreach(self::$variables_def as $name=>$def){
            if($def[0] === false && $showHiddenOption == false){
                continue;
            }
            $help.=$name."\n";
            if($def[0] != '')
                $help.="\t".$def[0]."\n";
            // type
            if(is_bool($def[1])){
                $help.="\t(boolean) default value: ".($def[1]?'1':'0')."\n";
            }elseif($def[1] != ''){
                $help.="\t default value: ".$def[1]."\n";
            }
        }
        $help.="\n\n";
        return $help;
    }

    static public function getIniContent($list = null){
        $ini='';
        foreach(self::$variables_def as $name=>$def){
            if($def[0] === false && $list === null){
                continue;
            }
            if($list !== null && is_array($list)){
                if(!in_array($name,$list))
                    continue;
            }
            if(is_bool($def[1])){
                $ini.=$name."=".($GLOBALS[$name]?'1':'0')."\n";
            }else{
                $value = $GLOBALS[$name];
                if ($value == '' || is_numeric($value) || preg_match("/^[\w]*$/", $value)) {
                    $ini.=$name."=".$value."\n";
                } else {
                    $ini.=$name."=\"".$value."\"\n";
                }
            }
        }
        return $ini;
    }
}

