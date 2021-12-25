<?php
	class Endpoint {
		public $endpoint;
		private $serverName = "Pewdictus";
		private $pingServer = "144.91.122.74";
		private $ip = "144.91.122.74";
		private $port = "27015";
		private $buildver = 'yujX0zPWDfRgPuuJ9FM4TIwITYFl4qEBrTWGsVTi';
		
		function __construct($buildVer)
		{
			if (empty($buildVer) || !isset($buildVer) || $buildVer != $this->buildver)
			{
				$this->serverName = "Client Update Required";
				$this->pingServer = "0.0.0.0";
				$this->ip = "0.0.0.0";
				$this->port = "0000";
			}
			
			$this->endpoint = '"Address"
			{
				"'.$this->serverName.'"
				{
					Platform_server_code "1"
					localized_name       "'.$this->serverName.'"
					region_code            "1"
					ping_server            "'.$this->pingServer.'"
					IP
					{
						"'.$this->ip.'" "'.$this->port.'"
					}
				}
					"Nakashima\'s Realm"
					{
						Platform_server_code "1"
						localized_name       "Nakashima\'s Realm"
						IP
						{
							"nakashimakun.ddns.net" "27015"
						}
					}
			}';
		}
	}
?>