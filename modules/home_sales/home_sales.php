<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class Home_Sales extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'home_sales';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('Home_sales');
      $this->description = $this->l('Description of home_sales.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:home_sales/home_sales.tpl';
   
      if (!Configuration::get('HOME_SALES_NAME'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('HOME_SALES_NAME', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('HOME_SALES_NAME')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'home_sales_url' => $this->context->link->getPageLink('home_sales', null, null, null, false, null, true),
        );

        if (!array_key_exists('home_sales_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['home_sales_string'] = '';
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
      $this->context->controller->addCSS('modules/home_sales/'.'style.css');
      $this->context->smarty->assign(
        array(
          'home_sales' => Configuration::get('home_sales'),
          'home_sales_link' => $this->context->link->getModuleLink('home_sales', 'display')
        )
      );
      return $this->display(__File__, 'home_sales.tpl');
    }

  // public function hookdisplayHeader($params){
  //   $this->context->controller->registerJavascript('my-module', 'modules/' . $this->name . '/views/js/my-module.js', array(
  //   'position' => 'bottom',
  //    'priority' => 150
  //   ));
  // }
}