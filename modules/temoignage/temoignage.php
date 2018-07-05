<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class Temoignage extends Module{
    private $templateFile;
    
    public function __construct()
    {
      $this->name = 'temoignage';
      $this->tab = 'front_office_features';
      $this->version = '1.0.0';
      $this->author = 'Pierro Lasticot';
      $this->need_instance = 0;
      $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
      $this->bootstrap = true;
  
      parent::__construct();
  
      $this->displayName = $this->l('temoignage');
      $this->description = $this->l('Description of temoignage.');
  
      $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
      $this->templateFile = 'module:temoignage/temoignage.tpl';
   
      if (!Configuration::get('TEMOIGNAGE_NAME'))
        $this->warning = $this->l('No name provided');
    }

    public function install()
    {
      if (Shop::isFeatureActive())
        Shop::setContext(Shop::CONTEXT_ALL);
    
      if (!parent::install() ||
        !$this->registerHook('leftColumn') ||
        !$this->registerHook('header') ||
        !Configuration::updateValue('TEMOIGNAGE_NAME', 'my friend')
      )
        return false;
    
      return true;
    }

    public function uninstall()
    {
      if (!parent::uninstall() ||
        !Configuration::deleteByName('TEMOIGNAGE_NAME')
      )
        return false;
    
      return true;
    }
    public function getWidgetVariables($hookName, array $configuration = [])
    {
        $widgetVariables = array(
            'temoignage_url' => $this->context->link->getPageLink('temoignage', null, null, null, false, null, true),
        );

        if (!array_key_exists('temoignage_string', $this->context->smarty->getTemplateVars())) {
            $widgetVariables['temoignage_string'] = '';
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
      $this->context->controller->addCSS('modules/temoignage/'.'style.css');
      $this->context->smarty->assign(
        array(
          'temoignage' => Configuration::get('temoignage'),
          'temoignage_link' => $this->context->link->getModuleLink('temoignage', 'display')
        )
      );
      return $this->display(__File__, 'temoignage.tpl');
    }

  // public function hookdisplayHeader($params){
  //   $this->context->controller->registerJavascript('my-module', 'modules/' . $this->name . '/views/js/my-module.js', array(
  //   'position' => 'bottom',
  //    'priority' => 150
  //   ));
  // }
}