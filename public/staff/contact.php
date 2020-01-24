<?php 
    require_once('../../private/initialize.php');
    require_login();
    require_manager();

    // get email of user
    $sql = "select email from people where admin_id = " . db_escape($db, $_SESSION['admin_id']);
    $result = mysqli_query($db, $sql);
    $from_email = mysqli_fetch_assoc($result);
    $from = $from_email['email'];

    // get info of owner
    if(isset($_GET['owner']) && is_numeric($_GET['owner'])) {
        $sql = "select * from people where admin_id = " . db_escape($db, $_GET['owner']);
        $result = mysqli_query($db, $sql);
        $owner = mysqli_fetch_assoc($result);
    }

    // get info for item
    if(isset($_GET['item']) && is_numeric($_GET['item'])) {
        $sql = "select * from content where id = " . db_escape($db, $_GET['item']);
        $result = mysqli_query($db, $sql);
        $item = mysqli_fetch_assoc($result);
    }

    if(is_post_request()){
        $to = (string) $_POST['owner'];
        $subject = (string) $_POST['subject'];
        $message = (string) $_POST['message'];
        $headers = "From: " . h($from) . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // if(!$to || !$subject || !$message) {
        //   $errors[] = "Please fill out all fields";
        // }

        if(preg_match("/[\r\n]/", $to) || preg_match("/[\r\n]/", $from) || preg_match("/[\r\n]/", $subject)) {
          die();
        }

        if(is_blank($to)) {
          $errors[] = "Please enter a recipient.";
        }elseif(!has_valid_email_format($to)) {
          $errors[] = "Recipient must have a valid email";
        }

        if(is_blank($subject)) {
          $errors[] = "Please include a subject.";
        }

        if(is_blank($message)) {
          $errors[] = "Please type a message.";
        }

        if(!has_valid_email_format($from)) {
          $errors[] = "Something went wrong with your email, please review and try again.";
        }

        if(!empty($errors)) {

        }else{
          $mail = mail($to, $subject, $message, $headers);
          if($mail === true) {
            $_SESSION['message'] = "Email Successfully Sent";
            redirect_to(url_for('/staff/index.php'));
          }else{
            $_SESSION['message'] = "Something went wrong";
          }
        }

    }

?>

<?php $page_title = 'Contact'; ?>
<?php $class = 'admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <!-- <a class="back-link" href="<?php echo url_for('/staff/index.php'); ?>">&laquo; Back to List</a> -->
  <a class="back-link" href="<?= url_for('/staff/index.php') ?>">&laquo; Back</a>

  <div class="subject new">
    <h1>Contact<?php if(isset($_GET['owner'])){echo " " . h($owner['first_name']) . " " . h($owner['last_name']);}else{echo "";} ?></h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/contact.php'); ?>" method="post">
      <dl>
        <dt>Owner Email</dt>
        <dd>
          <input type="email" name="owner" value="<?php echo isset($_GET['owner']) ? h($owner['email']) : ""; ?>">
        </dd>
      </dl>
      <dl>
        <dt>Subject</dt>
        <dd><input type="text" name="subject" value="<?php echo isset($_GET['item']) ? h($item['description']) : ""; ?>"></dd>
      </dl>
      <dl>
        <dt>Message</dt>
        <dd><textarea name="message" id="" cols="30" rows="10"></textarea></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Send" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>