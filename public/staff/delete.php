<?php

require_once('../../private/initialize.php');

require_login();
// require_manager();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  $result = delete_item($id);
  $_SESSION['message'] = 'The subject was deleted.';
  redirect_to(url_for('/staff/locations/show.php?id=' . $_POST['location']));

} else {
  $item = find_item_by_id($id);
  if(!require_user($item)) {
    redirect_to(url_for('/staff/error.php'));
  }
}

?>

<?php $page_title = 'Delete Item'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Item</h1>
    <p>Are you sure you want to delete this item?</p>
    <p class="item"><?= isset($item['work_order']) ? h($item['work_order']) . ", " : ""; ?><?php echo h($item['description']); ?></p>

    <form action="<?php echo url_for('/staff/delete.php?id=' . h(u($item['id']))); ?>" method="post">
      <div id="operations">
        <input type="hidden" name="location" value="<?php echo $item['location']; ?>">
        <input type="submit" name="commit" value="Delete Item" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
