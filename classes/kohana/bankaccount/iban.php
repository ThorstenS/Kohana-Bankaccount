<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Bankaccount_IBAN extends Bankaccount {

    /*
     * Numeric values for corresponding letters in IBAN
     */
    protected $convert = array(
        'A' => 10,
        'B' => 11,
        'C' => 12,
        'D' => 13,
        'E' => 14,
        'F' => 15,
        'G' => 16,
        'H' => 17,
        'I' => 18,
        'J' => 19,
        'K' => 20,
        'L' => 21,
        'M' => 22,
        'N' => 23,
        'O' => 24,
        'P' => 25,
        'Q' => 26,
        'R' => 27,
        'S' => 28,
        'T' => 29,
        'U' => 30,
        'V' => 31,
        'W' => 32,
        'X' => 33,
        'Y' => 34,
        'Z' => 35,
    );

    /**
     * Convert all letters to their numeric values
     *
     * @param string    IBAN
     *
     * @return iban
     * @access  protected
     *
     * @author Thorsten Schmidt
     * @date 08.03.2011
     * @version 1.0
     * @since 1.0
     */
    protected function _convert_to_numeric($iban)
    {
        return str_replace(
            array_keys($this->convert),
            array_values($this->convert),
            $iban
        );
    }

    /**
     * Prepare IBAN to be used in calculation
     *
     * @param string    IBAN
     *
     * @return IBAN
     * @access  protected
     *
     * @author Thorsten Schmidt
     * @date 08.03.2011
     * @version 1.0
     * @since 1.0
     */
    protected function _prepare_iban($iban)
    {
        // Remove "IBAN" from string, if given, and all whitespaces
        $iban = str_ireplace('IBAN', '', $iban);
        $iban = str_replace(' ', '', $iban);

        // Set country code to end of iban
        $country_code = substr($iban, 0, 4);
        $iban = substr($iban, 4) . $country_code;

        // convert letters to digits
        $iban = $this->_convert_to_numeric($iban);

        return $iban;
    }

    /**
     * Divide IBAN by 97
     *
     * @param string    Numeric IBAN
     *
     * @return int  remainder of division
     * @access  protected
     *
     * @author Thorsten Schmidt
     * @date 08.03.2011
     * @version 1.0
     * @since 1.0
     */
    protected function _divide_by_97_helper($numeric_iban)
    {
        return (int) bcmod($numeric_iban, 97);
    }

    /**
     * Validate an IBAN
     *
     * @param string    IBAN to check
     *
     * @return boolean true/false
     * @access  public
     *
     * @author Thorsten Schmidt
     * @date 08.03.2011
     * @version 1.0
     * @since 1.0
     */
    public function validate($iban)
    {
        $iban = $this->_prepare_iban($iban);

        $division_remainder = $this->_divide_by_97_helper($iban);

        if ( $division_remainder !== 1 )
        {
            return false;
        }

        return true;
    }
}