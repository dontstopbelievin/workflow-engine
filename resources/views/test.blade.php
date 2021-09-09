<?php
loop_arr('result', $data);
function loop_arr($key, $data)
{
    if(is_array($data)){
        foreach($data as $key => $value){
            loop_arr($key, $value);
        }
    }else{
        printf($key.": ".$data."<br/>");
    }
}
?>
