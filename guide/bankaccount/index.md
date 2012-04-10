Kohana-Bankaccount
============

Kohana-Bankaccount is a module to validate (at this moment only German) bank accounts.

It uses BAV (http://bav.malkusch.de).


Installation
-----

Copy this module to your modules directory and initialize it in your bootstrap.php

bootstrap.php

	Kohana::modules(array(
        'kohana-bankaccount'           => MODPATH . 'kohana-bankaccount',
    ));


Configuration
-----

You need to specify a database configuration group that should be used by BAV's PDO Backend.

Usage
-----

    $bankaccount = Bankaccount::instance();
    $bankname = $bankaccount->get_bankname_by_bankcode(50070024);
    echo $bankname; // -> Deutsche Bank PGK Frankfurt
    
    $valid = $bankaccount->validate(50070024, 987654321);    
    var_dump($valid); // -> false