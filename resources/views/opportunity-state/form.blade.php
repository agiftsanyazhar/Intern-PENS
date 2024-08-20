<x-app-layout :assets="$assets ?? []">
   <div>
      @php
         $id = $id ?? null;
      @endphp

      @if(isset($id))
         {!! Form::model($data, ['route' => ['opportunity-state.update', $id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
      @else
         {!! Form::open(['route' => ['opportunity-state.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif

      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} Opportunity State Information</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ route('opportunity-state.index') }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-opportunity-state-info">
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="role">Customer<span class="text-danger">*</span></label>
                           {{ Form::select('customer_id', $customers, old('customer_id'), ['class' => 'form-control', 'placeholder' => 'Select Customer', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="title">Opportunity Name<span class="text-danger">*</span></label>
                           {{ Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Enter Opportunity Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="opportunity_status_id">Opportunity Status<span class="text-danger">*</span></label>
                           {{ Form::select('opportunity_status_id', [
                              '1' => 'Inquiry',
                              '2' => 'Follow Up',
                              '3' => 'Stale',
                              '4' => 'Completed',
                              '5' => 'Failed'
                           ], old('opportunity_status_id'), ['class' => 'form-control', 'placeholder' => 'Select Opportunity Status', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label for="opportunity_value" class="form-label">Opportunity Value<span class="text-danger">*</span></label>
                           <div class="form-group input-group">
                              <span class="input-group-text">Rp</span>
                              {{ Form::number('opportunity_value', old('opportunity_value'), ['class' => 'form-control', 'placeholder' => 'Ex: 1200000', 'required']) }}
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                           {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Type Description...', 'required']) }}
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }} Opportunity State</button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>
