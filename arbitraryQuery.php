<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<h2>WRITE ANY QUERY</h2>

<form action="executeArbitraryQuery.php" method="post">
  Query:<br><input size="50" value="<?php if(isset($_GET['query'])){echo $_GET['query'];} ?>" type="text" name="query"><br>
  <input type="submit">
</form>


<?php if(isset($_GET['out'])){
echo "<br/><b>Result:</b><br/>";
echo $_GET['out'];
} ?>

</body>
</html>
