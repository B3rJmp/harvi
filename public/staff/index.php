<?php require_once('../../private/initialize.php'); ?>

<?php

  require_login();
  $region = $_GET['region'] ?? 'a';
  $locations = locations_by_alphabet($region);

?>

<?php $page_title = 'Warehouse'; ?>
<?php $class = 'locations'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="admin listing">
    <h1>Warehouse</h1>
    <div class="layout">
      <img src="<?php if(!isset($_GET['region'])){echo "/images/layout.png";}else{echo "/images/layout-" . $_GET['region'] . ".png";} ?>" alt="layout">
    </div>
    <h2>Browse Locations:</h2>
    <?php if(is_admin()){ ?>
      <!-- <div class="actions">
        <a class="action" href="<?php //echo url_for('/staff/locations/new.php'); ?>">Add Location</a>
      </div> -->
    <?php } ?>
    <div class="links">
      <div class="actions">
        <a class="action" href="<?php echo url_for('/staff/new.php'); ?>">Add Item</a>
        <a class="action" href="<?php echo url_for('/staff/my_items.php'); ?>">View My Items</a>
        <a class="action" href="<?php echo url_for('/staff/list_items.php'); ?>">View All Items</a>
      </div>
      <div class="search">
        <form action="<?php echo url_for('/staff/search.php'); ?>" method="post">
          <input type="search" name="search" id="search">
          <input type="submit" value="Search">  
        </form>
      </div>
    </div>
    <div class="table">
      <table class="locations-table list">
        <tr>
          <th>Location Name</th>
          <th>Pallet Present</th>
          <th>&nbsp;</th>
          <?php if(is_manager()) { ?>
            <th>&nbsp;</th>
            <?php if(is_admin()) { ?>
              <th>&nbsp;</th>
            <?php } ?>
          <?php } ?>
        </tr>

        <?php while($location = mysqli_fetch_assoc($locations)) { ?>
          <tr>
            <td><?php echo h(strtoupper($location['location_name'])); ?></td>
            <td><?php echo $location['pallet'] ? "Yes" : "No"; ?></td>
            <td><a class="action" href="<?php echo url_for('/staff/locations/show.php?id=' . h(u($location['location_id']))); ?>">View</a></td>
            <?php if(is_manager()) { ?>
              <td><a class="action" href="<?php echo url_for('/staff/locations/edit.php?id=' . h(u($location['location_id']))); ?>">Edit</a></td>
              <?php if(is_admin()){ ?>
                <td><a class="action" href="<?php echo url_for('/staff/locations/delete.php?id=' . h(u($location['location_id']))); ?>">Delete</a></td>
              <?php } ?>
            <?php } ?>
          </tr>
        <?php } ?>
      </table>
      <?php location_pagination(); ?>
    </div>

    <?php
      mysqli_free_result($locations);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
