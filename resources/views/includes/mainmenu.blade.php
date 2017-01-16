    <nav class="navbar navbar-fixed-top navbar-light bg-light"  >
      <a class="navbar-brand" href="{{ url('/') }}">Suffolk Democratic Committee</a>
      <ul class="nav navbar-nav">
        <li class="nav-item" >
          <a class="nav-link" id="navlink_person_a" href="{{ url('/person') }}">People<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="navlink_committee_a" href="{{ url('/committee') }}">Committees</a>
        </li>
        @if ( isset($additional_menu_items) )
            {{ $additional_menu_items }}
        @endif
        @if( \Auth::user() )
        <li class="nav-item nav-account" id="user" >
<!--            <a class="nav-link account" href="{{ url('profile') }}">{{ \Auth::user()->name }}</a> -->
                {{ \Auth::user()->name }}
        </li>
        @endif
        <li class="nav-item nav-account" id="login" >
            @if ( Auth::check() ) 
                <a class="nav-link account" href="{{ url('logout') }}">Log Out</a>
            @else
                <a class="nav-link" href="{{ url('login') }}">Log In</a>
            @endif
        </li>
        <li class="nav-item nav-account" id="register" >
            <a class="nav-link account" href="{{ url('register') }}">Register</a>
        </li>
      </ul>
    </nav>

