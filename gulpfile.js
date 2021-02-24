var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        'backend/bootstrap.min.css',
        'backend/animate.css',
        'backend/font-awesome.min.css',
        'backend/animsition.min.css',
        'backend/daterangepicker-bs3.css',
        'backend/morris.css',
        'backend/owl.carousel.css',
        'backend/owl.theme.css',
        'backend/rickshaw.min.css',
        'backend/bootstrap-datetimepicker.min.css',
        'backend/jquery.dataTables.min.css',
        'backend/datatables.bootstrap.min.css',
        'backend/chosen.min.css',
        'backend/toastr.min.css',
        'backend/main.css'
    ], 'public/assets/css/backend.css');

    mix.scripts([
        'backend/modernizr-2.8.3-respond-1.4.2.min.js',
        'backend/bootstrap.min.js',
        'backend/jRespond.min.js',
        'backend/d3.min.js',
        'backend/d3.layout.min.js',
        'backend/rickshaw.min.js',
        'backend/jquery.sparkline.min.js',
        'backend/jquery.slimscroll.min.js',
        'backend/jquery.animsition.min.js',
        'backend/moment.min.js',
        'backend/daterangepicker.js',
        'backend/screenfull.min.js',
        'backend/raphael-min.js',
        'backend/morris.min.js',
        'backend/owl.carousel.min.js',
        'backend/bootstrap-datetimepicker.min.js',
        'backend/jquery.dataTables.min.js',
        'backend/dataTables.bootstrap.js',
        'backend/chosen.jquery.min.js',
        'backend/toastr.min.js',
        'backend/jquery.sortable.min.js',
        'backend/jquery.easypiechart.min.js',
        'backend/tinymce.min.js',
//        'backend/main.js'
    ], 'public/assets/js/backend.js');

    mix.version(['public/assets/js/backend.js', 'public/assets/css/backend.css']);
});
