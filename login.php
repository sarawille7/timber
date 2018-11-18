<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<h2>Login</h2>

<form action="loginProcess.php" method="post">
    Username:<br><input type="text" name="username" required pattern="[A-Z]\w+|[a-z]\w+"><br>
    Password:<br><input type="password" name="password"><br>
<input type="submit" value= '<?php echo "Login"; ?>'>
</form>
</body>
</html>
