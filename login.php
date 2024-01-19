<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
  <div class="container pt-2 my-5 border animate__animated animate__zoomIn">
    <form action="loginvalidation.php" method="post" class="needs-validation" novalidate>
      <h2>Login Account</h2>
      <div class="imgcontainer">
          <img src="img/person.png" alt="Avatar" class="avatar">
      </div>
      <br>
      <div class="col">
        <div class="form-group">
          <label for="userid">STAFF ID</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="userid" placeholder="Enter Staff ID" name="userid" pattern="^(?=.*[A-Z])(?=.*\d)[A-Z\d]+$" required>
            <div class="invalid-feedback">
              Please enter a combination of only uppercase letters and numbers.
            </div>
          </div>     
        </div>       
      </div>
      <br>
      <div class="col">
        <div class="form-group">
          <label for="password">PASSWORD</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
            <input type="password" class="form-control" placeholder="Enter Password" name="password" minlength="8" maxlength="12" required>
            <div class="invalid-feedback">
              Password must be between 8 and 12 characters.
            </div>
          </div>
        </div>       
      </div>
      <br>
      <div class="row">
        <p>Does not have an account? Please <a style="color: blue;" href="register.php">Register</a> Now.</p>
        <button type="submit" class="btn btn-success">Login</button>
      </div>
    </form>
  </div>

  <script>
    (function () {
      'use strict'

      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)

          Array.from(form.elements).forEach(function(element) {
            element.addEventListener('input', function(event) {
              if (!element.checkValidity()) {
                element.classList.add('is-invalid')
              } else {
                element.classList.remove('is-invalid')
              }
            })
          })
        })
    })()
  </script>
  
</body>
</html>