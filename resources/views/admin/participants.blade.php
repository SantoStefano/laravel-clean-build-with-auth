@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <x-participants-table :participants="$participants" :export-route="route('admin.participants.export')" />
        </div>
    </div>
@endsection