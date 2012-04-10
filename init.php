<?php defined('SYSPATH') OR die('No direct access allowed.');

Route::set('bankaccount-get-bankname', 'bankaccount/bankname/<bankcode>', array(
        'controller' => 'Bankaccount',
        'action' => '(get_bankname_by_bankcode)',
        'bankcode' => '(\d)+',
        'directory'  => 'bankaccount/',
    ))
	->defaults(array(
		'controller' => 'Bankaccount',
		'action'     => 'get_bankname_by_bankcode',
		'directory'  => 'bankaccount/',
	));

Route::set('bankaccount-validate', 'bankaccount/validate/<bankcode>/<account>', array(
        'controller' => 'Bankaccount',
        'action' => '(validate)',
        'bankcode' => '(\d)+',
        'account' => '(\d)+',
        'directory'  => 'bankaccount/',
    ))
	->defaults(array(
		'controller' => 'Bankaccount',
		'action'     => 'validate',
		'directory'  => 'bankaccount/',
	));