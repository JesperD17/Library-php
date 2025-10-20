<?php
$path = "$_SERVER[QUERY_STRING]";
$cutAfter = strpos($path, '&');
$succesOrFail = substr($path, $cutAfter + 1);
?>

<form action="./actions/auth/registerUser.php" method="post">
  <label for="username">Username:</label> 
  <input id="username" name="username" required="" type="text" />
  <label for="email">Email:</label>
  <input id="email" name="email" required="" type="email" />
  <label for="password">Password:</label>
  <input id="password" name="password" required="" type="password" />
  <input name="register" type="submit" value="Register" />
</form>

<?php if ($succesOrFail === 'success=true') : ?>
  <p>Registration successful! You can now <a href="./pages/login.php">login</a>.</p>
<?php elseif ($succesOrFail === 'success=false&error=duplicate') : ?>
  <p>Error: The username or email is already taken. Please try again with different credentials.</p>
<?php elseif ($succesOrFail === 'success=false&error=sql') : ?>
  <p>Error: There was a problem with the registration process. Please try again later.</
<?php endif; ?>