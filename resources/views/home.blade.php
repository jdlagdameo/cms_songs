@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Dashboard</a>
            </li>
        </ol>
        <div class="row">
            <div class="col-12">
                <h1>Dashboard</h1>
                <p>Welcome {{Auth()->user()->name}}.</p>
            </div>
        </div>
    </div>
@endsection
