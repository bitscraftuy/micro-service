<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$response = array();
			$response['message'] = $message;
			$response['error'] = $error;
			$response['collection'] = $vendors;

			echo json_encode($response);
?>