<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerK3pDkFi\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerK3pDkFi/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerK3pDkFi.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerK3pDkFi\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerK3pDkFi\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'K3pDkFi',
    'container.build_id' => 'ef005b44',
    'container.build_time' => 1565014402,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerK3pDkFi');
