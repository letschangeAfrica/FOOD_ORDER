<?php
    include('../config/constants.php');
    //Destroy the system
    session_destroy(); 

    //redirect to login page
    header('Location:' . SITEURL . 'admin/login.php');

?>