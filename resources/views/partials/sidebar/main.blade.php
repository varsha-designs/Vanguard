<nav class="col-md-2 sidebar">
    <div class="user-box text-center pt-5 pb-3">
        <div class="user-img">
            <img src="{{ auth()->user()->present()->avatar }}"
                 width="90"
                 height="90"
                 alt="user-img"
                 class="rounded-circle img-thumbnail img-responsive">
        </div>
        <h5 class="my-3">
            <a href="{{ route('profile') }}">{{ auth()->user()->present()->nameOrEmail }}</a>
        </h5>

        <ul class="list-inline mb-2">
            <li class="list-inline-item">
                <a href="{{ route('profile') }}" title="@lang('My Profile')">
                    <i class="fas fa-cog"></i>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('auth.logout') }}" class="text-custom" title="@lang('Logout')">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Menu -->
    <div class="sidebar-sticky">
        <ul class="nav flex-column">

            <!-- Plugins -->
            @foreach (\Vanguard\Plugins\Vanguard::availablePlugins() as $plugin)
                @include('partials.sidebar.items', ['item' => $plugin->sidebar()])
            @endforeach

            <!-- Students -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('students.index') }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>@lang('Students')</span>
                </a>
            </li>

            <!-- Student Daily Activities -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('daily_activities.index') }}">
                    <i class="fas fa-tasks"></i>
                    <span>@lang('Stu-Daily Activities')</span>
                </a>
            </li>

            <!-- Student Schedule -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('schedules.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Stu-Schedule</span>
                </a>
            </li>

            <!-- Faculties -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('faculties.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>@lang('Faculties')</span>
                </a>
            </li>

            <!-- Faculty Daily Activities -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('faculty_activities.index') }}">
                    <i class="fas fa-tasks"></i>
                    <span>@lang('Fac-Daily Activities')</span>
                </a>
            </li>

            <!-- Faculty Schedule -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('faculty_schedules.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Fac-Schedule</span>
                </a>
            </li>

            <!-- Courses -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('courses.index') }}">
                    <i class="fas fa-book-open"></i>
                    <span>Courses</span>
                </a>
            </li>

            <!-- Financial Modelling -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('financial.index') }}">
                    <i class="fas fa-coins"></i>
                    <span>@lang('Financial Modelling')</span>
                </a>
            </li>

            <!-- Tabs -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tabs.profile') }}">
                    <i class="fas fa-table"></i>
                    <span>Tabs</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
