<?php
class Utils {
	
	/**
	 * Genera un string unico MD5
	 */
	public function generateApiKey() {
		return md5(uniqid(rand(), true));
	}
	
	/**
	 * Convertir un array en
	 * */
	function fun ($array,DOMDocument $xml, DOMElement $element){
		foreach ($array as $key => $value) {
			if(is_array($value)){
				fun($value,$xml,$element);
			}else{
				$node = $xml->createElement($key,$value);
				$element->appendChild($node);
			}
		}
	}
}