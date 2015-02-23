<?php
/**
* @package     jBuildTools
* @author      Laurent Jouanneau
* @contributor Dominique Papin
* @copyright   2006-2009 Laurent Jouanneau
* @copyright   2008 Dominique Päpin
* @link        http://www.jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/
/*
options :
    -i fichier.ini
    -D VAR=VALUE
*/

require_once(__DIR__.'/autoloader.php');

use \Jelix\BuildTools\Cli\Environment as ENV;

function init(){

    $sws = array('-v'=>false, '-h'=>false, '-ini'=>false, '-D'=>2);
    $params = array('ini'=>false);

    list($switches, $parameters) = \Jelix\BuildTools\Cli\Params::getOptionsAndParams($_SERVER['argv'], $sws, $params);

    if (isset($parameters['ini'])) {
        ENV::addIni($parameters['ini']);
    }

    if (isset($switches['-D'])) {
        foreach($switches['-D'] as $var){
            if(preg_match("/^(\w+)=(.*)$/",$var,$m)){
                ENV::set($m[1],$m[2]);
            }else
                throw new Exception('bad syntax for -D option  :'.$var."\n");
        }
    }
    if (isset($switches['-v'])) {
        ENV::set('VERBOSE_MODE',true);
    }
    if (isset($switches['-h'])) {
        echo ENV::help();
        exit(0);
    }

    if (isset($switches['-ini'])) {
        echo ENV::getIniContent();
        exit(0);
    }
}


function debugVars(){
    foreach ($GLOBALS as $n=>$v){
        if(ENV::verifyName($n,false)){
            echo $n, " = ";
            var_export($v);
            echo "\n";
        }
    }
}

try{
    if(!isset($GLOBALS['BUILD_OPTIONS'])) {
        throw new Exception('$BUILD_OPTIONS variable is missing in your build file');
    }

    $GLOBALS['BUILD_OPTIONS']['VERBOSE_MODE'] = array("",false);
    ENV::init($GLOBALS['BUILD_OPTIONS']);

    init();

}
catch(Exception $e){
    echo "\n\njBuildTools error : " , $e->getMessage(),"\n";
    echo "  options :  [-vh] [-D foo=bar]* file.ini
      -v  : verbose mode
      -D  : declare a variable and its value
      -h  : only display list of build options
";

    exit(1);
}
