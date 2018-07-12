<?php
if (!defined('_PS_VERSION_'))
{
  exit;
}

class HomePresentation extends Module
{
    public function __construct()
  {
    $this->name = 'homepresentation';  //nom du dossier
    $this->tab = 'front_office_features'; //titre de la section qui doit contenir ce module dans la liste des modules
    $this->version = '1.0.0';
    $this->author = 'Pierre sid-idris';
    $this->need_instance = 0; //charger la classe du module lors de l'affichage de la page "Modules" dans le back-office 0 = pas chargé
    $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    $this->bootstrap = true;
    // $this->registerJavascript(
    //     'popper-js',
    //     'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
    //     ['server' => 'remote', 'position' => 'head', 'priority' => 20]
    //     );
    // $this->registerJavascript(
    // 'remote-bootstrap',
    // 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', 
    // ['server' => 'remote', 'position' => 'bottom', 'priority' => 20]
    // );

    parent::__construct();

    $this->displayName = $this->l('Home presentation');
    $this->description = $this->l('Module de la page d\'accueil affichant les service de panammedia.');

    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    if (!Configuration::get('HOMEPRESENTATION_NAME'))
      $this->warning = $this->l('No name provided');

    $this->tabs = array(
        array(
            'class_name' => 'AdminHomePresentation',
            'ParentClassName' => 'AdminCatalog',
            'name' => 'Home presentation',
            'visible' => true,
            'icon' => 'store'
        )
    );


  }



  public function install()
  {
    if (Shop::isFeatureActive())
      Shop::setContext(Shop::CONTEXT_ALL);
   
    return parent::install() &&
      $this->registerHook('displayHome') &&
    //   $this->registerHook('leftColumn') &&
      $this->registerHook('header') &&
      Configuration::updateValue('HOMEPRESENTATION_NAME', 'my friend');

 
  }

public function uninstall()
{
  if (!parent::uninstall() ||
    !Configuration::deleteByName('HOMEPRESENTATION_NAME')
  )
    return false;

  return true;
}


public function getContent()
{
    $output = null;
 
    if (Tools::isSubmit('submit'.$this->name))
    {
        $homepresentation = strval(Tools::getValue('HOMEPRESENTATION_NAME'));
        if (!$homepresentation
          || empty($homepresentation)
          || !Validate::isGenericName($homepresentation))
            $output .= $this->displayError($this->l('Invalid Configuration value'));
        else
        {
            Configuration::updateValue('HOMEPRESENTATION_NAME', $homepresentation);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }
    }
    return $output.$this->displayForm();
}

public function displayForm()
{
    // Get default language
    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
 
    // Init Fields form array
    $fields_form[0]['form'] = array(
        'legend' => array(
            'title' => $this->l('Settings'),
        ),
        'input' => array(
            array(
                'type' => 'text',
                'label' => $this->l('service n°1'), //Configuration value
                'name' => 'HOMEPRESENTATION_NAME',
                'size' => 20,
                'required' => true
            ),
            array(
                'type' => 'text',
                'label' => $this->l('service n°2'), //Configuration value
                'name' => 'HOMEPRESENTATION_NAME',
                'size' => 20,
                'required' => true
            ),
            array(
                'type' => 'text',
                'label' => $this->l('service n°3'), //Configuration value
                'name' => 'HOMEPRESENTATION_NAME',
                'size' => 20,
                'required' => true
            )
        ),
        'submit' => array(
            'title' => $this->l('Save'),
            'class' => 'btn btn-default pull-right'
        )
    );
 
    $helper = new HelperForm();
 
    // Module, token and currentIndex
    $helper->module = $this;
    $helper->name_controller = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
 
    // Language
    $helper->default_form_language = $default_lang;
    $helper->allow_employee_form_lang = $default_lang;
 
    // Title and toolbar
    $helper->title = $this->displayName;
    $helper->show_toolbar = true;        // false -> remove toolbar
    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
    $helper->submit_action = 'submit'.$this->name;
    $helper->toolbar_btn = array(
        'save' =>
        array(
            'desc' => $this->l('Save'),
            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
            '&token='.Tools::getAdminTokenLite('AdminModules'),
        ),
        'back' => array(
            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Back to list')
        )
    );
 
    // Load current value
    $helper->fields_value['HOMEPRESENTATION_NAME'] = Configuration::get('HOMEPRESENTATION_NAME');
 
    return $helper->generateForm($fields_form);
}



public function hookDisplayHome($params)
{
  $this->context->smarty->assign(
      array(
          'homepresentation_name' => Configuration::get('HOMEPRESENTATION_NAME'),
          'homepresentation_link' => $this->context->link->getModuleLink('homepresentation', 'display')
      )
  );
  return $this->display(__FILE__, 'homepresentation.tpl');
}


 
public function hookDisplayHeader()
{
  $this->context->controller->addCSS($this->_path.'css/homepresentation.css', 'all');
  $this->context->controller->addJS($this->_path . 'js/script.js');//path of js
  $this->context->controller->addJS($this->_path . 'js/popper.min.js');//path of js
  

}


}