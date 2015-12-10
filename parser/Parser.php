<?php

class Parser{
	
	public function __construct(){
		
	}
	
	public function parsearArray($array, $root = "root", $item = 'item') {
		$xml = new DOMDocument ();
		
		$rootElement = $xml->createElement ( $root );
		
		foreach ( $array as $a ) {
			$itemElement = $xml->createElement ( $item );
			$this->addChildFromArray( $a, $xml, $itemElement );
			$rootElement -> appendChild($itemElement);
		}
		$xml->appendChild ( $rootElement );
		$header = "Content-Type:text/xml";
		
		header ( $header );
		print $xml->saveXML ();
	}
	
	private function addChildFromArray($array, DOMDocument $xml, DOMElement $element) {
		foreach ( $array as $key => $value ) {
			$node = $xml->createElement ( $key, $value );
			$element->appendChild ( $node );
		}
	}
	
	public function xmlError($mensaje,$root = "error") {
		$xml = new DOMDocument ();
		
		$rootElement = $xml->createElement ( $root );
		$rootElement->appendChild($xml->createElement("mensaje",$mensaje));
		$xml->appendChild($rootElement);
				
		header ( "Content-Type:text/xml" );
		print $xml->saveXML ();

	}
}