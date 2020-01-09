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
    $today = date('Y-m-d');
    $first_monday = date('Y-m-d', strtotime("first monday of this month"));
    // get date of last audit
    $last_audit = last_audit();
    // get audit status
    if($today == $last_audit){
        $complete = true;
    }else{
        $complete = false;
    }
    // set expiration date in months
    // ex. if searching for items older than 6 months, $interval = 6;
    $interval = 3;

    // execute script
    if($today==$first_monday){
        // if audit has not been performed yet
        if(!$complete){
            
            // find all owners with items older than time limit
            $owners = audit_owners($interval);

            // sort items by owner, send individual email to each owner with all their items in it
            foreach($owners as $owner){
                $items = audit_items($owner['admin_id'], $interval);
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
                        $message .= $item['description'] . ", (" . strtoupper($item['location_name']) . ")";
                        if($item['audit_number'] >= 3) {
                            $message .= " <strong style='color: red;'>Final Notice</strong>";
                        }
                        $message .= "</li>";
                    }
                    $message .= "</ul>";
                    $message .= "If you could help us track down the owners, that would be a great help. Thanks!!<br>";
                    $message .= "<em>&ast; Items marked <strong style='color: red;'>Final Notice</strong> have been in the warehouse for 5 months or more</em><br>";
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
                        $message .= $item['description'] . ", (" . strtoupper($item['location_name']) . ")";
                        if($item['audit_number'] >= 3) {
                            $message .= " <strong style='color: red;'>Final Notice</strong>";
                        }
                        $message .= "</li>";

                    }
                    $message .= "</ul>";
                    $message .= "In any case, come and find me if you have any questions, thanks!!<br>";
                    $message .= "<em>&ast; Items marked <strong style='color: red;'>Final Notice</strong> have been in the warehouse for 5 months or more</em><br>";
                    if(isset($to) && $to != NULL && $to != ''){
                        if(!empty($items)){
                            $mail = mail($to, $subject, $message, $headers);
                            // echo $message;
                        }
                    }
                }
            }
            // audit is complete, only do once on the first monday of each month
            
            // count how many items were audited
            $count = count_audit();
            // add audit to audit count
            audit_count_up($interval);
            // log the date of the last audit, and the quantity of items audited
            new_audit($today, $count);
        }else{
            // if audit has already been completed, display complete message
            $_SESSION['message'] = "Audit has been performed.";
        }
    }else{
        // on any day that is not the first monday of the month, the script will not execute
    }
    


?>