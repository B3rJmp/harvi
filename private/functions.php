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
  $url = $_SERVER['SCRIPT_NAME'];
  // echo $url;

  if(isset($_GET['region'])){
    $region = $_GET['region'];
  }else{
    $region = 'a';
  }

  $a = 'a';
  $page_link = "";
  for($i = 1; $i<=26; $i++) {
    if($i == $region) {
      $page_link .= "<span class=\"selected\">" . h(strtoupper($a)) . "</span>";
    }else{
      $page_link .= "<a href=\"{$url}?region=" . h(u($a)) . "\">" . h(strtoupper($a)) . "</a>";
    }
    $a++;
  }

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

function location_img($id) {
  $name = 'aa1';

  if($id >= 1 && $id <= 2) {
    echo url_for('/images/layout-aa.png');
  }elseif($id >= 3 && $id <= 4) {
    echo url_for('/images/layout-b.png');
  }elseif($id >= 5 && $id <= 8) {
    echo url_for('/images/layout-c.png');
  }elseif($id >= 9 && $id <= 11) {
    echo url_for('/images/layout-d.png');
  }elseif($id >= 12 && $id <= 14) {
    echo url_for('/images/layout-e.png');
  }elseif($id >= 15 && $id <= 17) {
    echo url_for('/images/layout-f.png');
  }elseif($id >= 18 && $id <= 19) {
    echo url_for('/images/layout-g.png');
  }elseif($id >= 20 && $id <= 21) {
    echo url_for('/images/layout-h.png');
  }elseif($id >= 22 && $id <= 23) {
    echo url_for('/images/layout-i.png');
  }elseif($id >= 24 && $id <= 26) {
    echo url_for('/images/layout-j.png');
  }elseif($id >= 27 && $id <= 29) {
    echo url_for('/images/layout-k.png');
  }elseif($id >= 30 && $id <= 32) {
    echo url_for('/images/layout-l.png');
  }elseif($id >= 33 && $id <= 35) {
    echo url_for('/images/layout-m.png');
  }elseif($id >= 36 && $id <= 38) {
    echo url_for('/images/layout-n.png');
  }elseif($id >= 39 && $id <= 42) {
    echo url_for('/images/layout-o.png');
  }elseif($id >= 43 && $id <= 46) {
    echo url_for('/images/layout-p.png');
  }elseif($id >= 47 && $id <= 50) {
    echo url_for('/images/layout-q.png');
  }elseif($id >= 51 && $id <= 54) {
    echo url_for('/images/layout-r.png');
  }elseif($id >= 55 && $id <= 56) {
    echo url_for('/images/layout-s.png');
  }elseif($id >= 57 && $id <= 58) {
    echo url_for('/images/layout-t.png');
  }elseif($id >= 59 && $id <= 60) {
    echo url_for('/images/layout-u.png');
  }elseif($id >= 61 && $id <= 62) {
    echo url_for('/images/layout-v.png');
  }elseif($id >= 63 && $id <= 65) {
    echo url_for('/images/layout-w.png');
  }elseif($id >= 66 && $id <= 68) {
    echo url_for('/images/layout-x.png');
  }elseif($id >= 69 && $id <= 72) {
    echo url_for('/images/layout-y.png');
  }elseif($id >= 73 && $id <= 76) {
    echo url_for('/images/layout-z.png');
  }elseif($id >= 77 && $id <= 80) {
    echo url_for('/images/layout-aa.png');
  }elseif($id >= 81 && $id <= 84) {
    echo url_for('/images/layout-ab.png');
  }elseif($id == 85) {
    echo url_for('/images/layout-nfloor.png');
  }elseif($id == 86) {
    echo url_for('/images/layout-cfloor.png');
  }elseif($id == 87) {
    echo url_for('/images/layout-sfloor.png');
  }else{
    echo "";
  }
}


?>
