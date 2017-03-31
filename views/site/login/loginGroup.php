<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
?>
                <div class="login-header">
                    <img src="img/logo.png" />
                    <h1><?= Yii::t('app', 'Добре дошли'); ?></h1>
                    <h3><?= Yii::t('app', 'моля влезте в своята група!'); ?></h3>
                    <hr>
                </div>
                <div class="content">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                ]); ?>
                    <div class="input-group">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'required' => true, 'id' => 'username', 'placeholder' => Yii::t('app', 'Потребителско име')])->label(Yii::t('app', 'Потребителско име')); ?>
                    </div>
                    <div class="input-group">
                        <?= $form->field($model, 'password')->passwordInput(['required' => true, 'placeholder' => Yii::t('app', 'Парола')])->label(Yii::t('app', 'Парола')); ?>
                    </div>
                    <div class="input-group">
                        <?= Html::submitButton(Yii::t('app', 'Вход'), ['class' => 'login-btn', 'name' => 'login-button']) ?> 
                    </div>
                <?php ActiveForm::end(); ?>
                </div>