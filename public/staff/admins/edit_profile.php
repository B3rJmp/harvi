<?php

require_once('../../../private/initialize.php');

require_login();

if(is_post_request()) {

  // Handle form values sent by new.php

  $admin = [];
  $admin['id'] = $_SESSION['admin_id'];
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['username'] = $_POST['username'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['password_confirm'] = $_POST['password_confirm'] ?? '';

  $result = update_admin($admin);
  if($result === true) {
    $_SESSION['message'] = 'The admin was successfully edited.';
    redirect_to(url_for('/staff/index.php'));
  } else {
    $errors = $result;
    //var_dump($errors);
  }

} else {

  $admin = view_user_profile();

}

// $admin_set = find_all_admins();
// $admin_count = mysqli_num_rows($admin_set);
// mysqli_free_result($admin_set);

?>

<?php $page_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/index.php'); ?>">&laquo; Back to Warehouse</a>

  <div class="admin edit">
    <h1>Edit Profile</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/admins/edit_profile.php'); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($admin['username']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="<?php echo h($admin['email']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Password</dt>
        <dd><input type="text" name="password" /></dd>
      </dl>
      <dl>
        <dt>Confirm Password</dt>
        <dd><input type="text" name="password_confirm" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Admin" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
