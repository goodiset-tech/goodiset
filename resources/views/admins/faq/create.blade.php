@extends('admins.master')

@section('title', 'Create FAQ')

@section('faq', 'active')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Create New FAQ</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('admins.faq.store') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label>Question</label>
                            <textarea name="question" class="form-control @error('question') is-invalid @enderror">{{ old('question') }}</textarea>
                            @error('question')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea name="answer" rows="4" class="form-control @error('answer') is-invalid @enderror">{{ old('answer') }}</textarea>
                            @error('answer')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Question Ar</label>
                            <textarea name="question_ar" dir="rtl" class="form-control @error('question_ar') is-invalid @enderror">{{ old('question_ar') }}</textarea>
                            @error('question')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Answer Ar</label>
                            <textarea name="answer_ar" dir="rtl" rows="4" class="form-control @error('answer_ar') is-invalid @enderror">{{ old('answer_ar') }}</textarea>
                            @error('answer')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Page</label>
                            <select name="page" class="form-control @error('page') is-invalid @enderror">
                                <option value="general" {{ old('page') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="stores" {{ old('page') == 'stores' ? 'selected' : '' }}>Stores</option>
                                <option value="retailers" {{ old('page') == 'retailers' ? 'selected' : '' }}>Retailers & Resellers</option>
                                <option value="partners" {{ old('page') == 'partners' ? 'selected' : '' }}>Partners</option>
                                <option value="influencers" {{ old('page') == 'influencers' ? 'selected' : '' }}>Influencers</option>
                                <option value="celebration" {{ old('page') == 'celebration' ? 'selected' : '' }}>Celebration</option>
                                <option value="corporate-events" {{ old('page') == 'corporate-events' ? 'selected' : '' }}>Corporate Events</option>
                            </select>
                            @error('page')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save FAQ</button>
                        <a href="{{ route('admins.faq') }}" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection