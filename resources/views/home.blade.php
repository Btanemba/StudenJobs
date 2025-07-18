<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header.package-header {
            background-color: #242c36;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-bottom: none;
        }

        .modal-header.package-header i.fa {
            font-size: 24px;
            margin-right: 10px;
        }

        .modal-header.package-header h3 {
            font-size: 24px;
            margin: 0;
            display: inline-block;
        }

        .modal-body.package-price {
            text-align: center;
            padding: 30px;
        }

        .modal-body.package-price h2 {
            font-size: 36px;
            color: #242c36;
            margin-bottom: 15px;
        }

        .modal-body.package-price h2 sup {
            font-size: 20px;
            vertical-align: super;
        }

        .modal-body.package-price p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .modal-footer {
            justify-content: center;
            border-top: none;
            padding: 15px;
        }

        .contact-btn {
            background-color: #242c36;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .contact-btn:hover {
            background-color: #1a2028;
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
@include('layouts.header')
@include('layouts.navbar')

<section class="main-banner" style="background:#242c36 url(img/DanStephenLibrary.jpeg) no-repeat">
    <div class="container">
        <div class="caption">
            <h2>At Your Service</h2>
            <form action="{{ route('home') }}" method="GET" class="search-form" id="searchForm">
                @php
                    $skills = \App\Models\Selection::where('table', 'Skills')
                        ->where('field', 'Un-skill')
                        ->orderBy('name')
                        ->pluck('name', 'code')
                        ->toArray();

                    $austrianRegions = \App\Models\Region::orderBy('name')->pluck('name', 'id')->toArray();
                @endphp

                <fieldset>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <select name="skills" class="form-control selectpicker">
                                <option value="">Select Skill</option>
                                @foreach ($skills as $code => $name)
                                    <option value="{{ $code }}" {{ request('skills') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <select name="country" id="countrySelect" class="form-control selectpicker">
                                <option value="">Select Country</option>
                                @php
                                    $countries = collect([
                                        'AT' => 'Austria',
                                        'CH' => 'Switzerland',
                                        'FR' => 'France',
                                        'separator' => '──────────',
                                    ])->merge(
                                        collect((new \League\ISO3166\ISO3166())->all())
                                            ->pluck('name', 'alpha2')
                                            ->sort()
                                    );
                                @endphp

                                @foreach($countries as $code => $name)
                                    @if($code === 'separator')
                                        <option disabled>{{ $name }}</option>
                                    @else
                                        <option value="{{ $code }}" {{ request('country') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <select name="region_id" id="regionSelect" class="form-control selectpicker" {{ request('country') != 'AT' ? 'disabled' : '' }}>
                                <option value="">Select Region (Austria only)</option>
                                @foreach($austrianRegions as $id => $name)
                                    <option value="{{ $id }}" {{ request('region_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="form-group col-md-3">
                            <input type="text" name="description" class="form-control" placeholder="Search by description" value="{{ request('description') }}">
                        </div> --}}

                        <div class="form-group col-md-12 d-flex justify-content-start" style="gap: 20px;">
                            <button type="submit" class="btn btn-primary px-4">Search</button>
                            <a href="{{ route('home') }}" class="btn btn-primary px-1">Clear</a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>

<!-- Enhanced Search Results Section -->
@if(request()->has('country') || request()->has('skills') || request()->has('region_id') || request()->has('description'))
    <section class="search-results" id="search-results">
        <div class="container">
            @if(!empty($users) && $users->count() > 0)
                <h2 class="search-results-title">Search Results</h2>
                <div class="row">
                    @foreach ($users as $user)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card user-card">
                                <div class="card-header d-flex align-items-center">
                                    <div class="profile-picture mr-3">
                                        @if ($user->person && $user->person->profile_picture)
                                            <img src="{{ Storage::url($user->person->profile_picture) }}"
                                                 alt="{{ $user->person->first_name ?? 'User' }}'s Profile Picture"
                                                 class="profile-img">
                                        @else
                                            <img src="{{ asset('images/default-profile.png') }}"
                                                 alt="Default Profile Picture"
                                                 class="profile-img">
                                        @endif
                                    </div>
                                    <h5 class="card-title mb-0">
                                        {{ $user->person->first_name ?? 'N/A' }} {{ $user->person->last_name ?? '' }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <a href="mailto:{{ $user->email }}" class="contact-btn">Contact Me</a>
                                    </p>
                                    @if(request('region_id'))
                                        <p class="card-text"><strong>Location:</strong>
                                            {{ $austrianRegions[request('region_id')] ?? 'Unknown' }}
                                        </p>
                                    @endif
                                    @php
                                        $skill = $user->skills->firstWhere('skill_name', $selectedSkill);
                                        $photos = $skill ? ($skill->sample_pictures ?? []) : [];
                                        $price = $skill ? ($skill->price ?? null) : null;
                                        $description = $skill ? ($skill->description ?? null) : null;
                                    @endphp
                                    @if ($price)
                                        <p class="card-text"><strong>Price:</strong>
                                            @if (is_numeric($price))
                                                <span class="price">€{{ number_format($price, 2) }}</span>
                                            @else
                                                {{ $price }}
                                            @endif
                                        </p>
                                    @endif
                                    <p class="card-text"><strong>Description:</strong>
                                        {{ $description ? Str::limit($description, 100, '...') : 'Not provided' }}
                                    </p>
                                </div>
                                @if (!empty($photos))
                                    <div class="card-body samples-section">
                                        <h5>Samples of Work Done</h5>
                                        <div class="photo-gallery">
                                            @foreach ($photos as $photo)
                                                <img src="{{ asset('storage/' . $photo) }}" alt="Sample Image" class="sample-img">
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body samples-section">
                                        <p>No photos uploaded for this skill.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info no-results">
                    <h3>No professionals found matching your criteria</h3>
                    <p>
                        @if(request('region_id'))
                            We couldn't find any {{ $selectedSkill ?? 'professionals' }} in
                            {{ $austrianRegions[request('region_id')] ?? 'the selected region' }}.
                        @else
                            We couldn't find any {{ $selectedSkill ?? 'professionals' }} matching your search.
                        @endif
                    </p>
                    <p>Try broadening your search by:</p>
                    <ul>
                        <li>Selecting a different region</li>
                        <li>Removing the location filter</li>
                        <li>Trying a different skill</li>
                        <li>Modifying the description search</li>
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endif

<section class="features">
    <div class="container">
        <div class="col-md-4 col-sm-4">
            <div class="features-content">
                <span class="box1"><span aria-hidden="true" class="icon-dial"></span></span>
                <h3>Create An Account</h3>
                <p>Create your account quickly and securely using your email address and password.</p>
            </div>
        </div>

        <div class="col-md-4 col-sm-4">
            <div class="features-content">
                <span class="box1"><span aria-hidden="true" class="icon-search"></span></span>
                <h3>Upload Skills</h3>
                <p>Easily upload your skills and qualifications to showcase your strengths.</p>
            </div>
        </div>

        <div class="col-md-4 col-sm-4">
            <div class="features-content">
                <span class="box1"><span aria-hidden="true" class="fa fa-credit-card"></span></span>
                <h3>Choose a Payment Plan</h3>
                <p>Select a payment plan that suits your needs and budget. Flexible options!</p>
            </div>
        </div>
    </div>
</section>

<section class="pricind">
    <div class="container">
        <div class="col-md-4 col-sm-4">
            <div class="package-box">
                <div class="package-header">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <h3>Monthly</h3>
                </div>
                <div class="package-price">
                    <h2>Student <sup>€</sup>10</h2>
                    <h4>Regular <sup>€</sup>15</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="package-box">
                <div class="package-header">
                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    <h3>6-Months</h3>
                </div>
                <div class="package-price">
                    <h2>Student <sup>€</sup>50</h2>
                    <h4>Regular <sup>€</sup>80</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="package-box">
                <div class="package-header">
                    <i class="fa fa-cube" aria-hidden="true"></i>
                    <h3>Yearly</h3>
                </div>
                <div class="package-price">
                    <h2>Student <sup>€</sup>100</h2>
                    <h4>Regular <sup>€</sup>160</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header package-header">
                <i class="fa fa-cog" aria-hidden="true"></i>
                <h3 class="modal-title" id="registerModalLabel">Special Offer</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body package-price">
                <h2>Register Now <sup>€</sup>2/month</h2>
                <p>Unlock full access for just €2 per month for the first month!</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Register Now</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script src="js/bootsnav.js"></script>
<script src="js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('countrySelect');
    const regionSelect = document.getElementById('regionSelect');
    const searchForm = document.getElementById('searchForm');

    function toggleRegionField() {
        regionSelect.disabled = countrySelect.value !== 'AT';
        if (regionSelect.disabled) {
            regionSelect.value = '';
        }
        if (typeof $.fn.selectpicker !== 'undefined') {
            $(regionSelect).selectpicker('refresh');
            $(countrySelect).selectpicker('refresh');
        }
    }

    toggleRegionField();
    countrySelect.addEventListener('change', toggleRegionField);

    function scrollToSearchResults() {
        const searchResults = document.getElementById('search-results');
        if (searchResults) {
            searchResults.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
            });
        }
    }

    const urlParams = new URLSearchParams(window.location.search);
    const hasSearchParams = urlParams.has('country') || urlParams.has('skills') || urlParams.has('region_id') || urlParams.has('description');

    if (hasSearchParams) {
        setTimeout(scrollToSearchResults, 300);
    }

    searchForm.addEventListener('submit', function (event) {
        setTimeout(scrollToSearchResults, 100);
    });
});

$(document).ready(function () {
    $('#registerModal').modal('show');
});
</script>
</body>
</html>
