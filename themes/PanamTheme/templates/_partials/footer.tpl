{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='hook_footer_before'}
  {hook h='displayFooterBefore'}
{/block}

{block name='hook_footer'}
  {hook h='displayFooter'}
{/block}

{block name='hook_footer_after'}
  {hook h='displayFooterAfter'}
{/block}

<p>
  {* {block name='copyright_link'}
    <a class="_blank" href="http://www.prestashop.com" target="_blank">
      {l s='%copyright% %year% - Ecommerce software by %prestashop%'
      sprintf=['%prestashop%' => 'PrestaShop™', '%year%' => 'Y'|date, '%copyright%' => '©'] d='Shop.Theme.Global'}
    </a>
  {/block} *}
</p>

<div class="container">
  <div class="logo col-lg-1">
    <img class="img-responsive panam-logo" src="{$shop.logo}" alt="{$shop.name}">
  </div>

  <div class="row">
    <!-- <div class="footer-list"> -->
      <div class="list-footer list-service  col-3">
        <ul>
          <li><a href="#">Impression</a></li>
          <li><a href="#">Web</a></li>
          <li><a href="#">Image de marque</a></li>
          <li><a href="#">A propos</a></li>
          <li><a href="#">Carrière</a></li>
          <li><a href="#">Nous joindre</a></li>
        </ul>
      </div>
      <div class="list-footer list-social col-3">
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Linkedin</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
    <!-- </div> -->
    
    <div class="list-footer newslette0r col-3">
      <a href="#" class="subscribe">s'inscrire à une newsletter</a>
    </div>
    
    <div class="list-footer footer-adress col-3">
      <p>914, rue Laurier, 2e étage</p>
      <p>Beloil, QC J3G 4K9</p>
      <p>514.319.0119</p>
      <p>info@panam-media.com</p>
    </div>
  </div>
</div>
