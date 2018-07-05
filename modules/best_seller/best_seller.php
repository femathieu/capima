<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class Best_seller extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'best_seller';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('best_seller');
      $this->description = $this->l('Description of best_seller.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:best_seller/best_seller.tpl';
   
      if (!Configuration::get('BEST_SELLER_NAME'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('BEST_SELLER_NAME', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('BEST_SELLER_NAME')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'best_seller_url' => $this->context->link->getPageLink('best_seller', null, null, null, false, null, true),
        );

        if (!array_key_exists('best_seller_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['best_seller_string'] = '';
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
      $this->context->controller->addCSS('modules/best_seller/'.'style.css');
      $this->context->smarty->assign(
        array(
          'best_seller' => Configuration::get('best_seller'),
          'best_seller_link' => $this->context->link->getModuleLink('best_seller', 'display')
        )
      );
      return $this->display(__File__, 'best_seller.tpl');
    }

  // public function hookdisplayHeader($params){
  //   $this->context->controller->registerJavascript('my-module', 'modules/' . $this->name . '/views/js/my-module.js', array(
  //   'position' => 'bottom',
  //    'priority' => 150
  //   ));
  // }
}