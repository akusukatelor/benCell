@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Profile Image -->
    <div class="col-md-3">
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="{{ $user->profile_photo_url }}"
                 alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ $user->name }}</h3>
          <p class="text-muted text-center">{{ $user->role ?? 'User' }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Followers</b> <a class="float-right">1,322</a>
            </li>
            <li class="list-group-item">
              <b>Following</b> <a class="float-right">543</a>
            </li>
            <li class="list-group-item">
              <b>Friends</b> <a class="float-right">13,287</a>
            </li>
          </ul>

          <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
        </div>
      </div>
    </div>

    <!-- Profile Details -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">

            <!-- Activity Tab -->
            <div class="active tab-pane" id="activity">
              <div class="post">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="{{ $user->profile_photo_url }}" alt="user image">
                  <span class="username">
                    <a href="#">{{ $user->name }}</a>
                  </span>
                  <span class="description">Shared publicly - {{ now()->format('H:i') }}</span>
                </div>
                <p>
                  Selamat datang di profil Anda!
                </p>
              </div>
            </div>

            <!-- Timeline Tab -->
            <div class="tab-pane" id="timeline">
              <div class="timeline timeline-inverse">
                <div class="time-label">
                  <span class="bg-danger">{{ now()->format('d M. Y') }}</span>
                </div>
                <div>
                  <i class="fas fa-envelope bg-primary"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> {{ now()->format('H:i') }}</span>
                    <h3 class="timeline-header"><a href="#">System</a> mengirimkan notifikasi</h3>
                  </div>
                </div>
              </div>
            </div>

            <!-- Settings Tab -->
            <div class="tab-pane" id="settings">
              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif

              <form class="form-horizontal" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputName" value="{{ old('name', $user->name) }}" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPhoto" class="col-sm-2 col-form-label">Foto Profil</label>
                  <div class="col-sm-10">
                    <input type="file" name="photo" class="form-control" id="inputPhoto">
                    @if($user->profile_photo_path)
                        <img src="{{ $user->profile_photo_url }}" alt="Profile" width="100" class="mt-2">
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Simpan</button>
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
