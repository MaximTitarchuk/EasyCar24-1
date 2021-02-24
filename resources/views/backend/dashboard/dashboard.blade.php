@extends('backend.layouts.backend')

@section('title', 'Статистика проекта')

@section('modal')
@endsection

@section('content')

    <section class="tile " style="min-height: 190px; overflow: hidden;">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font">Статистика по зарегистрированным пользователям</h1>
            <ul class="controls">
                <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">

            <div class="row">
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="100" data-size="140" data-bar-color="#418bca" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                        <i class="fa fa-users fa-4x text-blue" style="line-height: 140px;"></i>

                        <canvas height="140" width="140"></canvas></div>
                    <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-blue">{{ $data['users']['all'] }}</strong><br/> <small class="text-lg text-light text-default lt">{{ $data['users']['allText'] }}</small></p>
                    @if ($data['users']['allGrowthWeek'] != 0)
                        <p class="text-light"><i class="fa @if ($data['users']['allGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['users']['allGrowthWeek'] }}% на этой неделе</p>
                    @endif
                </div>
                <!-- /col
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="{{ $data['users']['activePercent'] }}" data-size="140" data-bar-color="#16a085" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;" >

                        <i class="fa fa-user fa-4x text-greensea" style="line-height: 140px;"></i>
                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-greensea">{{ $data['users']['active'] }}</strong><br/><nobr><small class="text-lg text-light text-default lt">{{ $data['users']['activeText'] }}</small></nobr> </p>
                        @if ($data['users']['activeGrowthWeek'] != 0)
                            <p class="text-light"><nobr><i class="fa @if ($data['users']['activeGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['users']['activeGrowthWeek'] }}% на этой неделе</nobr></p>
                        @endif
                        <canvas height="140" width="140"></canvas></div>
                </div>
                <!-- /col -->
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="{{ $data['users']['inactivePercent'] }}" data-size="140" data-bar-color="#e05d6f" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;" >
                        <i class="fa fa-user fa-4x text-lightred" style="line-height: 140px;"></i>
                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-lightred">{{ $data['users']['inactive'] }}</strong><br/><nobr><small class="text-lg text-light text-default lt">{{ $data['users']['inactiveText'] }}</small></nobr></p>
                        @if ($data['users']['inactiveGrowthWeek'] != 0)
                            <p class="text-light"><nobr><i class="fa @if ($data['users']['inactiveGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['users']['inactiveGrowthWeek'] }}% на этой неделе</nobr></p>
                        @endif
                        <canvas height="140" width="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /tile body -->

    </section>

    <section class="tile " style="min-height: 190px; overflow: hidden;">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font">Статистика по поиску</h1>
            <ul class="controls">
                <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">

            <div class="row">
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="100" data-size="140" data-bar-color="#418bca" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                        <i class="fa fa-search fa-4x text-blue" style="line-height: 140px;"></i>

                        <canvas height="140" width="140"></canvas>
                    </div>
                    <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-blue">{{ $data['search']['all'] }}</strong><br/> <small class="text-lg text-light text-default lt">{{ $data['search']['allText'] }}</small></p>
                    @if ($data['search']['allGrowthWeek'] != 0)
                        <p class="text-light"><i class="fa @if ($data['search']['allGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['search']['allGrowthWeek'] }}% на этой неделе</p>
                    @endif
                </div>
                <!-- /col -->
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="{{ $data['search']['foundPercent'] }}" data-size="140" data-bar-color="#16a085" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;" >

                        <i class="fa fa-search fa-4x text-greensea" style="line-height: 140px;"></i>
                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-greensea">{{ $data['search']['found'] }}</strong><br/><nobr><small class="text-lg text-light text-default lt">{{ $data['search']['foundText'] }}</small></nobr> </p>
                        @if ($data['search']['foundGrowthWeek'] != 0)
                            <p class="text-light"><nobr><i class="fa @if ($data['search']['foundGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['search']['foundGrowthWeek'] }}% на этой неделе</nobr></p>
                        @endif
                        <canvas height="140" width="140"></canvas></div>
                </div>
                <!-- /col -->
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="{{ $data['search']['notfoundPercent'] }}" data-size="140" data-bar-color="#e05d6f" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;" >

                        <i class="fa fa-search fa-4x text-lightred" style="line-height: 140px;"></i>
                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-lightred">{{ $data['search']['notfound'] }}</strong><br/><nobr><small class="text-lg text-light text-default lt">{{ $data['search']['notfoundText'] }}</small></nobr> </p>
                        @if ($data['search']['notfoundGrowthWeek'] != 0)
                            <p class="text-light"><nobr><i class="fa @if ($data['search']['notfoundGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['search']['notfoundGrowthWeek'] }}% на этой неделе</nobr></p>
                        @endif
                        <canvas height="140" width="140"></canvas></div>
                </div>
                <!-- /col -->
            </div>
        </div>
        <!-- /tile body -->

    </section>

    <section class="tile " style="min-height: 190px; overflow: hidden;">

        <!-- tile header -->
        <div class="tile-header dvd dvd-btm">
            <h1 class="custom-font">Статистика по оплатам</h1>
            <ul class="controls">
                <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
            </ul>
        </div>
        <!-- /tile header -->

        <!-- tile body -->
        <div class="tile-body">

            <div class="row">
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="100" data-size="140" data-bar-color="#418bca" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                        <i class="fa fa-rub fa-4x text-blue" style="line-height: 140px;"></i>

                        <canvas height="140" width="140"></canvas>
                    </div>
                    <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-blue">{{ $data['payment']['sum'] }} <i class="fa fa-rub"></i></strong></p>
                    @if ($data['payment']['sumGrowthWeek'] != 0)
                        <p class="text-light"><nobr><i class="fa @if ($data['payment']['sumGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['payment']['sumGrowthWeek'] }}% на этой неделе</nobr></p>
                    @endif
                </div>
                <!-- /col -->
                <!-- col -->
                <div class="col-lg-4 text-center">
                    <div class="easypiechart" data-percent="100" data-size="140" data-bar-color="#66CC66" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                        <i class="fa fa-rub fa-4x text-success" style="line-height: 140px;"></i>

                        <canvas height="140" width="140"></canvas>
                    </div>
                    <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-success">{{ $data['payment']['agregator'] }} <i class="fa fa-rub"></i></strong><br/><small>Free-Kassa</small></p>
                    @if ($data['payment']['agregatorGrowthWeek'] != 0)
                        <p class="text-light"><nobr><i class="fa @if ($data['payment']['agregatorGrowthWeek'] > 0) fa-caret-up text-success @else fa-caret-down text-danger @endif"></i> {{ $data['payment']['agregatorGrowthWeek'] }}% на этой неделе</nobr></p>
                    @endif
                </div>
                <!-- /col -->

            </div>
        </div>
        <!-- /tile body -->

    </section>

    <script>
        $(document).ready(function () {

        });
    </script>

@endsection