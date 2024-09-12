<x-app-layout :assets="$assets ?? []">
   <div>
      <?php
         $id = $id ?? null;
      ?>

      @if(isset($id))
         {!! Form::model($data, ['route' => ['health.update', $id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
      @else
         {!! Form::open(['route' => ['health.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif

      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} Health Information</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ route('health.index') }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-health-info">
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="status_health">Status Health<span class="text-danger">*</span></label>
                           {{ Form::text('status_health', old('status_health'), ['class' => 'form-control', 'placeholder' => 'Enter Status', 'required', 'disabled' => isset($id)]) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="day_parameter_value">Day Parameter Value<span class="text-danger">*</span></label>
                           {{ Form::text('day_parameter_value', old('day_parameter_value'), ['class' => 'form-control', 'placeholder' => 'Enter Day Parameter Value', 'required']) }}
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }} Health</button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>
