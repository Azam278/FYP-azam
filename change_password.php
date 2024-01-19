<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    // Check if the user is logged in and the username is stored in the session
    if (!isset($_SESSION['userid'])) {
        // Redirect to the login page or handle unauthorized access
        header("Location: login.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the submitted form data
        $newPassword = $_POST['newpass'];
        $confirmPassword = $_POST['confirm_password'];

        // Perform password validation and ensure they match
        if ($newPassword !== $confirmPassword) {
            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'The Confirm Password does not match with New Password.!'
                    }).then(function() {
                        window.location = 'change_password.php';
                    });
                }
                </script>";
        } else {
            // Retrieve the username from the session
            $userid = $_SESSION['userid'];

            // TODO: Update the password in the database for the given username
            // You need to implement the database update logic here

            // Update the password for both administrators and users
            $updateAdminQuery = "UPDATE administrator SET A_PASSWORD='$newPassword' WHERE ADMIN_ID='$userid'";
            $updateUserQuery = "UPDATE users SET StPassword='$newPassword' WHERE Staff_ID='$userid'";

            mysqli_query($conn, $updateAdminQuery);
            mysqli_query($conn, $updateUserQuery);

            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Password changed successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location = 'login.php';
                    });
                }
                </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
  <div class="container pt-2 my-5 border animate__animated animate__zoomIn">
    <form action="change_password.php" method="post" class="needs-validation" novalidate>
      <h2>Change Password</h2>
      <div class="imgcontainer">
          <img src="img/person.png" alt="Avatar" class="avatar">
      </div>
      <br>
      <div class="col">
        <div class="form-group">
          <label for="new_password">New Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
            <input type="password" class="form-control" placeholder="Enter Password" name="newpass" minlength="8" maxlength="12" required>
            <div class="invalid-feedback">
                Password must be between 8 and 12 characters.
            </div>
          </div>     
        </div>       
      </div>
      <br>
      <div class="col">
        <div class="form-group">
          <label for="confirm_password">Confirm Passowrd</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
            <input type="password" class="form-control" placeholder="Enter Password" name="confirm_password" minlength="8" maxlength="12" required>
            <div class="invalid-feedback">
              Password must be between 8 and 12 characters.
            </div>
          </div>
        </div>       
      </div>
      <br>
      <div class="row">
        <button type="submit" class="btn btn-success">Change Password</button>
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