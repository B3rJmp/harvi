<?php
  if(!isset($page_title)) { $page_title = 'Staff Area'; }
  if(is_logged_in()){
    $type = get_viewer_type();
  }else{

  }
?>

<!doctype html>

<html lang="en">
  <head>
    <title>Harvi - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <!-- <meta http-equiv="refresh" content="3"> -->
    <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>" />
  </head>

  <body>
    <header class="<?php echo $class ?? 'home'; ?>">
      <h1>Harvi</h1>
    </header>
    <?php if(is_logged_in()) { ?>
      <navigation>
        <ul>
          <li>User: <?php echo h($_SESSION['name'] ?? ''); ?></li>
          <li><a href="<?php echo url_for('/staff/index.php'); ?>">Warehouse</a></li>
          <li><a href="<?php echo url_for('/staff/admins/edit_profile.php'); ?>">Edit Profile</a></li>
          <?php if($type == 1) { ?>
            <li><a href="<?php echo url_for('/staff/admins/index.php'); ?>">Manage Users</a></li>
          <?php }elseif($type == 2) { ?>
            <li><a href="<?php echo url_for('/staff/admins/index.php'); ?>">View Users</a></li>
          <?php } ?>
          <li><a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
        </ul>
      </navigation>
    <?php } ?>

    <?php echo display_session_message(); ?>
