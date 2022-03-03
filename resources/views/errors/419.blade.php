@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('pageContent')
<div align="center">
    <h5><b>It seems your session has Expired !</b></h5>
    <br />
    <a href="{{Route::has('login') ? Route('login') : 'javascript:;' }}" class="btn btn-info">Login now and continue</a>
</div>
@endsection

