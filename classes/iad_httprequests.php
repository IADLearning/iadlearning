<?php

// This file is part of iAdLearning Moodle Plugin - http://www.iadlearning.com/
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

class iad_http {

    public function __construct($url, $port) {

        $this->url = $url;
        $this->port = $port;

    }


    public function iad_hhtp_get($api_call, $query_string = null) {

        $final_url = $this->url . ":" . $this->port . $api_call;
        if ($query_string) {
            $final_url = $final_url . '?' . $query_string; 
        }
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $final_url );
            curl_setopt($ch, CURLOPT_VERBOSE, 1 );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if( ! $response = curl_exec($ch)) 
            { 
                trigger_error(curl_error($ch)); 
            } 
            curl_close($ch);
            return $response;
        } catch (Exception $e) {
            $errorexecption = $e->getMessage();
            $errormsg = get_string('error_in_service', 'iad'). " " . $errorexecption;
            print_error($errormsg);
        }

    }



}

