<?php

class ServiceApache
{
	const INIT = 'systemd';
	
	public function reload ()
	{
		$cmdFormat;
		
		switch (self::INIT)
		{
			case 'sysvinit':
				$cmdFormat = 'service {:service:} {:cmd:}';
				break;
			case 'systemd':
				$cmdFormat = 'systemctl {:cmd:} {:service:}';
				break;
			case 'upstart':
				$cmdFormat = 'service {:service:} {:cmd:}';
				break;
		}
		
		$cmd = str_replace ('{:service:}', 'apache2', $cmdFormat);
		$cmd = str_replace ('{:cmd:}', 'reload', $cmd);
		
		exec ('service apache2 reload 2>&1', $output, $exitStatus);
		
		return array
		(
			'exitcode' => $exitStatus,
			'output' => implode (PHP_EOL, $output)
		);
	}
}
