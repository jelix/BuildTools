<?php
/**
* @author      Laurent Jouanneau
* @contributor
* @copyright   2006-2015 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/

define('PP_DATA_DIR', __DIR__.'/ppdatas/');

class PreProcTestCase extends \PHPUnit\Framework\TestCase {
    protected $proc;

    public function providerSimpleData() {
        return  array(
            // file without instructions
            array('source1.txt', 'source1.txt', array()),
            // with a simple #ifdef
            array('source2.txt', 'result2_1.txt', array()),
            array('source2.txt', 'result2_2.txt', array('FOO'=>true)),
            // with a simple #ifdef #else
            array('source3.txt', 'result3_1.txt', array()),
            array('source3.txt', 'result3_2.txt', array('FOO'=>true)),
            // with several imbricated #ifdef
            array('source4.txt', 'result4_1.txt', array()),
            array('source4.txt', 'result4_2.txt', array('FOO'=>true)),
            array('source4.txt', 'result4_3.txt', array('BAR'=>true)),
            array('source4.txt', 'result4_4.txt', array('FOO'=>true, 'BAR'=>true)),
            // #ifdef + #expand
            array('source5.txt', 'result5_1.txt', array()),
            array('source5.txt', 'result5_2.txt', array('FOO'=>"une variable foo", "BAR"=>"le bar est ouvert")),
            // #ifdef + #elifdef
            array('source6.txt', 'result6_1.txt', array()),
            array('source6.txt', 'result6_2.txt', array('FOO'=>true)),
            array('source6.txt', 'result6_3.txt', array('BAR'=>true)),
            array('source6.txt', 'result6_4.txt', array('FOO'=>true, 'BAR'=>true)),
            // #ifdef + 2 x #elifdef
            array('source7.txt', 'result7_1.txt', array()),
            array('source7.txt', 'result7_2.txt', array('FOO'=>true)),
            array('source7.txt', 'result7_3.txt', array('BAR'=>true)),
            array('source7.txt', 'result7_4.txt', array('BAZ'=>true)),
            array('source7.txt', 'result7_5.txt',  array('BAZ'=>true, 'BAR'=>true)),
            // #ifef + define
            array('source_define.txt', 'result_define.txt', array('FOO'=>true)),
            // #undef, #define
            array('source_define2.txt', 'result_define2.txt', array('FOO'=>'ok')),
            // #include
            array('source_include1.txt', 'result_include1.txt', array('FOO'=>'ok')),
            // #includephp
            array('source_include2.txt', 'result_include2.txt', array('FOO'=>'ok')),
            // #include | rmphptag
            array('source_include_phptag.txt', 'result_include2.txt', array('FOO'=>'ok')),
            // #include | some options
            array('source_include_options.txt', 'results_include_options.txt', array()),
            // #includeraw | some options
            array('source_includeraw_options.txt', 'results_includeraw_options.txt', array()),
            // #includeinto
            array('source_include_into.txt', 'results_include_into.txt', array()),
        );
    }

    public function providerSimpleData2() {
        return  array(
            // with a simple #ifdef
            array('source2.txt', 'result2_1.txt', array('FOO'=>'')),
            array('source2.txt', 'result2_2.txt', array('FOO'=>true)),
            // with a simple #ifdef #else
            array('source3.txt', 'result3_1.txt', array('FOO'=>'')),
            array('source3.txt', 'result3_2.txt', array('FOO'=>true)),
            // with several imbricated #ifdef
            array('source4.txt', 'result4_1.txt', array('FOO'=>'', 'BAR'=>'')),
            array('source4.txt', 'result4_2.txt', array('FOO'=>true, 'BAR'=>'')),
            array('source4.txt', 'result4_3.txt', array('BAR'=>true, 'FOO'=>'')),
            array('source4.txt', 'result4_4.txt', array('FOO'=>true, 'BAR'=>true)),
            // #ifdef + #expand
            array('source5.txt', 'result5_1.txt', array('FOO'=>'', 'BAR'=>'')),
            array('source5.txt', 'result5_2.txt', array('FOO'=>"une variable foo", "BAR"=>"le bar est ouvert")),
            // #ifdef + #elifdef
            array('source6.txt', 'result6_1.txt', array('FOO'=>'', 'BAR'=>'')),
            array('source6.txt', 'result6_2.txt', array('FOO'=>true)),
            array('source6.txt', 'result6_3.txt', array('BAR'=>true)),
            array('source6.txt', 'result6_4.txt', array('FOO'=>true, 'BAR'=>true)),
            // #ifdef + 2 x #elifdef
            array('source7.txt', 'result7_1.txt', array('FOO'=>'', 'BAR'=>'', 'BAZ'=>'')),
            array('source7.txt', 'result7_2.txt', array('FOO'=>true, 'BAR'=>'', 'BAZ'=>'')),
            array('source7.txt', 'result7_3.txt', array('BAR'=>true, 'FOO'=>'')),
            array('source7.txt', 'result7_4.txt', array('BAZ'=>true)),
            array('source7.txt', 'result7_5.txt',  array('BAZ'=>true, 'BAR'=>true)),

            array('source_if1.txt', 'result2_1.txt', array('FOO'=>'')),
            array('source_if1.txt', 'result2_2.txt', array('FOO'=>true)),

            array('source_if2.txt', 'result2_1.txt', array('FOO'=>'')),
            array('source_if2.txt', 'result2_2.txt', array('FOO'=>14)),

            array('source_if3.txt', 'result2_1.txt', array('FOO'=>'', 'BAR'=>'toto')),
            array('source_if3.txt', 'result2_2.txt', array('FOO'=>'toto',  'BAR'=>'toto')),

            array('source_if4.txt', 'result2_1.txt', array('FOO'=>true)),
            array('source_if4.txt', 'result2_2.txt', array('FOO'=>false)),
        );
    }

    function setUp() :void {
    }

    function tearDown() :void {

    }

    /**
     * @dataProvider providerSimpleData
     */
    function testSimple($source, $result, $vars) {
        $proc = new \Jelix\BuildTools\PreProcessor\PreProcessor();
        $proc->setVars($vars);
        $res = $proc->parseFile(PP_DATA_DIR.$source);
        $this->assertEquals($res, file_get_contents(PP_DATA_DIR.$result), "test $source / $result ");
    }

    /**
     * @dataProvider providerSimpleData2
     */
    function testSimple2($source, $result, $vars){
        $proc = new \Jelix\BuildTools\PreProcessor\PreProcessor();
        $proc->setVars($vars);
        $res = $proc->parseFile(PP_DATA_DIR.$source);
        $this->assertEquals($res, file_get_contents(PP_DATA_DIR.$result), "test $source / $result ");
    }

    public function providerErrorTests() {
        return array(
            array('source_err1.txt', 1,'source_err1.txt',8), // err syntax
            array('source_err2.txt', 2,'source_err2.txt',7), // err if missing
            array('source_err3.txt', 2,'source_err3.txt',5), // err if missing
            array('source_err4.txt', 3,'source_err4.txt',13), // err endif missing
            array('source_err5.txt', 4,'source_err5.txt',7), // err invalid filename
            array('source_err6.txt', 4,'subdir/inc_err.txt',11), // err invalid filename
            array('source_if_err1.txt', 5,'source_if_err1.txt',5), // err syntax err expression
            array('source_if_err2.txt', 6,'source_if_err2.txt',5), // err syntax err expression tok
        );
    }

    /**
     * @dataProvider providerErrorTests
     */
    function testErrors($source, $code, $source2, $sourceLine){
         try{
           $proc = new \Jelix\BuildTools\PreProcessor\PreProcessor();
           $res = $proc->parseFile(PP_DATA_DIR.$source);
           $this->assertFalse(true, $source.' : no errors!');
         }
         catch(\Jelix\BuildTools\PreProcessor\Exception $e) {
            $this->assertEquals($code, $e->getCode());

            if ($e->sourceFilename != PP_DATA_DIR.$source2) {
                $s = substr($e->sourceFilename, - strlen(PP_DATA_DIR.$source2));
                $this->assertEquals(PP_DATA_DIR.$source2, $s);
            }
            $this->assertEquals($sourceLine,$e->sourceLine);
        }
    }
}
