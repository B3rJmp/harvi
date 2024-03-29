<?php

require_once('../../../private/initialize.php');

require_login();
require_admin();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $admin = [];
  $admin['id'] = $id;
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['permission'] = $_POST['permission']==NULL || $_POST['permission']=="" ? 3 : $_POST['permission'];
  $admin['email'] = $_POST['email'] ?? '';
  $admin['username'] = $_POST['username'] ?? '';
  if(isset($_SESSION['super_admin'])){
    $admin['password'] = DEFAULT_PASS;
    $admin['password_confirm'] = DEFAULT_PASS;
  }

  $result = update_admin($admin);
  if($result === true) {
    $_SESSION['message'] = 'The user was successfully edited.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $id));
  } else {
    $errors = $result;
    //var_dump($errors);
  }
  // unset($_SESSION['super_admin']);

} else {

  $admin = find_admin_by_id($id);
  $permissions = find_all_types();

}

$admin_set = find_all_admins();
$admin_count = mysqli_num_rows($admin_set);
mysqli_free_result($admin_set);

?>

<?php $page_title = 'Edit User'; ?>
<?php $class = 'admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin edit">
    <h1>Edit User</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Access permission</dt>
        <dd>
          <select name="permission">
            <option value=""></option>
            <?php foreach($permissions as $permission) { ?>
              <option value="<?= $permission['type_id']; ?>" <?php if($permission['type_id'] == $admin['type']) {echo "selected";} ?>><?= ucfirst($permission['viewer_type']); ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><input type="text" name="username" value="<?php echo h($admin['username']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><input type="text" name="email" value="<?php echo h($admin['email']); ?>" /></dd>
      </dl>
      <?php if(isset($_SESSION['super_admin'])) { ?>
        <dl>
          <dt>Password</dt>
          <dd>Set to "<?php echo DEFAULT_PASS; ?>". Click "Save Changes" to commit</dd>
        </dl>
      <?php }else{ ?>
        <?php if(is_admin()){ ?>
          <a href="<?php echo url_for('/staff/admins/super.php?id=' . h(u($id)));  ?>">Reset to Default Password</a>
        <?php } ?>
      <?php } ?>
      <div id="operations">
        <input type="submit" value="Save Changes" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
