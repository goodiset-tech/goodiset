@extends('admins.master')

@section('title', 'FAQ')

@section('faq', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FAQ's List</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('admins.faq.create') }}" class="btn btn-primary btn-xs">Add New FAQ</a>
                    </div>
                </div>
                <div class="ibox-content">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover faq-table">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr = 1; @endphp
                                @foreach ($faqs as $faq)
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ Str::limit($faq->answer, 50) }}</td>
                                        <td>
                                            <span class="badge {{ $faq->status ? 'badge-primary' : 'badge-danger' }}">
                                                {{ $faq->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admins.faq.edit', $faq->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="javascript:void(0)" data-href="{{ route('admins.faq.destroy', $faq->id) }}" 
                                               class="btn btn-danger btn-sm delete_record">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.faq-table').DataTable({
        pageLength: 25,
        responsive: true
    });

    $(document).on('click', '.delete_record', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to delete this FAQ?')) {
            window.location = $(this).data('href');
        }
    });
});
</script>
@endpush