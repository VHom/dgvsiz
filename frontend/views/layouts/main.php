<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title>ДЖВ</title>
    <!--title--><!--?= Html::encode($this->title) ?></title-->
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody(); ?>
<?php
$js=<<<JS
$(document).on("click","[data-remote]",function(e) { 
    e.preventDefault();
    $("div#helpdesk_modal .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#helpdesk_modal .modal-body").html('');
}); 
JS;
$this->registerJs($js);
?>
<?php 
    $user_= \app\models\User::findOne(Yii::$app->user->id);
 ?>
<div class="wrap">
    <?php
    NavBar::begin([
      //  'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if(!$user_= app\models\User::findOne(Yii::$app->user->id)) {
        $menuItems[] = ['label' => 'Выход', 'url' => ['/site/login']];
    } else     
        if($user_->username == 'supervisor')
        {
        $menuItems = [
            ['label' => 'Сотрудники',
                'items' => [
                    ['label' => 'Список сотрудников', 'url' => ['/perslist/index']],
//                    ['label' => 'Карточки сотрудников', 'url' => ['/norm-card/index']],
//                    ['label' => 'Антропометрические данные сотрудников', 'url' => ['/pers-anthrop/index']],
                ],
            ],
//            ['label' => 'Нормы и размеры',
            ['label' => 'Нормы',
                'items' => [
                    ['label' => 'Размерные группы', 'url' => ['/nomenkind/index']],
//                    ['label' => 'Список размеров', 'url' => ['/sizelist/index']],
                    ['label' => 'Нормы по сотрудникам', 'url' => ['/norm-card/index-norm']],
                    ['label' => 'Нормы по должностям', 'url' => ['/normlist/index']],
                ],
            ],
            ['label' => 'Заявки',
                'items' =>[
                    ['label' => 'Обеспеченность сотрудников СИЗ и ФО', 'url' =>['/stat-spec/index-provision']],
                    ['label' => 'Дефициные ведомости подразделения', 'url' =>['/deficit-statment/index']],
                ]
            ],
            ['label' => 'Движение СИЗ и ФО',
                'items' => [
                    ['label' => 'Приход на склад', 'url' => ['/inorder/index']],
                    ['label' => 'Отпуск сотрудникам', 'url' => ['/norm-card/index']],
                    ['label' => 'Возврат от сотрудников', 'url' => ['/inorder/index-nakl']],
                    ['label' => 'Списание со склада', 'url' => ['/invoice/index-destr']],
                    ['label' => 'Внутрихозяйственные операции', 'url' => ['/draft/index']],
                ],
            ],
            ['label' => 'Складские остатки',
                'items' => [
                    ['label' => 'Остатки на складе', 'url' => ['/storemain/index']],
                    ['label' => 'Журнал складских операций', 'url' => ['/storejournal/index']],
                ],
            ],
            ['label' => 'Словари',
                'items' => [
/*                    ['label' => 'Администрирование',
                        'items' => [
                            ['label' => 'Список ролей', 'url' => ['/rolelist/index']],
                        ]
                    ],*/
                    ['label' => 'Оргструктура',
                        'items' => [
                            ['label' => 'Организации', 'url' => ['/complist/index']],
                            ['label' => 'Филиалы', 'url' => ['/branchlist/index']],
                            ['label' => 'Подразделения', 'url' => ['/arealist/index']],
                            ['label' => 'Штатное расписание', 'url' => ['/proflist/index']],
                            ['label' => 'Категории должностей', 'url' => ['/prof-cat/index']],
                            ['label' => 'Склады', 'url' => ['/storelist/index']],
                        ]
                    ],
                    ['label' => 'Номенклатура',
                        'items' => [
                            ['label' => 'Ед. измерения', 'url' => ['/measure-unit/index']],
                            ['label' => 'Номенклатура', 'url' => ['/nomenclature/index']],
                            ['label' => 'Комплекты', 'url' => ['/const-nomen/index-const']],
//                            ['label' => 'Замены', 'url' => ['/analog/index']],
                        ]
                    ],
                    ['label' => 'Общие',
                        'items' => [
                            ['label' => 'Поставщики', 'url' => ['/supplier/index']],
//                            ['label' => 'Пользователи', 'url' => ['/userlist/index']],
                            ['label' => 'Типы документов', 'url' => ['/doctypelist/index']],
                            ['label' => 'Складские операции', 'url' => ['/stopertype/index']],
                            ],
                    ],
                ]
            ],
            ['label' => 'Администрирование',
                'items' => [
                    ['label' => 'Техническая поддержка', 'url' => ['/helpdesk/index']],
                    ['label' => 'Пользователи', 'url' => ['/userlist/index']],
                    ['label' => 'Роли', 'url' => ['/rolelist/index']],
//                            ['label' => 'Типы документов', 'url' => ['/doctypelist/index']],
                    ['label' => 'Журнал операций', 'url' => ['/operjournal/index']],
                    ],
            ],

            ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ] 
        ];
        } elseif($user_->username == 'supervisor' || $user_->username == 'admin')
        {
            $menuItems = [
                ['label' => 'Оргструктура',
                    'items' => [
                        ['label' => 'Организации', 'url' => ['/complist/index']],
                        ['label' => 'Филиалы', 'url' => ['/branchlist/index']],
                        ['label' => 'Подразделения', 'url' => ['/arealist/index']],
                        ['label' => 'Должности', 'url' => ['/proflist/index']],
                        ['label' => 'Категории', 'url' => ['/prof-cat/index']],
                        ['label' => 'Склады', 'url' => ['/storelist/index']],
                    ]
                ],
                ['label' => 'Общие',
                    'items' => [
                        ['label' => 'Поставщики', 'url' => ['/supplier/index']],
//                            ['label' => 'Пользователи', 'url' => ['/userlist/index']],
                        ['label' => 'Типы документов', 'url' => ['/doctypelist/index']],
                        ['label' => 'Складские операции', 'url' => ['/stopertype/index']],
                        ],
                ],
                ['label' => 'Администрирование',
                    'items' => [
                        ['label' => 'Пользователи', 'url' => ['/userlist/index']],
                                ['label' => 'Роли', 'url' => ['/rolelist/index']],
    //                            ['label' => 'Типы документов', 'url' => ['/doctypelist/index']],
    //                            ['label' => 'Складские операции', 'url' => ['/stopertype/index']],
                        ],
                ],
                ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ] 
                
            ];
        }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <div class="col-lg-12">
            <div class="pull-left">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => 'Главная', 'url' => '/'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </div>
            <div class="pull-right">
                <?= !Yii::$app->user->isGuest?Html::a('Сообщение в техподдержку', ['#'], [
                    'title' => 'Отправить сообщение в техподдержку',
                    'data-toggle' => 'modal',
                    'data-target' => '#helpdesk_modal',
                    'data-backdrop'=>false,
                    'data-remote'=>Yii::$app->getUrlManager()->createAbsoluteUrl(['/helpdesk/create']),
                    'class' => 'btn btn-info'
                ]):'';
                ?>
            </div>
        </div>
    <?= Alert::widget() ?>
    <!--?= $this->render('flashes') ?-->
    <?= $content ?>
    <?php Modal::begin([
        'header'=> '<h4>Сообщение в техподдержку</h4>',
        'id'=>'helpdesk_modal',
        'options' => [
            'tabindex' => false,
        ]
    ]);

    Modal::end();
    ?>
    </div>
</div>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?='ООО "Операндъ"' ?> <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
