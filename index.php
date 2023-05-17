<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container-fluid bg-light">
        <div class="row mt-3">
            <div class="col-md-4">
                <h3 class="text-center alert alert-dark">Create User</h3>
                <form id="create-form">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="nameInput" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="emailInput" name="email">
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="phone" class="form-control" id="contactInput" name="contact" minlength="10"
                            maxlength="10" placeholder="+91">
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="addressInput" name="address"></input>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-block">Create</button>
                </form>
            </div>
            <div class="col-md-8">
                <h3 class="text-center alert alert-dark">Users List</h3>
                <table class="table table-bordered">
                    <caption>This is a table about users</caption>
                    <thead>
                        <tr class="alert alert-warning">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="load-table">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="update-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Update</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="edit-form">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="edit-id" name="id" hidden>
                                        <input type="text" class="form-control" id="edit-name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="edit-email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact:</label>
                                        <input type="phone" class="form-control" id="edit-contact" name="contact"
                                            minlength="10" maxlength="10" placeholder="+91">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" id="edit-address" name="address">
                                    </div>
                                    <button type="submit" id="editSubmitBtn"
                                        class="btn btn-primary btn-block">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            //fetching users information
            function loadTable() {
                $.ajax({
                    url: "fetchUsers.php",
                    type: "GET",
                    success: function (data) {
                        if (data.status == false || data.length == 0) {
                            //if there is no user appending a message to the table
                            $('#load-table').append(
                                "<tr><td colspan='6'><h2>" + data.message + "</h2></td></tr>"
                            );
                        } else {
                            // Empty the table before appending new data
                            $('#load-table').empty();
                            $.each(data, function (key, value) {
                                $('#load-table').append(
                                    "<tr>" +
                                    "<td>" + value.id + "</td>" +
                                    "<td>" + value.name + "</td>" +
                                    "<td>" + value.email + "</td>" +
                                    "<td>" + value.contact + "</td>" +
                                    "<td>" + value.address + "</td>" +
                                    "<td>" +
                                    "<button class='btn btn-sm btn-warning update-btn' data-id='" + value.id + "' data-name='" + value.name + "' data-email='" + value.email + "' data-contact='" + value.contact + "' data-address='" + value.address + "' data-toggle='modal' data-target='#update-modal'>Update</button>" +
                                    "<button class='btn btn-sm btn-danger ml-3' data-id='" + value.id + "'>Delete</button>" +
                                    "</td>" +
                                    "</tr>"
                                );
                            });

                        };
                    }
                });
            }
            loadTable();

            //function to convert form data to jsonData format
            function objToJsonData(targetForm){
                var arr = $(targetForm).serializeArray();
            }

            //Add users information to the database table
            $("#create-form").submit(function (e) {
                e.preventDefault();
                //grabbing the value from the input field corresponding to the id
                let name = $("#nameInput").val();
                let email = $("#emailInput").val();
                let contact = $("#contactInput").val();
                let address = $("#addressInput").val();

                let formData = {
                    'name': name,
                    'email': email,
                    'contact': contact,
                    'address': address
                };

                $.ajax({
                    url: "addUser.php",
                    type: "POST",
                    data: JSON.stringify(formData),
                    dataType: "json",
                    success: function (data) {
                        if (data.status == true) {
                            loadTable();
                            document.getElementById('create-form').reset();
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });

            //delete users information
            $('#load-table').on('click', '.btn-danger', function () {
                var userId = $(this).data('id');
                var obj = {
                    id: userId
                }
                var jsonData = JSON.stringify({
                    'id': userId
                });
                var row = this;
                console.log(jsonData);
                $.ajax({
                    url: "deleteUser.php",
                    type: "DELETE",
                    data: jsonData,
                    dataType: "json",
                    success: function (data) {
                        if (data.status == true) {
                            loadTable();
                            alert(data.message);
                            $(row).closest('tr').fadeOut();
                        } else {
                            alert(data.message);

                        }
                    }
                })
            });

            
        });
    </script>
</body>

</html>