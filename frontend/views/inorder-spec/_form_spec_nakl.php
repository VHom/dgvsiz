<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'Спецификация приходного ордера';
//$this->params['breadcrumbs'][] = $this->title;
$model = new \app\models\InorderSpec();
//throw new \yii\web\NotFoundHttpException('qq'.$id);
if($id)
    $model->nomen_id = $id;
?>
<div class="inorder-spec-index">
<?php if($id):?>
<?php $this->registerJs('$("#adsModal").modal("show");');?>
<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление спецификации</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/inorder-spec/_form_mod_nakl',['model' => $model, 'id'=>$id]); ?>
        </div>
        <!--div class="modal-footer">
          <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-default">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a>

        </div-->
      </div>
    </div>
</div>
<?php endif;?>    
</div>