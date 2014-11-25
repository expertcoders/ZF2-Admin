<?php 
/**
 * Helper for retrieving base URL
 *
 * @package  * @version $Id: $
 */
class Zend_View_Helper_BaseUrl extends Zend_View_Helper_Abstract
{
    /**     * @var string
     /
    protected $_baseUrl;
 
    /**     * Return base URL of application
     *
     * @return string
     */
    public function baseUrl()    {
        if (null === $this->_baseUrl) {
            if ($baseUrl = Zend_Registry::get('configuration')->app->url) {
                $this->_baseUrl = $baseUrl;
            } else if (isset($this->view->baseUrl)) {                $this->_baseUrl = $this->view->baseUrl;
            } else {
                $request = Zend_Controller_Front::getInstance()->getRequest();
                $this->_baseUrl = $request->getBaseUrl();
            }        }
 
        return $this->_baseUrl;
    }
} 
## Example Usage:
 

