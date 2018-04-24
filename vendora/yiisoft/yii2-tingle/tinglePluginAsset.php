<?php

namespace yii\tingle;

use yii\web\AssetBundle;

/**
 * Asset bundle for the tingle javascript files.
 *
 */
class tinglePluginAsset extends AssetBundle
{
	public $sourcePath = '@bower/tingle-master/dist';
	public $js = [
		'tingle.min.js',
	];
	public $depends = [
        'yii\web\JqueryAsset',
        'yii\tingle\tingleAsset',
    ];
}
