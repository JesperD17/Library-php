<?php
session_start();
$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);
?>

<div class="h-100-w-100 flex-center">
  <div class="flex-col border-radius margin-all bg-secondary border form-w">
    <div class="h1 padding-all center-text">Register</div>
    
    <form class="flex-col margin-unset padding-all" action="./actions/auth/registerUser.php" method="post">
      <div class="flex-col padding-btm">
        <label for="username">Username:</label>
        <input class="input border border-radius" name="username" required type="text" autofocus>
      </div>
      <div class="flex-col <?= $message === null ? 'padding-btm' : '' ?>">
        <label for="email">Email:</label>
        <input class="input border border-radius" name="email" required type="email">
      </div>
      <?php if ($message): ?>
        <div class="<?= htmlspecialchars($message['classes']) ?> wrap padding-btm">
          <?= $message['text'] ?>
        </div>
      <?php endif; ?>
      <div class="flex-col padding-btm">
        <label for="password">Password:</label>
        <input class="input border border-radius" name="password" required type="password">
      </div>
      <div class="gap flex-row flex-align">
        <button class="btn full-width baseText" name="register" type="submit" value="Register">Submit</button>
        <a class="flex-align full-width justify-end end-text" href="./forgot-password">Forgot password?</a>
      </div>
    </form>
  </div>
</div>