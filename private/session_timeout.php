<?php 

    // check last activity
    // if inactive for more than 15 minutes, log out admin
    if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
        $_SESSION['message'] = "Your session timed out, please log back in.";
        log_out_admin();
    }
    // record last activity
    $_SESSION['LAST_ACTIVITY'] = time();

?>