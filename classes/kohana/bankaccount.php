<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Bankaccount module to validate German bank accounts
 *
 * @package    Bankaccount
 */
abstract class Kohana_Bankaccount {

	/**
	 * Returns a singleton instance of Bankaccount
	 *
	 *     $bankaccount = Bankaccount::instance();
	 *
	 * @param   string  configuration group name
	 * @return  Bankaccount
	 */
	public static function factory($driver = 'bav')
	{
        $class = 'Bankaccount_' . ucfirst($driver);
		return new $class;
	}
}