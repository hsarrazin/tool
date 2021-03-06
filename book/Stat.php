<?php
/**
* @author Thomas Pellissier Tanon
* @copyright 2012 Thomas Pellissier Tanon
* @licence http://www.gnu.org/licenses/gpl.html GNU General Public Licence
*/

class Stat {
        public static function add($format, $lang) {
                $stat = self::getStat();
                if(isset($stat[$format][$lang]))
                    $stat[$format][$lang]++;
                else
                    $stat[$format][$lang] = 1;
                self::setStat($stat);
        }

        public static function getStat($month = 0, $year = 0) {
                global $wsexportConfig;
                $path = self::getStatPath($month, $year);
                if(file_exists($path))
                        return unserialize(file_get_contents($path));
                else
                        return array(
                                'epub' => array(),
                                'odt' => array(),
                                'xhtml' => array()
                            );
        }

        protected static function setStat($stat) {
                global $wsexportConfig;
                $path = self::getStatPath();
                return file_put_contents($path, serialize($stat));
        }

        protected static function getStatPath($month = 0, $year = 0) {
                global $wsexportConfig;
                if($month == 0 && $year == 0) {
                        date_default_timezone_set('UTC');
                        $date = getdate();
                        if(@mkdir($wsexportConfig['tempPath'].'/stat')) {}
                        if(@mkdir($wsexportConfig['tempPath'].'/stat/' . $date['year'])) {}
                        return $wsexportConfig['tempPath'].'/stat/' . $date['year'] . '/' . $date['mon'] .'.sphp';
                } else {
                        return $wsexportConfig['tempPath'].'/stat/' . $year . '/' . $month .'.sphp';
                }
        }
}

