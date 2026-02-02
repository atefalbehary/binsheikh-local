<style>
    .menu-active {
        background-color: rgb(242, 233, 224);
    }
</style>
<div class="user-dasboard-menu faq-nav">
    <ul>
        {{-- Profile --}}
        <li>
            <a href="{{ url('my-profile') }}"
                class="{{ request()->is('my-profile') && !request()->has('registration') ? 'menu-active' : '' }}">
                {{ __('messages.profile') }}
            </a>
        </li>

        {{-- Agency Role --}}
        @if(Auth::user()->role == 4)
        <li>
            <a href="{{ url('my-employees') }}"
                class="{{ request()->is('my-employees') ? 'menu-active' : '' }}">
                {{ __('messages.employees') }}
            </a>
        </li>
        @endif

        {{-- Client Registration --}}
        <li>
            <a href="{{ request()->is('my-profile')
                        ? 'javascript:void(0);'
                        : url('my-profile') . '?registration=true' }}"
                id="clientRegistrationBtn"
                class="{{ request()->has('registration') ? 'menu-active' : '' }}">
                Client Registration
            </a>
        </li>

        {{-- Client List --}}
        @if(Auth::user()->role == 4 || Auth::user()->role == 3)
        <li>
            <a href="{{ url('client-list') }}"
                class="{{ request()->is('client-list') ? 'menu-active' : '' }}">
                Client List
            </a>
        </li>
        @endif

        {{-- Visit Schedule --}}
        @if(Auth::user()->role == 3)
        <li>
            <a href="{{ url('visit-schedule') }}"
                class="{{ request()->is('visit-schedule') ? 'menu-active' : '' }}">
                {{ __('messages.my_visit_schedule') }}
            </a>
        </li>
        @endif

        {{-- Reservations --}}
        <li>
            <a href="{{ url('my-reservations') }}"
                class="{{ request()->is('my-reservations') ? 'menu-active' : '' }}">
                {{ __('messages.my_reservations') }}
            </a>
        </li>

        {{-- Favorite --}}
        <li>
            <a href="{{ url('favorite') }}"
                class="{{ request()->is('favorite') ? 'menu-active' : '' }}">
                {{ __('messages.my_favorite') }}
            </a>
        </li>
    </ul>

    <a href="{{ url('user/logout') }}" class="hum_log-out_btn">
        <i class="fa-light fa-power-off"></i> {{ __('messages.log_out') }}
    </a>
</div>