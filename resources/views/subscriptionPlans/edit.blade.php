@extends('layouts.dashboard')

@section('title')
    Edit {{$content['name']}} - 
@endsection

@section('pageTitle')
    Edit {{$content['name']}}
@endsection

@section('content')

<div class="container">
    <div class="col">
        <form action="{{ route('subscriptionPlanUpdate', ['id' => $id]) }}" method="POST">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') ? old('name') : $content['name'] }}">
                        @error('name')
                            <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                        @enderror
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') ? old('description') : $content['description'] }}</textarea>
                            @error('description')
                                <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="benefits">Benefits (separated by ,)</label>
                            <textarea class="form-control" id="benefits" name="benefits" rows="3">{{ old('benefits') ? old('benefits') : $content['benefits'] }}</textarea>
                            @error('benefits')
                                <div class="alert alert-danger py-2 my-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="public">Select visibility</label><br>

                            <select name="public" class="custom-select" onchange="switchVideoOption()" id="platform">
                                <option value="0" @if (old('public') == 0 || $content['public'] == 0) selected @endif>Private</option>
                                <option value="1" @if (old('public') == 1 || $content['public'] == 1) selected @endif>Public</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-primary my-2">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
