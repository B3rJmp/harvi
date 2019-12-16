<?php

require_once('../../private/initialize.php');

require_login();
// require_manager();

$item_set = find_all_items();
// $item_count = mysqli_num_rows($item_set) + 1;
$locations = find_all_locations();
$people = find_all_admins();
mysqli_free_result($item_set);
if(isset($_GET['location'])) {
  $location = $_GET['location'];
}

if(is_post_request()) {

  $item = [];
  $item['location'] = $_POST['location'] ?? 68;
  $item['work_order'] = strtoupper($_POST['work_order']) ?? NULL;
  $item['description'] = $_POST['description'] ?? '';
  $item['quantity'] = $_POST['quantity'] ?? 1;
  $item['owner_id'] = $_POST['owner_id'] ?? 0;
  $item['date_added'] = $_POST['date_added'] ?? date("Y-m-d");

  $result = insert_item($item);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The item was created successfully.';
    redirect_to(url_for('/staff/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $item = [];
  $item["location"] = $location ?? '';
  $item["work_order"] = '';
  $item["description"] = '';
  $item["owner_id"] = '';
  $item["date_added"] = '';
}

?>

<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <!-- <a class="back-link" href="<?php echo url_for('/staff/index.php'); ?>">&laquo; Back to List</a> -->
  <a class="back-link" href="<?= url_for('/staff/locations/index.php') ?>">&laquo; Back</a>

  <div class="subject new">
    <h1>Add Item</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/new.php'); ?>" method="post">
      <dl>
        <dt>Location</dt></dt>
        <dd>
          <select name="location" id="">
            <option value=""></option>
            <?php foreach($locations as $location) { ?>
              <option value="<?= $location['location_id']; ?>" <?= $location['location_id'] == $item['location'] ? "selected" : ""; ?>><?= strtoupper($location['location_name']); ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Work Order</dt>
        <dd><input type="text" name="work_order" id=""></dd>
      </dl>
      <dl>
        <dt>Description</dt>
        <dd><input type="text" name="description" id=""></dd>
      </dl>
      <dl>
        <dt>Quantity</dt>
        <dd><input type="number" name="quantity" value="1"></dd>
      </dl>
      <dl>
      <dl>
        <dt>Owner</dt></dt>
        <dd>
          <select name="owner_id" id="">
            <option value="0"></option>
            <?php foreach($people as $person) { ?>
              <option value="<?= $person['admin_id']; ?>"><?= $person['first_name'] . " " . $person['last_name']; ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Date Added</dt>
        <dd>
          <input type="date" name="date_added" value="<?= date("Y-m-d"); ?>" />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Add Item" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
