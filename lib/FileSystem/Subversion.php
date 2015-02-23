<?php
/**
* @package     jBuildTools
* @author      Laurent Jouanneau
* @contributor
* @copyright   2012-2015 Laurent Jouanneau
* @link        http://jelix.org
* @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
*/
namespace Jelix\BuildTools\FileSystem;


class Subversion extends Os {
    protected $vcs = 'svn';

    protected function launchCommand($cmd) {
        $d = getcwd();
        chdir($this->rootPath);
        exec($this->vcs.' '.$cmd, $output, $exitCode);
        chdir($d);
        return ($exitCode == 0);
    }

    function createDir($dir) {
        if (!file_exists($this->rootPath.$dir)) {
            $this->createDir(dirname($dir));
            mkdir($this->rootPath.$dir, 0775);
            return $this->launchCommand("add $dir");
        }
        return false;
    }

    function copyFile($sourcefile, $targetFile) {
        $addToVcs = !file_exists($this->rootPath.$targetFile);
        if (parent::copyFile($sourcefile, $targetFile)) {
            if ($addToVcs)
                $this->launchCommand("add $targetFile");
            return true;
        }
        return false;
    }

    function setFileContent($file, $content) {
        $addToVcs = !file_exists($this->rootPath.$file);
        parent::setFileContent($file, $content);
        if ($addToVcs) {
            $this->launchCommand("add $file");
        }
    }

    function removeFile($file) {
        if (file_exists($this->rootPath.$file))
            $this->launchCommand("rm $file");
        return true;
    }

    function removeDir($dir) {
        if (file_exists($this->rootPath.$dir))
            $this->launchCommand("rm $dir");
    }

    static public function revision($path='.'){
        $path = DirUtils::normalizeDir($path);
        $rev=-1;
        if (file_exists($path.'.svn/entries')) {
            $rev=`svnversion $path --no-newline`;
            if (preg_match("/(\d+)[MS]+/",$rev, $m)) {
                $rev = $m[1];
            }
        }
        return $rev;
    }
}

