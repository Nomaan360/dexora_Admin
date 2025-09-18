<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="border-right: 1px solid rgb(225, 222, 222);">
    <div class="app-brand demo ">
        <a href="{{url(route('dashboard'))}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/images/logo.png') }}" height="40">
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">Dexora</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9" />
                <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4" />
            </svg>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

        <li class="menu-item">
            <a href="{{route('dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('category.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Category">Category</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('ads.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Ads">Ads</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('tasks.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Tasks">Tasks</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('cards.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Cards">Cards</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('levels.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Levels">Levels</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('cipher.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Cipher">Cipher</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('combo.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Combo">Combo</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{route('affiliatetask.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Affiliate Task">Affiliate Task </div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('allusers')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('winner.index')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-ticket-2-line"></i>
                <div data-i18n="Winners">Winners</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{route('reportIndex')}}" class="menu-link">
                <i class="menu-icon tf-icons ri-file-chart-line"></i>
                <div data-i18n="Referral Report">Referral Report</div>
            </a>
        </li>

    </ul>
</aside>
<!-- / Menu -->