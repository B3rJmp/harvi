<?php require_once('../../private/initialize.php'); ?>

<?php require_login(); ?>

<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0
// echo $_SERVER['SCRIPT_NAME'];

$item = find_item_by_id($id);
$table = "content";

// $page_set = find_pages_by_item_id($id);

?>

<?php $page_title = 'Show Item'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <?php //if(has_presence($msg)) { ?>
    <!-- <a class="back-link" href="<?php //echo url_for('/staff/locations/show.php?id=' . $item['location']); ?>">&laquo; Back</a> -->
  <?php //}else{ ?>
    <a class="back-link" href="javascript:history.go(-1)">&laquo; Back</a>
  <?php //} ?>

  <div class="bigdiv">

    <h1>Item: <?php if(isset($item['work_order'])) {echo h($item['work_order']) . ", " . $item['description'];}else{echo $item['description'];} ?></h1>

    <div class="itemShow">
      <div class="location">
        <!-- <h2>Location:</h2> -->
        <img src="<?= $item['img']; ?>" alt="Location">
        <?php if(isset($item['level_img'])) { ?>
          <img src="<?php echo $item['level_img']; ?>" alt="level">
        <?php } ?>
      </div>
      <div class="">
        <div class="">
          <table class="list">
            <tr>
              <th>Location</th>
              <th>Quantity</th>
              <th>Owner</th>
              <th>Owner Contact</th>
              <th>Date Added</th>
            </tr>
            <tr>
              <td><?php echo h(strtoupper($item['location_name'])); ?></td>
              <td><?php echo h($item['quantity']); ?></td>
              <td>
                <?php if(is_manager()) { ?>
                  <a href="<?= url_for('/staff/admins/show.php?id=' . h(u($item['admin_id']))); ?>"><?= h($item['first_name']) . " " . h($item['last_name']); ?></a>
                <?php }else{ ?>
                  <?= h($item['first_name']) . " " . h($item['last_name']); ?>
                <?php } ?>
              </td>
              <td><?php echo h($item['email']); ?></td>
              <td><?php echo h(date('d-M-Y', strtotime($item['date_added']))); ?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php //page_links($table); ?>
    <?php if(require_user($item)) { ?>
      <a href="<?= url_for('/staff/edit.php?id=' . h(u($item['id']))); ?>">Edit Item</a>
    <?php } ?>

  </div>

</div>
