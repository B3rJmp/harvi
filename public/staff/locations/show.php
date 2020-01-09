<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); ?>
<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$location = find_location_by_id($id);
$items = find_items_by_location($id);

?>

<?php $page_title = 'Show Location'; ?>
<?php $class = 'locations'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <?php //if(isset($msg) && $msg != '') { ?>
    <a class="back-link" href="<?= url_for('/staff/locations/index.php') ?>">&laquo; Back</a>
  <?php //}else{ ?>
    <!-- <a class="back-link" href="javascript:history.go(-1)">&laquo; Back</a> -->
  <?php //} ?>

  <div class="admin show">

    <h1>Location: <?php echo h(strtoupper($location['location_name'])); ?></h1>

    <div class="attributes">
      <div class="itemShow">
        <div>
          <dl>
            <dt>Pallet Present</dt>
            <dd><?php echo $location['pallet'] ? "Yes" : "No"; ?></dd>
          </dl>
        </div>
        <div class="location">
          <!-- <h2>Location:</h2> -->
          <img src="<?= $location['img']; ?>" alt="Location">
        </div>
      </div>
      <div class="admin listing">
        <h2>Items in this location:</h2>
        <div class="action_links">
          <?php if(is_manager()) { ?>
            <a href="<?= url_for('/staff/locations/edit.php?id=' . h(u($location['location_id']))); ?>">Edit Location</a>
            <a href="<?= url_for('/staff/new.php?location=' . h(u($location['location_id']))); ?>">Add Item to <?= strtoupper($location['location_name']); ?></a>
          <?php } ?>
          <?php page_links('locations'); ?>
        </div>

        <table class="locations-table list">
          <tr>
            <th>Description</th>
            <th>Quantity</th>
            <th>Owner</th>
            <th>Date Added</th>
            <th>&nbsp;</th>
            <?php if(is_manager()) { ?>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
            <?php } ?>
          </tr>

          <?php while($item = mysqli_fetch_assoc($items)) { ?>
            <tr class="<?php echo change_color($item['audit_number']); ?>">
              <!-- <td><?php //if(!isset($item['work_order']) || $item['work_order'] == '') {echo $item['description'];}else{echo h($item['work_order']) . ", " . $item['description'];} ?></td> -->
              <td><?php if(isset($item['work_order'])){echo h($item['work_order']) . ", ";}else{echo "";} echo h($item['description']); ?></td>
              <td><?php echo h($item['quantity']); ?></td>
              <td><?php echo h($item['first_name']) . " " . h($item['last_name']); ?></td>
              <td><?php echo h(date('d-M-Y', strtotime($item['date_added']))); ?></td>
              <td><a class="action" href="<?php echo url_for('/staff/show.php?id=' . h(u($item['id']))); ?>">View</a></td>
              <?php if(is_manager()) { ?>
                <td><a class="action" href="<?php echo url_for('/staff/edit.php?id=' . h(u($item['id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/delete.php?id=' . h(u($item['id']))); ?>">Delete</a></td>
              <?php } ?>
            </tr>
          <?php } ?>
        </table>

        <?php
          mysqli_free_result($items);
        ?>
  </div>
      
    </div>

  </div>

</div>
