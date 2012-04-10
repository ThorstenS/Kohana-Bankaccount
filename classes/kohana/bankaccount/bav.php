<?php defined('SYSPATH') or die('No direct script access.');

require_once( Kohana::find_file('vendor/bav/classes/autoloader', 'BAV_Autoloader') );
BAV_Autoloader::add(Kohana::find_file('vendor/bav/classes/dataBackend', 'BAV_DataBackend_PDO'));

/**
 * Bankaccount module to validate German bank accounts
 *
 * @package    Bankaccount
 */
class Kohana_Bankaccount_Bav extends Bankaccount {
    
    /**
	 * @var  object  bav instance
	 */
    protected $bav;
    
    /**
	 * Returns a singleton instance of Bankaccount_BAV
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
            $db_group = Kohana::$config->load('bankaccount')->db_group;
            $db_config = Kohana::$config->load('database')->$db_group;
            
			$pdo = new PDO(
            'mysql:host='.$db_config['connection']['hostname'].
            ';dbname=' . $db_config['connection']['database'], 
            $db_config['connection']['username'], 
            $db_config['connection']['password']);
            
            $pdo->exec("SET CHARACTER SET utf8");
            
			Bankaccount::$instances[$driver][$name] = new Kohana_Bankaccount_Bav(new BAV_DataBackend_PDO($pdo));
		}

		return Bankaccount::$instances[$driver][$name];
	}
	
	/**
	 * Creates a new BAV wrapper.
	 *
	 * @param   object  BAV_DataBackend_PDO
	 */
	public function __construct(BAV_DataBackend_PDO $bav)
	{
	   $this->bav = $bav;
	}
	
	/**
	 * Get the bank name based on bank code
	 *
	 *     $name = $bankaccount->get_bankname_by_bankcode(50070024);
	 *     echo $name; // -> Deutsche Bank PGK Frankfurt
	 *
	 * @param   string bank code
	 * @throws Bankaccount_Exception
	 * @return  string  bank name
	 */
	public function get_bankname_by_bankcode($bank_code)
	{
        try
        {
            $bank = $this->bav->getBank($bank_code);
            $bank_name = $bank->getMainAgency()->getShortTerm();
        }
        catch ( Exception $fail)
        {
            throw new Bankaccount_Exception($fail->getMessage());
        }
        
        return $bank_name;
	}
	
	/**
	 * Validate an account numer
	 *
	 *     $valid = $bankaccount->validate(50070024, 987654321);
	 *     var_dump($valid); // -> false
	 *
	 * @param   string bank code
	 * @param   string account number
	 * @return bool true/false
	 */
	public function validate($bankcode, $accountnumber)
	{
	    if (empty($bankcode) OR empty($accountnumber))
        {
            return false;
        }
        
        try
        {
            $bank = $this->bav->getBank($bankcode);
            
            if ( ! $bank->isValid($accountnumber))
            {
                return false;
            }
        }
        catch ( Exception $e)
        {
            return false;
        }
        
        return true;
	}
	
	/**
	 * Install database, make sure user has permissions to create table
	 * Only call this once, if you want to update your dataset, use update()
	 *
	 *     $bankaccount->install();
	 */
	public function install()
	{
        $this->bav->install();
	}
	
	/**
	 * Update database, make sure user has permissions to create table
	 *
	 *     $bankaccount->update();
	 */
	public function update()
	{
        $this->bav->update();
	}
}