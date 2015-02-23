<?php

/**
* @package     jBuildTools
* @author      Laurent Jouanneau
* @contributor
* @copyright   2009 Laurent Jouanneau
* @link        http://jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/

define('SC_DATA_DIR',__DIR__.'/scdata/');

class StripCommentTestCase extends PHPUnit_Framework_TestCase {

    public function providerTestFiles() {
        return array(
            array('source1.txt', 'result1.txt'),
        );
    }

    function setUp() {
    }

    function tearDown() {

    }

    /**
     * @dataProvider providerTestFiles
     */
    function testSimple($source, $result){
        $res = \Jelix\BuildTools\PreProcessor\PhpCommentsRemover::stripComments(file_get_contents(SC_DATA_DIR.$source));
        //if (!file_exists(SC_DATA_DIR.$result))
        //    file_put_contents(SC_DATA_DIR.$result,$res);
        $expected = file_get_contents(SC_DATA_DIR.$result);

        $this->assertEquals($expected, $res, "test $source / $result ");
    }
}
