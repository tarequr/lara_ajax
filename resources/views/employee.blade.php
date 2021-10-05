<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laravel Ajax CURD</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">

	<script type="text/javascript" src="{{ asset('js/sweetalert2@11.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

</head>
<body>
	<div class="container">
		<div style="margin-top: 50px;">
			<h1 class="text-center">Laravel Ajax CURD</h1>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-sm-8">
				<div class="card">
					<div class="card-header">
						<span>All Employee</span>
					</div>
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Name</th>
									<th scope="col">Designation</th>
									<th scope="col">Address</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<!-- jquey ajax -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<span id="addEmployee">Add Employee</span>
						<span id="updateEmployee">Update Employee</span>
					</div>
					<div class="card-body">
						<div class="form-group">
							<label class="form-label">Name</label>
							<input type="text" id="name" class="form-control" placeholder="Enter name">
							<strong class="text-danger" id="nameError"></strong>
						</div>
						<div class="form-group mt-3">
							<label class="form-label">Designation</label>
							<input type="text" id="designation" class="form-control" placeholder="Enter designation">
							<strong class="text-danger" id="designationError"></strong>
						</div>
						<div class="form-group mt-3">
							<label class="form-label">Address</label>
							<input type="text" id="address" class="form-control" placeholder="Enter address">
							<strong class="text-danger" id="addressError"></strong>
						</div>
						<div class="form-group mt-4">
							<!-- catch employee id-->
							<input type="hidden" id="id">

							<button type="submit" id="saveBtn" onclick="addData();" class="btn btn-sm btn-primary">Save</button>
							<button type="submit" id="updateBtn" onclick="updateData();" class="btn btn-sm btn-primary">Update</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
	<script>
		$('#addEmployee').show();
		$('#updateEmployee').hide();
		$('#saveBtn').show();
		$('#updateBtn').hide();

		//ajax setup
		$.ajaxSetup({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		})

		/************ start get all data  from database ************/
		function allData(){
			$.ajax({
				type: "get",
				dataType: "json",
				url: "/employee/all-data",
				success: function(employees){
					let data = "";

					$.each(employees, function(key, value){
						data = data + "<tr>"
						data = data + "<td>"+ (key+1) +"</td>"
						data = data + "<td>"+ value.name +"</td>"
						data = data + "<td>"+ value.designation +"</td>"
						data = data + "<td>"+ value.address +"</td>"
						data = data + "<td width='18%'>"
						data = data + "<button type='submit' class='btn btn-sm btn-info' style='margin-right: 5px;' onclick='editData("+value.id+");'>Edit</button>"
						data = data + "<button type='submit' class='btn btn-sm btn-danger' onclick='deleteData("+value.id+");'>Delete</button>"
						data = data + "</td>"
						data = data + "</tr>"
					})

					$('tbody').html(data);
				}
			})
		}

		allData();

		/************ end all data  from database ************/

		/************ start clear html input tag data ************/
 		function clearValue() {
 			$('#name').val('');
			$('#designation').val('');
			$('#address').val('');

			//Error field is null
			$('#nameError').text('');
			$('#designationError').text('');
			$('#addressError').text('');
 		}
 		/************ end clear html input tag data ************/

		/************ start store data ************/
		function addData(){
			let name = $('#name').val();
			let designation = $('#designation').val();
			let address = $('#address').val();

			let formData = {
				name:name,
				designation:designation,
				address:address
			}

			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/employee/store",
				data: formData,
				success: function(data){
					clearValue();
					allData();

					/****** start sweetalert2 msg ******/
					let Msg = Swal.mixin({
						toast: true,
					    position: 'top-end',
					    icon: 'success',
					    showConfirmButton: false,
					    timer: 1500
					})

					Msg.fire({
					  type: 'success',
					  title: 'Data create successfully!',
					})
					/****** end sweetalert2 msg ******/		
				},
				error: function(error){
					$('#nameError').text(error.responseJSON.errors.name);
					$('#designationError').text(error.responseJSON.errors.designation);
					$('#addressError').text(error.responseJSON.errors.address);
				}
			})
		}
		/************ end store data ************/

		/************ start edit data ************/
		function editData(id) {
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "/employee/edit/"+id,
				success: function (data) {
					$('#addEmployee').hide();
					$('#updateEmployee').show();
					$('#saveBtn').hide();
					$('#updateBtn').show();

					$('#id').val(data.id);
					$('#name').val(data.name);
					$('#designation').val(data.designation);
					$('#address').val(data.address);
				}
			});
		}
		/************ end edit data ************/

		/************ start update data ************/
		function updateData() {
			let id = $('#id').val();
			let name = $('#name').val();
			let designation = $('#designation').val();
			let address = $('#address').val();

			let formData = {
				name:name,
				designation:designation,
				address:address
			}

			$.ajax({
				type: "PUT",
				dataType: "json",
				url:"/employee/update/"+id,
				data: formData,
				success: function(data) {
					$('#addEmployee').show();
					$('#updateEmployee').hide();
					$('#saveBtn').show();
					$('#updateBtn').hide();

					clearValue();
					allData();

					/****** start sweetalert2 msg ******/
					let Msg = Swal.mixin({
						toast: true,
					    position: 'top-end',
					    icon: 'success',
					    showConfirmButton: false,
					    timer: 1500
					})

					Msg.fire({
					  type: 'success',
					  title: 'Data update successfully!',
					})
					/****** end sweetalert2 msg ******/
				},
				error: function(error){
					$('#nameError').text(error.responseJSON.errors.name);
					$('#designationError').text(error.responseJSON.errors.designation);
					$('#addressError').text(error.responseJSON.errors.address);
				}
			})
		}
		/************ end update data ************/

		/************ start delete data ************/
		function deleteData(id) {
			Swal.fire({
			  title: 'Are you sure?',
			  text: "You won't be able to revert this!",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
			  if (result.isConfirmed) {

			  	//ajax delete start
			    $.ajax({
					type: "POST",
					dataType: "json",
					url:"/employee/destroy/"+id,
					success:function(data){
						$('#addEmployee').show();
						$('#updateEmployee').hide();
						$('#saveBtn').show();
						$('#updateBtn').hide();

						clearValue();
						allData();

						/****** start sweetalert2 msg ******/
						let Msg = Swal.mixin({
							toast: true,
						    position: 'top-end',
						    icon: 'success',
						    showConfirmButton: false,
						    timer: 1500
						})

						Msg.fire({
						  type: 'success',
						  title: 'Data delete successfully!',
						})
						/****** end sweetalert2 msg ******/
						
					}
				})
				//ajax delete end

			  	}

			})			
		}
		/************ end delete data ************/
	</script>
</body>
</html>