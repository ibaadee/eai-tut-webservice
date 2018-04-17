<?php
require_once('nusoap/lib/nusoap.php');
$client = new nusoap_client('http://kawung.mhs.cs.ui.ac.id/~ibad.rahadian/webservice/server.php');

$response = $client->call('get_message', array("name"=>"Harry"));
echo $response;

echo "<br/>";
$response = $client->call('get_product', array("category"=>"books"));
echo $response;

$data = array(
	'ID'=>"1",
	'first_name'=>"Hermione",
	'last_name'=>"Granger",
	'email'=>"hermione@hogwarts.com"
);

$response = $client->call('reformat_contact', array('contact'=>$data));
echo "<pre>";
print_r($response);
echo "</pre>";

?>
