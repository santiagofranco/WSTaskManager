<?php
class Utils {
	
	/**
	 * Genera un string unico MD5
	 */
	public function generateApiKey() {
		return md5(uniqid(rand(), true));
	}
}