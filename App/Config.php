<?php

namespace App;


/**
 * Application configuration
 *
 * 
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'eduflix';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'eduflix';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'kb5KaU32xlvqJngf';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;



    
    /**
     * Program name
     * @var string
     */
    const NAMEPROGRAM = 'Eduflix';

     /**
     * HOST name
     * @var string
     */
    const HOST = 'http://localhost/';

    /**
     * DIRECTORY name
     * @var string
     */
    const DIRECTORY = 'eduflix/public/';

    /**
     * Assets name
     * @var string
     */
    const ASSETS = Config::HOST.Config::DIRECTORY.'/assets/';
}
