  <!-- ============================ Footer Start ================================== -->
  <footer class="footer skin-dark-footer">
      <div class="container">

          <div class="row">
              @foreach ($footerMenu as $item)
                  <div class="col">
                      <div class="footer-widget mb-5 mb-md-5 mb-lg-0">
                          <h4 class="widget-title text-pri">{{ $item->name }}</h4>
                          <ul class="footer-menu">
                              @foreach ($item->items as $menuitem)
                                  <li>
                                      <a href="{{ $menuitem->target }}"
                                          @if ($menuitem->target_blank) target="_blank" @endif>
                                          {{ $menuitem->label }}
                                      </a>
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
              @endforeach
          </div>

          <div class="row">
              <div class="footer-bottom w-100 border-top">
                  <div class="row align-items-center justify-content-between g-3">

                      <div class="col-lg-4 col-md-4">
                      </div>

                      <div class="col-lg-4 col-md-4">
                          <div class="text-center">Copyright {{ date('Y') }} © All Rights Reserved</div>
                      </div>

                      <div class="col-lg-4 col-md-4">

                      </div>

                  </div>
              </div>
          </div>

      </div>

  </footer>
  <!-- ============================ Footer End ================================== -->

  </div>

  <script src="{{ url('/assets/js/vendors.js') }}"></script>

  <script src="{{ url('/assets/js/custom.js') }}"></script>
  <script>
      const counters = document.querySelectorAll('.stat-number');
      const speed = 60;

      counters.forEach(counter => {
          const animate = () => {
              const target = +counter.getAttribute('data-target');
              const current = +counter.innerText.replace(/,/g, '').replace('+', '');
              const suffix = counter.getAttribute('data-suffix') || '';


              const increment = Math.ceil(target / speed);

              if (current < target) {
                  const nextValue = current + increment;
                  if (nextValue >= target) {
                      counter.innerText = target.toLocaleString('en-US') + suffix;
                  } else {
                      counter.innerText = nextValue.toLocaleString('en-US') + suffix;
                      setTimeout(animate, 25); // 
                  }
              } else {
                  counter.innerText = target.toLocaleString('en-US') + suffix;
              }
          }
          animate();
      });
  </script>

  <script>
      // 1. Mobile Drawer Toggle
      const hamburger = document.getElementById('mob-hamburger');
      const drawer = document.getElementById('mob-drawer-container');

      hamburger.addEventListener('click', (e) => {
          e.stopPropagation();
          hamburger.classList.toggle('open');
          drawer.classList.toggle('active');
      });

      // 2. Click to open dropdown (Desktop & Mobile)
      const allNavItems = document.querySelectorAll('.nav-item');

      allNavItems.forEach(item => {
          const link = item.querySelector('.nav-link');

          if (item.querySelector('.dropdown-menu')) {
              link.addEventListener('click', (e) => {
                  e.stopPropagation();

                  // Close other open dropdowns first
                  allNavItems.forEach(otherItem => {
                      if (otherItem !== item) {
                          otherItem.classList.remove('open');
                      }
                  });

                  // Toggle current dropdown
                  item.classList.toggle('open');
              });
          }
      });

      // 3. Close dropdowns automatically if clicked anywhere outside
      document.addEventListener('click', () => {
          allNavItems.forEach(item => item.classList.remove('open'));
      });

      // 4. Extra Security: If window resizes to desktop, clear all mobile active triggers
      window.addEventListener('resize', () => {
          if (window.innerWidth > 1024) {
              hamburger.classList.remove('open');
              drawer.classList.remove('active');
              allNavItems.forEach(item => item.classList.remove('open'));
          }
      });
  </script>
  <!-- Bootstrap JS -->
  <script defer src="//unpkg.com/alpinejs"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
