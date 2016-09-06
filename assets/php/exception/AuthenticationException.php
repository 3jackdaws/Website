<?php

/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 9/5/2016
 * Time: 6:53 PM
 */
class AuthenticationException extends Exception
{
    public $account = null;
    public function __construct($message, Account $account)
    {
        parent::__construct($message);
        $this->account = $account;
    }
}