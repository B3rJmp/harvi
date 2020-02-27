<?php 

    require_once('../../../private/initialize.php');

    require_login();
    require_admin();
    if(!isset($_GET['id'])) {
        redirect_to(url_for('/staff/admins/index.php'));
    }
    $id = $_GET['id'];

    if(is_post_request()){
        $sql = "select * from people where admin_id = " . $_SESSION['admin_id'];
        $result = mysqli_query($db, $sql);
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        if($user['type'] != 1){
            echo "you are not an admin";
        }else{
            $password = $_POST['password'];
            if(password_verify($password, $user['hashed_password'])){
                $_SESSION['super_admin'] = 1;
                if(isset($_SESSION['verify_attempt'])) {
                  unset($_SESSION['verify_attempt']);
                }
                redirect_to(url_for('/staff/admins/edit.php?id=' . h(u($id))));
            }else{
                
                if(isset($_SESSION['verify_attempt']) && $_SESSION['verify_attempt'] >= 2) {
                  $_SESSION['message'] = "Too many attempts, please log in to try again.";
                  log_out_admin();
                  unset($_SESSION['verify_attempt']);
                  redirect_to(url_for('/staff/login.php'));
                }else{
                  $errors[] = "Verification Failed";
                  if(isset($_SESSION['verify_attempt'])) {
                    $_SESSION['verify_attempt']++;
                  }else{
                    $_SESSION['verify_attempt'] = 1;
                  }
                }
            }
        }
    }

?>

<?php $page_title = 'Unlock Super'; ?>
<?php $class = 'admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($id))); ?>">&laquo; Back to List</a>

  <div class="admin delete">
    <h1>Reset User Password</h1>

    <?php echo display_errors($errors); ?>

    <p>Verify Admin Password</p>

    <form action="<?php echo url_for('/staff/admins/super.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="password" name="password">
        <input type="submit" name="commit" value="Continue" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>