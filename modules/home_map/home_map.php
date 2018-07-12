<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class Home_map extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'home_map';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('home_map');
      $this->description = $this->l('Description of old_map.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:home_map/home_map.tpl';
   
      if (!Configuration::get('HOME_MAP_NAME'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('HOME_MAP_NAME', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('HOME_MAP_NAME')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'home_map_url' => $this->context->link->getPageLink('home_map', null, null, null, false, null, true),
        );

        if (!array_key_exists('home_map_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['home_map_string'] = '';
        }

        return $widgetVariables;
    }

    public function renderWidget($hookName, array $configuration = []){
        $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));

        return $this->fetch($this->templateFile);
    }

    public function hookHeader ($params)
    {
    }
    
    
    public function hookDisplayHome($params){
      $this->context->controller->bootstrap=true;
      $this->context->controller->addCSS('modules/home_map/'.'style.css');
      $this->context->smarty->assign(
        array(
          'home_map' => Configuration::get('home_map'),
          'home_map_link' => $this->context->link->getModuleLink('home_map', 'display')
        )
      );
      return $this->display(__File__, 'home_map.tpl');
    }

  // public function hookdisplayHeader($params){
  //   $this->context->controller->registerJavascript('my-module', 'modules/' . $this->name . '/views/js/my-module.js', array(
  //   'position' => 'bottom',
  //    'priority' => 150
  //   ));
  // }
}