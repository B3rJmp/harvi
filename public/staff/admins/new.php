<?php

require_once('../../../private/initialize.php');

require_login();
require_admin();

$admin_set = find_all_admins();
$permissions = find_all_types();
$admin_count = mysqli_num_rows($admin_set) + 1;
mysqli_free_result($admin_set);

if(is_post_request()) {

  $admin = [];
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['permission'] = $_POST['permission']==NULL || $_POST['permission']=="" ? 3 : $_POST['permission'];
  $admin['username'] = $_POST['username'] ?? '';
  $admin['password'] = DEFAULT_PASS;
  $admin['password_confirm'] = DEFAULT_PASS;

  $result = insert_admin($admin);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The user was created successfully.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  $admin = [];
  $admin['first_name'] = '';
  $admin['last_name'] = '';
  $admin['email'] = '';
  $admin['username'] = '';
  // $admin['password'] = '';
  // $admin['password_confirm'] = '';
}

?>

<?php $page_title = 'Create User'; ?>
<?php $class = 'admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin new">
    <h1>Create User</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/admins/new.php'); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name"/></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name"/></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username"/></dd>
      </dl>
      <dl>
        <dt>Access permission</dt>
        <dd>
          <select name="permission">
            <option value=""></option>
            <?php foreach($permissions as $permission) { ?>
              <option value="<?= $permission['type_id']; ?>" <?php if($permission['type_id'] == 3) {echo "selected";} ?>><?= ucfirst($permission['viewer_type']); ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="email" name="email"/></dd>
      </dl>
      <dl>
        <dt>Password</dt>
        <dd>(Use Default Password)</dd>
      </dl>
      <!-- <dl>
        <dt>Confirm Password</dt>
        <dd><input type="password" name="password_confirm"  /></dd>
      </dl> -->
      <div id="operations">
        <input type="submit" value="Create Admin" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
