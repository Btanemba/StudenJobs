{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


<x-backpack::menu-item title="Persons" icon="la la-user nav-icon" :link="backpack_url('user')" />





<li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="la la-lock nav-icon"></i> {{ trans('backpack::base.logout') }}
    </a>
</li>

<!-- Add a hidden form for logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

