<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

require_once SYSTEMPATH . 'Config/Services.php';

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{

	public static function privateKey(){
		$key = <<<EOD
		-----BEGIN RSA PRIVATE KEY-----
		MIICXQIBAAKBgQCBye81o4SFDERgr8sapg0mL2jdUp3ccXsjCT/f2AUMZs2nTNzF
		PRj1WwCdmEgF3hs/7V9K4rkw1B3GxwmaH3yrlMp0PPt5VOmfGAlv/v3OjKr7wDxY
		oRLnCFj7hNwjYHnBQvNIYzO02qLQBHygTKS6KvKJEC0VfEjoU1TBep0guwIDAQAB
		AoGAPO07svVg50g77Rt4/7iFobBNzN/UpUBMasUTzBPPQuQblHbbiGfHCJ7Aqjpr
		TP3X0umueyv1fXuFwuN6mXRAhGc/d/DW15j59INuCO5Y9qpphY1XNfD+uni674RD
		GJWJYMZXsaO+6Mv91y0bGRrKP9+VPQ8tB6zx0LY/AhkcuckCQQDoAjjScrLnFwSg
		B/s/5CF2dT01kcPBqpY+bkD6pUrHaZA6pxKwYGrBOmJcUcSbPUY3EyTGmMYMnV9D
		m4f8LFG3AkEAjzW6fFwnTASAT+0ux3SianoC4mXr4psFT+it+01DuBOTXZ5qHBmS
		2hIFKzK8jmLDOsSRPjyj1Ffvi0t7g0sZHQJAb8PaQa8VdfOFu938cCvi3uDdirfc
		mKgn1o1gah5EZsn4u/iOLT9VTh5lEdomHy6ma5OiTLV9+se5A6WiHZ3wAwJBAIgX
		L9OUI0frEyBhLc4fOWTj86+/2Wyrkl3AqO0iHJNmDumta/quFs6ix0So32ST2CEV
		wUyahbl5o0sE/SfkisUCQQCd+48IYjU4C0FX9ApBIv4r+4jYr600XkbAQ4UnZlpP
		roPDwgkDrrrb71jq7gG9DN3fQrAtll8JLATm6BlnEJLU
		-----END RSA PRIVATE KEY-----
		EOD;
		
		return $key;
	}

	//    public static function example($getShared = true)
	//    {
	//        if ($getShared)
	//        {
	//            return static::getSharedInstance('example');
	//        }
	//
	//        return new \CodeIgniter\Example();
	//    }

}
