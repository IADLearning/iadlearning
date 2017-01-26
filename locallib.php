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



function sha1_hmac($key, $data, $blockSize = 64, $opad = 0x5c, $ipad = 0x36) {

	// Keys longer than blocksize are shortened
	if (strlen($key) > $blockSize) {
		$key = sha1($key, true);
	}

	// Keys shorter than blocksize are right, zero-padded (concatenated)
	//	'str_pad' pads a string to a certain length with another string
	$key       = str_pad($key, $blockSize, chr(0x00), STR_PAD_RIGHT);
	$o_key_pad = $i_key_pad = '';

	for($i = 0; $i < $blockSize; $i++) {
		// 'ord' returns ASCII value of character
		//	'chr' returns a one-character string containing the character specified by ASCII
		$o_key_pad .= chr( ord( substr($key, $i, 1)) ^ $opad);
		$i_key_pad .= chr( ord( substr($key, $i, 1)) ^ $ipad);
	}

	return sha1($o_key_pad . sha1($i_key_pad . $data, true), true);
}



function generate_signature($secretAccessKey, $requestparameters) {

	$signaturebase="";

	// Order query params in alphabetical order and create string to sign

	ksort($requestparameters);
	foreach ($requestparameters as $key => $value) {
		$signaturebaselenght = strlen($signaturebase);
		if ($signaturebaselenght > 0) {
			$signaturebase.="&";
		}
		$signaturebase.=urlencode($key)."=".urlencode($value);
	}
	$signaturebase = preg_replace('/[+]/', '%20', $signaturebase);
	return base64_encode(sha1_hmac(urlencode($secretAccessKey), $signaturebase));
}



function generate_url_query($requestparameters) {

	$querystring="";
	foreach ($requestparameters as $key => $value) {
		$querystringlength = strlen($querystring);
		if ($querystringlength > 0) {
			$querystring.="&";
		}
		$querystring.=urlencode($key)."=".urlencode($value);
		$querystring = preg_replace('/[+]/', '%20', $querystring);
	}
	return $querystring;
}


?>
