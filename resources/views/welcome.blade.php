@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 bg-light mb-3 shadow-sm">
                <status-form></status-form>
            </div>
            <status-list></status-list>
        </div>
    </div>
</div>

@endsection