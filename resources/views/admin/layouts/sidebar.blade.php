<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <span class="align-middle">MyBot</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('contacts.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Contacts</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('templates.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('templates.index') }}">
                    <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Templates</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('messages.index') }}">
                    <i class="align-middle" data-feather="send"></i> 
                    <span class="align-middle">Messages</span>
                </a>
            </li>
        </ul>
    </div>
</nav>