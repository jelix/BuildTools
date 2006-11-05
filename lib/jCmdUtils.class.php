<?php
/**
* @package    jelix
* @subpackage utils
* @version    $Id:$
* @author     Loic Mathaud
* @contributor Laurent Jouanneau
* @copyright  2006 Loic Mathaud
* @link        http://www.jelix.org
* @licence  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public Licence, see LICENCE file
*/

/**
 *
 * @package    jelix
 * @subpackage utils
 */
class jCmdUtils {

    private function __construct() {}

    public static function getOptionsAndParams($argv, $sws, $params) {
        $switches = array();
        $parameters = array();

        //---------- get the switches
        while (count($argv) && $argv[0]{0} == '-') {
            if (isset($sws[$argv[0]])) {
                if ($sws[$argv[0]]) {
                    $multiple=($sws[$argv[0]] > 1);
                    if (isset($argv[1]) && $argv[1]{0} != '-') {
                        $sw = array_shift($argv);
                        if($multiple)
                            $switches[$sw][] = array_shift($argv);
                        else
                            $switches[$sw] = array_shift($argv);
                    } else {
                        throw new Exception("Error: value missing for the '".$argv[0]."' option\n");
                    }
                } else {
                    $sw = array_shift($argv);
                    $switches[$sw] = true;
                }
            } else {
                throw new Exception("Error: unknow option '".$argv[0]."' \n");
            }
        }

        //---------- get the parameters
        foreach ($params as $pname => $needed) {
            if (count($argv) == 0) {
                if ($needed) {
                    throw new Exception("Error: '$pname' parameter missing\n");
                } else {
                    break;
                }
            }
            $parameters[$pname]=array_shift($argv);
        }

        if (count($argv)) {
            throw new Exception("Error: two many parameters\n");
        }

        return array($switches , $parameters);
    }

}

?>
