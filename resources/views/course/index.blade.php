@extends('layouts.app')


@section('content')

    @include('Admin.flash-message')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: red;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: green;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px green;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .modal {
            top: 54px !important;
        }

        @media (max-width: 575.98px) {
            /* Add a class to the table container to make it responsive */
            .responsive-table {
                overflow-x: auto;
            }

            .modal {
                width: 192% !important;
            }
        }
    </style>
    <main class="app-content {{user_theme_get()}}">
        <div class="app-title">

            <div>
                <h1><i class="fa fa-th-list"></i>Show All Courses</h1>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 float-right mb-5">
            <span class="pull-right float-right">&nbsp;
                <button type="button" class="btn btn-sm btn-shadow btn-outline-primary btn-hover-shine"
                        data-bs-toggle="modal"
                        data-bs-target="#add_course">
 + Add
                </button></span>

                <!-- Modal -->
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body sortableTable__container table-responsive" id="my_report">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Course Name</th>
                                <th>Institution Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($courses as $key => $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if(isset($course->resume_name))
                                            {{ $course->resume_name->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>{{ $course->institution_name }}</td>
                                    <td>{{ $course->start_date }}</td>
                                    <td>{{ $course->end_date }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="statuss"
                                                   data-id="{{$course->id}}"
                                                   id="statusToggle" {{ $course->status === 'active' ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-shadow btn-outline-info btn-hover-shine checkbox-edit"
                                                data-bs-toggle="modal"
                                                data-disable_date="{{$course->id}}"
                                                data-bs-target="#edit_course{{$course->id}}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-shadow btn-outline-danger btn-hover-shine delete-course"
                                            data-delete-id="{{ $course->id }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i></button>
                                        {{--                                        {!! Form::open(['method' => 'DELETE','route' => ['course.destroy', $course->id],'style'=>'display:inline','onclick' => "return confirm('Are you sure?')"]) !!}--}}
                                        {{--                                        {!! Form::submit('Delete', ['class' => 'btn btn-outline-danger']) !!}--}}
                                        {{--                                        {!! Form::close() !!}--}}
                                    </td>
                                </tr>

                                <!-- Edit course Modal -->
                                <div class="modal fade" id="edit_course{{$course->id}}"
                                     data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" style="max-width: 50%;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Courses</h5>
                                                <div class="submitter" style="
          font-family: 'Open Sans';
          font-size: 16px;
          font-weight: 700;
          color: #e60101;
          line-height: 29.96px;
          padding-bottom: 15px;
        ">
                                                    All fields are mandatory(*)
                                                </div>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="edit_form_{{ $course->id }}"
                                                      action="{{route('course.update',$course->id)}}"
                                                      method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @method('patch')


                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Employee Name</label><span
                                                                    class="text-danger"><b>*</b></span>
                                                                <select class="form-control" name="resume_id" id="">
                                                                    <option value="">---Select Employee Name---</option>
                                                                    @foreach($resumes as $resume)
                                                                        <option
                                                                            value="{{$resume->id}}" @if(isset($course)) {{$course->resume_id == $resume->id  ? 'selected' : ''}} @endif>{{$resume->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Course Name</label><span
                                                                    class="text-danger"><b>*</b></span>
                                                                <input type="text"
                                                                       class="form-control" id="course_name"
                                                                       value="{{$course->course_name}}"
                                                                       name="course_name"
                                                                       placeholder="Enter Course Name...">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Institution
                                                                    Name</label><span
                                                                    class="text-danger"><b>*</b></span>
                                                                <input type="text"
                                                                       class="form-control" id="institution_name"
                                                                       value="{{$course->institution_name}}"
                                                                       name="institution_name"
                                                                       placeholder="Enter Institution Name...">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Start Date</label>
                                                                <input type="month"
                                                                       class="form-control date" id="start_date"
                                                                       value="{{$course->start_date}}" max=""
                                                                       name="start_date">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">End Date</label><span
                                                                    class="text-danger check_box"><b>*</b></span>
                                                                <input type="month"
                                                                       class="form-control date"
                                                                       id="end_date_{{$course->id}}"
                                                                       value="{{$course->end_date}}"
                                                                       min="" name="end_date">

                                                                <input type="checkbox"
                                                                       class="checkbox-class check"
                                                                       data-enddate="end_date_{{$course->id}}"
                                                                       id="check_{{$course->id}}" value="1"
                                                                       name="check" @if(isset($course)) {{$course->check == 1  ? 'checked' : ''}} @endif>
                                                                <label class="control-label">Present</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Description</label>
                                                                <textarea class="form-control" name="description"
                                                                          id="">{{$course->description}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-sm btn-shadow btn-outline-secondary btn-hover-shine"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-shadow btn-outline-info btn-hover-shine update-btn"
                                                                data-resume-id="{{ $course->id }}">Update
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- Add Course Modal -->
        <div class="modal fade" id="add_course" data-bs-backdrop="static" data-bs-keyboard="false"
             tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Courses</h5>
                        <div class="submitter" style="
          font-family: 'Open Sans';
          font-size: 16px;
          font-weight: 700;
          color: #e60101;
          line-height: 29.96px;
          padding-bottom: 15px;
        ">
                            All fields are mandatory(*)
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add_form" action="{{route('course.store')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label">Employee Name</label><span
                                            class="text-danger"><b>*</b></span>
                                        <select class="form-control  @error('resume_id') is-invalid @enderror"
                                                name="resume_id" id="">
                                            <option value="">---Select Employee Name---</option>
                                            @foreach($resumes as $resume)
                                                <option value="{{$resume->id}}">{{$resume->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('resume_id')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label">Course Name</label><span
                                            class="text-danger"><b>*</b></span>
                                        <input type="text"
                                               class="form-control  @error('course_name') is-invalid @enderror"
                                               id="course_name"
                                               value=""
                                               name="course_name"
                                               placeholder="Enter Course Name...">
                                        @error('course_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label">Institution Name</label><span
                                            class="text-danger"><b>*</b></span>
                                        <input type="text"
                                               class="form-control  @error('institution_name') is-invalid @enderror"
                                               id="institution_name"
                                               value=""
                                               name="institution_name"
                                               placeholder="Enter Institution Name...">
                                        @error('institution_name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date</label><span
                                            class="text-danger"><b>*</b></span>
                                        <input type="month"
                                               class="form-control date  @error('start_date') is-invalid @enderror"
                                               id="start_date" value="{{old('start_date')}}"
                                               max="" name="start_date">
                                        @error('start_date')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label">End Date</label><span
                                            class="text-danger check_box"><b>*</b></span>
                                        <input type="month"
                                               class="form-control date  @error('end_date') is-invalid @enderror"
                                               id="end_date" value="{{old('end_date')}}"
                                               min="" name="end_date">

                                        <input type="checkbox"
                                               class="check" id="check" value="1"
                                               name="check">
                                        <label class="control-label">Present</label>
                                        @error('end_date')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" name="description" id=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button"
                                        class="btn btn-sm btn-shadow btn-outline-secondary btn-hover-shine"
                                        data-bs-dismiss="modal">Close
                                </button>
                                <button type="submit" id="submitBtn"
                                        class="btn btn-sm btn-shadow btn-outline-primary btn-hover-shine">Save changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <p class="text-center text-primary"><small>Developer Name :- <b style="color: red">Dushyant Chhatraliya</b></small>
    </p>
@endsection
@push('page_scripts')
    <script>
        $(document).ready(function () {
            $('#submitBtn').click(function (e) { // Change 'submitBtn' to the actual ID of your button
                e.preventDefault();
                var formData = new FormData($('#add_form')[0]); // Use the form ID 'add_form'

                $.ajax({
                    type: 'POST',
                    url: $('#add_form').attr('action'), // Use the form's action attribute
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#add_course').modal('hide'); // Close the modal
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Your record was created successfully.',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

                    },
                    error: function (xhr) {
                        // Handle validation errors (e.g., display error messages)
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];

                        for (var field in errors) {
                            errorMessages.push(errors[field][0]);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errorMessages.join('<br>') + '<br>', // Join error messages with <br> tags
                        });
                    }
                });
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            $('.update-btn').click(function (e) {
                e.preventDefault();

                // Get the resume ID from the data attribute
                var resumeId = $(this).data('resume-id');

                // Build the form selector dynamically based on the resume ID
                var formSelector = '#edit_form_' + resumeId;

                // Get the CSRF token value from the meta tag
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Add the CSRF token to the headers of the AJAX request
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                var formData = new FormData($(formSelector)[0]);

                $.ajax({
                    type: 'POST',
                    url: $(formSelector).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#edit_course' + resumeId).modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Update!',
                            text: 'Your record updated successfully.',
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];

                        for (var field in errors) {
                            errorMessages.push(errors[field][0]);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errorMessages.join('<br>') + '<br>',
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('.statuss').change(function () {
            var status = $(this).prop('checked') == true ? 'active' : 'De-Active';
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('courseStatus') }}',
                data: {'status': status, 'id': id},
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your status was updated successfully.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page
                        }
                    });

                }


            });
        })
    </script>
    <script>
        // Get references to the checkbox and the End Date input
        const checkbox = document.getElementById('check');
        const endDateInput = document.getElementById('end_date');

        // Add an event listener to the checkbox
        checkbox.addEventListener('click', function () {
            // If the checkbox is checked, disable the End Date input; otherwise, enable it
            endDateInput.disabled = checkbox.checked;

            // Clear the value of the End Date input if it's being disabled
            if (checkbox.checked) {
                endDateInput.value = '';
            }
        });
    </script>
    <script>
        // Get the current date
        const currentDate = new Date();

        // Get the current year and month as separate variables
        const currentYear = currentDate.getFullYear();
        const currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');

        // Create the maxDate value in YYYY-MM format
        const maxDate = `${currentYear}-${currentMonth}`;

        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            // Get all elements with the class name 'date'
            const elementsWithDateClass = document.querySelectorAll('.date');

            // Iterate over the elements and set the 'max' attribute for each one
            elementsWithDateClass.forEach(function (element) {
                element.setAttribute('max', maxDate);
            });
        });
    </script>


    {{--    Edit Time--}}
    <script>
        $(document).ready(function () {
            // Add an event listener to all checkboxes with the class 'checkbox-class'
            $('.checkbox-class').change(function () {
                // Find the associated end_date input using the 'data-enddate' attribute
                const endDateInput = $('#' + $(this).data('enddate'));
                // Check the state of the checkbox
                if ($(this).is(':checked')) {
                    // Checkbox is checked, disable the end_date input and clear its value
                    endDateInput.prop('disabled', true);
                    endDateInput.val('');
                } else {
                    // Checkbox is unchecked, enable the end_date input
                    endDateInput.prop('disabled', false);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.checkbox-edit').click(function () {
                // Get the corresponding checkbox and end_date input based on the data-resume-id attribute
                const resumeId = $(this).data('disable_date');
                const checkbox = $('#check_' + resumeId);
                const endDateInput = $('#end_date_' + resumeId);
                // Check the state of the checkbox
                if (checkbox.is(':checked')) {
                    // Checkbox is checked, disable the end_date input and clear its value
                    endDateInput.prop('disabled', true);
                    endDateInput.val('');
                } else {
                    // Checkbox is unchecked, enable the end_date input
                    endDateInput.prop('disabled', false);
                }

                // Close the modal
                $('#editModal' + resumeId).modal('hide');
            });
        });
    </script>

    {{--   Delete Record With Js --}}
    <script>
        $(document).ready(function () {
            // Add click event listener to the delete button
            $(document).on('click', '.delete-course', function () {
                var id = $(this).data('delete-id');

                // Show a SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send an AJAX request to delete the resource record
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('course.destroy', ['course' => 'id']) }}' + id,
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                // Handle the success response (e.g., reload the page or remove the deleted item from the DOM)
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Delete!',
                                    text: 'Your record deleted successfully.',
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
                            },
                            error: function (error) {
                                // Handle the error response (e.g., show an error message)
                                Swal.fire('Error', 'An error occurred while deleting the record.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{--  Check Box Click Required star hide/show  --}}
    <script>
        $(document).ready(function () {
            // Add an event listener to the checkbox
            $('.check').change(function () {
                if ($(this).is(':checked')) {
                    $('.check_box').hide(); // Hide the span when the checkbox is checked
                } else {
                    $('.check_box').show(); // Show the span when the checkbox is unchecked
                }
            });
        });

    </script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush
