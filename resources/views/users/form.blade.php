<x-app-layout :assets="$assets ?? []">
   <div>
      <?php
         $id = $id ?? null;
      ?>
      @if(isset($id))
         {!! Form::model($data, ['route' => ['users.update', $id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
      @else
         {!! Form::open(['route' => ['users.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif

      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} User Information</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-user-info">
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="name">Name<span class="text-danger">*</span></label>
                           {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder'=> 'Enter Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                           {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Enter Email', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="phone">Mobile Number</label>
                           {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '+628123456789']) }}
                        </div>       
                        <div class="form-group col-md-12">
                           <label class="form-label" for="role_id">Role<span class="text-danger">*</span></label>
                           {{ Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control', 'placeholder' => 'Select Role', 'required']) }}
                        </div>                  
                        <div class="form-group col-md-12">
                           <label class="form-label" for="note">Note</label>
                           {{ Form::textarea('note', old('note'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Type Note...']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="pass">New Password{!! $id !== null ? ' (Optional)' : '<span class="text-danger">*</span>' !!}</label>
                           {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter New Password']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="rpass">Repeat New Password{!! $id !== null ? ' (Optional)' : '<span class="text-danger">*</span>' !!}</label>
                           {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Repeat New Password']) }}
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }} User</button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>
