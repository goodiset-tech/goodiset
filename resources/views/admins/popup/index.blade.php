@extends('admins.master')

@section('title', 'Popup Management')

@section('popup_active', 'active') <!-- Adjust based on your sidebar menu -->

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Popup Form</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('admins.popup.store') }}">
                            @csrf
                            <div class="form-group">
                                <label class="control-label" style="margin-left: 15px">Popup Image</label>
                                <div class="col-lg-12">
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    @if (isset($popup->image))
                                        <img src="{{ asset($popup->image) }}" alt="Current Popup" style="max-width: 200px; margin-top: 10px;">
                                    @endif
                                    @error('image')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" style="margin-left: 15px">Start Date</label>
                                <div class="col-lg-12">
                                    <input type="date" name="start_date" class="form-control" value="{{ isset($popup->start_date) ? $popup->start_date : '' }}" required>
                                    @error('start_date')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" style="margin-left: 15px">End Date</label>
                                <div class="col-lg-12">
                                    <input type="date" name="end_date" class="form-control" value="{{ isset($popup->end_date) ? $popup->end_date : '' }}" required>
                                    @error('end_date')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" style="margin-left: 15px">Status</label>
                                <div class="col-lg-12">
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ isset($popup->status) && $popup->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ isset($popup->status) && $popup->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" style="margin-left: 15px"></label>
                                <div class="col-lg-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><strong>Save</strong></button>
                                    {{-- @if (isset($popup->id))
                                        <a href="javascript:void(0)" data-href="{{ route('admins.popup.delete') }}" class="btn btn-sm btn-danger delete_record">Delete</a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete_record').click(function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this popup?')) {
                    $.ajax({
                        url: $(this).data('href'),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            window.location.href = '{{ route('admins.popup') }}';
                        },
                        error: function(xhr) {
                            alert('Error deleting popup.');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection