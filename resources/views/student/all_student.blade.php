<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Material Design for Bootstrap fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <!-- Material Design for Bootstrap CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <title>Ajax ToDo list with multiple data</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
              <input type="hidden" value="{{ csrf_token() }}" id="token">
          <div class="card" style="width: 100%;">
            <div class="card-header">
              <h5 class="font-weight-bold">Ajax To-Do List With Multiple Data  <a href="#" class="float-right pr-3" id="addNew" data-toggle="modal" data-target="#showModal"><i class="fas fa-plus"></i></a></h5>
            </div>
            <div class="card-body">
              
              <table class="table" id="refresh_data">
                <thead class="thead-light">
                  <tr>
                    <th scope="col-3">Id</th>
                    <th scope="col-3">Name</th>
                    <th scope="col-3">Email</th>
                    <th scope="col-3">Mobile</th>
                  </tr>
                </thead>
                <tbody >
                  @foreach( $students as $single_student)
                  <tr class="ourStudent" data-toggle="modal" data-target="#showModal" >
                    <th>{{ $single_student->id }}</th>
                    <td id="student_name{{ $single_student->id }}">{{ $single_student->name }}</td>
                    <td id="student_email{{ $single_student->id }}">{{ $single_student->email }}</td>
                    <td id="student_mobile{{ $single_student->id }}">{{ $single_student->mobile }}</td>
                    <input type="hidden" id="findId" value="{{ $single_student->id }}">
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
      
      <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Student Registation Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="studentForm">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" autocomplete="off" class="form-control is-filled" id="name" name="name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="Mobile">Mobile No.</label>
                    <input type="text" autocomplete="off" class="form-control" id="mobile" name="mobile">
                  </div>
                </div>
               
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="email">Email</label>
                    <input type="email" autocomplete="off" class="form-control" id="email" name="email">
                  </div>
                </div>
                 <input type="hidden" id="id">
              
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="save_change">Save changes</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete">Delete</button>
              <input type="submit" class="btn btn-primary" id="addNewButton" value="Save">
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.min.js"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
    <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
    <script>
        //*********************************
        // All Student Show Section
        //*********************************
        $(document).on('click', '.ourStudent', function() {
            var findid = $(this).find('#findId').val();
            var name = $('#student_name' + findid).text();
            var mobile = $('#student_mobile' + findid).text();
            var email = $('#student_email' + findid).text();
            $('#id').val(findid);
            $('#name').val(name);
            $('#mobile').val(mobile);
            $('#email').val(email);
            $('#addNewButton').hide();
            $('#save_change').show();
            $('#delete').show();
        });


        //*********************************
        // Create Form
        //*********************************
        $(document).on('click', '#addNew', function() {
            $('#addNewButton').show();
            $('#save_change').hide();
            $('#delete').hide();
            var name = $('#name').val('');
            var mobile = $('#mobile').val('');
            var email = $('#email').val('');
        });

        //*********************************
        // Create Section
        //*********************************

          $('#addNewButton').click(function(){
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var email = $('#email').val();
            var token = $('#token').val();
            $.ajax({
                type: 'post',
                url: "{{ url('create') }}",
                data: {
                    'name': name,
                    'mobile': mobile,
                    'email': email,
                    '_token': token
                },
                success: function(data) {
                    $('#refresh_data').load(location.href + ' #refresh_data');
                }
            })
        });

        //*********************************
        // Delete Item With Ajax
        //*********************************
        $('#delete').click(function() {
            var id = $('#id').val();
            var token = $('#token').val();
            $.ajax({
                type: 'post',
                url: "{{ url('delete')}}",
                data: {
                    'id': id,
                    '_token': token,
                },
                success: function(data) {
                    $('#refresh_data').load(location.href + '  #refresh_data');
                }
            })
        });

        //*********************************
        // Update Item with Ajax
        //*********************************
        $('#save_change').click(function() {
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var email = $('#email').val();
            var token = $('#token').val();
            var id = $('#id').val();

            $.ajax({
                type: 'post',
                url: "{{ url('update')}}",
                data: {
                    'name': name,
                    'mobile': mobile,
                    'email': email,
                    'id': id,
                    '_token': token
                },
                success: function(data) {
                    $('#refresh_data').load(location.href + '  #refresh_data');
                }
            })
        })
    </script>

    <script>
        $(function() {
        //*********************************
        // Validation Massage Show Section
        //*********************************

            $.validator.setDefaults({
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .addClass('has-error bmd-form-group is-focused is-filled');
                },
                unhighlight: function(element) {
                    $(element)
                        .closest('.form-group')
                        .removeClass('has-error');
                },

            });
          //*********************************
          // Mobile Number Validation
          //*********************************
            $("#mobile").mask("(999) 9999-9999");

          //*********************************
          // Mobile Number Validation
          //*********************************
            $('#studentForm').validate({

          //*********************************
          // validation type
          //*********************************
                rules: {
                    name: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                },

          //*********************************
          // Validation Message
          //*********************************
                messages: {
                    name: {
                        required: 'Please Give Your Name',
                    },
                    mobile: {
                        required: 'Please Give Mobile Number',
                    },
                    email: {
                        required: 'Please give an <b>email</b>',
                        email: 'Please give an valid <b>email</b>',
                    },
                }
            });
        });
    </script>
  </body>
</html>