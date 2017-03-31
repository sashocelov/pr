<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;
?>
                <div class="login-header">
                    <i class="fa fa-asterisk logo"></i>
                    <h1><?= $groupTitle; ?></h1>
                    <h3><?= Yii::t('app', 'моля въведете парола за своята обект!'); ?></h3>
                    <hr>
                </div>
                <div class="content">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                ]); ?>
                    <ul class="place-list">
                    <?php foreach ($pGroupPlaces as $pPlace) : ?>
                        <?php 
                            $strBG = '';
                            if (isset($pPlace['group_data'])) {
                                $aData = unserialize($pPlace['group_data']);
                                $strBG = isset($aData['block-bg']) ? $aData['block-bg'] : '';
                            }
                            $strUrl = '#';
                            if ($pPlace['password'] == NULL) {
                                $strUrl = Url::to(['loginfreeplace', 'id' => $pPlace['id']]);
                            }
                        ?>
                        <li style="background-image: url(<?= $strBG; ?>)">
                            <a href="<?= $strUrl; ?>">
                                <span class="<?= $pPlace['password'] == NULL ? '' : 'fa fa-lock' ?>"></span>
                                <div><?= $pPlace['title']; ?></div>
                            </a>
                        </li>
                    <?php endforeach;?>
                    </ul>
                    <div class="input-group">
                        <?= $form->field($model, 'password')->passwordInput(['required' => true, 'placeholder' => Yii::t('app', 'Парола')])->label(Yii::t('app', 'Парола')); ?>
                    </div>

                    <div class="input-group">
                        <?= Html::submitButton(Yii::t('app', 'Вход'), ['class' => 'login-btn', 'name' => 'login-button']) ?> 
                        <?= Html::a(Yii::t('app', 'Изход от "{GROUP_TITLE}"', ['GROUP_TITLE' => $groupTitle]), Yii::$app->urlManager->createUrl("/logoutgroup"), ['class' => 'logout-button']); ?>
                    </div>
                <?php ActiveForm::end(); ?>
                </div>