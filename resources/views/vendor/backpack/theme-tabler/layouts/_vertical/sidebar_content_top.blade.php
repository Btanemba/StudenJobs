@if($auth ?? true)
    @if (backpack_auth()->guest())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('backpack.auth.login') }}">
                <i class="nav-icon la la-sign-in-alt d-block d-lg-none d-xl-block"></i> <span>{{ trans('backpack::base.login') }}</span>
            </a>
        </li>
    @else
        <li class="nav-item dropdown d-none d-lg-block">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="true">
             
                {{ backpack_user()->name }}
            </a>
            <div class="dropdown-menu" data-bs-popper="static">
                @if(config('backpack.base.setup_my_account_routes'))
                    <a class="dropdown-item" href="{{ route('backpack.account.info') }}">
                        <i class="nav-icon la la-lock d-block"></i>
                        {{ trans('backpack::base.my_account') }}
                    </a>
                @endif
             
           
            </div>
        </li>
    @endif
    <li class="nav-separator"></li>
@endif

{{--
    IMPORTANT NOTE!
    @include(backpack_view('inc.topbar_left_content')) in no longer used!
--}}
