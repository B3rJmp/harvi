<?php 
    // require_once('../../private/initialize.php');
    
    // The idea of this script is to automate the warehouse audit
    // script will gather information on all items in the warehouse that have been there for longer than a specified time
    // once all information is gathered, the script will separate items by owner
    // script will then send a single email to each owner, containing all the expired items belonging to that owner
    // script will also send an email to the managers regarding the items with no defined owner
    // this script will only run once on the first monday of each month.
    // Thane Stevens

    // get all managers
    function get_managers() {
        global $db;

        $sql = "select * from people where type = 2";
        $result = mysqli_query($db, $sql);
        return $result;
    }

    // get current date and first Monday of current month
    $today = date('d-M-Y');
    $first_monday = date('d-M-Y', strtotime("first monday of this month"));
    // $first_monday = $today;
    // get audit status
    $status = $_SESSION['audit'] ?? 0;
    if($today==$first_monday){
        // if audit has not been performed yet
        if($status == 0){
            
            // find all owners with items older than time limit
            $owners = audit_owners();

            // sort items by owner, send individual email to each owner with all their items in it
            foreach($owners as $owner){
                $items = audit_items($owner['admin_id']);
                // for all items with no defined owner, email managers
                if($owner['admin_id'] == 0) {
                    $to = '';
                    $managers = get_managers();
                    // send to each manager
                    foreach($managers as $manager){
                        $to .= $manager['email'] . ", ";
                    }
                    $to .= "thane.stevens2@thermofisher.com";
                    $subject = "Warehouse Audit";
                    $headers = "From: manager.harvi@gmail.com\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $message = "Hey Managers, we found some items in the warehouse that have been there a while, and we don't know who they belong to: <br>";
                    $message .= "<ul>";
                    foreach($items as $item){
                        $message .= "<li>";
                        if(isset($item['work_order'])){$message .= $item['work_order'] . ", ";}
                        $message .= $item['description'] . ", (" . strtoupper($item['location_name']) . ")</li>";
                    }
                    $message .= "</ul>";
                    $message .= "If you could help us track down the owners, that would be a great help. Thanks!!<br>";
                    if(isset($to) && $to != NULL && $to != ''){
                        if(!empty($items)){
                            $mail = mail($to, $subject, $message, $headers);
                            // echo $message;
                        }
                    }
                }else{ // if item has a definitive owner, send email to that specific owner
                    $to = $owner['email'];
                    $subject = "Warehouse Audit";
                    $headers = "From: manager.harvi@gmail.com\r\n";
                    $headers .= "CC: thane.stevens2@thermofisher.com\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $message = "Hey " . ucfirst($owner['first_name']) . ", we found some items in the warehouse that have been there a while, we were wondering what you want to do with them: <br>";
                    $message .= "<ul>";
                    foreach($items as $item){
                        $message .= "<li>";
                        if(isset($item['work_order'])){$message .= $item['work_order'] . ", ";}
                        $message .= $item['description'] . ", (" . strtoupper($item['location_name']) . ")</li>";
                    }
                    $message .= "</ul>";
                    $message .= "In any case, come and find me if you have any questions, thanks!!<br>";
                    if(isset($to) && $to != NULL && $to != ''){
                        if(!empty($items)){
                            $mail = mail($to, $subject, $message, $headers);
                            // echo $message;
                        }
                    }
                }
            }
            // audit is complete, only do once on the first monday of each month
            $_SESSION['audit'] = 1;
        }else{
            // // $_SESSION['message'] = "Last audit was done " . $first_monday . ".";
            // // unset($_SESSION['message']);
            echo "Audit has been performed";
        }
    }else{
        // once first monday is done, reset audit variable
        $_SESSION['audit'] = 0;
        echo "Today is " . $today . ".<br>";
        echo "Last audit was performed on " . $first_monday . ".";
    }
    


?>