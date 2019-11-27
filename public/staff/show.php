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
    <a class="back-link" href="<?= url_for('/staff/index.php'); ?>">&laquo; Back</a>
  <?php //}else{ ?>
    <!-- <a class="back-link" href="javascript:history.go(-1)">&laquo; Back</a> -->
  <?php //} ?>

  <div class="item show">

    <h1>Item: <?php if(isset($item['work_order'])) {echo h($item['work_order']) . ", " . $item['description'];}else{echo $item['description'];} ?></h1>

    <div class="attributes">
      <dl>
        <dt>Location</dt>
        <dd><?php echo h(strtoupper($item['location_name'])); ?></dd>
      </dl>
      <dl>
        <dt>Quantity</dt>
        <dd><?php echo h($item['quantity']); ?></dd>
      </dl>
      <dl>
        <dt>Owner</dt>
        <dd>
          <?php if(is_manager()) { ?>
            <a href="<?= url_for('/staff/admins/show.php?id=' . h(u($item['admin_id']))); ?>"><?= h($item['first_name']) . " " . h($item['last_name']); ?></a>
          <?php }else{ ?>
            <?= h($item['first_name']) . " " . h($item['last_name']); ?>
          <?php } ?>
        </dd>
      </dl>
      <dl>
        <dt>Owner Contact</dt>
        <dd><?php echo h($item['email']); ?></dd>
      </dl>
      <dl>
        <dt>Date Added</dt>
        <dd><?php if($item['date_added'] > date('today')) {echo "true";}else{echo "false";} ?></dd>
        <!-- <dd><?php //echo h($item['date_added']); ?></dd> -->
      </dl>
    </div>
    <?php page_links($table); ?>

  </div>

</div>
