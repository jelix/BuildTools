<?php
/**
* @package     jBuildTools
* @author      Laurent Jouanneau
* @contributor
* @copyright   2006-2015 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/

namespace Jelix\BuildTools\PreProcessor;

class Exception extends \Exception {
    public $sourceFilename = '';
    public $sourceLine = 0;

    protected $errmessages = array(
        'unknown error',
        'syntax error',
        '#ifxx statement is missing',
        '#endif statement is missing',
        'Cannot include file %s',
        'Syntax error in the expression : %s',
        'Syntax error in an expression : "%s" is not allowed'
    );

    public function __construct($sourceFilename, $sourceLine, $code=0, $param=null) {
        $this->sourceFilename = $sourceFilename;
        $this->sourceLine = $sourceLine+1;
        if($code > count($this->errmessages)) $code = 0;
        if($param != null){
            $err = sprintf($this->errmessages[$code], $param);
        }else{
            $err = $this->errmessages[$code];
        }
        parent::__construct($err, $code);
    }

    public function __toString() {
        return 'Error '.$this->code.': '.$this->message .', file source='.$this->sourceFilename. ' line='.$this->sourceLine;
    }
}
