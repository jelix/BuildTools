<?php

/**
 * @author      Laurent Jouanneau
 * @copyright   2006-2015 Laurent Jouanneau
 *
 * @link        http://jelix.org
 * @licence     GNU General Public Licence see LICENCE file or http://www.gnu.org/licenses/gpl.html
 */

namespace Jelix\BuildTools\FileSystem;
use Jelix\FileUtilities\Directory;

class DirUtils
{
    /**
     * create a directory.
     *
     * @return bool false if the directory did already exist
     * @deprecated
     */
    public static function createDir($dir)
    {
        return Directory::create($dir);
    }

    public static function normalizeDir($dirpath)
    {
        return rtrim(\Jelix\FileUtilities\Path::normalizePath($dirpath), '/').'/';
    }

    /**
     * Recursive function deleting a directory.
     *
     * @param string $path         The path of the directory to remove recursively
     * @param bool   $deleteParent If the path must be deleted too
     * @deprecated
     */
    public static function removeDir($path, $deleteParent = true)
    {
        return Directory::remove($path, $deleteParent);
    }
}
