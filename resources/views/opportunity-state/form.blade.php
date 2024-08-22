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
                        <div class="form-group col-md-6">
                           <label class="form-label" for="customer_id">Customer<span class="text-danger">*</span></label>
                           <select id="customer_id" name="customer_id" class="form-control select2" required>
                               <option value="">Select Customer</option>
                               @foreach($customers as $customerId => $company_name)
                                   <option value="{{ $customerId }}" data-pic="{{ $customerPics[$customerId] }}"
                                       {{ isset($data) && $data->customer_id == $customerId ? 'selected' : '' }}>
                                       {{ $company_name }}
                                   </option>
                               @endforeach
                           </select>
                       </div>

                       <div class="form-group col-md-6">
                           <label class="form-label" for="customer_pic">Customer PIC<span class="text-danger">*</span></label>
                           <input type="text" id="customer_pic" name="customer_pic" class="form-control" placeholder="Customer PIC" disabled required value="{{ isset($data) ? $customerPics[$data->customer_id] : '' }}">
                       </div>

                        <div class="form-group col-md-12">
                           <label class="form-label" for="title">Opportunity Name<span class="text-danger">*</span></label>
                           {{ Form::text('title', old('title'), [
                              'class' => 'form-control', 
                              'placeholder' => 'Enter Opportunity Name', 
                              'required'
                           ]) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="opportunity_status_id">Opportunity Status<span class="text-danger">*</span></label>
                           {{ Form::select('opportunity_status_id', [
                              '1' => 'Inquiry',
                              '2' => 'Follow Up',
                              '3' => 'Stale',
                              '4' => 'Completed',
                              '5' => 'Failed'
                           ], old('opportunity_status_id'), [
                              'class' => 'form-control', 
                              'placeholder' => 'Select Opportunity Status', 
                              'required'
                           ]) }}
                        </div>
                        <div class="form-group col-md-6">
                           <label for="opportunity_value" class="form-label">Opportunity Value<span class="text-danger">*</span></label>
                           <div class="form-group input-group">
                              <span class="input-group-text">Rp</span>
                              {{ Form::number('opportunity_value', old('opportunity_value'), [
                                 'class' => 'form-control', 
                                 'placeholder' => 'Ex: 1200000', 
                                 'required'
                              ]) }}
                           </div>
                        </div>
                        <div class="form-group col-md-12">
                           <label class="form-label" for="description">Description<span class="text-danger">*</span></label>
                           {{ Form::textarea('description', old('description'), [
                              'class' => 'form-control', 
                              'rows' => 3, 
                              'placeholder' => 'Type Description...', 
                              'required'
                           ]) }}
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
   
   @push('scripts')
   <script>
      $(document).ready(function() {
          // Ketika dropdown customer berubah
          $('#customer_id').change(function() {
              var selectedOption = $(this).find(':selected');
              var customerPic = selectedOption.data('pic');

              // Mengisi field Customer PIC dengan data yang sesuai
              $('#customer_pic').val(customerPic);
          });
      });
  </script>
   @endpush
 
   
</x-app-layout>
