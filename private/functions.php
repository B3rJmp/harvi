<?php

  function url_for($script_path) {
    // add the leading '/' if not present
    if($script_path[0] != '/') {
      $script_path = "/" . $script_path;
    }
    return $script_path;
  }

  function u($string="") {
    return urlencode($string);
  }

  function raw_u($string="") {
    return rawurlencode($string);
  }

  function h($string="") {
    return htmlspecialchars($string);
  }

  function error_404() {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
  }

  function error_500() {
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
  }

  function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }

  function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
      $output .= "<div class=\"errors\">";
      $output .= "Please fix the following errors:";
      $output .= "<ul>";
      foreach($errors as $error) {
        $output .= "<li>" . h($error) . "</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }

  function get_and_clear_session_message(){
    if(isset($_SESSION['message']) && $_SESSION != '') {
      $msg = $_SESSION['message'];
      unset($_SESSION['message']);
      return $msg;
    }
  }

  function display_session_message() {
    $msg = get_and_clear_session_message();
    if(!is_blank($msg)) {
      return '<div id="message">' . h($msg) . '</div>';
    }
  }

  function pagination($limit = 10, $table = 'content') {
    global $db;
    $url = $_SERVER['SCRIPT_NAME'];
    // echo $url;

    if(isset($_GET['page'])){
      $current_page = $_GET['page'];
    }else{
      $current_page = 1;
    }

    $sql = "select count(*) from " . $table . " ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $page_count = $row[0];
    $pages = ceil($page_count / $limit);
    $page_link = "";
    for($i = 1; $i<=$pages; $i++) {
      if($i == $current_page) {
        $page_link .= "<span class=\"selected\">{$i}</span>";
      }else{
        $page_link .= "<a href=\"{$url}?page={$i}\">{$i}</a>";
      }
    }
    $back_link = "";
    $next_link = "";
    if(($current_page - 1) > 0){
      $back_link .= "<a href=\"{$url}?page=" . ($current_page - 1) . "\">&laquo; Back</a>";
    }
    if(($current_page + 1) <= $pages) {
      $next_link .= "<a href=\"{$url}?page=" . ($current_page + 1) . "\">Next &raquo;</a>";
    }

    if($page_count > $limit) {
      echo $back_link;
      echo $page_link;
      echo $next_link;
    }
  }

  function admin_pagination($limit = 10) {
    global $db;
    $url = $_SERVER['SCRIPT_NAME'];
    // echo $url;

    if(isset($_GET['page'])){
      $current_page = $_GET['page'];
    }else{
      $current_page = 1;
    }

    $sql = "select count(*) from people where admin_id > 1 ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $page_count = $row[0];
    $pages = ceil($page_count / $limit);
    $page_link = "";
    for($i = 1; $i<=$pages; $i++) {
      if($i == $current_page) {
        $page_link .= "<span class=\"selected\">{$i}</span>";
      }else{
        $page_link .= "<a href=\"{$url}?page={$i}\">{$i}</a>";
      }
    }
    $back_link = "";
    $next_link = "";
    if(($current_page - 1) > 0){
      $back_link .= "<a href=\"{$url}?page=" . ($current_page - 1) . "\">&laquo; Back</a>";
    }
    if(($current_page + 1) <= $pages) {
      $next_link .= "<a href=\"{$url}?page=" . ($current_page + 1) . "\">Next &raquo;</a>";
    }

    if($page_count > $limit) {
      echo $back_link;
      echo $page_link;
      echo $next_link;
    }
  }

  function location_pagination() {
    global $db;
    $url = url_for('/staff/index.php');
    // echo $url;

    if(isset($_GET['region'])){
      $region = $_GET['region'];
    }else{
      $region = 'a';
    }

    $a = 'a';
    $page_link = "";
    for($i = 1; $i<=28; $i++) {
      if($i == $region) {
        $page_link .= "<span class=\"selected\">" . h(strtoupper($a)) . "</span>";
      }else{
        $page_link .= "<a href=\"{$url}?region=" . h(u($a)) . "\">" . h(strtoupper($a)) . "</a>";
      }
      $a++;
    }
    $page_link .= "<a href=\"" . url_for('/staff/locations/show.php') . "?id=88\">MEZANINE</a>";
    $page_link .= "<a href=\"" . url_for('/staff/locations/show.php') . "?id=89\">NFLOOR</a>";
    $page_link .= "<a href=\"" . url_for('/staff/locations/show.php') . "?id=90\">CFLOOR</a>";
    $page_link .= "<a href=\"" . url_for('/staff/locations/show.php') . "?id=91\">SFLOOR</a>";

    echo $page_link;
  }

  function page_links($table) {
    global $db;

    $id = $_GET['id'];
    $next = $id + 1;
    $back = $id - 1;
    
    $sql = "select count(*) from " . $table;
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $page_count = $row[0];
    // echo $page_count;

    $next_link = "<a href=\"" . $_SERVER['SCRIPT_NAME'] . "?id=" . $next . "\">Next &raquo;</a>";
    $back_link = "<a href=\"" . $_SERVER['SCRIPT_NAME'] . "?id=" . $back . "\">&laquo; Previous</a>";

    if(($id - 1) > 0){
      echo $back_link;
    }
    if(($id + 1) <= $page_count){
      echo $next_link;
    }
  }

  function change_color($audit_number) {
    
    if($audit_number == 1) {
      return "first_notice";
    }elseif($audit_number == 2) {
      return "second_notice";
    }elseif($audit_number >= 3) {
      return "final_notice";
    }else{
      return "";
    }

  }

  function save_last_region() {
    if(is_logged_in()){
      if(isset($_GET['region'])) {
        $region = $_GET['region'];
        setcookie('last_region', $region, time() + 900, "/");
      }else{
        if(isset($_COOKIE['last_region'])){
          $region = $_COOKIE['last_region'];
          setcookie('last_region', $region, time() + 900, "/");
        }else{
          setcookie('last_region', '', time(), "/");
        }
      }
    }
  }


?>
