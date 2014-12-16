<!DOCTYPE html>
<html >
	<?php session_start();?>
	<head>
		<title> INBOX | 
                    <?php echo $_SESSION['Name'];?> 
		</title>
		<meta http-equiv="Content-type" content="text/html;charset=ISO-8859-1" />
		<script src= 'message.js' type='text/javascript'></script>
		<script src='//ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js' type='text/javascript'></script>
                <link rel="stylesheet" type="text/css" href="inboxstyle.css" />

	</head>

	<body id="container">

		<div>

			<div id="header">
				<h1 >Cheapo Mail System Inbox</h1>
			</div>

			<div id="menu">
                            <ul>
                                <li><a id="compose" href="#">Compose</a></li>
                                <li><a id="inbox" href="#">Inbox</a></li>

			<?php	//Only administrator should be able to register 
				if($_SESSION['Username'] == 'admin')
				{
					echo '<li><a href="newuser.html">Register</a></li>';
				}
			?>
                                <li><a href='action.php?a=logout'>Logout</a></li><br /><!-- Sends request for logout control sequence to be run -->
				<span id='id'>Session:<?php echo $_SESSION['ID'];?></span>
			</ul>								

                        </div>

			<div id="page-content">
			No New Messages 
			</div>

			

		</div>
	</body>
</html>
