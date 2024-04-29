{{-- resources/views/test_toastr.blade.php --}}

@extends('layouts.app')

@section('content')
    <h1>Toastr Notification Tests</h1>
    <ul>
        <li><a href="/test-success">Trigger Success Notification</a></li>
        <li><a href="/test-error">Trigger Error Notification</a></li>
        <li><a href="/test-info">Trigger Info Notification</a></li>
        <li><a href="/test-warning">Trigger Warning Notification</a></li>
    </ul>
@endsection
