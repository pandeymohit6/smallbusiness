<!-- ============================ Browse By Locations Start ================================== -->
		<section class="bg-light">
			<div class="container">

				<div class="row align-items-center justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="smart-heading-wrap">
							<div class="smart-heading">
								<h2 class="section-title">Popular Business Categories</h2>
							</div>

						</div>
					</div>
				</div>

				<div class="row justify-content-start g-4">

					@forelse($businessCategories ?? [] as $category)
						<!-- Dynamic Category Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="{{ route('businesses.index', ['type' => $category->business_type]) }}" class="typesLink smalls">
									<img src="https://via.placeholder.com/300x200?text={{ urlencode($category->business_type) }}" class="img" alt="{{ $category->business_type }}">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">{{ $category->business_type }}</h5>
										</div>
										<div class="listFounded"><span class="list text-light">{{ $category->total }}</span></div>
									</div>
								</a>
							</div>
						</div>
					@empty
						<!-- Fallback static categories -->
						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-1.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Family House</h5>
										</div>
										<div class="listFounded"><span class="list text-light">52 </span></div>
									</div>
								</a>
							</div>
						</div>

						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-2.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Apartments</h5>
										</div>
										<div class="listFounded"><span class="list text-light">19 </span></div>
									</div>
								</a>
							</div>
						</div>

						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-3.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Villa & Resort</h5>
										</div>
										<div class="listFounded"><span class="list text-light">48 </span></div>
									</div>
								</a>
							</div>
						</div>

						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-4.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Office & Studio</h5>
										</div>
										<div class="listFounded"><span class="list text-light">36 </span></div>
									</div>
								</a>
							</div>
						</div>

						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-5.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Duplexes </h5>
										</div>
										<div class="listFounded"><span class="list text-light">45 </span></div>
									</div>
								</a>
							</div>
						</div>

						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-6.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Condo House</h5>
										</div>
										<div class="listFounded"><span class="list text-light">12 </span></div>
									</div>
								</a>
							</div>
						</div>

						<!-- Single Item -->
						<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
							<div class="propertyTypesgrid style-2">
								<a href="#" class="typesLink smalls">
									<img src="assets/img/cat-7.jpg" class="img" alt="Property Types">
									<div class="typesCaps">
										<div class="typesTitle">
											<h5 class="title">Condo House</h5>
										</div>
										<div class="listFounded"><span class="list text-light">12 </span></div>
									</div>
								</a>
							</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-8.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Condo House</h5>
									</div>
									<div class="listFounded"><span class="list text-light">12 </span></div>
								</div>
							</a>
						</div>
					</div>

					<div class="categories-links-wrapper">
						<a href="#" class="category-link">View more Popular Business Categories <span
								class="arrow">&rarr;</span></a>
						<a href="#" class="category-link">View all Categories <span class="arrow">&rarr;</span></a>
					</div>
				@endforelse

				</div>

			</div>
		</section>
		<!-- ============================ Browse By Locations End ================================== -->

		<!-- ============================ Explore Best houses for sale Start ==================================== -->
		<section class="bg-light1">
			<div class="container">

				<div class="featured-section fea-se">
					<h2 class="section-title">Mid Market Businesses</h2>

					<div class="cards-container">

						<div class="business-card">
							<div class="card-content">
								<a href="#" class="card-heading">Heavy-Duty Truck And Diesel Engine Repair Business</a>
								<p class="card-location">San Antonio, Texas</p>
							</div>

						</div>

						<div class="business-card">
							<div class="card-content">
								<a href="#" class="card-heading">Global Business Coaching Platform With Licensing
									Potential</a>
								<p class="card-location">Dayton, Ohio</p>
							</div>

						</div>

						<div class="business-card">
							<div class="card-content">
								<a href="#" class="card-heading">High-Growth DTC Health And Beauty Brand</a>
								<p class="card-location">United States</p>
							</div>

						</div>

						<div class="business-card">
							<div class="card-content">
								<a href="#" class="card-heading">Premium Stand-Alone Liquor Store</a>
								<p class="card-location">San Sanford, Florida</p>
							</div>

						</div>
						<div class="categories-links-wrapper">
							<a href="#" class="category-link">View all Mid Market businesses <span
									class="arrow">&rarr;</span></a>
						</div>

					</div>
				</div>
			</div>
		</section>

		<!-- ============================ Browse By Locations Start ================================== -->
		<section class="bg-light">
			<div class="container">

				<div class="row align-items-center justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="smart-heading-wrap">
							<div class="smart-heading">
								<h2 class="section-title">Popular Business Locations</h2>
							</div>

						</div>
					</div>
				</div>

				<div class="row justify-content-start g-4">

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-1.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Family House</h5>
									</div>
									<div class="listFounded"><span class="list text-light">52 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-2.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Apartments</h5>
									</div>
									<div class="listFounded"><span class="list text-light">19 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-3.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Villa & Resort</h5>
									</div>
									<div class="listFounded"><span class="list text-light">48 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-4.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Office & Studio</h5>
									</div>
									<div class="listFounded"><span class="list text-light">36 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-5.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Duplexes </h5>
									</div>
									<div class="listFounded"><span class="list text-light">45 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-6.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Condo House</h5>
									</div>
									<div class="listFounded"><span class="list text-light">12 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-7.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Condo House</h5>
									</div>
									<div class="listFounded"><span class="list text-light">12 </span></div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-8.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Condo House</h5>
									</div>
									<div class="listFounded"><span class="list text-light">12 </span></div>
								</div>
							</a>
						</div>
					</div>

					<div class="categories-links-wrapper">
						<a href="#" class="category-link">View more Popular Locations <span
								class="arrow">&rarr;</span></a>
					</div>

				</div>

			</div>
		</section>
		<!-- ============================ Browse By Locations End ================================== -->

		<section class="bg-light2">
			<div class="container">
				<div class="franchise-section">
					<h2 class="section-title2">Featured Franchises</h2>

					<div class="franchise-container">

						<div class="franchise-card">
							<div class="card-front">
								<div class="logo-box">
									<img src="https://www.franchisesales.co.uk/franchiseImages/franchise6471/browseLogoBig.jpg"
										alt="Eazi Apps Logo">
								</div>
								<div class="divider-line"></div>
								<p class="brand-name">Eazi Apps</p>
							</div>
							<div class="card-back">
								<p class="description-text">
									Deliver cost-effective, well-crafted iPhone, iPad, Android and Mobile Web Apps to
									businesses without any technical or design experience.
								</p>
							</div>
						</div>

						<div class="franchise-card">
							<div class="card-front">
								<div class="logo-box">
									<img src="https://www.franchisesales.co.uk/franchiseImages/franchise6471/browseLogoBig.jpg"
										alt="Young Engineers Logo">
								</div>
								<div class="divider-line"></div>
								<p class="brand-name">Young Engineers</p>
							</div>
							<div class="card-back">
								<p class="description-text">
									Provide high-quality STEM education and enrichment programs for children using
									enterprise tools and models.
								</p>
							</div>
						</div>

						<div class="franchise-card promote-card">
							<div class="promote-content">
								<h3 class="promote-title">Promote your franchise on SmallBusinessesForSale.com</h3>
								<p class="promote-text">Access a combined audience of 1.6 million aspiring franchisees.
								</p>
							</div>
						</div>

					</div>

					<div class="bottom-link-wrapper">
						<a href="#" class="visit-link">Visit our Franchise Section <span class="arrow">&rarr;</span></a>
					</div>
				</div>
			</div>
		</section>

		<!-- ============================ Browse By Locations Start ================================== -->
		<section class="bg-light">
			<div class="container">

				<div class="row align-items-center justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="smart-heading-wrap">
							<div class="smart-heading">
								<h2 class="section-title">How Do I Sell My Business?</h2>
							</div>

						</div>
					</div>
				</div>

				<div class="row justify-content-start g-4">

					<!-- Single Item -->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-1.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Family House</h5>
									</div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-2.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Apartments</h5>
									</div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-3.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Villa & Resort</h5>
									</div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-4.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Office & Studio</h5>
									</div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-5.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Duplexes </h5>
									</div>
								</div>
							</a>
						</div>
					</div>

					<!-- Single Item -->
					<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
						<div class="propertyTypesgrid style-2">
							<a href="#" class="typesLink smalls">
								<img src="assets/img/cat-6.jpg" class="img" alt="Property Types">
								<div class="typesCaps">
									<div class="typesTitle">
										<h5 class="title">Condo House</h5>
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="categories-links-wrapper">
						<a href="#" class="category-link">View more Popular Locations <span
								class="arrow">&rarr;</span></a>
					</div>

				</div>

			</div>
		</section>