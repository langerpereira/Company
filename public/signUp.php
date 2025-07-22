<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link type="image/png" sizes="16x16" rel="icon" href=".../icons8-done-clouds-16.png">
  <title>Sign Up</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
      background-image: url('1.jpg');
      background-size: cover;
      background-position: center;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      padding: 20px;
    }

    .form-box {
      background-color: rgba(255, 255, 255, 0.41);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #e531be;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #ca068f;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h2>Sign Up</h2>
      <form action="../include/signup.php" method="POST">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" required />
        </div>
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" required />
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </div>
</body>
</html>
