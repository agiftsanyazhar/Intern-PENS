<x-app-layout :assets="$assets ?? []">
   <div>
      <?php
         $id = $id ?? null;
      ?>

      @if(isset($id))
         {!! Form::model($data, ['route' => ['customers.update', $id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
      @else
         {!! Form::open(['route' => ['customers.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif

      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} Customer Information</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-customer-info">
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="company_name">Company Name<span class="text-danger">*</span></label>
                           {{ Form::text('company_name', old('company_name'), ['class' => 'form-control', 'placeholder' => 'Enter Company Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="company_address">Company Address<span class="text-danger">*</span></label>
                           {{ Form::text('company_address', old('company_address'), ['class' => 'form-control', 'placeholder' => 'Enter Company Address', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="company_email">Company Email<span class="text-danger">*</span></label>
                           {{ Form::email('company_email', old('company_email'), ['class' => 'form-control', 'placeholder' => 'Enter Company Email', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="company_phone">Company Phone<span class="text-danger">*</span></label>
                           {{ Form::text('company_phone', old('company_phone'), ['class' => 'form-control', 'placeholder' => 'Enter Company Phone', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="company_pic_name">PIC Name<span class="text-danger">*</span></label>
                           {{ Form::text('company_pic_name', old('company_pic_name'), ['class' => 'form-control', 'placeholder' => 'Enter PIC Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="company_pic_address">PIC Address<span class="text-danger">*</span></label>
                           {{ Form::text('company_pic_address', old('company_pic_address'), ['class' => 'form-control', 'placeholder' => 'Enter PIC Address', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="company_pic_email">PIC Email<span class="text-danger">*</span></label>
                           {{ Form::email('company_pic_email', old('company_pic_email'), ['class' => 'form-control', 'placeholder' => 'Enter PIC Email', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="company_pic_phone">PIC Phone<span class="text-danger">*</span></label>
                           {{ Form::text('company_pic_phone', old('company_pic_phone'), ['class' => 'form-control', 'placeholder' => 'Enter PIC Phone', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="description">Description</label>
                           {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Type Description...']) }}
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }} Customer</button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>
