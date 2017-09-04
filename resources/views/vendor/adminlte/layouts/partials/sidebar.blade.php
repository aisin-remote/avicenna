<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <!-- Multilevel link ref -->
            {{-- dev-1.0, Ferry, 20170822, Depth level menu kami batasi 0-3 untuk performance, jika lebih maka dianggap 3 --}}
            @foreach ($aisya_root_menu as $root_menu)

              @if (! $root_menu->apps_has_child)    {{-- level-0 --}}
                <li><a href="{{ url($root_menu->apps_route) }}"><i class='{{ $root_menu->apps_icon_code }}'></i> <span>{{ $root_menu->apps_fname }}</span></a></li>
              
              @else
                <li class="treeview">
                  <a href="{{ url($root_menu->apps_route) }}">
                    <i class="{{ $root_menu->apps_icon_code }}"></i> <span>{{ $root_menu->apps_fname }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">

                    @foreach ($aisya_menu_1 = AisyaApps::select('ais_apps.*')
                                                        ->join('role_has_apps', 'ais_apps.id', '=', 'role_has_apps.apps_id')
                                                        ->whereIn('role_has_apps.role_id', $user->roles->pluck('id')->toArray())
                                                        ->where('apps_level', 1)
                                                        ->where('apps_tcode_root', $root_menu->apps_tcode)
                                                        ->distinct()->get() as $menu_1)

                      @if (! $menu_1->apps_has_child)    {{-- level-1 --}}
                        <li><a href="{{ url($menu_1->apps_route) }}"><i class="{{ $menu_1->apps_icon_code }}"></i> {{ $menu_1->apps_fname }}</a></li>

                      @else
                        <li class="treeview">
                          <a href="{{ url($menu_1->apps_route) }}"><i class="{{ $menu_1->apps_icon_code }}"></i> {{ $menu_1->apps_fname }}
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">

                            @foreach ($aisya_menu_2 = AisyaApps::select('ais_apps.*')
                                                                ->join('role_has_apps', 'ais_apps.id', '=', 'role_has_apps.apps_id')
                                                                ->whereIn('role_has_apps.role_id', $user->roles->pluck('id')->toArray())
                                                                ->where('apps_level', 2)
                                                                ->where('apps_tcode_parent', $menu_1->apps_tcode)
                                                                ->distinct()->get() as $menu_2)
                              
                              @if (! $menu_2->apps_has_child)    {{-- level-2 --}}
                                <li><a href="{{ url($menu_2->apps_route) }}"><i class="{{ $menu_2->apps_icon_code }}"></i> {{ $menu_2->apps_fname }}</a></li>

                              @else
                                <li class="treeview">
                                  <a href="{{ url($menu_2->apps_route) }}"><i class="{{ $menu_2->apps_icon_code }}"></i> {{ $menu_2->apps_fname }}
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                    @foreach ($aisya_menu_3 = AisyaApps::select('ais_apps.*')
                                                                ->join('role_has_apps', 'ais_apps.id', '=', 'role_has_apps.apps_id')
                                                                ->whereIn('role_has_apps.role_id', $user->roles->pluck('id')->toArray())
                                                                ->where('apps_level', 3)
                                                                ->where('apps_tcode_parent', $menu_2->apps_tcode)
                                                                ->distinct()->get() as $menu_3)

                                        <li><a href="{{ url($menu_3->apps_route) }}"><i class="{{ $menu_3->apps_icon_code }}"></i> {{ $menu_3->apps_fname }}</a></li>
                                    @endforeach
                                  </ul>
                                </li>
                              @endif

                            @endforeach

                          </ul>
                        </li>

                      @endif

                    @endforeach

                  </ul>
                </li>
             
              @endif  {{-- dev-1.0, Ferry, 20170822, jika menu punya sub menu --}}
            @endforeach

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
