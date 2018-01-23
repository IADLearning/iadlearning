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
 * The main iad configuration form
 *
 *
 * @package    mod_iadlearning
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Calculates the SHA1 HMAC hash for a given data
 *
 * @param string $key Key used to generate the SHA1 HASH
 * @param string $data Data to hash
 * @param integer $blocksize Block size for SHA1 algorithm
 * @param integer $opad O-key pad
 * @param integer $opad I-key pad
 *
 * @return string sha1 hmac hash
 *
 */
function iadlearning_sha1_hmac($key, $data, $blocksize = 64, $opad = 0x5c, $ipad = 0x36) {

    // Keys longer than blocksize are shortened.
    if (strlen($key) > $blocksize) {
        $key = sha1($key, true);
    }

    // Keys shorter than blocksize are right, zero-padded (concatenated)
    // 'str_pad' pads a string to a certain length with another string.
    $key       = str_pad($key, $blocksize, chr(0x00), STR_PAD_RIGHT);
    $okeypad = $ikeypad = '';

    for ($i = 0; $i < $blocksize; $i++) {
        // Variable 'ord' returns ASCII value of character.
        // Variable 'chr' returns a one-character string containing the character specified by ASCII.
        $okeypad .= chr( ord( substr($key, $i, 1)) ^ $opad);
        $ikeypad .= chr( ord( substr($key, $i, 1)) ^ $ipad);
    }

    return sha1($okeypad . sha1($ikeypad . $data, true), true);
}


/**
 * Generates URL signature for end to end validation
 *
 * @param array $requestparameters Associative array containing the query string options
 * @param string $secretaccesskey Key used to generate signature
 *
 * @return string Signature
 */
function iadlearning_generate_signature($secretaccesskey, $requestparameters) {

    $signaturebase = "";

    // Order query params in alphabetical order and create string to sign.

    ksort($requestparameters);
    foreach ($requestparameters as $key => $value) {
        $signaturebaselenght = strlen($signaturebase);
        if ($signaturebaselenght > 0) {
            $signaturebase .= "&";
        }
        $signaturebase .= urlencode($key)."=".urlencode($value);
    }
    $signaturebase = preg_replace('/[+]/', '%20', $signaturebase);
    return base64_encode(iadlearning_sha1_hmac(urlencode($secretaccesskey), $signaturebase));
}


/**
 * Generates the query string from the options array
 *
 * @param array $requestparameters Associative array containing the query string options
 *
 * @return string Query string
 */
function iadlearning_generate_url_query($requestparameters) {

    $querystring = "";
    foreach ($requestparameters as $key => $value) {
        $querystringlength = strlen($querystring);
        if ($querystringlength > 0) {
            $querystring .= "&";
        }
        $querystring .= urlencode($key)."=".urlencode($value);
        $querystring = preg_replace('/[+]/', '%20', $querystring);
    }
    return $querystring;
}
