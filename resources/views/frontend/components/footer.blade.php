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

  <!-- Log In Modal -->
  <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
      <div class="modal-dialog" id="loginmodal">
          <div class="modal-content">
              <div class="modal-header justify-content-end border-0 pb-0">
                  <a href="#" class="square--30 circle bg-light-danger text-danger" data-bs-dismiss="modal"
                      aria-label="Close"><i class="fa-solid fa-xmark"></i></a>
              </div>

              <div class="modal-body px-4">
                  <!-- Heading -->
                  <div class="text-center mb-5">
                      <h2>Welcome Back</h2>
                      <p class="fs-6">Login to manage your account.</p>
                  </div>
                  <!-- End Heading -->

                  <!-- Form -->
                  <form class="needs-validation px-lg-2" novalidate>

                      <!-- Form -->
                      <div class="row align-items-center justify-content-between g-3 mb-4">
                          <div class="col-xl-6 col-lg-6 col-md-6"><a href="#"
                                  class="btn btn-outline-secondary border rounded-3 text-md px-lg-2 full-width"><img
                                      src="assets/img/google.html" class="img-fluid me-2" width="16"
                                      alt="">Login with Google</a></div>
                          <div class="col-xl-6 col-lg-6 col-md-6"><a href="#"
                                  class="btn btn-outline-secondary border rounded-3 text-md px-lg-2 full-width"><img
                                      src="assets/img/facebook.html" class="img-fluid me-2" width="16"
                                      alt="">Login with Facebook</a></div>
                      </div>
                      <!-- End Form -->

                      <!-- Form -->
                      <div class="mb-4">
                          <label class="form-label" for="email01">Your email</label>
                          <input type="email" class="form-control" id="email01" placeholder="email@site.com"
                              required>
                          <span class="invalid-feedback">Please enter a valid email address.</span>
                      </div>
                      <!-- End Form -->

                      <!-- Form -->
                      <div class="mb-4">
                          <div class="d-flex justify-content-between align-items-center">
                              <label class="form-label" for="pass01">Password</label>
                              <a class="link fw-medium text-primary" href="forgot-password.html">Forgot Password?</a>
                          </div>

                          <div class="input-group-merge">
                              <input type="password" class="form-control" id="pass01"
                                  placeholder="8+ characters required" required>
                          </div>

                          <span class="invalid-feedback">Please enter a valid password.</span>
                      </div>
                      <!-- End Form -->

                      <div class="d-grid mb-3">
                          <button type="submit" class="btn btn-primary fw-medium">Log in</button>
                      </div>

                      <div class="text-center">
                          <p>Don't have an account yet? <a class="link fw-medium text-primary" href="signup.html">Sign
                                  up here</a></p>
                      </div>
                  </form>
                  <!-- End Form -->
              </div>

              <div class="modal-footer p-3 border-top">
                  <div class="d-flex align-items-center justify-content-between gap-3">
                      <div class="brand px-lg-4 px-3"><img src="assets/img/brand/logo-1.html" class="img-fluid"
                              alt=""></div>
                      <div class="brand px-lg-4 px-3"><img src="assets/img/brand/logo-3.html" class="img-fluid"
                              alt=""></div>
                      <div class="brand px-lg-4 px-3"><img src="assets/img/brand/logo-2.html" class="img-fluid"
                              alt=""></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- End Modal -->

  </div>

  <script src="assets/js/vendors.js"></script>

  <script src="assets/js/custom.js"></script>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
