<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    @php
      $obj = \App\Models\Settings::pluck('value', 'key');
      $logo = $obj['logo'];
    @endphp
    <a href="{{ route('dashboard') }}"><img src="{{ asset('uploads/logo/'.$logo) }}" /></a>
    {{-- <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a> --}}
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    {{-- <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Menu Header</span>
    </li> --}}

    <li class="menu-item @yield('dashboard')">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="fa fa-tachometer" aria-hidden="true"></i>&nbsp;&nbsp;
        <div>{{ transWord('Dashobard') }}</div>
      </a>
    </li>

    @if (LaravelLocalization::getCurrentLocale() == 'ar')
      @can('show_translates')
        <li class="menu-item @yield('translates')">
          <a href="{{ route('translates-edit') }}" class="menu-link">
            <i class="fa fa-language" aria-hidden="true"></i>&nbsp;&nbsp;
            <div>{{ transWord('Translates') }}</div>
          </a>
        </li>
      @endcan
    @endif

    @if(auth()->user()->can('show_users') || auth()->user()->can('show_roles'))
      <li class="menu-item @yield('users-management')">
        <a href="#" class="menu-link menu-toggle">
          <i class="fa fa-user"></i>&nbsp;&nbsp;
          <div>{{ transWord('Users') }}</div>
        </a>

        @can('show_users')
          <ul class="menu-sub">
            <li class="menu-item @yield('users')">
              <a href="{{ route('users-users-all') }}" class="menu-link">
                <div>{{ transWord('Users') }}</div>
              </a>
            </li>
          </ul>
        @endcan

        @can('show_roles')
          <ul class="menu-sub">
            <li class="menu-item @yield('roles')">
              <a href="{{ route('users-roles-all') }}" class="menu-link">
                <div>{{ transWord('Roles') }}</div>
              </a>
            </li>
          </ul>
        @endcan
      </li>
    @endif

    @can('update_settings')
      <li class="menu-item @yield('settings')">
        <a href="{{ route('settings-edit') }}" class="menu-link">
          <i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;
          <div>{{ transWord('Settings') }}</div>
        </a>
      </li>
    @endcan

  </ul>

</aside>
