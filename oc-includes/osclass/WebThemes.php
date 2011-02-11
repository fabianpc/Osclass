<?php

    /**
     * OSClass – software for creating and publishing online classified advertising platforms
     *
     * Copyright (C) 2010 OSCLASS
     *
     * This program is free software: you can redistribute it and/or modify it under the terms
     * of the GNU Affero General Public License as published by the Free Software Foundation,
     * either version 3 of the License, or (at your option) any later version.
     *
     * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
     * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
     * See the GNU Affero General Public License for more details.
     *
     * You should have received a copy of the GNU Affero General Public
     * License along with this program. If not, see <http://www.gnu.org/licenses/>.
     */

     class WebThemes {

        private static $instance ;
        private $theme ;
        private $theme_url ;
        private $theme_path ;

        public static function newInstance() {
            if(!self::$instance instanceof self) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        public function __construct() {
            $this->setCurrentTheme( osc_theme() ) ;
        }

        /* PRIVATE */
        private function setCurrentThemeUrl() {
            $this->theme_url = osc_base_url() . 'oc-content/themes/' . $this->theme . '/' ;
        }

        private function setCurrentThemePath() {
            $this->theme_path = osc_base_path() . 'oc-content/themes/' . $this->theme . '/' ; //XXX: must take data from defined global var.
        }

        /* PUBLIC */
        public function setCurrentTheme($theme) {
            $this->theme = $theme ;
            $this->setCurrentThemeUrl() ;
            $this->setCurrentThemePath() ;
        }

        public function getCurrentTheme() {
            return $this->theme ;
        }

        public function getCurrentThemeUrl() {
            return $this->theme_url ;
        }

        public function getCurrentThemePath() {
            return $this->theme_path ;
        }

        public function getCurrentThemeStyles() {
            return $this->theme_url . 'css/' ;
        }

        public function getCurrentThemeJs() {
            return $this->theme_url . 'js/' ;
        }

        /**
         * This function returns an array of themes (those copied in the oc-content/themes folder)
         * @return <type>
         */
        public function getListThemes() {
            $themes = array();
            $dir = opendir( osc_base_path() .  'oc-content/themes');
            while ($file = readdir($dir)) {
                if (preg_match('/^[a-z0-9_]+$/i', $file))
                    $themes[] = $file;
            }
            closedir($dir);
            return $themes;
        }
        /**
         *
         * @param <type> $theme
         * @return <type> 
         */
        function loadThemeInfo($theme) {
            $path = osc_base_path() . 'oc-content/themes/' . $theme . '/index.php';
            if (!file_exists($path))
                return false;
            require_once $path;

            $fxName = $theme . '_theme_info';
            if (!function_exists($fxName))
                return false;
            $result = call_user_func($fxName);

            $result['int_name'] = $theme;

            return $result;
        }
    }

?>