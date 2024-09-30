@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
<x-app-layout :assets="$assets ?? []">
<div>
   @if (isset($masterDetail))
      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">{{ $masterDetail->title }}</h4>
                  </div>
                  <div class="card-action">
                     {!! $backAction ?? '' !!}
                  </div>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-2">
                        <p class="fw-bold">Customer Name:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $masterDetail->customer->company_name }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Status:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ getOpportunityStatusNameById($masterDetail->opportunity_status_id) }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Value:</p>
                     </div>
                     <div class="col-md-10">
                        <p>Rp{{ number_format($masterDetail->opportunity_value, 0, ',', '.') }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Description:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $masterDetail->description }}</p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Created By:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $masterDetail->createdByUser->name }} <small>{{ date('Y/m/d H:i', strtotime($masterDetail->created_at )) }}</small></p>
                     </div>
                     <div class="col-md-2">
                        <p class="fw-bold">Updated By:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $masterDetail->updatedByUser->name ?? '' }} <small>{{ $masterDetail->updated_by ? date('Y/m/d H:i', strtotime($masterDetail->updated_at)) : '' }}</small></p>
                     </div>
                     {{-- <div class="col-md-2">
                        <p class="fw-bold">Deleted By:</p>
                     </div>
                     <div class="col-md-10">
                        <p>{{ $masterDetail->deletedByUser->name ?? '' }} <small>{{ $masterDetail->deleted_by ? date('Y/m/d H:i', strtotime($masterDetail->deleted_at)) : '' }}</small></p>
                     </div> --}}
                  </div>
               </div>
            </div>
         </div>
      </div>
   @endif

   <div class="row">
      <div class="col-xl-12 col-lg-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">{{ $pageTitle ?? 'List'}}</h4>
               </div>
               <div class="card-action">
                  {!! $headerAction ?? '' !!}
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  {{ $dataTable->table(['class' => 'table w-100'],true) }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</x-app-layout>
