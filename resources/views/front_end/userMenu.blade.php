<div class="user-dasboard-menu faq-nav">
    <ul>
        <li><a href="{{ url('my-profile') }}" style="background-color: rgb(242, 233, 224);">{{ __('messages.profile') }}</a></li>

        @if(\Auth::user()->role == 4)
        <!-- Agency Role (role 4) - Show Employees -->
        <li><a href="{{ url('my-employees') }}">{{ __('messages.employees') }}</a></li>
        @endif

        @if (request()->routeIs('my-profile'))
        <li>
            <a href="javascript:void(0);" id="clientRegistrationBtn">
                Client Registration
            </a>
        </li>
        @else
        <li>
            <a href="{{ url('my-profile') }}?registration=true">
                Client Registration
            </a>
        </li>
        @endif

        @if(\Auth::user()->role == 4 || \Auth::user()->role == 3)
        <li><a href="{{ url('client-list') }}">Client List</a></li>
        @endif

        @if( \Auth::user()->role == 3)
        <li><a href="{{ url('visit-schedule') }}">{{ __('messages.my_visit_schedule') }}</a></li>
        @endif

        <li><a href="{{ url('my-reservations') }}">{{ __('messages.my_reservations') }}</a></li>
        <li><a href="{{ url('favorite') }}">{{ __('messages.my_favorite') }}
                <!-- <span>6</span> -->
            </a></li>

    </ul>
    <a href="{{ url('user/logout') }}" class="hum_log-out_btn"><i class="fa-light fa-power-off"></i> {{ __('messages.log_out') }}</a>
</div>