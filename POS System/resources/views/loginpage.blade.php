<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="../Images/invoice.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('Styles/Login.css') }}">
</head>

<body>
  <div class="login-container">
    <div class="logo">
      <img src="../Images/logo.png" alt="">
    </div>
    <h1 class="login-heading">
      AL Baraka Factory For Gold & Precious Metals
    </h1>
    <form action="login" method="POST" class="login-form">
      @csrf
      <div>
        <label id="user" for="username">Username</label>
        <input pattern="\w{1}[\w\d]{1,}" onfocus="document.getElementById('user').classList.add('up')" onblur="!this.value && document.getElementById('user').classList.remove('up')" type="text" id="username" name="username" class="input" required>
      </div>
      <div>
        <label id="pass" for="password">Password</label>
        <input onfocus="document.getElementById('pass').classList.add('up')" onblur="!this.value && document.getElementById('pass').classList.remove('up')" type="password" id="password" name="password" class="input" required>
      </div>

      <div class="btn-container">
        <button onclick="document.querySelector('.login-form').action = 'login'" type="submit" class="login-btn">Login</button>
        <button onclick="document.querySelector('.login-form').action = 'signin'" type="submit" class="admin-btn">Admin Panel</button>
      </div>
    </form>
  </div>

  <!-- <script src="{{ asset('Logics/Login.js') }}"></script> -->

</body>

</html>