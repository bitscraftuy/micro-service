<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 16 May 2017 05:00:00 GMT');
header('Content-type: application/json; charset=utf-8');

$response = array();
$response['message'] = $message;
$response['error'] = $error;
$response['collection'] = $collection;
echo json_encode($response);
$lastError = json_last_error();
$encodeError = '';
switch ($lastError) {
	case JSON_ERROR_NONE :
		$encodeError = FALSE;
		break;
	case JSON_ERROR_DEPTH :
		$encodeError = ' - Maximum stack depth exceeded';
		break;
	case JSON_ERROR_STATE_MISMATCH :
		$encodeError = ' - Underflow or the modes mismatch';
		break;
	case JSON_ERROR_CTRL_CHAR :
		$encodeError = ' - Unexpected control character found';
		break;
	case JSON_ERROR_SYNTAX :
		$encodeError = ' - Syntax error, malformed JSON';
		break;
	case JSON_ERROR_UTF8 :
		$encodeError = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
		break;
	default :
		$encodeError = ' - Unknown error';
		break;
}
if ($encodeError ) echo $encodeError;
?>