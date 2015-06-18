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

class Mercurial extends Subversion
{
    protected $vcs = 'hg';

    public function createDir($dir)
    {
        return \Jelix\FileUtilities\Directory::create($this->rootPath.$dir);
    }

    public static function revision($path = '.')
    {
        $path = DirUtils::normalizeDir($path);
        $rev = -1;
        if (file_exists($path.'.hg')) {
            $rev = `hg tip --template "{rev}" -R $path`;
            if (preg_match("/(\d+)/", $rev, $m)) {
                $rev = $m[1];
            }
        }

        return $rev;
    }
}
