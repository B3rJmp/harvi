<?php

  // Performs all actions necessary to log in an admin
  function log_in_admin($admin) {
  // Renerating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['name'] = $admin['first_name'] . " " . $admin['last_name'];
    $_SESSION['type'] = $admin['type'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['username'];
    return true;
  }

  // Performs all actions necessary to log out an admin
  function log_out_admin() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['name']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);
    unset($_SESSION['type']);
    // session_destroy(); // optional: destroys the whole session
    return true;
  }


  // is_logged_in() contains all the logic for determining if a
  // request should be considered a "logged in" request or not.
  // It is the core of require_login() but it can also be called
  // on its own in other contexts (e.g. display one link if an admin
  // is logged in and display another link if they are not)
  function is_logged_in() {
    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
    return isset($_SESSION['admin_id']);
  }

  function get_viewer_type() {
    return $_SESSION['type'];
  }

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function require_login() {
    if(!is_logged_in()) {
      redirect_to(url_for('/staff/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }

  function require_admin() {
    $type = get_viewer_type();
    if($type != 1){
      redirect_to(url_for('/staff/error.php'));
      return false;
      die();
    }else{
      return true;
    }
  }

  function require_manager() {
    $type = get_viewer_type();
    if($type == 1 || $type == 2) {
      return true;
    }else{
      redirect_to(url_for('/staff/error.php'));
      return false;
      die();
    }
  }

  function is_admin() {
    $type = get_viewer_type();
    if($type != 1){
      return false;
    }else{
      return true;
    }
  }

  function is_manager() {
    $type = get_viewer_type();
    if($type == 1 || $type == 2) {
      return true;
    }else{
      return false;
    }
  }

  function is_user($id) {
    if(is_manager() || get_viewer_type() == $id) {
      return true;
    }else{
      return false;
    }
  }

?>
