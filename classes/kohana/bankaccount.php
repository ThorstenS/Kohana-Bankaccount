<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Bankaccount module to validate German bank accounts
 *
 * @package    Bankaccount
 */
abstract class Kohana_Bankaccount {
    
    /**
	 * @var  string  default instance name
	 */
	public static $default_name = 'default';

	/**
	 * @var  array  Bankaccount class instances
	 */
	public static $instances = array();
    
	/**
	 * Returns a singleton instance of Bankaccount
	 *
	 *     $bankaccount = Bankaccount::instance();
	 *
	 * @param   string  configuration group name
	 * @return  Bankaccount
	 */
	public static function instance($driver = 'bav', $name = NULL)
	{
		if ($name === NULL)
		{
			// Use the default instance name
			$name = Bankaccount::$default_name;
		}
        
        if ( ! isset(Bankaccount::$instances[$driver][$name]))
		{
			$class = 'Bankaccount_' . ucfirst($driver);

			Bankaccount::$instances[$driver][$name] = $class::instance($driver, $name);
		}

		return Bankaccount::$instances[$driver][$name];
	}
}