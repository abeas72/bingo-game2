    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <!--<li class="nav-item active">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Login Screens:</h6>
          <a class="dropdown-item" href="#">Login</a>
          <a class="dropdown-item" href="#">Register</a>
          <a class="dropdown-item" href="#">Forgot Password</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Other Pages:</h6>
          <a class="dropdown-item" href="#">404 Page</a>
          <a class="dropdown-item" href="#">Blank Page</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>

            <li class="nav-item active">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-address-card"></i>
          <span>My Game Cards</span>
        </a>
      </li>
    -->
    
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small><i class="fas fa-fw fa-address-card"></i></small>
                <span><small>Game Cards</small></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <!--<small class="dropdown-header">View Card Options:</small>
                <small><a class="dropdown-item" href="{{ route('cards.current_cards') }}">Current Cards</a></small>
                <small><a class="dropdown-item" href="{{ route('cards.all_cards') }}">All Cards</a></small>
                <small><a class="dropdown-item" href="{{ route('cards.my_cards') }}">My Cards</a></small>-->
                <small><a class="dropdown-item" href="{{ route('cards.test_select') }}">Select Cards</a></small>
                <small><a class="dropdown-item" href="{{ route('cards.index') }}">Active Player Cards</a></small>
                <!--<small><a class="dropdown-item" href="{{ route('cards.index') }}"">All Player Cards</a></small>-->
            </div>
        </li>
        <!--
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cards.index') }}">
                <small><i class="fas fa-fw fa-chart-area"></i></small>
                <span><small>View All Game Cards</small></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cards.index') }}">
                <small><i class="fas fa-fw fa-chart-area"></i></small>
                <span><small>View Current Game Cards</small></span>
          </a>
        </li>-->
        <li class="nav-item">
             <a class="nav-link" href="{{ route('games.index') }}">
                <small> <i class="fas fa-fw fa-chart-area"></i></small>
                <span><small>View All Games</small></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('drawresults.index') }}">
                <small> <i class="fas fa-fw fa-chart-area"></i></small>
                <span><small>View All Draw Results</small></span>
            </a>
        </li>
    </ul>