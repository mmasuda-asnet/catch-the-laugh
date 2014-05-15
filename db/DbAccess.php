<?php

function get_login_info($id, $getdata, $pw){
    //処理
    $select = <<< EOL
    select groupID from mst_group where groupID = %s and groupPW = '%s';      
EOL;
    $link = mysql_connect('localhost', 'root');
    if(!$link){
        die("not linked");
    }
    mysql_select_db('map_db', $link);
    $result = mysql_query(sprintf($select, $getdata, $pw), $link);
    if(!$result){
//        mysql_close($link);
//        return FALSE;
        die("query miss".sprintf($select, $getdata, $pw));
    }
    
    $insert = <<< EOL
    insert into mst_user(userName, groupID) values ('%s', %s);        
EOL;
    $result = mysql_query(sprintf($insert, $id, $getdata), $link);
    if(!$result){
        mysql_close($link);
        return FALSE;
    }
    $select = <<< EOL
    select userID from mst_user where userName = '%s' and groupID = %s;      
EOL;
    $result = mysql_query(sprintf($select, $id, $getdata), $link);
    if(!$result){
        die(sprintf($select, $id, $getdata).$result);
        mysql_close($link);
        return FALSE;
    }
    $row = mysql_fetch_assoc($result);
    $userId = $row['userID'];
    mysql_close($link);
    return $userId;
}

function insert_post_data($path, $lat, $lon, $userId){
    $insert = <<< EOL
    insert into tbl_image(imagePath, userID, lat, lon, groupID) select '$path', $userId, $lat, $lon, groupId from mst_user where userID=$userId;        
EOL;
    
    $link = mysql_connect('localhost', 'root');
    
    mysql_select_db('map_db', $link);
    
    $result = mysql_query($insert, $link);
    if(!$result){
        die("error");
    }
    mysql_close($link);
}

function get_image_list($id){
    $select = <<< EOL
            select imageId, imagePath, userName, lat, lon from tbl_image
            inner join mst_user on tbl_image.userId=mst_user.userId
            where tbl_image.groupId=$id;
EOL;
    
    $link = mysql_connect('localhost', 'root');
    
    mysql_select_db('map_db', $link);
    
    $result = mysql_query($select, $link);
    if(!$result){
        die("error");
    }
    mysql_close($link);
    return $result;
}