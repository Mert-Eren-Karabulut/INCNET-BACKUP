<?php

    if(isset($_POST['button'])){
        
        $date1 = $_POST['date'];
        $date2 = $_POST['date2'];
        
        if(strtotime($date1) < strtotime($date2)){
            
            $string = 'date 2 is bigger';
            
        }else{
            
            $string = 'date1 is bigger';
        }
        
        echo '<script>alert("' . $string . '")</script>';
    
    
    }

?>
<html>
    <body>
        <?php 

            $yearAgo = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d"), date("Y") -10));

            echo $yearAgo;

        ?>
        <br>
        <form method="post">
            
            <input type="date" name="date" value="1971-07-27" />
            <input type="date" name="date2" value="1823-06-30" />
            <input type="submit" name="button" value="click">
            <h1> <?php echo date('G'); ?></h1>
        
        </form>
        
        
    </body>

</html>