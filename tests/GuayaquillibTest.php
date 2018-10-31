<?php

use PHPUnit\Framework\TestCase;

class GuayaquillibTest extends TestCase
{
	public function testAutoload()
	{
		$this->assertTrue(\class_exists('\\GuayaquilRequestAM'));
		$this->assertTrue(\class_exists('\\GuayaquilRequestOEM'));
		$this->assertTrue(\class_exists('\\GuayaquilSoapWrapper'));
		$this->assertTrue(\class_exists('\\SSLSoapClient'));
	}

	public function testConnect()
	{
		$file = \realpath(__DIR__ . '/../auth.php');

		if (false === $file)
		{
			$this->assertTrue(false);

			return;
		}

		$auth = require $file;

		$soap = new \GuayaquilSoapWrapper();

		$soap->setUserAuthorizationMethod($auth['username'], $auth['password']);

		$soap->queryData('ManufacturerInfo:Locale=ru_RU|ManufacturerId=4096', false);

		$this->assertTrue(! (0 === \strpos($soap->getError(), 'E_ACCESSDENIED')));
	}
}
