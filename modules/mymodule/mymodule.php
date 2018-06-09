<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class MyModule extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'mymodule';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('My module');
      $this->description = $this->l('Description of my module.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:mymodule/mymodule.tpl';
   
      if (!Configuration::get('MYMODULE_NAME'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('MYMODULE_NAME', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('MYMODULE_NAME')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'mymodule_url' => $this->context->link->getPageLink('mymodule', null, null, null, false, null, true),
        );

        if (!array_key_exists('mymodule_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['mymodule_string'] = '';
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
      $this->context->controller->addCSS('modules/mymodule/'.'style.css');
      $this->context->smarty->assign(
        array(
          'mymodule' => Configuration::get('mymodule'),
          'mymodule_link' => $this->context->link->getModuleLink('mymodule', 'display')
        )
      );
      return $this->display(__File__, 'mymodule.tpl');
    }
}