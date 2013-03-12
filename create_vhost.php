<?php

$host_file  	= '/etc/hosts';
$http_root_dir		= '/www';
$virtual_host_dir	= '/etc/httpd/conf/virtualhosts';

$domain		= $argv[1];

if (!file_exists($http_root_dir.'/'.$domain))
{
	mkdir($http_root_dir.'/'.$domain);
}

$http_conf = <<<CONF
NameVirtualHost *:80

<VirtualHost *:80>
        DocumentRoot /www/$domain/
        ServerName $domain
</VirtualHost>
CONF;

file_put_contents($virtual_host_dir.'/'.$domain.'.conf', $http_conf);

file_put_contents($http_root_dir.'/'.$domain.'/index.html', 'Welcome to '.$domain);

file_put_contents($host_file, "\n#$domain\n127.0.0.1 $domain\n" , FILE_APPEND);

`/bin/systemctl  restart httpd.service`;


