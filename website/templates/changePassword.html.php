<!Doctype>
<html>
<head>
	<link rel="stylesheet" href="/Design/design.css">
	<title>change Pw</title>
</head>
<body>
	<h1>Change Password</h1>
	<form method="POST">
	<?php echo $csrf;
	if ($codeSent)
	{?>
		<label>Secret Code:
			<input type="text" name="code"/>
		</label>
		<label>new Password:
			<input type="password" name="password">
		</label>
		<input type="submit" name="changepw" value="Change Password">
	</form>
	<?php
	}
	else if(!$codeSent)
	{?>
	<form method="POST">
	<?php echo $csrf?>
		<label>Enter the e-mail adress of you account. You will receive a code there that you need to enter to reset you password.</label>
		<div>
			<label>Email:
				<input type="email" name="email"/>
			</label>
			<input type="submit" name="Send" value="Send">
		</div>
	</form>
	<?php 
	}?>
</body>
</html>