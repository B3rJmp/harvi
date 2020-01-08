<?php 

  require_once('../../private/initialize.php');
  require_login();
  $items = find_my_items();
  $page_title = 'Staff Menu';
  include(SHARED_PATH . '/staff_header.php');

?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/index.php'); ?>">&laquo; Back to List</a>
  <div class="admin listing">
    <h1>My Items</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/new.php'); ?>">Add Item</a>
      <a class="action" href="<?php echo url_for('/staff/my_items.php'); ?>">View My Items</a>
      <a class="action" href="<?php echo url_for('/staff/locations/index.php'); ?>">View All Locations</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>Location</th>
        <th>Pallet</th>
        <th>Description</th>
        <!-- <th>Owner</th> -->
  	    <th>Date Added</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($item = mysqli_fetch_assoc($items)) { ?>
        <tr>
          <td><?php echo strtoupper(h($item['location_name'])); ?></td>
          <td><?php echo (h($item['pallet']) ? "Yes" : "No"); ?></td>
          <!-- <td><?php //if(!isset($item['work_order']) || $item['work_order'] == '') {echo $item['description'];}else{echo h($item['work_order']) . ", " . $item['description'];} ?></td> -->
          <td><?php if(isset($item['work_order'])){echo $item['work_order'] . ", ";}else{echo "";} echo $item['description']; ?></td>
          <!-- <td><?php //echo h($item['first_name']) . " " . h($item['last_name']); ?></td> -->
    	    <td><?php echo h(date('d-M-Y', strtotime($item['date_added']))); ?></td>
          <td><a class="action" href="<?php echo url_for('/staff/show.php?id=' . h(u($item['id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/edit.php?id=' . h(u($item['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/delete.php?id=' . h(u($item['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($items);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
