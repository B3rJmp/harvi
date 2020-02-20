<?php

  function list_all_admins($limit){
    global $db;
    $page = $_GET['page'] ?? 1;
    $offset = $limit * ($page - 1);

    $sql = "SELECT * FROM people ";
    $sql .= "JOIN ";
    $sql .= "view_type on people.type = view_type.type_id ";
    $sql .= "where admin_id > 1 ";
    $sql .= "ORDER BY type_id asc ";
    $sql .= "limit " . $limit . " offset " . $offset ;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_all_admins(){
    global $db;

    $sql = "SELECT * FROM people ";
    $sql .= "JOIN ";
    $sql .= "view_type on people.type = view_type.type_id ";
    $sql .= "where admin_id >= 1 ";
    $sql .= "ORDER BY type desc, last_name asc ";
    // $sql .= "limit " .  . " offset " .  ;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_all_types() {
    global $db;

    $sql = "select * from view_type ";
    $data = mysqli_query($db, $sql);
    confirm_result_set($data);
    // $result = mysqli_fetch_assoc($data);
    return $data;
  }

  function find_admin_by_id($id) {
    global $db;

    $sql = "SELECT * FROM people ";
    $sql .= "JOIN ";
    $sql .= "view_type on people.type = view_type.type_id ";
    $sql .= "WHERE admin_id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }

  function view_user_profile() {
    global $db;
    
    $sql = "SELECT * FROM people ";
    $sql .= "JOIN ";
    $sql .= "view_type on people.type = view_type.type_id ";
    $sql .= "where admin_id = " . $_SESSION['admin_id'] . " ";
    $sql .= "limit 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $user = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $user;
  }

  function find_admin_by_username($username) {
    global $db;

    $sql = "SELECT * FROM people ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }

  function validate_admin($admin, $options=[]) {

    $password_required = $options['password_required'] ?? true;
    if(is_blank($admin['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], array('max' => 255))) {
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], array('min' => 5, 'max' => 20))) {
      $errors[] = "Username must be between 5 and 20 characters.";
    } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
      $errors[] = "Username has already been taken.";
    }
    if($password_required){
      if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($admin['password'], array('min' => 8))) {
        $errors[] = "Password must contain 8 or more characters";
      } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }
    

      if(is_blank($admin['password_confirm'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['password'] !== $admin['password_confirm']) {
        $errors[] = "Password and confirm password must match.";
      }
    }

    return $errors;
  }

  // * when creating a new user, that user is sent an email with their credentials
  // * only usable when email capabilities have been restored
  function email_new_user($admin, $insert = false, $temp_pass) {
    if($admin['type'] == 1) {
      $type = 'an Admin';
      $type_msg = "As an Admin, you will have permission to manage other users, as well as manage the warehouse on behalf of managers and engineers.";
    }elseif($admin['type'] == 2) {
      $type = 'a Manager';
      $type_msg = "As a Manager, you will be responsible to help manage the warehouse on behalf of engineers, as well as assign items in the warehouse to particular owners, and edit information on those items.";
    }else{
      $type = 'an Engineer';
      $type_msg = "You can now access Harvi to view items in the warehouse. You are responsible for everything you add and remove from the warehouse. If you need to add or remove something from the warehouse that does not belong to you, please contact one of the lab technicians.";
    }
    $to = $admin['email'];
    $subject = "Welcome to Harvi";
    $message = "You've been added to Harvi by " . h($_SESSION['name']) . " as " . h($type) . ".\r\n";
    $message .= $type_msg . "\r\n";
    if($insert == true) {
      $message .= "Your username will be " . $admin['username'] . ".\r\n";
      $message .= "Your temporary password has been set to " . h($temp_pass) . ". For security reasons, we suggest you change this as soon as you log in for the first time.\r\n";
    }else{
      
    }
    $headers = "From: manager.harvi@gmail.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $mail = mail($to, $subject, $message, $headers);
    if($mail) {
      // $_SESSION['message'] = "Email Successfully Sent";
      return true;
    }else{
      // $_SESSION['message'] = "Something went wrong when sending the email";
      return false;
    }
  }

  function insert_admin($admin){
    global $db;

    $errors = validate_admin($admin);
    if(!empty($errors)) {
      return $errors;
    }
    // * disabled random password generator
    // * uncomment when email capabilities are restored
    // $rand_pass = substr(str_shuffle(MD5(microtime())), 0, 15);
    // $hashed_password = password_hash($rand_pass, PASSWORD_BCRYPT);
    $hashed_password = password_hash(DEFAULT_PASS, PASSWORD_BCRYPT);

    $sql = "INSERT INTO people ";
    $sql .= "(first_name, last_name, type, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['permission']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      // * disable new user notification
      // * uncomment when email capabilities are restored
      // email_new_user($admin, true, $rand_pass);
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_admin($admin){
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if(!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE people SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    $sql .= "type='" . db_escape($db, $admin['permission']) . "', ";
    if($password_sent){
      $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE admin_id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
    unset($_SESSION['super_admin']);
  }

  // * when deleting a user, any items they may have had will be placed under undefined ownership
  function change_owner($id) {
    global $db;

    $sql = "update content set owner_id = 0 ";
    $sql .= "where owner_id = " . db_escape($db, $id);
    $result = mysqli_query($db, $sql);

    if($result) {
      return true;
    }else{
      return false;
    }
  }

  function delete_admin($id){
    global $db;

    change_owner($id);

    $sql = "DELETE FROM people ";
    $sql .= "WHERE admin_id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function list_all_items($limit = 10){
    global $db;
    $page = $_GET['page'] ?? 1;
    $offset = $limit * ($page - 1);

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "order by location asc, work_order desc, owner_id desc ";
    $sql .= "limit " . $limit . " offset " . $offset;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function search_items($input){
    global $db;
    // $page = $_GET['page'] ?? 1;
    // $offset = $limit * ($page - 1);

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "where description like '%" . db_escape($db, $input) . "%' ";
    $sql .= "or work_order like '%" . db_escape($db, $input) . "%' ";
    $sql .= "or concat_ws(\" \", first_name, last_name) like '%" . db_escape($db, $input) . "%' ";
    $sql .= "order by location asc, work_order desc, owner_id desc ";
    // $sql .= "limit " . $limit . " offset " . $offset;
    // echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_all_items(){
    global $db;

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "order by location asc, work_order desc, id asc ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_my_items(){
    global $db;

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "where owner_id = " . $_SESSION['admin_id'] . " ";
    $sql .= "order by location_name asc ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  
  function find_item_by_id($id) {
    global $db;

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    // echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $item = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $item; // returns an assoc. array
  }

  function find_items_by_location($location) {
    global $db;

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "where location_id = " . $location . " ";
    $sql .= "order by location_id asc";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_items_by_owner($owner) {
    global $db;

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "where admin_id = " . $owner . " ";
    $sql .= "order by location_id asc";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function validate_item($item) {
    $errors = [];

    // location
    if(is_blank($item['location'])) {
      $errors[] = "Item must have a defined location";
    }else{
      // location = number?
      if(!is_numeric($item['location']) && !is_blank($item['location'])){
        $errors[] = "Something is wrong with the selected location";
      }
    }

    // description
    if(is_blank($item['description'])) {
      $errors[] = "Item must have a description";
    }

    // quantity
    if(is_blank($item['quantity'])) {
      $errors[] = "Item must have a quantity";
    }

    if($item['quantity'] <= 0) {
      $errors[] = "Item quantity must be at least 1";
    }

    // date added
    if(is_blank($item['date_added'])) {
      $errors[] = "Please specify the date this item was added";
    }
    if(strtotime($item['date_added']) > time()){
      $errors[] = "Date can not be in the future";
    }
    
    // owner_id = number?
    if($item['owner_id'] != NULL && !is_numeric($item['owner_id'])){
      $errors[] = "Something is wrong with the selected owner";
    }

    return $errors;
  }

  function insert_item($item) {
    global $db;

    $errors = validate_item($item);
    if(!empty($errors)) {
      return $errors;
    }

    // shift_page_positions(0, $item['position'], $item['subject_id']);

    $sql = "INSERT INTO content ";
    $sql .= "(location, work_order, description, quantity, owner_id, date_added) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $item['location']) . "', ";
    $sql .= is_empty($item['work_order']) . ", ";
    $sql .= "'" . db_escape($db, $item['description']) . "', ";
    $sql .= "'" . db_escape($db, $item['quantity']) . "', ";
    $sql .= db_escape($db, no_owner($item['owner_id'])) . ", ";
    $sql .= "'" . db_escape($db, $item['date_added']) . "'";
    $sql .= ")";
    // echo $sql;
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_item($item){
    global $db;

    // $password_sent = !is_blank($item['password']);

    $errors = validate_item($item);
    if(!empty($errors)) {
      return $errors;
    }

    // $hashed_password = password_hash($item['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE content SET ";
    $sql .= "location='" . db_escape($db, $item['location']) . "', ";
    $sql .= "work_order = " . is_empty($item['work_order']) . ", ";
    $sql .= "owner_id='" . db_escape($db, no_owner($item['owner_id'])) . "', ";
    $sql .= "description='" . db_escape($db, $item['description']) . "', ";
    $sql .= "quantity='" . db_escape($db, $item['quantity']) . "', ";
    $sql .= "date_added='" . db_escape($db, $item['date_added']) . "', ";
    $sql .= "audit_number=" . db_escape($db, $item['audit_number']) . " ";
    $sql .= "WHERE id='" . db_escape($db, $item['id']) . "' ";
    $sql .= "LIMIT 1";
    echo $sql;
    // var_dump($sql);

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function delete_item($id){
    global $db;

    $sql = "DELETE FROM content ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function list_all_locations($limit = 10) {
    global $db;
    $page = $_GET['page'] ?? 1;
    $offset = $limit * ($page - 1);

    $sql = "select * from locations ";
    // $sql .= "order by location_name ";
    $sql .= "limit " . $limit . " offset " . $offset;
    // $sql .= "join content on locations.location_id = content.location ";
    // $sql .= "group by location";
    $data = mysqli_query($db, $sql);
    confirm_result_set($data);
    // $result = mysqli_fetch_assoc($data);
    return $data;
  }

  function locations_by_alphabet($region = 'a') {
    global $db;

    $sql = "select * from locations ";
    $sql .= "where location_name like '" . strtolower($region) . "_' ";
    $sql .= "order by location_name ";
    // $sql .= "join content on locations.location_id = content.location ";
    // $sql .= "group by location";
    $data = mysqli_query($db, $sql);
    confirm_result_set($data);
    // $result = mysqli_fetch_assoc($data);
    return $data;
  }

  function find_all_locations() {
    global $db;
    // $page = $_GET['page'] ?? 1;
    // $offset = $limit * ($page - 1);

    $sql = "select * from locations ";
    // $sql .= "order by location_name ";
    // $sql .= "limit " . $limit . " offset " . $offset;
    // $sql .= "join content on locations.location_id = content.location ";
    // $sql .= "group by location";
    $data = mysqli_query($db, $sql);
    confirm_result_set($data);
    // $result = mysqli_fetch_assoc($data);
    return $data;
  }

  function find_location_by_id($id) {
    global $db;

    $sql = "SELECT * FROM locations ";
    $sql .= "WHERE location_id=" . db_escape($db, $id) . " ";
    $sql .= "LIMIT 1";
    // echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $location = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $location; // returns an assoc. array
  }

  function validate_location($location) {
    $errors = [];

    // Name
    if(isset($location['name'])){
      if(is_blank($location['name'])) {
        $errors[] = "Location must have a name";
      }
    }

    // Pallet
    if(!isset($location['pallet']) || $location['pallet'] == '') {
      $location['pallet'] = false;
    }else{
      $location['pallet'] = true;
    }

    return $errors;
  }

  function update_location($location){
    global $db;

    // $password_sent = !is_blank($location['password']);

    $errors = validate_location($location);
    if(!empty($errors)) {
      return $errors;
    }

    // $hashed_password = password_hash($location['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE locations SET ";
    $sql .= "pallet= " . no_pallet($location['pallet']) . " ";
    $sql .= "WHERE location_id='" . db_escape($db, $location['id']) . "' ";
    $sql .= "LIMIT 1";
    // var_dump($sql);

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function insert_location($location){
    global $db;

    // $password_sent = !is_blank($location['password']);

    $errors = validate_location($location);
    if(!empty($errors)) {
      return $errors;
    }

    // $hashed_password = password_hash($location['password'], PASSWORD_BCRYPT);

    $sql = "insert into locations (location_name, pallet) ";
    $sql .= "values ";
    $sql .= "('" . strtolower($location['name']) . "', " . $location['pallet'] . ") ";
    // echo $sql;
    // var_dump($sql);

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function find_expired_items() {
    global $db;

    $sql = "select * from content ";
    $sql .= "JOIN ";
    $sql .= "people on content.owner_id = people.admin_id ";
    $sql .= "JOIN ";
    $sql .= "locations on content.location = locations.location_id ";
    $sql .= "where owner_id != 1 and date_added <= now()-interval 3 month ";
    $sql .= "order by location_name asc ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function audit_owners($interval){
    global $db;

    $sql = "select * from people ";
    $sql .= "where admin_id in ";
    $sql .= "(select owner_id from content ";
    $sql .= "where date_added <= now()-interval " . $interval . " month) ";
    $sql .= "and admin_id != 1 ";
    // $sql .= "group by owner_id ";
    $result = mysqli_query($db, $sql);
    // $row = mysqli_fetch_row($result);
    return $result;
  }

  function audit_items($owner_id, $interval){
    global $db;

    $sql = "select * from content ";
    $sql .= "join locations on content.location = locations.location_id ";
    $sql .= "where owner_id = " . $owner_id . " ";
    $sql .= "and date_added <= now()-interval " . $interval . " month ";
    $result = mysqli_query($db, $sql);
    return $result;
  }

  function expired_notifications() {
    global $db;

    $sql = "select count(*) from content ";
    $sql .= "where owner_id = " . $_SESSION['admin_id'] . " ";
    $sql .= "and date_added <= now()-interval 3 month ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);
    $count = $row[0];
    if(isset($count) && $count > 0 && $count != '') {
      $_SESSION['message'] = "You currently have " . $count . " expired items. Please review your items.";
    }else{
      return false;
    }
  }

  function count_audit(){
    global $db;

    $sql = "select count(*) from content ";
    $sql .= "where owner_id != 1 and date_added <= now()-interval 3 month ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);
    $count = $row[0];
    return $count;
  }

  function last_audit() {
    global $db;

    $sql = "select date from audit_log ";
    $sql .= "order by id desc ";
    $sql .= "limit 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $last_audit = mysqli_fetch_row($result); // find first
    $date = $last_audit[0];
    mysqli_free_result($result);
    return $date;

  }

  function new_audit($date, $count){
    global $db;

    $sql = "insert into audit_log (date, items)";
    $sql .= "values ";
    $sql .= "('" . $date . "', " . $count . ")";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function audit_count_up($interval) {
    global $db;

    $sql = "update content ";
    $sql .= "set audit_number = (audit_number + 1) ";
    // $sql .= "set audit_number = 1 ";
    $sql .= "where owner_id != 1 ";
    $sql .= "and date_added <= now()-interval " . $interval . " month ";
    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

?>
