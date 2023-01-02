
<?PHP
function dirList ($directory, $sortOrder){

    //Get each file and add its details to two arrays
    $results = array();
    $handler = opendir($directory);
    $file_dates = array();
    while ($file = readdir($handler)) { 
        
        if ($file != '.' && $file != '..' && $file != "robots.txt" && $file != ".htaccess"){
            $currentModified = filectime($directory."/".$file);
            $file_names[] = $file;
            $file_dates[] = date ("d/m/Y H:i:s.",$currentModified);
        }   
    }
       closedir($handler);

    //Sort the date array by preferred order
    if ($sortOrder == "newestFirst"){
     
        arsort($file_dates);
    }else{
        
        asort($file_dates);
    }
   
    //Match file_names array to file_dates array
    $file_names_Array = array_keys($file_dates);
    foreach ($file_names_Array as $idx => $name) $name=$file_names[$name];
    $file_dates = array_merge($file_dates);
   
    $i = 0;

    //Loop through dates array and then echo the list
    foreach ($file_dates as $file_dates){
        $date = $file_dates;
        $j = $file_names_Array[$i];
        $file = $file_names[$j];
        $i++;
           
        echo  "File name: $file - Date de adição: $date. <br/>";       
    }

}

dirList('./arquivos','newestFirst');
?>
