<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerKysjrzs\appProdProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerKysjrzs/appProdProjectContainer.php') {
    touch(__DIR__.'/ContainerKysjrzs.legacy');

    return;
}

if (!\class_exists(appProdProjectContainer::class, false)) {
    \class_alias(\ContainerKysjrzs\appProdProjectContainer::class, appProdProjectContainer::class, false);
}

return new \ContainerKysjrzs\appProdProjectContainer([
    'container.build_hash' => 'Kysjrzs',
    'container.build_id' => '9c562eb3',
    'container.build_time' => 1565233485,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerKysjrzs');
