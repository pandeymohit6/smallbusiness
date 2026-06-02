{{--  <section class="bg-light1">

			<div class="container">

				<div class="featured-section fea-se">
					<h2 class="section-title">Featured Businesses</h2>

					<div class="cards-container">

						@forelse($featuredBusinesses ?? [] as $business)
							<div class="business-card">
								<div class="card-content">
									<a href="{{ route('businesses.show', $business->slug) }}" class="card-heading">
										{{ $business->title }}
									</a>
									<p class="card-location">
										{{ $business->location }}
									</p>
								</div>
								<div class="card-footer">
									@if($business->asking_price)
										${{ number_format($business->asking_price) }}
									@else
										On request
									@endif
								</div>
							</div>
						@empty
							<!-- Fallback featured businesses -->
							<div class="business-card">
								<div class="card-content">
									<a href="#" class="card-heading">Heavy-Duty Truck And Diesel Engine Repair Business</a>
									<p class="card-location">San Antonio, Texas</p>
								</div>
								<div class="card-footer">On request</div>
							</div>

							<div class="business-card">
								<div class="card-content">
									<a href="#" class="card-heading">Global Business Coaching Platform With Licensing
										Potential</a>
									<p class="card-location">Dayton, Ohio</p>
								</div>
								<div class="card-footer">Available On Request</div>
							</div>

							<div class="business-card">
								<div class="card-content">
									<a href="#" class="card-heading">High-Growth DTC Health And Beauty Brand</a>
									<p class="card-location">United States</p>
								</div>
								<div class="card-footer">$700,000</div>
							</div>

							<div class="business-card">
								<div class="card-content">
									<a href="#" class="card-heading">Premium Stand-Alone Liquor Store</a>
									<p class="card-location">San Sanford, Florida</p>
								</div>
								<div class="card-footer">$900,000</div>
							</div>
						@endforelse

					</div>
				</div>
			</div>
		</section>  --}}


		<section class="bg-light1">
<div class="container">
 
				<div class="featured-section fea-se">
<h2 class="section-title">Featured Businesses</h2>
 
					<div class="cards-container">
 
						<div class="business-card">
<div class="card-content">
<a href="#" class="card-heading">It is a long established fact that a reader will distracted</a>
<p class="card-location">San Antonio, Texas</p>
</div>
<div class="card-footer">On request</div>
</div>
 
						<div class="business-card">
<div class="card-content">
<a href="#" class="card-heading">It is a long established fact that a reader will be distracted</a>
<p class="card-location">Dayton, Ohio</p>
</div>
<div class="card-footer">Available On Request</div>
</div>
 
						<div class="business-card">
<div class="card-content">
<a href="#" class="card-heading">It is a long established fact that a reader will</a>
<p class="card-location">United States</p>
</div>
<div class="card-footer">$400,000</div>
</div>
 
						<div class="business-card">
<div class="card-content">
<a href="#" class="card-heading">Premium Stand-Alone Liquor Store USA</a>
<p class="card-location">San Sanford, Florida</p>
</div>
<div class="card-footer">$600,000</div>
</div>
 
					</div>
</div>
</div>
</section>