<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private '.service_locator.fPmj2Hu' shared service.

return $this->privates['.service_locator.fPmj2Hu'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'Repository' => ['privates', 'App\\Repository\\EntrepriseRepository', 'getEntrepriseRepositoryService.php', true],
], [
    'Repository' => 'App\\Repository\\EntrepriseRepository',
]);