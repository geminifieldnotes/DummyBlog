<?php

    /* Purpose: Script to connect to database
     * Author: Mariah Garcia <mgarcia50@academic.rrc.ca>
     * Date: February 05, 2021
     */

    define('DB_DSN', 'mysql:host=localhost;dbname=serverside');
    define('DB_USER', 'serveruser');
    define('DB_PASS', 'gorgonzola7!');

    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
