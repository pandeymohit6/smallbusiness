 @extends('frontend.layouts.app')

 @section('content')
    	<section class="ad-flt">
		    <div class="container">
            <div class="flr-top-header">
        <div class="flr-search-container">
            <i class="fa-solid fa-magnifying-glass flr-search-icon"></i>
            <input type="text" placeholder="e.g. Gas Stations in Texas">
            <button>Search</button>
        </div>
        <div class="flr-header-links">
            <a href="#"><i class="fa-regular fa-bell"></i> Create alert</a>
            <a href="#"><i class="fa-solid fa-sliders"></i> Advanced Search</a>
        </div>
    </div>

    <div class="flr-main-container">
        
        <div class="flr-sidebar" id="flrSidebarDrawer">
            <button class="flr-sidebar-close-btn" id="flrFilterCloseBtn"><i class="fa-solid fa-xmark"></i></button>
            <h2>Filter Your Search</h2>
            
            <div class="flr-filter-group" style="z-index: 60;">
                <label class="flr-group-title">Business Location</label>
                
                <div class="flr-location-trigger-select" id="flrLocationDropdownTrigger" style="margin-bottom: 8px;">
                    <span id="flrSelectedCountryLabel">USA</span>
                    <i class="fa-solid fa-caret-down flr-dropdown-arrow"></i>
                </div>

                <div class="flr-custom-country-dropdown" id="flrCountryDropdownMenu" style="top: 66px;">
                    <div class="flr-dropdown-search-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="flrCountrySearchInput" placeholder="Type a country here...">
                    </div>
                    <div class="flr-country-list-scroll">
                        <div class="flr-country-item"><span>All Countries</span><span class="flr-country-count">(58762)</span></div>
                        <div class="flr-country-item"><span>Australia</span><span class="flr-country-count">(11077)</span></div>
                        <div class="flr-country-item"><span>Canada</span><span class="flr-country-count">(2828)</span></div>
                        <div class="flr-country-item"><span>France</span><span class="flr-country-count">(8362)</span></div>
                        <div class="flr-country-item flr-selected-item"><span>India</span><span class="flr-country-count">(237)</span></div>
                        <div class="flr-country-item"><span>Ireland</span><span class="flr-country-count">(287)</span></div>
                        <div class="flr-country-item"><span>New Zealand</span><span class="flr-country-count">(346)</span></div>
                        <div class="flr-country-item"><span>Portugal</span><span class="flr-country-count">(157)</span></div>
                        <div class="flr-country-item"><span>South Africa</span><span class="flr-country-count">(815)</span></div>
                    </div>
                </div>

                <div class="flr-location-trigger-select" id="flrRegionDropdownTrigger" style="margin-bottom: 8px;">
                    <span id="flrSelectedRegionLabel">All Regions</span>
                    <i class="fa-solid fa-caret-down flr-dropdown-arrow"></i>
                </div>

                <div class="flr-custom-country-dropdown" id="flrRegionDropdownMenu" style="top: 114px;">
                    <div class="flr-dropdown-search-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="flrRegionSearchInput" placeholder="Type a region here...">
                    </div>
                    <div class="flr-country-list-scroll">
                        <div class="flr-country-item flr-selected-item"><span>All Regions</span><span class="flr-country-count"></span></div>
                        <div class="flr-country-item"><span>Mid South</span><span class="flr-country-count">(3146)</span></div>
                        <div class="flr-country-item"><span>Mid West</span><span class="flr-country-count">(1866)</span></div>
                        <div class="flr-country-item"><span>Mountain</span><span class="flr-country-count">(778)</span></div>
                        <div class="flr-country-item"><span>New England</span><span class="flr-country-count">(564)</span></div>
                        <div class="flr-country-item"><span>North East</span><span class="flr-country-count">(2616)</span></div>
                        <div class="flr-country-item"><span>Pacific</span><span class="flr-country-count">(2294)</span></div>
                        <div class="flr-country-item"><span>Plains</span><span class="flr-country-count">(431)</span></div>
                        <div class="flr-country-item"><span>South East</span><span class="flr-country-count">(4100)</span></div>
                    </div>
                </div>

                <div class="flr-location-trigger-select" id="flrStateDropdownTrigger" style="margin-bottom: 8px;">
                    <span id="flrSelectedStateLabel">All States</span>
                    <i class="fa-solid fa-caret-down flr-dropdown-arrow"></i>
                </div>

                <div class="flr-custom-country-dropdown" id="flrStateDropdownMenu" style="top: 162px;">
                    <div class="flr-dropdown-search-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="flrStateSearchInput" placeholder="Type a state here...">
                    </div>
                    <div class="flr-country-list-scroll">
                        <div class="flr-country-item flr-selected-item"><span>All States</span><span class="flr-country-count"></span></div>
                        <div class="flr-country-item"><span>Arizona</span><span class="flr-country-count">(647)</span></div>
                        <div class="flr-country-item"><span>California</span><span class="flr-country-count">(1783)</span></div>
                        <div class="flr-country-item flr-sub-level"><span>California - North</span><span class="flr-country-count">(561)</span></div>
                        <div class="flr-country-item flr-sub-level"><span>California - South</span><span class="flr-country-count">(954)</span></div>
                        <div class="flr-country-item"><span>Colorado</span><span class="flr-country-count">(366)</span></div>
                        <div class="flr-country-item"><span>Florida</span><span class="flr-country-count">(2862)</span></div>
                        <div class="flr-country-item"><span>Illinois</span><span class="flr-country-count">(543)</span></div>
                    </div>
                </div>

                <div class="flr-location-trigger-select" id="flrCityDropdownTrigger" style="margin-bottom: 8px;">
                    <span id="flrSelectedCityLabel">All Cities</span>
                    <i class="fa-solid fa-caret-down flr-dropdown-arrow"></i>
                </div>

                <div class="flr-custom-country-dropdown" id="flrCityDropdownMenu" style="top: 210px;">
                    <div class="flr-dropdown-search-container">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="flrCitySearchInput" placeholder="Type a city here...">
                    </div>
                    <div class="flr-country-list-scroll">
                        <div class="flr-country-item flr-selected-item"><span>All Cities</span><span class="flr-country-count"></span></div>
                        <div class="flr-country-item"><span>Dallas County</span><span class="flr-country-count">(182)</span></div>
                        <div class="flr-country-item"><span>Dallas/ Ft. Worth Metroplex</span><span class="flr-country-count">(251)</span></div>
                        <div class="flr-country-item"><span>Houston</span><span class="flr-country-count">(238)</span></div>
                        <div class="flr-country-item"><span>Jacksonville</span><span class="flr-country-count">(146)</span></div>
                        <div class="flr-country-item"><span>Las Vegas</span><span class="flr-country-count">(243)</span></div>
                        <div class="flr-country-item"><span>Los Angeles</span><span class="flr-country-count">(173)</span></div>
                    </div>
                </div>
            </div>

            <div class="flr-filter-group" style="z-index: 55;">
                <label class="flr-group-title">Business Category</label>
                <div class="flr-location-trigger-select" id="flrCategoryDropdownTrigger">
                    <span id="flrSelectedCategoryLabel">All Sectors</span>
                    <i class="fa-solid fa-caret-down flr-dropdown-arrow"></i>
                </div>

                <div class="flr-mega-category-dropdown" id="flrCategoryMegaMenu">
                    <div class="flr-mega-grid">
                        <div class="flr-category-col" id="flrMainSectorsColumn">
                            <div class="flr-category-item" data-sector="all-sectors"><span>All Sectors (17117)</span> <i class="fa-solid fa-angle-right"></i></div>
                            <div class="flr-category-item" data-sector="agriculture"><span>Agriculture (96)</span> <i class="fa-solid fa-angle-right"></i></div>
                            <div class="flr-category-item" data-sector="energy"><span>Energy (122)</span> <i class="fa-solid fa-angle-right"></i></div>
                            <div class="flr-category-item" data-sector="engineering"><span>Engineering (328)</span> <i class="fa-solid fa-angle-right"></i></div>
                            <div class="flr-category-item" data-sector="food"><span>Food (4607)</span> <i class="fa-solid fa-angle-right"></i></div>
                            <div class="flr-category-item flr-active-parent" data-sector="franchise-resales"><span>Franchise Resales (670)</span> <i class="fa-solid fa-angle-right"></i></div>
                            <div class="flr-category-item" data-sector="leisure"><span>Leisure (2490)</span> <i class="fa-solid fa-angle-right"></i></div>
                        </div>
                        
                        <div class="flr-category-col" id="flrSubSectorsColumn"></div>
                    </div>
                    <div class="flr-category-dropdown-footer">
                        <div class="flr-footer-breadcrumb" id="flrMenuBreadcrumb">Franchise Resales (670)</div>
                        <button class="flr-btn-update">Update Results</button>
                    </div>
                </div>
            </div>
            <div class="flr-filter-group">
                <label class="flr-group-title">Asking Price ($)</label>
                <div class="flr-input-range">
                    <input type="text" placeholder="Min">
                    <input type="text" placeholder="Max">
                </div>
                <label class="flr-checkbox-label"><input type="checkbox"> Disclosed Only</label>
            </div>

            <div class="flr-filter-group">
                <label class="flr-group-title">Cash Flow ($)</label>
                <div class="flr-input-range">
                    <input type="text" placeholder="Min">
                    <input type="text" placeholder="Max">
                </div>
                <label class="flr-checkbox-label"><input type="checkbox"> Disclosed Only</label>
            </div>
			
			<div class="flr-filter-group">
                <label class="flr-group-title">Sales Revenue ($)</label>
                <div class="flr-input-range">
                    <input type="text" placeholder="Min">
                    <input type="text" placeholder="Max">
                </div>
                <label class="flr-checkbox-label"><input type="checkbox"> Disclosed Only</label>
            </div>

            <div class="flr-filter-group">
                <label class="flr-group-title">Property Filters</label>
                <label class="flr-checkbox-label"><input type="checkbox"> Real Property <span class="flr-count-span">(20)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Lease <span class="flr-count-span">(464)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Relocatable <span class="flr-count-span">(46)</span></label>
            </div>
			
			<div class="flr-filter-group">
                <label class="flr-group-title">Type of Business</label>
                <label class="flr-checkbox-label"><input type="checkbox"> Work From Home <span class="flr-count-span">(108)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Franchise <span class="flr-count-span">(464)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Price Reduced <span class="flr-count-span">(46)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Mid Market <span class="flr-count-span">(26)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Distressed <span class="flr-count-span">(4)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Low Cost <span class="flr-count-span">(134)</span></label>
            </div>
			
			<div class="flr-filter-group">
                <label class="flr-group-title">Type of Management</label>
                <label class="flr-checkbox-label"><input type="checkbox"> Owner Managed <span class="flr-count-span">(180)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Employee Owned (ESOP) <span class="flr-count-span">(1)</span></label>
                <label class="flr-checkbox-label"><input type="checkbox"> Absentee Ownership <span class="flr-count-span">(85)</span></label>
            </div>
			
			<div class="flr-filter-group">
				<label class="flr-group-title">Age of Listing</label>
				<div class="flr-premium-listing-age-grid">
					<label class="flr-age-chip-card">
						<input type="radio" name="listingAge" value="anytime">
						<span class="flr-chip-label-text">Anytime</span>
						<span class="flr-chip-badge-count">670</span>
					</label>

					<label class="flr-age-chip-card">
						<input type="radio" name="listingAge" value="3days">
						<span class="flr-chip-label-text">Last 3 Days</span>
						<span class="flr-chip-badge-count">20</span>
					</label>

					<label class="flr-age-chip-card flr-active-chip">
						<input type="radio" name="listingAge" value="14days" checked>
						<span class="flr-chip-label-text">Last 14 Days</span>
						<span class="flr-chip-badge-count">90</span>
					</label>

					<label class="flr-age-chip-card">
						<input type="radio" name="listingAge" value="month">
						<span class="flr-chip-label-text">Last Month</span>
						<span class="flr-chip-badge-count">160</span>
					</label>

					<label class="flr-age-chip-card">
						<input type="radio" name="listingAge" value="3months">
						<span class="flr-chip-label-text">Last 3 Months</span>
						<span class="flr-chip-badge-count">391</span>
					</label>
				</div>
			</div>
        </div>

        <div class="flr-content-area">
            <div class="flr-results-header">
			     <button class="flr-mobile-filter-btn" id="flrMobileFilterOpenBtn">
                    <i class="fa-solid fa-filter"></i> Filter & Refine
                </button>

                <h1>Franchise Resales For Sale In The United States</h1>
                <div class="flr-results-count">Showing <strong>1 - 25</strong> of <strong>670</strong></div>
                
                <p class="flr-info-desc">
                    Try a business that comes with a playbook. Explore Franchise Resales For Sale across the US, featuring multi-unit food franchises, national auto repair centers, and digital marketing service businesses. Secure a business with a recognized brand to fast-track your journey!
                </p>
            </div>

            <div class="flr-sorting-row">
                <div class="flr-sort-item">Sort by:<br><select><option>Default</option></select></div>
                <div class="flr-sort-item">Show:<br><select><option>25</option></select></div>
            </div>

            <div class="flr-business-card">
                <div class="flr-card-header-row">
                    <a href="#" class="flr-card-title">AI-Enabled Registration And Administrative Outsourcing Business Model</a>
                    <div class="flr-badge-container">
                        <span class="flr-badge flr-updated">Updated</span>
                        <span class="flr-badge flr-business">Business</span>
                    </div>
                </div>
                <div class="flr-location"><i class="fa-solid fa-location-dot"></i> Remote opportunity, US</div>
                
                <div class="flr-card-body">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&auto=format&fit=crop&q=60" alt="Business Image" class="flr-card-img">
                    <div class="flr-financial-details">
                        <div class="flr-financial-row"><span class="flr-label">Asking Price</span><span class="flr-value">$19,999</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Revenue</span><span class="flr-value">$69,392</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Cash Flow</span><span class="flr-value">$49,745</span></div>
                    </div>
                    <div class="flr-card-description">
                        The business operates a website-driven, fixed-fee registration and administrative processing platform, charging a standardized fee of per completed registration. The model is specifically designed to... <a href="#" class="flr-more-details">More details »</a>
                    </div>
                </div>

                <div class="flr-card-footer">
                    <div class="flr-tag-container">
                        <span class="flr-footer-tag"><i class="fa-solid fa-arrows-spin"></i> Relocatable</span>
                        <span class="flr-footer-tag"><i class="fa-solid fa-house-laptop"></i> Work From Home</span>
                    </div>
                    <div class="flr-action-buttons">
                        <button class="flr-btn-save"><i class="fa-regular fa-bookmark"></i> Save</button>
                        <button class="flr-btn-contact">Contact seller</button>
                    </div>
                </div>
            </div>

            <div class="flr-business-card">
                <div class="flr-card-header-row">
                    <a href="#" class="flr-card-title">Fast-Growing Window Cleaning Franchise</a>
                    <div class="flr-badge-container">
                        <span class="flr-badge flr-new">New</span>
                        <span class="flr-badge flr-business">Business</span>
                    </div>
                </div>
                <div class="flr-location"><i class="fa-solid fa-location-dot"></i> Adams County, Colorado, US</div>
                
                <div class="flr-card-body">
                    <img src="https://images.unsplash.com/photo-1527689368864-3a821dbccc34?w=400&auto=format&fit=crop&q=60" alt="Window Cleaning" class="flr-card-img">
                    <div class="flr-financial-details">
                        <div class="flr-financial-row"><span class="flr-label">Asking Price</span><span class="flr-value">$325,000</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Revenue</span><span class="flr-value">$479,084</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Cash Flow</span><span class="flr-value">$171,297</span></div>
                    </div>
                    <div class="flr-card-description">
                        Established 10+ Years. Recognized Franchise Brand. $128,000 Equipment Included. Home-Based Operation with Storage Facility Support. Repeat and Recurring Customer Base. Residential + Commercial Revenue... <a href="#" class="flr-more-details">More details »</a>
                    </div>
                </div>

                <div class="flr-card-footer">
                    <div class="flr-tag-container">
                        <span class="flr-footer-tag"><i class="fa-solid fa-house-laptop"></i> Work From Home</span>
                    </div>
                    <div class="flr-action-buttons">
                        <button class="flr-btn-save"><i class="fa-regular fa-bookmark"></i> Save</button>
                        <button class="flr-btn-contact">Contact seller</button>
                    </div>
                </div>
            </div>
            
            <div class="flr-business-card">
                <div class="flr-card-header-row">
                    <a href="#" class="flr-card-title">Chopped Leaf in Spokane, WA</a>
                    <div class="flr-badge-container flr-frnc">
                        <span class="flr-badge flr-franchise-right">Franchise</span>
                    </div>
                </div>
                <div class="flr-location">Spokane, WA, Washington</div>
                
                <div class="flr-card-body">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&amp;auto=format&amp;fit=crop&amp;q=60" alt="Chopped Leaf Logo" class="flr-card-img">
                    
                    <div class="flr-financial-details">
                        <div class="flr-financial-row"><span class="flr-label">Franchise Fee</span><span class="flr-value">$30,000</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Investment</span><span class="flr-value">On request</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Lifestyle</span><span class="flr-value">Full time</span></div>
                    </div>
                    <div class="flr-card-description">
                        Franchise with Chopped Leaf &amp; join our mission to turn "health food" into "comfort food". <a href="#" class="more-details">More details »</a>
                    </div>
                </div>

                <div class="flr-card-footer">
                    <div class="flr-tag-container">
                        <span class="flr-footer-tag flr-new-franchise-tag"><i class="fa-solid fa-share-nodes"></i> New Franchise</span>
                    </div>
                    <div class="flr-action-buttons">
                        <button class="flr-btn-contact" style="padding: 10px 32px;">Contact franchise</button>
                    </div>
                </div>
            </div>

            <div class="flr-business-card">
                <div class="flr-card-header-row">
                    <a href="#" class="flr-card-title">Mobile Showroom Floor Covering Business National Brand</a>
                    <div class="flr-badge-container">
                        <span class="flr-badge flr-new">New</span>
                        <span class="flr-badge flr-business">Business</span>
                    </div>
                </div>
                <div class="flr-location"><i class="fa-solid fa-location-dot"></i> Bridgeview, Illinois, US</div>
                
                <div class="flr-card-body">
                    <div class="flr-card-no-img">
                        <i class="fa-solid fa-store"></i>
                        <span>Retail Showroom</span>
                    </div>
                    <div class="flr-financial-details">
                        <div class="flr-financial-row"><span class="flr-label">Asking Price</span><span class="flr-value">$160,000</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Revenue</span><span class="flr-value">$250,000</span></div>
                        <div class="flr-financial-row"><span class="flr-label">Cash Flow</span><span class="flr-value">$50K - $100K</span></div>
                    </div>
                    <div class="flr-card-description">
                        This national franchise has an owner who is looking to sell this mobile showroom business. Selling floor covering carpet/wood/tile direct to consumers who shop in the comfort of their own homes. Other... <a href="#" class="flr-more-details">More details »</a>
                    </div>
                </div>

                <div class="flr-card-footer">
                    <div class="flr-tag-container">
                        <span class="flr-footer-tag"><i class="fa-solid fa-file-contract"></i> Lease</span>
                    </div>
                    <div class="flr-action-buttons">
                        <button class="flr-btn-save"><i class="fa-regular fa-bookmark"></i> Save</button>
                        <button class="flr-btn-contact">Contact seller</button>
                    </div>
                </div>
            </div>

            <div class="flr-pagination-container">
                <div class="flr-pagination-status">
                    Showing <strong>1 - 25</strong> of <strong>670</strong> results
                </div>
                <div class="flr-pagination-box">
                    <a href="#" class="flr-pagination-link flr-nav-btn">« Prev</a>
                    <a href="#" class="flr-pagination-link flr-active">1</a>
                    <a href="#" class="flr-pagination-link">2</a>
                    <a href="#" class="flr-pagination-link">3</a>
                    <a href="#" class="flr-pagination-link">4</a>
                    <a href="#" class="flr-pagination-link">5</a>
                    <a href="#" class="flr-pagination-link">6</a>
                    <a href="#" class="flr-pagination-link">7</a>
                    <a href="#" class="flr-pagination-link">8</a>
                    <a href="#" class="flr-pagination-link">9</a>
                    <a href="#" class="flr-pagination-link">10</a>
                    <a href="#" class="flr-pagination-link flr-nav-btn">Next »</a>
                </div>
            </div>

        </div>
    </div>
</div>
</section>
 @endsection
