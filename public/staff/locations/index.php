<?php require_once('../../../private/initialize.php'); ?>

<?php

  require_login();
  // require_manager();
  $limit = 15;
  $table = "locations";
  $region = $_GET['region'] ?? 'A';

  // $locations = list_all_locations($limit);
  $locations = list_all_locations($limit);

?>

<?php $page_title = 'Locations'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="admin listing">
    <h1>Locations</h1>
    <h2>Region: <?= strtoupper($region); ?></h2>
    <?php if(is_admin()){ ?>
      <div class="actions">
        <a class="action" href="<?php echo url_for('/staff/locations/new.php'); ?>">Add Location</a>
      </div>
    <?php } ?>
    <div class="table">
      <table class="list">
        <tr>
          <!-- <th>ID</th> -->
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
            <!-- <td><?php //echo h($admin['admin_id']); ?></td> -->
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
      <?php pagination($limit, $table); ?>
    </div>

    <?php
      mysqli_free_result($locations);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
