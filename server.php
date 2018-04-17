<?php
require_once('nusoap/lib/nusoap.php');
$server = new soap_server();

$namespace = "http://kawung.cs.ui.ac.id/~ibad.rahadian/webservice/server.php";
$server->configureWSDL("BooksApp");
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
	'contact',
	'complexType',
	'struct',
	'all',
	'',
	array(
		'ID'=>array('name'=>'ID', 'type'=>'xsd:string'),
		'first_name'=>array('name'=>'first_name', 'type'=>'xsd:string'),
		'last_name'=>array('name'=>'last_name', 'type'=>'xsd:string'),
		'email'=>array('name'=>'email', 'type'=>'xsd:string')
	)
);

function get_message($name) {
   	return "Welcome ".$name;
}

$server->register('get_message');

function get_product($category) {
	if(category == "books") {
		$books = join("<br/> ", array(
			"The Books of Magic",
			"Black Magic and Curses",
			"Advance Mastery in Potions Making"
		));
		return "You need to buy: <br/>".$books;
	} else {
		return "You must read books";
	}
}

$server->register(
	'get_message',
	array('name'=>'xsd:string'),
	array('return'=>'xsd:string'),
	$namespace,
	false,
	'rpc',
	'encoded',
	'Metode Hello World Sederhana'
);
$server->register('get_product');

function reformat_contact($contact) {
	$contact['ID'] = "KODE".$contact['ID'];
	$contact['first_name'] = "Mrs. ".$contact['first_name'];
	$contact['email'] = $contact['last_name']."@hogwarts.ac.id";
	return $contact;
}

$server->register(
	'reformat_contact',
	array('contact'=>'tns:contact'),
	array('return'=>'tns:contact'),
	$namespace,
	false,
	'rpc',
	'encoded',
	'Metode mengubah isi contact'
);


if(!isset($HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
$server->service($HTTP_RAW_POST_DATA);
exit();

?>
