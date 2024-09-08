<x-app-layout :assets="$assets ?? []">
   <div>
      
      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">All Notifications</h4>
                  </div>
                  <div class="card-action">
                     <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary" role="button">Back</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex justify-content-start">
                     <ul class="nav nav-tabs nav-tunnel nav-slider" role="tablist">
                           <li class="nav-item" role="presentation">
                              <a href="#" class="nav-link filter-link {{ $filter === 'all' ? 'bg-primary active' : '' }}" data-filter="all">
                                 All
                              </a>
                           </li>
                           <li class="nav-item" role="presentation">
                              <a href="#" class="nav-link filter-link {{ $filter === 'read' ? 'bg-primary active' : '' }}" data-filter="read">
                                 Read
                              </a>
                           </li>
                           <li class="nav-item" role="presentation">
                              <a href="#" class="nav-link filter-link {{ $filter === 'unread' ? 'bg-primary active' : '' }}" data-filter="unread">
                                 Unread
                              </a>
                           </li>
                     </ul>
                  </div>

                  <!-- Notifications container -->
                  <div id="notifications-content" class="mt-3">
                     @include('notification.partials.list', ['notifications' => $notifications])
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>

   @push('scripts')
      <script>
         document.addEventListener('DOMContentLoaded', function() {
            const filterLinks = document.querySelectorAll('.filter-link');

            filterLinks.forEach(link => {
                  link.addEventListener('click', function(event) {
                     event.preventDefault();

                     // Get the filter from the clicked link
                     const filter = this.getAttribute('data-filter');

                     // Perform the AJAX request
                     fetch(`{{ route('notification.index') }}?filter=${filter}`, {
                        headers: {
                              'X-Requested-With': 'XMLHttpRequest'
                        }
                     })
                     .then(response => response.json())
                     .then(data => {
                        // Update the notifications content
                        document.getElementById('notifications-content').innerHTML = data.html;

                        // Update active class on the filter links
                        filterLinks.forEach(link => link.classList.remove('bg-primary', 'active'));
                        this.classList.add('bg-primary', 'active');
                     })
                     .catch(error => {
                        console.error('Error:', error);
                     });
                  });
            });
         });
      </script>
   @endpush
</x-app-layout>
