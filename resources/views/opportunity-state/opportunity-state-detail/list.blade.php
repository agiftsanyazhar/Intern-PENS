@push('scripts')

@endpush

<x-app-layout :assets="$assets ?? []">
   <div>
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Opportunity State Detail List</h4>
                  </div>
               </div>
               <div class="card-body px-0">
                  {{-- <div class="row">
                     <div class="col-sm-12">
                        <h4 class="mb-2">Invoice  #215462</h4>
                        <h5 class="mb-3">Hello , Devon Lane </h5>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.</p>
                     </div>
                  </div> --}}
                  <div class="table-responsive">

                  </div>
               </div>
            </div>
         </div>
      </div>
</div>
</x-app-layout>
