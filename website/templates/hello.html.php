<?php
use livio\Service\Homepage\HomepagePdoService;
?>
<!Doctype>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="design">
 	<title>Homepage</title>
</head>
<body>
	<h1>Mario's Blog</h1>
	<a href="login">Login</a>
	<?php 
	echo "<table border='1'>";
	echo "<tr><th>title</th> <th>content</th> <th></th> <th>likes</th> <th>dislikes</th></tr>";
	foreach ($posts as $row)
	{
		
		echo "<tr>";
		echo "<td>" .$row['title'] . "</td>";
		echo "<td>" .$row['content'] . "</td>";
		echo "<td>" . "	<form id='like' method='post'> 
						<input type='hidden' name='post_id' id='post_id' value=".$row['id'].">
						<input type='submit' value='Like'>
						<form>" . "</td>";
		
		$likesCount = 0;
		$dislikesCount = 0;
		foreach ($likes as $like)
		{
			if ($like['post_id'] === $row['id'])
			{
				if($like['isDislike'] === 0)
				{
					$likesCount++;
				}
				else
				{
					$dislikesCount++;
				}
			}
		}
		echo "<td>".$likesCount."</td>";
		echo "<td>".$dislikesCount."</td>";
		echo "</tr>";
	}
	echo "</table>";
	?>
	
</body>
</html>