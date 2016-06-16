<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Empleados_basic;

class PruebadbController extends Controller
{
    public function actionCopia()
    {
        $query = Empleados_basic::find();

        $pagination = new Pagination([
            'defaultPageSize' => 25,
            'totalCount' => $query->count(),
        ]);

        $empleados_basic = $query->orderBy('COD_EPL')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('copia', [
            'empleados_basic' => $empleados_basic,
            'pagination' => $pagination,
        ]);
    }
}