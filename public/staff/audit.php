<?php 
    require_once('../../private/initialize.php');    

    $today = date('d-M-Y');
    $first_monday = date('d-M-Y', strtotime("first monday of this month"));
    // $first_monday = $today;
    $status = $_SESSION['audit'] ?? 0;
    if($today==$first_monday){
        if($status == 0){
            $_SESSION['audit'] = 1;
            $owners = audit_owners();

            foreach($owners as $owner){
                // echo "<h1>" . $owner['first_name'] . "</h1>";
                // echo "<ul>";
                $items = audit_items($owner['admin_id']);
                // $to = $owner['email'];
                $to = 'thanerstevens@gmail.com';
                $subject = "Warehouse Audit";
                $headers = array('From' => 'thane.stevens2@thermofisher.com');
                $message = "Hey " . ucfirst($owner['first_name']) . ", we found some items in the warehouse that have been there a while, we were wondering what you want to do with them: <br>";
                $message .= "<ul>";
                foreach($items as $item){
                    $message .= "<li>";
                    if(isset($item['work_order'])){$message .= $item['work_order'] . ", ";}
                    $message .= $item['description'] . "</li>";
                }
                $message .= "</ul><br>";
                $message .= "In any case, come and find me if you have any questions, thanks!!";
                if(isset($to) && $to != NULL && $to != ''){
                    $mail = mail($to, $subject, $message, $headers);
                }
            }
        }else{
            // $_SESSION['message'] = "Last audit was done " . $first_monday . ".";
        }
    }else{
        $_SESSION['audit'] = 0;
        // echo "Today is " . $today . ".<br>";
        // echo "Last audit was performed on " . $first_monday . ".";
        // unset($_SESSION['audit']);
    }
    // echo "<br>" . $_SESSION['audit'];
    


?>