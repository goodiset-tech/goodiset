@extends('admins.master')

@section('roles', 'active')

@section('title', 'Demand Detail')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="card-header flex-column flex-md-row border-bottom p-0">
                            <div class="row m-0 pb-2 mb-2">
                                <div class="col-lg-6 col-sm-12 p-0">
                                    <div class="head-label">
                                        <h5 class="card-title mb-0 pt-2">Update Role</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <form action="{{ route('admins.roles.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-floating form-floating-outline mb-3">
                                    <label for="Name">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        {{ $role->name == 'Super Admin' ? 'readonly' : '' }} value="{{ $role->name }}"
                                        placeholder="Enter Name">
                                    
                                </div>

                                <label>Role Permissions:</label></br>
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
                                            {{-- Loop through modules instead --}}
                                            <tr>
                                                <td style="text-align: center;">{{$no++}}</td>
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
                                                                class="permission-checkbox" value="{{ $permission->id }}"
                                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table></br></br>

                                <div class="col-sm-12 mt-3">
                                    <button type="submit" class="btn btn-primary">Update Role</button>
                                </div>

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
