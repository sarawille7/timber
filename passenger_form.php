<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<h2>PASSENGER FORM</h2>

 <?php
$is_update = true;

if(isset($_GET['firstname'])){
    $firstname = $_GET['firstname'];}
else{
    $firstname = '';
    $is_update = false;}


if(isset($_GET['middleinitial'])){
    $middleinitial = $_GET['middleinitial'];}
else{
    $middleinitial = '';
    $is_update = false;}

if(isset($_GET['lastname'])){
    $lastname = $_GET['lastname'];}
else{
    $lastname = '';
    $is_update = false;}

if(isset($_GET['ssn'])){
    $ssn = $_GET['ssn'];}
else{
    $ssn = '';
    $is_update = false;}


if($is_update === true){
    $action_direct = 'updatePassenger.php';
    $button = 'Update Info';}
else{
    $action_direct = 'createPassenger.php';
    $button = 'Submit';}
?>

<form action='<?php echo $action_direct ?>' method="post">
    First Name:<br><input type="text" name="firstname" required pattern="[A-Z]\w+|[a-z]\w+" value='<?php echo $firstname; ?>'><br>
    Middle Initial (Not required):<br><input type="text" name="middleinitial" pattern="[A-Z]|[a-z]" value='<?php echo $middleinitial; ?>'><br>
    Last Name:<br><input type="text" name="lastname" required pattern="[A-Z]\w+|[a-z]\w+" value='<?php echo $lastname; ?>'><br>
    SSN (Input as follows: ###-##-####):<br><input type="text" name="ssn" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" value='<?php echo $ssn; ?>'><br><br>
<?php
    if($is_update === true){
        echo "<input type='hidden' name='oldssn' value=$ssn>";
    }
?>
<input type="submit" value= '<?php echo $button; ?>'>
</form>

</body>
</html>
