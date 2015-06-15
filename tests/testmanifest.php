<?php
/**
* @author      Laurent Jouanneau
* @copyright   2015 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/
use Jelix\BuildTools\Manifest\Reader as Reader;
use Jelix\BuildTools\FileSystem\DirUtils;


class ManifestTestCase extends PHPUnit_Framework_TestCase {

    protected function verifyDirContent($expectedDir, $resultDir) {

        // first, verify that every files into resultDir match files into expectedDir
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($resultDir));
        $it->rewind();
        while($it->valid()) {
            if (!$it->isDot()) {
                $resultpath = $it->getSubPath();
                $resultBasename = $it->getBaseName();
                $this->assertFileExists($expectedDir.$resultpath.'/'.$resultBasename);
                $this->assertFileEquals($expectedDir.$resultpath.'/'.$resultBasename, $resultDir.$resultpath.'/'.$resultBasename);
            }
            $it->next();
        }

        // second, verify that everyfile into expectedDir ar in resultDir
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($expectedDir));
        $it->rewind();
        while($it->valid()) {
            if (!$it->isDot()) {
                $expectedpath = $it->getSubPath();
                $expectedBasename = $it->getBaseName();
                $this->assertFileExists($resultDir.$expectedpath.'/'.$expectedBasename);
            }
            $it->next();
        }
    }

    function setUp() {
        if (file_exists(__DIR__.'/_result')) {
            DirUtils::removeDir(__DIR__.'/_result', false);
        }
        else {
            mkdir(__DIR__.'/_result');
        }
    }


    function testSimpleCopy() {
        $manifest = new Reader(__DIR__.'/manifests/simplecopy.mn', __DIR__.'/sourcedir/', __DIR__.'/_result');
        $manifest->process(array(), false);
        $this->verifyDirContent(__DIR__.'/expecteddirs/simplecopy/', __DIR__.'/_result/');
    }

    function testSimpleCopyWithALL() {
        $manifest = new Reader(__DIR__.'/manifests/simplecopyALL.mn', __DIR__.'/sourcedir/', __DIR__.'/_result');
        $manifest->process(array(), false);
        $this->verifyDirContent(__DIR__.'/expecteddirs/simplecopyALL/', __DIR__.'/_result/');
    }

    function testSimpleCopyWithALLREC() {
        $manifest = new Reader(__DIR__.'/manifests/simplecopyALLREC.mn', __DIR__.'/sourcedir/', __DIR__.'/_result');
        $manifest->process(array(), false);
        $this->verifyDirContent(__DIR__.'/expecteddirs/simplecopy/', __DIR__.'/_result/');
    }

    function testWithPreprocessor() {
        $manifest = new Reader(__DIR__.'/manifests/withpreprocessor.mn', __DIR__.'/sourcedir/', __DIR__.'/_result');
        $manifest->process(array('MYVARIABLE'=>'hello'), false);
        $this->verifyDirContent(__DIR__.'/expecteddirs/withpreprocessor/', __DIR__.'/_result/');
    }

    function testWithPreprocessorALLREC() {
        $manifest = new Reader(__DIR__.'/manifests/withpreprocessorALLREC.mn', __DIR__.'/sourcedir/', __DIR__.'/_result');
        $manifest->process(array('MYVARIABLE'=>'hello'), false);
        $this->verifyDirContent(__DIR__.'/expecteddirs/withpreprocessor/', __DIR__.'/_result/');
    }
}