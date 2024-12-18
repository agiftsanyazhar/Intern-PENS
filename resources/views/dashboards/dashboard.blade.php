<x-app-layout :assets="$assets ?? []">
   <div class="row">
      <div class="col-lg-6 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-success text-white rounded p-3">
                     <svg xmlns="http://www.w3.org/2000/svg"  width="20px" height="20px" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($totalUsers) }}</h2>
                     Users
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-6 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-info text-white rounded p-3">
                     <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($totalCustomers) }}</h2>
                     Customers
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-primary text-white rounded p-3">
                     Rp                      
                  </div>
                  <div class="text-end">
                     <h2 class="counter">Rp{{ formatCurrency($opportunityGrossValue) }}</h2>
                     Total Earning
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-info text-white rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($totalOpportunities) }}</h2>
                     Total Opportunity
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-success text-white rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($opportunityCompleted) }}</h2>
                     Completed
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-danger text-white rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($opportunityFailed) }}</h2>
                     Failed
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card bg-soft-success">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-soft-success rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($opportunityGood) }}</h2>
                     Opportunity Good
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card bg-soft-warning">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-soft-warning text-white rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($opportunityFair) }}</h2>
                     Opportunity Fair
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card bg-soft-danger ">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-soft-danger rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($opportunityPoor) }}</h2>
                     Opportunity Poor
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="card bg-soft-dark">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center">
                  <div class="bg-soft-dark text-white rounded p-3">
                     <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.4" d="M22 11.9998C22 17.5238 17.523 21.9998 12 21.9998C6.477 21.9998 2 17.5238 2 11.9998C2 6.47776 6.477 1.99976 12 1.99976C17.523 1.99976 22 6.47776 22 11.9998Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8701 12.6307C12.8701 13.1127 12.4771 13.5057 11.9951 13.5057C11.5131 13.5057 11.1201 13.1127 11.1201 12.6307V8.21069C11.1201 7.72869 11.5131 7.33569 11.9951 7.33569C12.4771 7.33569 12.8701 7.72869 12.8701 8.21069V12.6307ZM11.1251 15.8035C11.1251 15.3215 11.5161 14.9285 11.9951 14.9285C12.4881 14.9285 12.8801 15.3215 12.8801 15.8035C12.8801 16.2855 12.4881 16.6785 12.0051 16.6785C11.5201 16.6785 11.1251 16.2855 11.1251 15.8035Z" fill="currentColor"></path>
                     </svg>
                  </div>
                  <div class="text-end">
                     <h2 class="counter">{{ formatCurrency($opportunityCritical) }}</h2>
                     Opportunity Critical
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12 col-lg-8">
         <div class="row">
            @include('dashboards.charts.chart-earning')
            @include('dashboards.charts.earning-overview')
         </div>
      </div>
      <div class="col-md-12 col-lg-4">
         <div class="row">
            <div class="col-md-6 col-lg-12">
               @include('dashboards.charts.performance-earning')
               @include('dashboards.charts.chart-opportunities')
               @include('dashboards.charts.activity-overview')
            </div>
         </div>
      </div>
   </div>
</x-app-layout>
