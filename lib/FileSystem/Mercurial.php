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


class Mercurial extends Svn {
    protected $vcs = 'hg';

    function createDir($dir) {
        return DirUtils::createDir($this->rootPath.$dir);
    }
}