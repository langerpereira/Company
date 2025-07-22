<?php
session_start();
if ($_SESSION['loggedin'] !== true) {
    header("Location: ../public/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link type="image/png" sizes="16x16" rel="icon" href="../public/11.png">
  <style>
    body{
      background: url(./2.jpg);
      background-size: cover;
      background-repeat: no-repeat;
    }
    .form-section {
      background-color: #f8f9fab3;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .doc-input {
      margin-bottom: 10px;
    }


  </style>
</head>
<body class="bg-light">
  <div class="container mt-1">
    <div class="form-section mt-5 shadow">
      <a class="btn btn-danger btn-large m-1 " href="logout.php">Logout</a>
      <h3 class="mb-4 text-center">Add Employee</h3>
      <form id ="addEmployeeForm">

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" id="first_name" class="form-control" name="first_name" >
          </div>
          <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" id="last_name" class="form-control" name="last_name" >
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" id="email" class="form-control" name="email" >
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="date" id="dob" class="form-control" name="dob">
          </div>
          <div class="col-md-6">
            <label class="form-label">Gender</label>
            <select id="gender" class="form-select" name="gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
      <label class="form-label">Documents</label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="documents[]" value="Aadhar Card" id="aadhar">
        <label class="form-check-label" for="aadhar">Aadhar Card</label>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="documents[]" value="Pan Card" id="pan">
        <label class="form-check-label" for="pan">Pan Card</label>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="documents[]" value="Driving License" id="license">
        <label class="form-check-label" for="license">Driving License</label>
      </div>
      
    </div>

        <div class="d-grid mb-3">
          <button type="submit" value='submit' class="btn btn-primary">Submit</button>
        </div>
         <input class="btn btn-secondary btn-sm float-end" type="reset" value="Clear Form">

      </form>
      <div class="d-inline-block">
        <a href="../public/view.php" class="btn btn-secondary btn-sm">View All Employees</a>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
      $(document).ready(function(){
        $("#addEmployeeForm").on("submit", function(event){
          event.preventDefault();

          var firstName = $("#first_name").val();
          var lastName = $("#last_name").val();
          var email = $("#email").val();
          var dob = $("#dob").val();
          var gender = $("#gender").val();
          var documents = [];
            $("input[name='documents[]']:checked").each(function () {
              documents.push($(this).val());
            });

          $.ajax({
            url: "../include/add_employee.php",
            type: "POST",
            data: {
              first_name: firstName,
              last_name: lastName,
              email: email,
              dob: dob,
              gender: gender,
              documents: documents
            },
            success: function(response) {
              // console.log("Server Response:", response);
              alert(response);
            },
            error: function(error) {
              console.error("AJAX Error:", status, error);
              alert("Error adding employee. Please try again.");
            }
          });
        });
      })
  </script>
</body>
</html>
