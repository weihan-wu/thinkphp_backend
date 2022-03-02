<?php

return [
	//跨域总开关
	'on' => true,
	'headers' => 'multipart/form-data,Token,Accept,Authorization,Cache-Control,Content-Type,DNT,If-Modified-Since,Keep-Alive,Origin,User-Agent,X-Mx-ReqToken,X-Requested-With,X-CustomHeader',
	'allow_host' => [
		'http://127.0.0.1',
		'http://localhost:8080/',
	],
];
