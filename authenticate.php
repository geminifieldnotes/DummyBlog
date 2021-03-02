 <?php

    /* Purpose: Script to authenticate user to gain access to other functionalities of the blog
     * Author: Mariah Garcia <mgarcia50@academic.rrc.ca>
     * Date: February 05, 2021
     */

    define('ADMIN_LOGIN', 'moon');
    define('ADMIN_PASSWORD', 'callisto11');

    if (
        !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
        || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
        || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)
    ) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="Our Blog"');
        exit("Access Denied: Username and password required.");
    }

    ?>
