<x-app-layout :assets="$assets ?? []">
   <div>
      @php
         $id = $opportunityStateDetailId ?? null;
      @endphp

      @if(isset($id))
         {!! Form::model($data, ['route' => ['opportunity-state-detail.update', $id], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}
      @else
         {!! Form::open(['route' => ['opportunity-state-detail.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
      @endif

      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $id !== null ? 'Update' : 'New' }} Opportunity State Detail Information</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ route('opportunity-state.show', $opportunityStateId) }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-opportunity-state-detail-info">
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="opportunity_status_id">Opportunity Status<span class="text-danger">*</span></label>
                           {{ Form::text('opportunity_state_id', $opportunityStateId, ['class' => 'form-control', 'hidden' => true, 'required']) }}
                           {{ Form::select('opportunity_status_id', [
                              '1' => 'Inquiry',
                              '2' => 'Follow Up',
                              '3' => 'Stale',
                              '4' => 'Completed',
                              '5' => 'Failed'
                           ], old('opportunity_status_id'), ['class' => 'form-control', 'placeholder' => 'Select Opportunity Status', 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="description">Description</label>
                           {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Type Description...']) }}
                        </div>
                     </div>
                     <button type="submit" class="btn btn-primary">{{ $id !== null ? 'Update' : 'Add' }} Opportunity State Detail</button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>
