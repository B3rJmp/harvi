<?php

require_once('../../../private/initialize.php');

require_login();
require_admin();

// if(!isset($_GET['id'])) {
//   redirect_to(url_for('/staff/admins/index.php'));
// }
// $id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $location = [];
  // $location['id'] = $id;
  if(!isset($_POST['pallet']) || $_POST['pallet'] = '' || $_POST['pallet'] == NULL) {
    $location['pallet'] = false;
  }else{
    $location['pallet'] = true;
  }
  $location['name'] = $_POST['name'];

  $result = insert_location($location);
  if($result === true) {
    $_SESSION['message'] = 'The location was successfully created.';
    redirect_to(url_for('/staff/locations/show.php?id=' . $id));
  } else {
    $errors = $result;
    //var_dump($errors);
  }

} else {

  // $location = find_location_by_id($id);
  // $permissions = find_all_types();

}

?>

<?php $page_title = 'Edit Location'; ?>
<?php $class = 'locations'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/locations/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin edit">
    <h1>Add Location</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/locations/new.php'); ?>" method="post">
      <dl>
        <dt>Location Name</dt>
        <dd><input type="text" name="name"/></dd>
      </dl>
      <dl>
      <dl>
        <dt>Pallet?</dt>
        <dd><input type="checkbox" name="pallet"/></dd>
      </dl>
      <dl>
      <div id="operations">
        <input type="submit" value="Create Location" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
