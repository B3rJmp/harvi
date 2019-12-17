<?php 

  require_once('../../private/initialize.php');
  require_login();
  get_viewer_type();
  $limit = 15;
  $items = list_all_items($limit);
  $page_title = 'Staff Menu';
  include(SHARED_PATH . '/staff_header.php');

?>

<div id="content">
  <div class="admin listing">
    <h1>Manage Warehouse</h1>

    <div class="links">
      <div class="actions">
        <a class="action" href="<?php echo url_for('/staff/new.php'); ?>">Add Item</a>
        <a class="action" href="<?php echo url_for('/staff/my_items.php'); ?>">View My Items</a>
        <a class="action" href="<?php echo url_for('/staff/locations/index.php'); ?>">View All Locations</a>
      </div>
      <div class="search">
        <form action="<?php echo url_for('/staff/search.php'); ?>" method="post">
          <input type="search" name="search" id="search">
          <input type="submit" value="Search">  
        </form>
      </div>
    </div>
    <div class="table">
      <table class="list">
        <tr>
          <th>Location</th>
          <th>Pallet</th>
          <th>Work Order</th>
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
          <tr>
            <td><?php echo strtoupper(h($item['location_name'])); ?></td>
            <td><?php echo (h($item['pallet']) ? "Yes" : "No"); ?></td>
            <!-- <td><?php //if(!isset($item['work_order']) || $item['work_order'] == '') {echo $item['description'];}else{echo h($item['work_order']) . ", " . $item['description'];} ?></td> -->
            <td><?php if(isset($item['work_order'])){echo $item['work_order'];}else{echo "-";} ?></td>
            <td style="text-align: left;"><?php echo $item['description']; ?></td>
            <td><?php echo h($item['quantity']); ?></td>
            <td><?php if(isset($item['owner_id'])) {echo h($item['first_name']) . " " . h($item['last_name']);}else{echo "(undefined)";} ?></td>
            <td><?php echo h(date('d-M-Y', strtotime($item['date_added']))); ?></td>
            <td><a class="action" href="<?php echo url_for('/staff/show.php?id=' . h(u($item['id']))); ?>">View</a></td>
            <?php if(is_manager()) { ?>
              <td><a class="action" href="<?php echo url_for('/staff/edit.php?id=' . h(u($item['id']))); ?>">Edit</a></td>
              <td><a class="action" href="<?php echo url_for('/staff/delete.php?id=' . h(u($item['id']))); ?>">Delete</a></td>
            <?php } ?>
          </tr>
        <?php } ?>
      </table>
      <?php pagination($limit); ?>
    </div>

    <?php
      mysqli_free_result($items);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
