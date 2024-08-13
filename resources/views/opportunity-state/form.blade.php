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
                           <label class="form-label" for="opportunity_status">Opportunity State Name<span class="text-danger">*</span></label>
                           {{ Form::text('opportunity_status', old('opportunity_status'), ['class' => 'form-control', 'placeholder' => 'Enter Opportunity State Name', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="note">Note</label>
                           {{ Form::textarea('note', old('note'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Type Note...']) }}
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
