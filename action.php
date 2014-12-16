<?php
session_start();
header('Access-Control-Allow-Origin:*');
$connect = mysql_connect('localhost','admin','Admin@123');
$recipient_id; 
if(!mysql_select_db('mail_users'))
{
	die('Failure selecting Database'. mysql_error());
}


if($_GET['a'] == 'login')
{//verify credentials of user login information 
$username = $_POST['username'];
$password = $_POST['password'];
	$get_user_qstr =  "SELECT * FROM users WHERE username ='$username' AND pword = '$password'";   
	$query_get_user = mysql_query($get_user_qstr,$connect);
	//test the credentials
	if(!$query_get_user) 			
	{
		die('Could not execute query'.mysql_error($connect));
	}
	else
	{
            $row="";
		if($row =mysql_fetch_array($query_get_user,MYSQL_ASSOC))
		{
			while($row)
			{
				if(($username === $row['username']) && ($password === $row['pword']))
				{
					$_SESSION['Name'] = $row['firstname'].' '.$row['lastname']; 
					$_SESSION['ID'] = $row['id'];
					$_SESSION['Username'] = $row['username'];
					echo ('User Login Successful');
					echo('<script>location.replace("inbox.php")</script>');
				}
			}
		}
		else
		{
			echo "<script>alert('Incorrect Credentials');
					location.replace('index.html');</script>";
		}
	}
}
else if ($_GET['a'] == 'register')
{
	$add_qstr = "INSERT INTO users 
			(
				firstname,
				lastname,
				pword,
				username
			) 
			VALUES
			(
				'$_POST[f_name]',
				'$_POST[l_name]',
				'$_POST[user_pwd]',
				'$_POST[user_name]')";
	$register_q = mysql_query($add_qstr , $connect);
	if(!$register_q)
	{
		die('Query error'.mysql_error($connect));
	}
	else
	{
		echo"<script>alert('Registration complete')</script>";
		echo "<script>location.replace('newUser.html')</script>";
	}
}
else if($_GET['a']=='logout')
{
	echo '<script>alert("Logging you out '.$_SESSION['Name'].'")</script>';
	session_destroy();
	echo '<script>location.replace("index.html");</script>';
}
else if($_GET['a'] == 'getmessage')
{//control sequence to get all the msesage for the user that is logged ins
	header('Content-Type: text/xml');
	$querystring = "SELECT *
			 FROM message, users
			 WHERE  message.recipient_id = '$_SESSION[ID]'";
	$XML_GETquery = mysql_query($querystring, $connect);
	if(!$XML_GETquery)
	{
		die('Query Error'.mysql_error($connect));
	}
	else
	{
		$xml = new DOMDocument('1.0', 'iso-8859-1');
		//Creating the XML file with the root node <MESSAGESTORE>
		$xml->formatOutput = true;
		$beginningNode = $xml->createElement('MESSAGES');
		$xml->appendChild($beginningNode);
		while($row = mysql_fetch_array($XML_GETquery, MYSQL_ASSOC))
		{
			//Tag that should house all the details for a message
			$messageTag =  $xml ->createElement('MESSAGE'); 
			$beginningNode->appendChild($messageTag);
			$senderIDTag = $xml->createElement('ID', $row['id']);
			$toTag= $xml->createElement('TO',$row['recipient_id']);
			$fromTag = $xml->createElement('FROM',$row['user_id']);
			$subjectTag = $xml->createElement('SUBJECT',$row['subject']);
			$contentTag = $xml->createElement('BODY',$row['body']);
			
			//Appending the created Tags to the XML document under  <MESSAGE>
			$messageTag->appendChild($senderIDTag);
			$messageTag->appendChild($toTag);
			$messageTag->appendChild($fromTag);
			$messageTag->appendChild($subjectTag);
			$messageTag->appendChild($contentTag);
		}
		
		echo $xml->saveXML();
	}

}
else if($_GET['a']=='createmessage')
{
	$recipient_check="SELECT id
			         FROM users
			         WHERE username = '$_REQUEST[to]'";
	$check_query = mysql_query($recipient_check, $connect);
	if(!$check_query || $_REQUEST['to'] == NULL)
	{
		die('User not Found\n'.mysql_error($connect));
	}
	else
	{
		while($row = mysql_fetch_array($check_query,MYSQL_ASSOC))
		{
			$recipient_id = $row['id'];
		}
		$send_message_string = "INSERT INTO message
					       (
					       	body,
					       	subject,
					       	user_id,
					       	recipient_id
					       )
					       VALUES
					       (
					       	'$_REQUEST[body]',
					       	'$_REQUEST[subject]',
					       	'$_SESSION[ID]',
					       	'$recipient_id'
					       )";
		$send_query = mysql_query($send_message_string,$connect);
		if(!$send_query)
		{
			die("Send Failure<br>".mysql_error($connect));
		}
		else
		{
			echo "Success Message sent to '$_REQUEST[to]' ";
		}
	}

}
else if(!isset($_GET['a']))
{
	echo '<script>alert("Error occured \nRedirecting to your Inbox")</script>';
	echo '<script>location.replace("inbox.php")</script>';
}
?>