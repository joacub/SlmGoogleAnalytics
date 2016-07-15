<?php
/**
 * Copyright (c) 2012-2013 Jurian Sluiman.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author      Witold Wasiczko <witold@wasiczko.pl>
 * @copyright   2012-2013 Jurian Sluiman.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://www.psd2html.pl
 */
namespace SlmGoogleAnalytics\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SlmGoogleAnalytics\View\Helper\GoogleAnalytics;

class GoogleAnalyticsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, ModuleManager::class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sm = $container;
        $script = $sm->get('SlmGoogleAnalytics\Service\ScriptFactory');
        $helper = new GoogleAnalytics($script);

        $config = $sm->get('config');
        $config = $config['google_analytics'];

        if (isset($config['container_name'])) {
            $helper->setContainerName($config['container_name']);
        }

        return $helper;
    }

//    public function __invoke(ContainerInterface $container, $name, array $options = null)
//    {
//        $configuration    = $container->get('ApplicationConfig');
//        $listenerOptions  = new ListenerOptions($configuration['module_listener_options']);
//        $defaultListeners = new DefaultListenerAggregate($listenerOptions);
//        $serviceListener  = $container->get('ServiceListener');
//
//        $serviceListener->addServiceManager(
//            $container,
//            'service_manager',
//            'Zend\ModuleManager\Feature\ServiceProviderInterface',
//            'getServiceConfig'
//        );
//
//        $serviceListener->addServiceManager(
//            'ControllerManager',
//            'controllers',
//            'Zend\ModuleManager\Feature\ControllerProviderInterface',
//            'getControllerConfig'
//        );
//        $serviceListener->addServiceManager(
//            'ControllerPluginManager',
//            'controller_plugins',
//            'Zend\ModuleManager\Feature\ControllerPluginProviderInterface',
//            'getControllerPluginConfig'
//        );
//        $serviceListener->addServiceManager(
//            'ViewHelperManager',
//            'view_helpers',
//            'Zend\ModuleManager\Feature\ViewHelperProviderInterface',
//            'getViewHelperConfig'
//        );
//        $serviceListener->addServiceManager(
//            'RoutePluginManager',
//            'route_manager',
//            'Zend\ModuleManager\Feature\RouteProviderInterface',
//            'getRouteConfig'
//        );
//
//        $events = $container->get('EventManager');
//        $defaultListeners->attach($events);
//        $serviceListener->attach($events);
//
//        $moduleEvent = new ModuleEvent;
//        $moduleEvent->setParam('ServiceManager', $container);
//
//        $moduleManager = new ModuleManager($configuration['modules'], $events);
//        $moduleManager->setEvent($moduleEvent);
//
//        return $moduleManager;
//    }
//
//    /**
//     * Create and return ModuleManager instance
//     *
//     * For use with zend-servicemanager v2; proxies to __invoke().
//     *
//     * @param ServiceLocatorInterface $container
//     * @return ModuleManager
//     */
//    public function createService(ServiceLocatorInterface $container)
//    {
//        return $this($container, ModuleManager::class);
//    }

}
