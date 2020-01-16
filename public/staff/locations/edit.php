<?php

require_once('../../../private/initialize.php');

require_login();
require_manager();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/locations/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $location = [];
  $location['id'] = $id;
  if(!isset($_POST['pallet']) || $_POST['pallet'] = '' || $_POST['pallet'] == NULL) {
    $location['pallet'] = false;
  }else{
    $location['pallet'] = true;
  }

  $result = update_location($location);
  if($result === true) {
    $_SESSION['message'] = 'The location was successfully edited.';
    redirect_to(url_for('/staff/locations/show.php?id=' . $id));
  } else {
    $errors = $result;
    //var_dump($errors);
  }

} else {

  $location = find_location_by_id($id);
  $permissions = find_all_types();

}

// $admin_set = find_all_admins();
// $admin_count = mysqli_num_rows($admin_set);
// mysqli_free_result($admin_set);

?>

<?php $page_title = 'Edit Location'; ?>
<?php $class = 'locations'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin edit">
    <h1>Edit: <?= strtoupper(h($location['location_name'])); ?></h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/locations/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Pallet?</dt>
        <dd><input type="checkbox" name="pallet" value="<?php echo h($location['pallet']); ?>" <?= ($location['pallet'] ? "checked" : ""); ?> /></dd>
      </dl>
      <dl>
      <div id="operations">
        <input type="submit" value="Edit Location" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
