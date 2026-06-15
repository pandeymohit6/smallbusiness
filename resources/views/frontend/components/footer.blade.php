  <!-- ============================ Footer Start ================================== -->
  <footer class="footer skin-dark-footer">
      <div class="container">

          <div class="row">
              @if ($footerMenu && $footerMenu->count())
                  @foreach ($footerMenu as $item)
                      <div class="col">
                          <div class="footer-widget mb-5 mb-md-5 mb-lg-0">
                              <h4 class="widget-title text-pri">{{ $item->name }}</h4>
                              <ul class="footer-menu">
                                  @foreach ($item->items as $child)
                                      <li>
                                          <a href="{{ $child->getUrl() }}"
                                              @if ($child->target_blank) target="_blank" @endif>
                                              {{ $child->label }}
                                          </a>
                                      </li>
                                  @endforeach
                              </ul>
                          </div>
                      </div>
                  @endforeach
              @endif
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
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#password');

      togglePassword.addEventListener('click', function(e) {
          const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
          password.setAttribute('type', type);
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

  <script>
      const categoryData = {
          'all-sectors': ['All Main Sectors Overview'],
          'agriculture': ['Agricultural Supplies (22)', 'Farms (30)', 'Misc. Agriculture (56)', 'Ranches (5)',
              'Vineyards & Wineries (21)'
          ],
          'energy': ['Alternative Energy (45)', 'Gas Stations (52)', 'Oil & Petroleum (25)'],
          'engineering': ['Civil Engineering (110)', 'Precision Engineering (128)', 'Structural Panels (90)'],
          'food': ['Bakeries (320)', 'Cafes & Coffee Shops (1200)', 'Fast Food Outlets (2100)', 'Restaurants (987)'],
          'franchise-resales': ['Food Franchise Resales (204)', 'Leisure Franchise Resales (60)',
              'Misc. Franchise Resales (178)', 'Retail Franchise Resales (54)', 'Service Franchise Resales (345)'
          ],
          'leisure': ['Amusement Parks (32)', 'Gyms & Fitness Centers (1450)', 'Hotels & Motels (1008)']
      };

      const countryTrigger = document.getElementById('flrLocationDropdownTrigger');
      const countryMenu = document.getElementById('flrCountryDropdownMenu');
      const countryLabel = document.getElementById('flrSelectedCountryLabel');

      const regionTrigger = document.getElementById('flrRegionDropdownTrigger');
      const regionMenu = document.getElementById('flrRegionDropdownMenu');
      const regionLabel = document.getElementById('flrSelectedRegionLabel');

      const stateTrigger = document.getElementById('flrStateDropdownTrigger');
      const stateMenu = document.getElementById('flrStateDropdownMenu');
      const stateLabel = document.getElementById('flrSelectedStateLabel');

      const cityTrigger = document.getElementById('flrCityDropdownTrigger');
      const cityMenu = document.getElementById('flrCityDropdownMenu');
      const cityLabel = document.getElementById('flrSelectedCityLabel');

      const categoryTrigger = document.getElementById('flrCategoryDropdownTrigger');
      const categoryMenu = document.getElementById('flrCategoryMegaMenu');
      const categoryLabel = document.getElementById('flrSelectedCategoryLabel');

      const mainSectorsColumn = document.getElementById('flrMainSectorsColumn');
      const subSectorsColumn = document.getElementById('flrSubSectorsColumn');
      const menuBreadcrumb = document.getElementById('flrMenuBreadcrumb');

      const sidebarFilterDrawer = document.getElementById('flrSidebarDrawer');
      const mobileFilterOpenBtn = document.getElementById('flrMobileFilterOpenBtn');
      const mobileFilterCloseBtn = document.getElementById('flrFilterCloseBtn');

      if (mobileFilterOpenBtn && sidebarFilterDrawer) {
          mobileFilterOpenBtn.addEventListener('click', function(e) {
              e.stopPropagation();
              sidebarFilterDrawer.classList.add('flr-mobile-open');
          });
      }

      if (mobileFilterCloseBtn && sidebarFilterDrawer) {
          mobileFilterCloseBtn.addEventListener('click', function(e) {
              e.stopPropagation();
              sidebarFilterDrawer.classList.remove('flr-mobile-open');
          });
      }

      function closeAllMenus() {
          [countryMenu, regionMenu, stateMenu, cityMenu, categoryMenu].forEach(m => m.classList.remove('flr-open'));
          [countryTrigger, regionTrigger, stateTrigger, cityTrigger, categoryTrigger].forEach(t => t.classList.remove(
              'flr-active-box'));
      }

      function setupToggle(trigger, menu) {
          trigger.addEventListener('click', function(e) {
              e.stopPropagation();
              const isOpen = menu.classList.contains('flr-open');
              closeAllMenus();
              if (!isOpen) {
                  menu.classList.add('flr-open');
                  trigger.classList.add('flr-active-box');
              }
          });
      }

      setupToggle(countryTrigger, countryMenu);
      setupToggle(regionTrigger, regionMenu);
      setupToggle(stateTrigger, stateMenu);
      setupToggle(cityTrigger, cityMenu);
      setupToggle(categoryTrigger, categoryMenu);

      function updateSubCategories(sectorKey, breadcrumbText) {
          subSectorsColumn.innerHTML = '';
          const subs = categoryData[sectorKey] || [];
          subs.forEach(subName => {
              const itemDiv = document.createElement('div');
              itemDiv.className = 'flr-sub-category-item';
              itemDiv.innerHTML =
                  `<span>${subName}</span> <i class="fa-solid fa-angle-right" style="font-size:11px; color:#94a3b8;"></i>`;
              itemDiv.addEventListener('click', function(e) {
                  e.stopPropagation();
                  categoryLabel.innerText = subName.split('(')[0].trim();
                  closeAllMenus();
                  sidebarFilterDrawer.classList.remove('flr-mobile-open');
              });
              subSectorsColumn.appendChild(itemDiv);
          });
          menuBreadcrumb.innerText = breadcrumbText;
      }

      document.querySelectorAll('#flrMainSectorsColumn .flr-category-item').forEach(item => {
          item.addEventListener('click', function(e) {
              e.stopPropagation();
              document.querySelectorAll('#flrMainSectorsColumn .flr-category-item').forEach(el => el
                  .classList.remove('flr-active-parent'));
              this.classList.add('flr-active-parent');
              const targetSector = this.getAttribute('data-sector');
              const textLabel = this.querySelector('span').innerText;
              updateSubCategories(targetSector, textLabel);
          });
      });

      document.querySelectorAll('.flr-age-chip-card').forEach(card => {
          card.addEventListener('click', function() {
              document.querySelectorAll('.flr-age-chip-card').forEach(c => c.classList.remove(
                  'flr-active-chip'));
              this.classList.add('flr-active-chip');
              const radioInput = this.querySelector('input[type="radio"]');
              if (radioInput) radioInput.checked = true;
          });
      });

      function setupDropdownSearch(inputId, menuId) {
          const searchInput = document.getElementById(inputId);
          const menuBox = document.getElementById(menuId);
          searchInput.addEventListener('input', function() {
              const filterValue = searchInput.value.toLowerCase().trim();
              const items = menuBox.querySelectorAll('.flr-country-item');
              items.forEach(item => {
                  const itemText = item.querySelector('span:first-child').innerText.toLowerCase();
                  item.style.display = itemText.includes(filterValue) ? 'flex' : 'none';
              });
          });
          searchInput.addEventListener('click', e => e.stopPropagation());
      }

      setupDropdownSearch('flrCountrySearchInput', 'flrCountryDropdownMenu');
      setupDropdownSearch('flrRegionSearchInput', 'flrRegionDropdownMenu');
      setupDropdownSearch('flrStateSearchInput', 'flrStateDropdownMenu');
      setupDropdownSearch('flrCitySearchInput', 'flrCityDropdownMenu');

      function registerSelectionHandler(menuId, labelObj) {
          document.querySelectorAll(`#${menuId} .flr-country-item`).forEach(item => {
              item.addEventListener('click', function() {
                  labelObj.innerText = this.querySelector('span:first-child').innerText;
                  closeAllMenus();
                  sidebarFilterDrawer.classList.remove('flr-mobile-open');
              });
          });
      }

      registerSelectionHandler('flrCountryDropdownMenu', countryLabel);
      registerSelectionHandler('flrRegionDropdownMenu', regionLabel);
      registerSelectionHandler('flrStateDropdownMenu', stateLabel);
      registerSelectionHandler('flrCityDropdownMenu', cityLabel);

      updateSubCategories('franchise-resales', 'Franchise Resales (670)');
      document.querySelector('.flr-btn-update').addEventListener('click', e => {
          e.stopPropagation();
          closeAllMenus();
          sidebarFilterDrawer.classList.remove('flr-mobile-open');
      });

      document.addEventListener('click', function() {
          closeAllMenus();
      });
  </script>
  <!-- Bootstrap JS -->
  <script defer src="//unpkg.com/alpinejs"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
