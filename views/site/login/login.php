<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
?>
                <div class="login-header bg" data-bg="<?= $strBgUrl; ?>">
                    <i class="fa fa-asterisk logo"></i>
                    <h1><?= $placeTitle; ?></h1>
                    <h3><?= Yii::t('app', 'моля въведете парола за потребителския си профил!'); ?></h3>
                    <hr>
                </div>
                <div class="content">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                ]); ?>
<!--                     <div class="input-group">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'required' => true, 'id' => 'username', 'placeholder' => Yii::t('app', 'Потребителско име')])->label(Yii::t('app', 'Потребителско име')); ?>
                    </div> -->
                    <div class="input-group">
                        <?= $form->field($model, 'password')->passwordInput(['required' => true, 'placeholder' => Yii::t('app', 'Парола')])->label(Yii::t('app', 'Парола')); ?>
                    </div>
                    <div class="input-group">
                        <?= Html::submitButton(Yii::t('app', 'Вход'), ['class' => 'login-btn', 'name' => 'login-button']) ?> 
                        <?php if ($bReturnToGroup) : ?>
                            <?= Html::a(Yii::t('app', 'Изход'), Yii::$app->urlManager->createUrl("/logoutgroup"), ['class' => 'logout-button']); ?>
                        <?php else : ?>
                            <?= Html::a(Yii::t('app', 'Изход от "{PLACE_TITLE}"', ['PLACE_TITLE' => $placeTitle]), Yii::$app->urlManager->createUrl("/logoutplace"), ['class' => 'logout-button']); ?>
                        <?php endif; ?>
                    </div>
                <?php ActiveForm::end(); ?>
                </div>