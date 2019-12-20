<?php

require_once('../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $item = [];
  $item['id'] = $id;
  $item['location'] = $_POST['location'] ?? 68;
  $item['work_order'] = strtoupper($_POST['work_order']) ?? NULL;
  $item['description'] = $_POST['description'] ?? '';
  $item['quantity'] = $_POST['quantity'] ?? 1;
  $item['owner_id'] = $_POST['owner_id'] ?? 0;
  $item['date_added'] = $_POST['date_added'] ?? date("Y-m-d");

  $result = update_item($item);

  if($result === true) {
    $_SESSION['message'] = 'The item was successfully edited.';
    redirect_to(url_for('/staff/show.php?id=' . $id));
  } else {
    $errors = $result;
    //var_dump($errors);
  }

} else {

  
  $item = find_item_by_id($id);
  // is_user($item);
  if(require_user($item)) {
    $locations = find_all_locations();
    $people = find_all_admins();
  }else{
    redirect_to(url_for('/staff/error.php'));
  }

}

// $item_set = find_all_items();
// $item_count = mysqli_num_rows($item_set);
// mysqli_free_result($item_set);

?>

<?php $page_title = 'Edit item'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <!-- <a class="back-link" href="<?php //echo url_for('/staff/my_items.php'); ?>">&laquo; Back to List</a> -->
  <a class="back-link" href="javascript:history.go(-1)">&laquo; Back</a>

  <div class="subject edit">
    <h1>Edit Item</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Location</dt></dt>
        <dd>
          <select name="location" id="">
            <option value="0"></option>
            <?php foreach($locations as $location) { ?>
              <option value="<?= $location['location_id']; ?>" <?= $location['location_id'] == $item['location'] ? "selected" : ""; ?>><?= strtoupper($location['location_name']); ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Work Order</dt>
        <dd><input type="text" name="work_order" id="" value="<?= $item['work_order'] ?? ""; ?>"></dd>
      </dl>
      <dl>
        <dt>Description</dt>
        <dd><input type="text" name="description" id="" value="<?= $item['description']; ?>"></dd>
      </dl>
      <dl>
        <dt>Quantity</dt>
        <dd><input type="number" name="quantity" id="" value="<?= $item['quantity']; ?>"></dd>
      </dl>
      <dl>
        <dt>Owner</dt></dt>
        <dd>
          <select name="owner_id" id="">
            <option value=""></option>
            <?php foreach($people as $person) { ?>
              <option value="<?= $person['admin_id']; ?>" <?= $person['admin_id'] == $item['owner_id'] ? "selected" : "" ?>><?= $person['first_name'] . " " . $person['last_name']; ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Date Added</dt>
        <dd>
        <?php if(is_manager()) { ?>
          <input type="date" name="date_added" value="<?= $item['date_added'] ?? date("Y-m-d"); ?>" />
        <?php }else{ echo $item['date_added'];} ?>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Item" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
