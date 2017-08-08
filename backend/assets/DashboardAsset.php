<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/site.css',
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/bootstrap3-wysihtml5.min.css',
        'css/morris.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',
        'css/site.css',
        'css/custom-bootstrap.css',
    ];
    public $js = [
        'js/main.js',
        'js/jquery-ui.min.js',
        'js/bootstrap.min.js',
        'js/jquery.sparkline.min.js',
        'js/jquery.slimscroll.min.js',
        'js/fastclick.js',
        'js/adminlte.min.js',
        'js/jquery.knob.min.js',
        //'raphael/raphael.min.js',
        //'morris/morris.min.js',
        'plugins/bootstrap3-wysihtml5.all.min.js',
        //'plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        //'danger-picker/moment.min.js',
        //'danger-picker/daterangepicker.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}