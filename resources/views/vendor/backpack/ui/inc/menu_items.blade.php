{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}</a></li>

@auth
    @if (auth()->user()->isAdmin())
        {{-- Admin-only menu items --}}
        <x-backpack::menu-item title="Administrators" icon="la la-user-shield" :link="backpack_url('administrator')" />
        <x-backpack::menu-item title="Persons" icon="la la-user" :link="backpack_url('user')" />
        <x-backpack::menu-item title="Skills" icon="la la-cogs" :link="backpack_url('skill')" />


        <x-backpack::menu-dropdown title="Settings" icon="la la-cog">
            <x-backpack::menu-dropdown-item title="Selections" :link="backpack_url('selection')" />
            <x-backpack::menu-dropdown-item title="Regions" :link="backpack_url('region')" />
        </x-backpack::menu-dropdown>
    @else
        {{-- Regular user menu items --}}
        <x-backpack::menu-item title="My Profile" icon="la la-user" :link="backpack_url('user/' . auth()->id() . '/edit')" />
        <x-backpack::menu-item title="My Skills" icon="la la-cogs" :link="backpack_url('skill?user_id=' . auth()->id())" />

        {{-- <x-backpack::menu-item title="Invoices" icon="la la-file-invoice" :link="backpack_url('invoice')" /> --}}

    @endif
@endauth

<x-backpack::menu-item title="Invoices" icon="la la-file-invoice" :link="backpack_url('invoice')" />


<li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="la la-lock nav-icon"></i> {{ trans('backpack::base.logout') }}
    </a>
</li>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
