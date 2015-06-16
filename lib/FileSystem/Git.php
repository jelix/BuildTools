<?php

/**
 * @author      Laurent Jouanneau
 * @contributor
 *
 * @copyright   2012-2015 Laurent Jouanneau
 *
 * @link        http://jelix.org
 * @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
 */

namespace Jelix\BuildTools\FileSystem;

class Git extends Mercurial
{
    protected $vcs = 'git';

    public function removeDir($dir)
    {
        if (file_exists($this->rootPath.$dir)) {
            return $this->launchCommand("rm -r $dir");
        }

        return false;
    }

    public static function revision($path = '.')
    {
        $path = DirUtils::normalizeDir($path);
        $rev = -1;
        if (file_exists($path.'.git')) {
            $wd = getcwd();
            chdir($path);
            $rev = intval(`git rev-list HEAD --count`);
            chdir($wd);
        }

        return $rev;
    }
}
