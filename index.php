<?php
session_start();
require_once './db/DbAccess.php';
$id = @$_POST['id'];
$pw = @$_POST['pw'];

$getdata = @$_GET['id'];


$html = <<<EOL
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title></title>
                    </head>
                    <body>
                    
                        <form method='post' action='./index.php?id=$getdata' >
                        ID:
                        <input type='text' id='id' name='id'/>
                        <br/>
                        PW:
                        <input type='password' id='pw' name='pw'/>
                        <input type='submit' value='login'/>
                        </form>
                    </body>
                    </html>
EOL;
if (is_null($pw) or is_null($pw)) {
    //postで値が渡されていない場合

    print_r($_COOKIE);
    echo $html;
} else {
    //POSTで値が渡された場合
    $regPw = get_login_info($id, $pw);
    if ($pw === $regPw) {
        $_SESSION['id'] = $id;
        $_SESSION['eid'] = md5($id);
        $_SESSION['pw'] = $pw;
        if(!is_null($getdata) and strlen($getdata) > 0){
            header("Location: ./map/map.php?id=".$getdata);
            
        }
        
        exit();
    } else {
        echo '<font color="red">パスワードちゃうで</font>';
        echo $html;
    }
}
?>
