<?php

use StaticLink\View\Helper\StaticLink;

return array(
    'factories' => array(
        'staticLink' => function($sm) {
            return new StaticLink($sm->getServiceLocator()->get('Request'));
        }
    )
);