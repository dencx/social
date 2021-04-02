<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				//'pattern' => '',
				'required' => true
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				//'pattern' => '',
				'required' => true
			],
			[
				'name' => 'position',
				'source' => 'p',
				'default' => '',
				'required' => false
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'pattern' => 'ukrphone',
				'required' => true
			],
			[
				'name' => 'email',
				'source' => 'p',
				'pattern' => 'latemail',
				'required' => true
			],
		]
	]
];