<?php


    $id = $_GET['id'];
    $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < 5; $i++) {
            $key .= $keys[array_Rand($keys)];
        }
	  
	move_uploaded_file($_FILES['file']['tmp_name'], '../rh/'.$id.'/'. date('Ymd')."_".$_FILES['file']['name']);
    
	  
	echo "success";
	die();
    ?>