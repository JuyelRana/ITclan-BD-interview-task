@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="font-weight-bold">{{ $idea ? 'Edit': 'Add' }} Idea</h4>
                            </div>
                            <div class="col-md-6 row justify-content-end align-items-end">
                                <a class="btn btn-primary" href="{{ route('ideas.index') }}">
                                    Idea List
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                              action="{{ $idea ? route('ideas.update', $idea) : route('ideas.store') }}">
                            @csrf
                            @if($idea)
                                @method('PUT')
                            @endif


                            <div class="form-group row">

                                <label
                                    for="name"
                                    class="col-md-2 col-form-label text-md-right">
                                    Name
                                </label>

                                <div class="col-md-10">

                                    <input
                                        id="name"
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        value="{{ $idea ? $idea->name : old('name') }}"
                                        required
                                        placeholder="Enter name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <label
                                    for="email"
                                    class="col-md-2 col-form-label text-md-right">
                                    Email
                                </label>

                                <div class="col-md-10">

                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email"
                                        value="{{ $idea ? $idea->email : old('email') }}"
                                        required
                                        placeholder="Enter email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <label
                                    for="idea"
                                    class="col-md-2 col-form-label text-md-right">
                                    Idea
                                </label>

                                <div class="col-md-10">
                                    <textarea
                                        class="form-control @error('idea') is-invalid @enderror"
                                        name="idea"
                                        id="idea"
                                        required
                                        rows="4">{{ $idea ? $idea->idea : old('idea') }}</textarea>

                                    @error('idea')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-2 offset-md-10 row justify-content-end align-items-end">

                                    <a class="btn btn-secondary mr-2" href="{{ route('ideas.index') }}">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ $idea ? 'Update' : 'Add' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
