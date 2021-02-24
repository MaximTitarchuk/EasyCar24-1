<div class="row">
    <h4 class="text-center">Статистика за сутки</h4>
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="100"
             data-size="140"
             data-bar-color="#418bca"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-search fa-4x text-blue" style="line-height: 140px;"></i>

        </div>
        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-blue">{{ $stats['day']['all'] }}</strong><br/><small class="text-lg text-light text-blue lt">Запросов </small></p>
    </div>
    <!-- /col -->
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="{{ $stats['day']['percent-found'] }}"
             data-size="140"
             data-bar-color="#16a085"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-search fa-4x text-greensea" style="line-height: 140px;"></i>

        </div>
        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-greensea">{{ $stats['day']['found'] }}</strong><br/><small class="text-lg text-light text-greensea lt">Найдено</small></p>
    </div>
    <!-- /col -->
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="{{ $stats['day']['percent-sms'] }}"
             data-size="140"
             data-bar-color="#5cb85c"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-paper-plane fa-4x text-success" style="line-height: 140px;"></i>
            <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-success">{{ $stats['day']['sms'] }}</strong><br/><small class="text-lg text-light text-success lt">SMS</small></p>
        </div>
    </div>
    <!-- /col -->
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="{{ $stats['day']['percent-call'] }}"
             data-size="140"
             data-bar-color="#5bc0de"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-phone fa-4x text-info" style="line-height: 140px;"></i>
            <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-info">{{ $stats['day']['call'] }}</strong><br/><small class="text-lg text-light text-info lt">Вызовов</small></p>
        </div>
    </div>
    <!-- /col -->
</div>
<!-- /row -->

<div class="row" style="margin-top: 20px">
    <h4 class="text-center">Статистика за все время</h4>
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="100"
             data-size="140"
             data-bar-color="#418bca"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-search fa-4x text-blue" style="line-height: 140px;"></i>

        </div>
        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-blue">{{ $stats['all']['all'] }}</strong><br/><small class="text-lg text-light text-blue lt">Запросов </small></p>
    </div>
    <!-- /col -->
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="{{ $stats['all']['percent-found'] }}"
             data-size="140"
             data-bar-color="#16a085"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-search fa-4x text-greensea" style="line-height: 140px;"></i>

        </div>
        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-greensea">{{ $stats['all']['found'] }}</strong><br/><small class="text-lg text-light text-greensea lt">Найдено</small></p>
    </div>
    <!-- /col -->
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="{{ $stats['all']['percent-sms'] }}"
             data-size="140"
             data-bar-color="#5cb85c"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-paper-plane fa-4x text-success" style="line-height: 140px;"></i>
            <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-success">{{ $stats['all']['sms'] }}</strong><br/><small class="text-lg text-light text-success lt">SMS</small></p>
        </div>
    </div>
    <!-- /col -->
    <!-- col -->
    <div class="col-lg-3 text-center">
        <div class="easypiechart"
             data-percent="{{ $stats['all']['percent-call'] }}"
             data-size="140"
             data-bar-color="#5bc0de"
             data-scale-color="false"
             data-line-cap="round"
             data-line-width="4"
             style="width: 140px; height: 140px;">

            <i class="fa fa-phone fa-4x text-info" style="line-height: 140px;"></i>
            <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-info">{{ $stats['all']['call'] }}</strong><br/><small class="text-lg text-light text-info lt">Вызовов</small></p>
        </div>
    </div>
    <!-- /col -->
</div>
<!-- /row -->