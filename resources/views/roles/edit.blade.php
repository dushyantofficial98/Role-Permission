@extends('layouts.app')
@section('content')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            background-color: #31c3af;
            border: 1px solid #ced4da;
            border-radius: 2px;
            cursor: default;
            float: left;
            margin-right: 9px;
            margin-top: 7px;
            padding: 0 5px;
        }

        .select2-container--open .select2-dropdown--below {
            margin-top: -49px !important;
        }
    </style>
    <main class="app-content {{user_theme_get()}}">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Edit Role</h1>
                {{-- <p>Sample forms</p> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title"></h3>
                    <div class="tile-body">
                        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id],'id' => 'update_form']) !!}

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Name:</label>
                                <input name="name" type="text" value="{{$role->name}}"
                                       class="form-control @error('name') is-invalid @enderror" id="oldPasswordInput"
                                       placeholder="Enter Full Name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <select class="mul-select form-control @error('permission') is-invalid @enderror"
                                        name="permission[]" multiple="true">
                                    @foreach($permission as $value)
                                        <option
                                            value="{{$value->id}}" {{ in_array($value->id, $rolePermissions) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <br>
                    <button type="submit" id="editBtn" class="btn btn-sm btn-shadow btn-outline-info btn-hover-shine">
                        Update
                    </button>
                    <a href="{{route('roles.index')}}"
                       class="btn btn-sm btn-shadow btn-outline-secondary btn-hover-shine">Back</a>
                    {!! Form::close() !!}
                </div>


            </div>
        </div>


        </div>
    </main>



@endsection
@push('page_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".mul-select").select2({
                placeholder: "Select Permission",
                tags: true,
            });
        })
    </script>
    {{--  Edit User With Ajax  --}}
    <script>
        var usersRoute = "{{ route('roles.index') }}";
    </script>
    <script>
        $(document).ready(function () {
            $('#editBtn').click(function (e) { // Change 'submitBtn' to the actual ID of your button
                e.preventDefault();
                var formData = new FormData($('#update_form')[0]); // Use the form ID 'add_form'

                $.ajax({
                    type: 'POST',
                    url: $('#update_form').attr('action'), // Use the form's action attribute
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Your record was updated successfully.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Go back to the specific URL
                                window.location.href = usersRoute;

                            }
                        });

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
@endpush

