<?php require_once('../../../private/initialize.php'); ?>

<?php

  require_login();
  require_manager();

  $limit = 15;
  $admin_set = list_all_admins($limit);

?>

<?php $page_title = 'Admins'; ?>
<?php $class = 'admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="admin listing">
    <h1>Users</h1>
    <?php if(is_admin()){ ?>
      <div class="actions">
        <a class="action" href="<?php echo url_for('/staff/admins/new.php'); ?>">Create New User</a>
      </div>
    <?php } ?>

  	<div class="table">
  	  <table class="admins-table list">
    	  <tr>
          <!-- <th>ID</th> -->
          <th>Permissions</th>
          <th>Name</th>
    	    <th>Email</th>
    	    <th>Username</th>
    	    <th>&nbsp;</th>
          <?php if(is_admin()) { ?>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
          <?php } ?>
    	  </tr>
  
        <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
          <tr>
            <!-- <td><?php //echo h($admin['admin_id']); ?></td> -->
            <td><?php echo h(ucfirst($admin['viewer_type'])); ?></td>
            <td><?php echo h($admin['first_name']) . " " . h($admin['last_name']); ?></td>
      	    <td><?php echo h($admin['email']); ?></td>
            <td><?php echo h($admin['username']); ?></td>
            <td><a class="action" href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($admin['admin_id']))); ?>">View</a></td>
            <?php if(is_admin()) { ?>
              <td><a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($admin['admin_id']))); ?>">Edit</a></td>
              <td><a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['admin_id']))); ?>">Delete</a></td>
            <?php } ?>
      	  </tr>
        <?php } ?>
    	</table>
      <?php admin_pagination($limit); ?>
  	</div>

    <?php
      mysqli_free_result($admin_set);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
