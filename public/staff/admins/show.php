<?php require_once('../../../private/initialize.php'); ?>
<?php require_login(); require_manager(); ?>
<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$admin = find_admin_by_id($id);
$items = find_items_by_owner($id);
// echo $_SERVER['REQUEST_URI'];

?>

<?php $page_title = 'Show Admin'; ?>
<?php $class = 'admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
<?php //if(is_post_request()) { ?>
  <a class="back-link" href="<?= url_for('/staff/admins/index.php') ?>">&laquo; Back</a>
<?php //}else{ ?>
  <!-- <a class="back-link" href="javascript:history.go(-1)">&laquo; Back</a> -->
<?php //} ?>

  <div class="admin show">

    <h1>User: <?php echo h($admin['first_name'] . " " . $admin['last_name']); ?></h1>

    <div class="attributes">
      <!-- <dl>
        <dt>First Name</dt>
        <dd><?php //echo h($admin['first_name']); ?></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><?php //echo h($admin['last_name']); ?></dd>
      </dl> -->
      <dl>
        <dt>Permissions</dt>
        <dd><?php echo h(ucfirst($admin['viewer_type'])); ?></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><a href="mailto:<?php echo h($admin['email']); ?>"><?php echo h($admin['email']); ?></a></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><?php echo h($admin['username']) ?></dd>
      </dl>
      <div class="admin listing">
        <h2>Items belonging to this user:</h2>

        <table class="admins-table list">
          <tr>
            <th>Description</th>
            <th>Location</th>
            <th>Pallet</th>
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
              <td><?php if(isset($item['work_order'])){echo $item['work_order'] . ", ";}else{echo "";} echo $item['description']; ?></td>
              <td><?php echo h(strtoupper($item['location_name'])); ?></td>
              <td><?php echo $item['pallet'] ? "Yes" : "No"; ?></td>
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
      <?php if(is_admin()) { ?>
        <a href="<?= url_for('/staff/admins/edit.php?id=' . h(u($admin['admin_id']))); ?>">Edit Admin</a>
      <?php } ?>
    </div>

  </div>

</div>
