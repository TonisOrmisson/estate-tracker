<?php

use yii\helpers\Html;
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <div>
            <a href="#" class="sidebar-toggle btn" data-toggle="push-menu" role="button">
                <span title = "Toggle navigation"><></span>
            </a>
        </div>

        <?= Html::a(
            'X',
            ['/site/logout'],
            ['data-method' => 'post', 'class' => 'btn btn-sm', 'title' => 'Logout']
        ) ?>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Objektid', 'icon' => 'home', 'url' => ['/item']],
                    ['label' => 'Listings', 'icon' => 'list', 'url' => ['/listing']],
                    ['label' => 'Seaded', 'icon' => 'gear', 'items' => [
                        ['label' => 'Providers', 'icon' => 'gear', 'url' => ['/provider']],
                        ['label' => 'Objekti tüübid', 'icon' => 'gear', 'url' => ['/item-type']],
                        ['label' => 'Users', 'icon' => 'users', 'url' => ['/user/admin']],
                        ['label' => 'Parses', 'icon' => 'users', 'url' => ['/parse']],

                    ]],
                ],
            ]
        ) ?>

    </section>
    <?= \tonisormisson\versiontag\VersionTag::widget(['tooltipLocation' => 'right'])?>

</aside>
