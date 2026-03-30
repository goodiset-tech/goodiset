@extends('layout.app')
  @section('content')
  <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Forget Password</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="/">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Forget Password</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

  <div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-md-12">
                <form class="main-form full" method="POST">
                  @csrf
                  <div class="col-xs-12 mb-20">
                    <div class="heading-part heading-bg">
                      <h2 class="heading">Forget Password</h2>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="login-email">Email address</label>
                      <input id="login-email" class="form-control" type="email" required name="email" placeholder="Email Address">
                    </div>
                  </div>
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </form>
          </div>
        </div>
    </div>
          
   
       
  @endsection