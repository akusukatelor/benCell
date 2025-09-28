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
                 src="{{ asset('dist/img/user4-128x128.jpg') }}"
                 alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">Nama User</h3>
          <p class="text-muted text-center">Software Engineer</p>

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
            <div class="active tab-pane" id="activity">
              <!-- Post -->
              <div class="post">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="user image">
                  <span class="username">
                    <a href="#">Jonathan Burke Jr.</a>
                  </span>
                  <span class="description">Shared publicly - 7:45 PM today</span>
                </div>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                </p>
              </div>
              <!-- /.post -->
            </div>

            <div class="tab-pane" id="timeline">
              <div class="timeline timeline-inverse">
                <div class="time-label">
                  <span class="bg-danger">10 Feb. 2025</span>
                </div>
                <div>
                  <i class="fas fa-envelope bg-primary"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> 12:05</span>
                    <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="settings">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
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
