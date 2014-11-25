<?php

namespace StaticLink\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Http\Request;

class StaticLink extends AbstractHelper {
    const SUBDOMAIN = 'static';

    // Resource types and their directory names
    const IMAGE = 'images';
    const CSS = 'css';
    const JS = 'js';
    const VIDEO = 'videos';
    const OTHER = 'other';

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param string $file_name The name of the file to create a link to.
     * @param string $subfolder Optional. The name of the subfolder to use. Should usually be one of the defined constants.
     * @param array $subdirectories An array of subdirectories to append after the subfolder (which comes after the host). Should contain only strings.
     */
    public function __invoke($file_name, $subfolder = null, array $subdirectories = array()) {
        $static_url = 'http://' . self::SUBDOMAIN . '.' . $this->request->getUri()->getHost() . '/';

        if (!empty($subfolder)) {
            $static_url .= $subfolder . '/';
        }

        if (is_array($subdirectories) && !empty($subdirectories)) {
            foreach ($subdirectories as $subdirectory) {
                $static_url .= $subdirectory . '/';
            }
        }

        $static_url .= $file_name;

        return $static_url;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function getRequest() {
        return $this->request;
    }
}