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
                echo "<h1>" . $owner['first_name'] . "</h1>";
                echo "<ul>";
                $items = audit_items($owner['admin_id']);
                foreach($items as $item){
                    echo "<li>";
                    if(isset($item['work_order'])){echo $item['work_order'] . ", ";}
                    echo $item['description'] . "</li>";
                }
                echo "</ul>";
            }
        }else{
            echo "Today is the first monday of the month.<br>";
            echo "Audit has been performed.";
        }
    }else{
        $_SESSION['audit'] = 0;
        echo "Today is " . $today . ".<br>";
        echo "Last audit was performed on " . $first_monday . ".";
        // unset($_SESSION['audit']);
    }
    // echo "<br>" . $_SESSION['audit'];
    


?>