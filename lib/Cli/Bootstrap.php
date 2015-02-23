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

class Bootstrap {

    static function start($buildOptions = array()) {
        try{
            $buildOptions['VERBOSE_MODE'] = array("",false);
            Environment::init($buildOptions);
            self::processArg();
        }
        catch(\Exception $e) {
            self::help($e->getMessage());
        }
    }
    
    static function help($error='') {
        if ($error) {
            echo "\nJelixBuildTools error : " , $error,"\n";
        }
        echo "JelixBuildTools  options :  [-vh] [-D foo=bar]* file.ini\n".
            "\t-v  : verbose mode\n".
            "\t-D  : declare a variable and its value\n".
            "\t-h  : only display list of build options\n";
        if ($error) {
            exit(1);
        }
        else {
            exit(0);
        }
    }
    
    static function processArg() {
        $sws = array('-v'=>false, '-h'=>false, '-ini'=>false, '-D'=>2);
        $params = array('ini'=>false);
    
        list($switches, $parameters) = \Jelix\BuildTools\Cli\Params::getOptionsAndParams($_SERVER['argv'], $sws, $params);
    
        if (isset($parameters['ini'])) {
            Environment::addIni($parameters['ini']);
        }
    
        if (isset($switches['-D'])) {
            foreach($switches['-D'] as $var){
                if(preg_match("/^(\w+)=(.*)$/",$var,$m)){
                    Environment::set($m[1],$m[2]);
                }
                else {
                    throw new Exception('bad syntax for -D option  :'.$var."\n");
                }
            }
        }
        if (isset($switches['-v'])) {
            Environment::set('VERBOSE_MODE',true);
        }
        if (isset($switches['-h'])) {
            echo Environment::help();
            exit(0);
        }
    
        if (isset($switches['-ini'])) {
            echo Environment::getIniContent();
            exit(0);
        }
    }
    
    
    static function debugVars(){
        foreach ($GLOBALS as $n=>$v){
            if(Environment::verifyName($n,false)){
                echo $n, " = ";
                var_export($v);
                echo "\n";
            }
        }
    }
}
