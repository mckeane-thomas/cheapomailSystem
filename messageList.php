<?php        

$connect = mysql_connect('localhost','admin','Admin@123');
$subject = $_POST['subject'];
if(!mysql_select_db('mail_users'))
{
	die('Failure selecting Database'. mysql_error());
}
if(isset($_COOKIES['username'])){
    $user = $_COOKIES['username'];
    
    $msg_query = "SELECT * FROM message WHERE subject = '$subject'";
    $msg_result = mysql_query($connect, $msg_query);
        
    while($row = mysql_fetch_array($msg_result)){
        $sender = $row['user_id'];
        $msgBody = $row['body'];
        $msg_sub = $row['subject'];
        
        echo"<div class = 'readmsg'>";
        echo "<div id = 'sub'>".$msg_sub."</div>";
        echo "<hr id = 'hr2'>";
        echo "<div id = 'from'><strong>FROM: </strong>".$sender."</div>";
        echo "<p id = 'msg_body'>".$msgBody."</p>";
        echo"</div>";
        
        if($flag === 0){
            $id_str = "SELECT id FROM user WHERE username = '$user'";
            $id_query = mysql_query($connect, $id_str);
            while($row2 = mysql_fetch_array($id_query)){
                $date = date("YYYY/MM/DD");
                $id = $row['id'];
                
                $newQuery = "INSERT INTO mesage_read (message_id,reader_id,date) VALUES ('$id_msg','$id','$date');";
                if(!mysql_query($connect,$newQuery)){
                    echo "Could not connect!";
                }
            }
        }
    }
    
    
}else{
     echo "<script>alert('Could not read messages');
            location.replace('index.html');</script>";
}
?>