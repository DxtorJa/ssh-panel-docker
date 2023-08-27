@extends('layouts.master')
@section('title', $user->name . '\'s Profile')
@section('body')

    <!-- Title Page Section -->
    <div class="block-header">
        <h2>USER PROFILE</h2>
    </div>
    <!-- End Title Page Section -->

    <!-- Simple Widget -->
    <div class="row clearfix">

        <div class="col-lg-12">
            @if($errors->count() > 0)
                <div class="alert alert-danger">
                    <h4>Please fix error below!</h4>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                </div>
            @endif
            @if(isset($success))
                <div class="alert alert-success">
                    {{$success}}
                </div>
            @endif
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4 col-md-4">
            <div class="card">
                <div class="body">
                    <div class="text-center">
                        <img style="width:100%;height:100%;" src="{{$user->images}}" class="img-rounded img-responsive">
                        <hr />
                        
                        <form method="post" action="/profile/change-image" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <input type="file" class="form-control" name="images">
                            <br />
                            <button type="submit" class="btn btn-success">CHANGE IMAGE</button>
                    
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-sm-12 col-xs-12 col-md-8">
            <div class="card">
                <div class="header">
                    <h2>
                        CHANGE ACCOUNT DETAILS
                    </h2>
                </div>
                <div class="body">
                    <form method="post" id="change-details">

                        {{csrf_field()}}

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="{{$user->name}}" name="username" id="username">
                                        <label class="form-label">Username</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" value="{{$user->email}}" name="email" id="email">
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="password" id="password">
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success text-center pull-right" style="width: 40%;" id="btn-change-details" onclick="changeDetails();">SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        YOUR SSH ACCOUNT
                    </h2>
                </div>
                <div class="body">
                    @if($sshs->count() < 1)
                        <h1 class="text-center">NO ACCOUNT FOUND</h1>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>USERNAME</th>
                                        <th>AT SERVER</th>
                                        <th>CREATED AT</th>
                                        <th>EXPIRED ON</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($sshs as $ssh)
                                        <tr id="row-{{$ssh->id}}">
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{$ssh->username}}</td>
                                            <td>{{$ssh->at_server}}</td>
                                            <td>{{$ssh->created_at->diffForHumans()}}</td>
                                            <td>{{\Carbon\Carbon::parse($ssh->expired_on)->diffForHumans()}}</td>
                                            <td>
                                                @if($user->role == 'admin')
                                                    @if($ssh->status == 'locked')
                                                        <button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockSSHAccount({{$ssh->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
                                                    @else
                                                        <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockSSHAccount({{$ssh->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
                                                    @endif
                                                    <button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Account" onclick="removeSSHAccount({{$ssh->id}})"><i class="material-icons" id="delete-account">delete</i></button>
                                                    <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Password" onclick="changeSSHPassword({{$ssh->id}})"><i class="material-icons" id="edit-account">vpn_key</i></button>
                                                @else
                                                    @if($ssh->status == 'locked')
                                                        <button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockSSHAccount({{$ssh->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
                                                    @else
                                                        <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockSSHAccount({{$ssh->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
                                                    @endif
                                                    <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Password" onclick="changeSSHPassword({{$ssh->id}})"><i class="material-icons" id="edit-account">vpn_key</i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        YOUR VPN ACCOUNT
                    </h2>
                </div>
                <div class="body">
                    @if($vpns->count() < 1)
                        <h1 class="text-center">NO ACCOUNT FOUND</h1>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>USERNAME</th>
                                        <th>AT SERVER</th>
                                        <th>CREATED AT</th>
                                        <th>EXPIRED ON</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($vpns as $vpn)
                                        <tr id="row-{{$vpn->id}}">
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{$vpn->username}}</td>
                                            <td>{{$vpn->at_server}}</td>
                                            <td>{{$vpn->created_at->diffForHumans()}}</td>
                                            <td>{{\Carbon\Carbon::parse($vpn->expired_on)->diffForHumans()}}</td>
                                            <td>
                                                @if($user->role == 'admin')
                                                    @if($vpn->status == 'locked')
                                                        <button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockVPNAccount({{$vpn->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
                                                    @else
                                                        <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockVPNAccount({{$vpn->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
                                                    @endif
                                                    <button class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Account" onclick="removeVPNAccount({{$vpn->id}})"><i class="material-icons" id="delete-account">delete</i></button>
                                                    <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Password" onclick="changeVPNPassword({{$vpn->id}})"><i class="material-icons" id="edit-account">vpn_key</i></button>
                                                @else
                                                    @if($vpn->status == 'locked')
                                                        <button class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Unlock Account" onclick="unlockVPNAccount({{$vpn->id}})" id="unlock-account"><i class="material-icons" id="unlock-account">lock_open</i></button>
                                                    @else
                                                        <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Lock Account" onclick="lockVPNAccount({{$vpn->id}})" id="lock-account"><i class="material-icons" id="lock-account">lock</i></button>
                                                    @endif
                                                    <button class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Change Password" onclick="changeVPNPassword({{$vpn->id}})"><i class="material-icons" id="edit-account">vpn_key</i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        YOUR DNS
                    </h2>
                </div>
                <div class="body">
                    @if($dns->count() < 1)
                        <h1 class="text-center">NO DNS RECORD FOUND</h1>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SUBDOMAIN</th>
                                        <th>POINTED TO</th>
                                        <th>CREATED AT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($dns as $zone)
                                        <tr id="row-{{$zone->id}}">
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{$zone->subdomain}}</td>
                                            <td>{{$zone->pointed_to}}</td>
                                            <td>{{$zone->created_at->diffForHumans()}}</td>
                                            <td>
                                                <button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete Records" onclick="deleteRecord({{$zone->id}})"><i class="material-icons">delete</i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Simple Widget -

@endsection