<?php

function clean_data($data=null){
    $data = trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    
    return$data;
}

?>

