@extends('adminlte::page')

@section('title', 'Edit Siswa')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Siswa</h1>
            </div>
            <div class="col-sm-6">
                <div class="breadcrumb float-sm-right">
                    {{-- {{ Breadcrumbs::render('siswa.edit', $user) }} --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Identitas Akun Siswa</h3>
                    </div>
                    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['siswa.update', $user->id], 'files' => true]) !!}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            {!! Form::text('name', null, ['placeholder' => 'Nama Lengkap', 'id' => 'name', 'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null), 'required']) !!}
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            {!! Form::text('username', null, ['placeholder' => 'Username', 'id' => 'username', 'class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : null), 'required']) !!}
                            @error('username')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="telp">Nomor Telephon / HP</label>
                            {!! Form::text('telp', null, ['placeholder' => 'Nomor Telephon / HP', 'id' => 'telp', 'class' => 'form-control' . ($errors->has('telp') ? ' is-invalid' : null), 'required']) !!}
                            @error('telp')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            {!! Form::text('email', null, ['placeholder' => 'Email', 'id' => 'email', 'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : null), 'required']) !!}
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            {!! Form::password('password', ['placeholder' => 'Password', 'id' => 'password', 'class' => 'form-control']) !!}
                            <span>Kosongkan apabila tidak ingin ada perubahan</span>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm Password</label>
                            {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'id' => 'confirm-password', 'class' => 'form-control']) !!}
                            <span>Kosongkan apabila tidak ingin ada perubahan</span>
                        </div>
                        {{-- <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
