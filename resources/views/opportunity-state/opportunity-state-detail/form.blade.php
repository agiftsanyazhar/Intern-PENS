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
                     <h4 class="card-title">{{ $opportunityState->title }}</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ route('opportunity-state.show', $opportunityStateId) }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-2">
                        <p class="fw-bold">Customer Name:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $opportunityState->customer->company_name }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Status:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ getOpportunityStatus($opportunityState->opportunity_status_id) }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Value:</p>
                     </div>
                     <div class="col-md-10">
                        <p>Rp{{ number_format($opportunityState->opportunity_value, 0, ',', '.') }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Description:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $opportunityState->description }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Created By:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $opportunityState->createdByUser->name }} <small>{{ date('Y/m/d H:i', strtotime($opportunityState->created_at )) }}</small></p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Updated By:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $opportunityState->updatedByUser->name ?? '' }} <small>{{ $opportunityState->updated_by ? date('Y/m/d H:i', strtotime($opportunityState->updated_at)) : '' }}</small></p>
                     </div>
                     {{-- <div class="col-md-2">
                        <p class="fw-bold">Deleted By:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $opportunityState->deletedByUser->name ?? '' }} <small>{{ $opportunityState->deleted_by ? date('Y/m/d H:i', strtotime($opportunityState->deleted_at)) : '' }}</small></p>
                     </div> --}}
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $id !== null ? (isset($show) ? '' : 'Update') : 'New' }} Opportunity State Detail Information</h4>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-opportunity-state-detail-info">
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="opportunity_status_id">Opportunity Status<span class="text-danger">*</span></label>
                           {{ Form::text('opportunity_state_id', $opportunityStateId, ['class' => 'form-control', 'disabled' => isset($show) ? true : false, 'hidden' => true, 'required']) }}
                           {{ Form::select('opportunity_status_id', [
                              '1' => 'Inquiry',
                              '2' => 'Follow Up',
                              '3' => 'Stale',
                              '4' => 'Completed',
                              '5' => 'Failed'
                           ], old('opportunity_status_id'), ['class' => 'form-control', 'placeholder' => 'Select Opportunity Status', 'disabled' => isset($show) ? true : false, 'required']) }}
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                           {{ Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Type Description...', 'disabled' => isset($show) ? true : false, 'required']) }}
                        </div>
                     </div>
                     @unless(isset($show))
                        <button type="submit" class="btn btn-primary">{{ $id !== null ? (isset($show) ? '' : 'Update') : 'New' }} Opportunity State Detail</button>
                     @endunless
                  </div>
               </div>
            </div>
         </div>
      </div>

      {!! Form::close() !!}
   </div>
</x-app-layout>
