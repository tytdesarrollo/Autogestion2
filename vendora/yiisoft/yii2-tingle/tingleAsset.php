<?php

namespace yii\tingle;

use yii\web\AssetBundle;

/**
 * Asset bundle for the tingle css files.
 *
 */
class tingleAsset extends AssetBundle
{
	public $sourcePath = '@bower/tingle-master/dist';
	public $css = [
		'tingle.min.css',
	];
}
