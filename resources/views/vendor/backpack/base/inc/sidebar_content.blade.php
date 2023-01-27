@can('user')
    <li class="nav-title">Организация</li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i>
            {{ trans('backpack::base.dashboard') }}</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('cadry') }}'><i class='nav-icon la la-users'></i> Ходимлар
        </a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('department') }}'><i class='nav-icon la la-cubes'></i>
            Бўлимлар </a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('teacherworker') }}'><i
                class='nav-icon la la-hands-helping'></i> Устоз-шогирт</a></li>
@endcan

@can('admin')
    <li class="nav-title">Машғулотлар</li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('theme') }}'><i class='nav-icon la la-check-circle'></i> Машғулотлар</a></li>
@endcan


@can('admin')
    <li class="nav-title">Статистика</li>
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('statistics') }}"><i
                class="la la-chart-pie nav-icon"></i> Статистика </a></li>

    <li class="nav-title">Имтихонлар</li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('examination') }}'><i
                class='nav-icon la la-balance-scale'></i> Имтихонлар</a></li>

    <li class="nav-title">Лавозимлар</li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('position') }}'><i class='nav-icon la la-star'></i>
            Лавозимлар </a></li>

    <li class="nav-title">Маълумот</li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('education') }}'><i class='nav-icon la la-info'></i>
            Маълумот </a></li>
@endcan


@can('super-admin')
    <li class="nav-title">Предприятия</li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('railway') }}'><i class='nav-icon la la-sitemap'></i>
            Катта корхоналар</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('organization') }}'><i
                class='nav-icon la la-sitemap'></i> Корхоналар </a></li>

    <li class="nav-title">Администрация</li>
    <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Аутентификация</a>
        <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i>
                    <span>Фойдаланувчилар</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                        class="nav-icon la la-id-badge"></i> <span>Роли</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                        class="nav-icon la la-key"></i> <span>Разрешения</span></a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('userorganization') }}'><i
                        class='nav-icon la la-user-check'></i> Прикрепление</a></li>
        </ul>
    </li>
@endcan
