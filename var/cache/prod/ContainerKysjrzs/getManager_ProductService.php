<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'manager.product' shared service.

include_once $this->targetDirs[3].'\\src\\AppBundle\\Manager\\ProductManagerInterface.php';
include_once $this->targetDirs[3].'\\src\\AppBundle\\Manager\\ProdManager.php';

return $this->services['manager.product'] = new \AppBundle\Manager\ProdManager(${($_ = isset($this->services['service.repository.product']) ? $this->services['service.repository.product'] : $this->load('getService_Repository_ProductService.php')) && false ?: '_'}, ($this->targetDirs[3].'\\app'), ${($_ = isset($this->services['request_stack']) ? $this->services['request_stack'] : ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())) && false ?: '_'});
