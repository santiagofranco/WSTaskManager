<?php
require 'daos/DAOTasks.php';
require 'Config.php';
require 'db/DBConnect.php';

// function defination to convert array to xml
function array_to_xml( $data, &$xml_data ) {
	foreach( $data as $key => $value ) {
		if( is_array($value) ) {
			if( is_numeric($key) ){
				$key = 'item'.$key; //dealing with <0/>..<n/> issues
			}
			$subnode = $xml_data->addChild($key);
			array_to_xml($value, $subnode);
		} else {
			$xml_data->addChild("$key",htmlspecialchars("$value"));
		}
	}
}

$dao = new DAOTasks();
$tasks = $dao->getTasks();

$xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
array_to_xml($tasks, $xml);

echo $xml->asXML();
