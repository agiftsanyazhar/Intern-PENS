<x-guest-layout>
   <section class="login-content">
      <div class="row m-0 align-items-center bg-white vh-100">
         <div class="col-md-6">
            <div class="row justify-content-center">
               <div class="col-md-10">
                  <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                     <div class="card-body">
                        <h2 class="mb-2 text-center">Sign In</h2>
                        <x-auth-session-status :status="session('status')" />

                        <!-- Validation Errors -->
                        <x-auth-validation-errors :errors="$errors" />

                        <form method="POST" action="{{ route('login') }}" data-toggle="validator">
                           @csrf

                           <div class="form-group">
                              <label for="email" class="form-label">Email</label>
                              <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" class="form-control" required autofocus>
                           </div>

                           <div class="form-group">
                              <label for="password" class="form-label">Password</label>
                              <input class="form-control" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                           </div>

                           <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary">{{ __('Sign In') }}</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="{{asset('images/auth/01.png')}}" class="img-fluid gradient-main animated-scaleX" alt="images">
         </div>
      </div>
   </section>
</x-guest-layout>

