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
  <meta charset="UTF-8">
  <title>Employee Table</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body {
      background: url(./3.jpg);
      background-size: cover;
      background-repeat: no-repeat;
      padding: 30px;
    }
    .table-container {
      background-color: #ffffff86;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.318);
    }

    .form-group {
      margin-bottom: 10px;
      padding: 10px;
    }
  </style>
</head>
<body>
  <div class="container table-container shadow">
    <a class="btn btn-danger btn-large m-2 " href="logout.php">Logout</a>
    <h2 class="text-center mb-4">Employee Directory</h2>
    <div class="table-responsive">
      <table id="employeeTable" class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">dob</th>
            <th scope="col">Gender</th>
            <th scope="col">Documents</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div id='edit-modal' class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h2>Edit User</h2>
        <div class="form-group">
          <label for="edit_first_name">First Name</label>
          <input type="text" class="form-control" id="edit_first_name" name="first_name">
        </div>
        <div class="form-group">
          <label for="edit_last_name">Last Name</label>
          <input type="text" class="form-control" id="edit_last_name" name="last_name">
        </div>
        <div class="form-group">
          <label for="edit_email">Email</label>
          <input type="email" class="form-control" id="edit_email" name="email">
        </div>
        <div class="form-group">
          <label for="edit_dob">Date of Birth</label>
          <input type="date" class="form-control" id="edit_dob" name="dob">
      </div>
       <div class="form-group">
        <label for="edit_gender">Gender</label>
        <select class="form-control" id="edit_gender" name="gender">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
       </div>

        <div class="form-group">
          <label class="form-label">Documents</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="documents[]" value="Aadhar Card" id="aadhar">
            <label class="form-check-label" for="aadhar">Aadhar Card</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="documents[]" value="PAN Card" id="pan">
            <label class="form-check-label" for="pan">PAN Card</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="documents[]" value="Passport" id="passport">
            <label class="form-check-label" for="passport">Passport</label>
          </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit-btn">Save changes</button>
      </div>
    </div>
  </div>
</div>

    </div>
    <div class="mt-3">
        <a href="../public/index.php" class="btn btn-secondary btn-sm">Add Employees</a>
      </div>
      
  </div>
     

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function(){

      function loadData() {
        
        // view employee data
        $.ajax({
            url: "../include/view_employee.php",
            type: "POST",
            dataType: "json",
            success: function(data){
                $.each(data, function(index, row){
                    var newRow = "<tr><td>" + row.id + "</td><td>" + row.first_name + "</td><td>" + row.last_name + "</td><td>" + row.email + "</td><td>" + row.dob + "</td><td>" + row.gender + "</td><td>" + row.documents + "</td><td class='button-container text-center'><button class='btn btn-sm btn-outline-primary edit-btn' data-bs-toggle='modal' data-bs-target='#exampleModal' data-id='" + row.id + "'>Edit</button><button class='btn btn-sm btn-outline-danger delete-btn mx-2' data-id='" + row.id + "'>Delete</button></td></tr>";
                    $("#employeeTable tbody").append(newRow);
                });
            },
             error: function(xhr, status, error){
                     console.error("AJAX Error:", status, error);
            }
        });
      }
      //delete employee
      loadData();

      $("#employeeTable").on("click", ".delete-btn", function(){
       var employeeId = $(this).data("id");
        if(confirm("Are you sure you want to delete this employee?")) {
          $.ajax({
            url: "../include/delete_employee.php",
            type: "POST",
            data: { id: employeeId },
            success: function(response) {
              alert(response);
              $("#employeeTable tbody").empty(); 
              loadData(); 
            },
            error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
            }
          });
        }
      });

      //edit employee

      $("#employeeTable").on("click", ".edit-btn", function () {
          editUserId = $(this).data("id");

          const row = $(this).closest("tr");
          const name = row.find("td:nth-child(2)").text();
          const lastName = row.find("td:nth-child(3)").text();
          const email = row.find("td:nth-child(4)").text();
          const dob = row.find("td:nth-child(5)").text();
          const gender = row.find("td:nth-child(6)").text();
          const documents = row.find("td:nth-child(7)").text().split(", ");

          $("#edit_first_name").val(name);
          $("#edit_last_name").val(lastName);
          $("#edit_email").val(email);
          $("#edit_dob").val(dob);
          $("#edit_gender").val(gender);

          $("input[name='documents[]']").prop("checked", false);
          documents.forEach(function (doc) {
            $("input[name='documents[]'][value='" + doc + "']").prop("checked", true);
          });
        });

        // EDIT - save logic
        $("#edit-btn").on("click", function () {
          if (editUserId == null) {
            console.error("No user ID selected.");
            return;
          }

          const newName = $("#edit_first_name").val();
          const newLastName = $("#edit_last_name").val();
          const newEmail = $("#edit_email").val();
          const newDob = $("#edit_dob").val();
          const newGender = $("#edit_gender").val();
          const newDocuments = $("input[name='documents[]']:checked")
            .map(function () {
              return $(this).val();
            })
            .get();

          if (!newName || !newLastName || !newEmail || !newDob || !newGender) {
            alert("Please fill in all fields.");
            return;
          }

          $.ajax({
            url: "../include/update_employee.php",
            type: "POST",
            data: {
              id: editUserId,
              first_name: newName,
              last_name: newLastName,
              email: newEmail,
              dob: newDob,
              gender: newGender,
              documents: newDocuments,
            },
            success: function (response) {
              alert(response);
              $("#exampleModal").modal("hide");
              $("#employeeTable tbody").empty();
              loadData();
            },
            error: function (xhr, status, error) {
              console.error("AJAX Error:", status, error);
            },
          });
        });
      });
</script>
    

</body>
</html>
