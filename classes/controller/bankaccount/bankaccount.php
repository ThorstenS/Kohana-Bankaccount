<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Bankaccount module to validate German bank accounts
 *
 * @package    Bankaccount
 */
class Controller_Bankaccount_Bankaccount extends Controller {
    
    public function action_get_bankname_by_bankcode()
    {
        $bankcode = $this->request->param('bankcode');
        
        $bank = Bankaccount::instance();
        $name = '';
        
        try
        {
            $name = $bank->get_bankname_by_bankcode($bankcode);
        }
        catch (Bankaccount_Exception $e)
        {
            throw $e;
        }
        catch (Exception $e)
        {
            throw $e;
        }
        
        $this->response->body($name);
    }
    
    public function action_validate()
    {
        $bankcode = $this->request->param('bankcode');
        $account  = $this->request->param('account');
        
        $bank = Bankaccount::instance();
        $result = false;
        try
        {
            $result = $bank->validate($bankcode, $account);
        }
        catch (Bankaccount_Exception $e)
        {
            throw $e;
        }
        catch (Exception $e)
        {
            throw $e;
        }
        
        $this->response->body((int) $result);
    }
}