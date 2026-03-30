@extends('admins.master')

@section('roles', 'active')

@section('title', 'Roles')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Role Form</h5>
                    </div>

                    <div class="ibox-content">
                        <form action="{{ route('admins.roles.store') }}" class="form-horizontal" method="post">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <label for="Name">Role Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Name">
                            </div>

                            <label>Role Permissions:</label><br><br>
                            <label>
                                <input type="checkbox" id="selectAll"> Select All
                            </label>
                            <br>
                            <table border="1" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Sr#</th>
                                        <th style="text-align: center;">Module</th>
                                        <th style="text-align: center;">Create</th>
                                        <th style="text-align: center;">Read</th>
                                        <th style="text-align: center;">Update</th>
                                        <th style="text-align: center;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td style="text-align: center;">{{ $no++ }}</td>
                                            <td style="text-align: center;">{{ ucfirst($module) }}</td>
                                            @foreach (['create', 'read', 'update', 'delete'] as $action)
                                                <td style="text-align: center;">
                                                    @php
                                                        // Find the specific permission
                                                        $permission = $permissions
                                                            ->where('module_name', $module)
                                                            ->where('action', $action)
                                                            ->first();
                                                    @endphp
                                                    @if ($permission)
                                                        <input type="checkbox" name="permissions[]"
                                                            class="permission-checkbox" value="{{ $permission->id }}">
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table><br><br>
                            <button type="submit" class="btn btn-primary">Create Role</button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection
