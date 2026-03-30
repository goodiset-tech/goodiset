@extends('layout.app')

@section('content')
    <form action="{{ route('import.products') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="file">Choose Excel File:</label>
            <input type="file" name="file" id="file" required>
        </div>
        <button type="submit">Import</button>
    </form>
@endsection
