<?php
// This file is part of iadlearning Moodle Plugin - http://www.iadlearning.com/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Http requests handling library
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date        2017-01-26
 */

defined('MOODLE_INTERNAL') || die();

class iadlearning_http {

    public function __construct($protocol, $url, $port) {

        $this->protocol = $protocol;
        $this->url = $url;
        $this->port = $port;

    }

    public function iadlearning_http_get($apicall, $requestparameters = array()) {

        $finalurl = $this->protocol . $this->url . ":" . $this->port . $apicall;
        try {
            $c = new curl;
            $response = $c->get($finalurl, $requestparameters);
            $info = $c->get_info();
            $errorno = $c->get_errno();
            if (!$errorno) {
                $responsecode = $info["http_code"];
                return array($responsecode, $response);
            } else {
                return array($errorno, $response);
            }
        } catch (Exception $e) {
            $errorexecption = $e->getMessage();
            $errormsg = get_string('error_in_service', 'iad'). " " . $errorexecption;
            print_error($errormsg);
        }
    }


    public function iadlearning_http_post($apicall, $fields = null) {

        $finalurl = $this->protocol . $this->url . ":" . $this->port . $apicall;

        try {
            $c = new curl;
            $response = $c->post($finalurl, $fields, array('CURLOPT_HTTPHEADER' => "Content-type: application/json"));
            $info = $c->get_info();
            $errorno = $c->get_errno();
            if (!$errorno) {
                $responsecode = $info["http_code"];
                return array($responsecode, $response);
            } else {
                return array($errorno, $response);
            }
            return array($responsecode, $response);
        } catch (Exception $e) {
            $errorexecption = $e->getMessage();
            $errormsg = get_string('error_in_service', 'iad'). " " . $errorexecption;
            print_error($errormsg);
        }

    }



}

