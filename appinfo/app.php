<?php

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [
        // The string under which your app will be referenced in owncloud
        'id' => 'ownnotes',

        // The sorting weight for the navigation.
        // The higher the number, the higher will it be listed in the navigation
        'order' => 10,

        // The route that will be shown on startup
        'href' => $urlGenerator->linkToRoute('ownnotes.page.index'),

        // The icon that will be shown in the navigation, located in img/
        'icon' => $urlGenerator->imagePath('ownnotes', 'ownnotes.svg'),

        // The application's title, used in the navigation & the settings page of your app
        'name' => \OC::$server->getL10N('ownnotes')->t('OwnNotes'),
    ];
});

