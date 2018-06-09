  <nav class="navbar navbar-light">
  <div class="container">
        <div class="row" style="width: 100%">
            <div class="col-6">
                {block name='header_logo'}
                    <a class="logo" href="{$urls.base_url}" title="{$shop.name}">
                        <img class="img-responsive" src="{$shop.logo}" alt="{$shop.name}">
                    </a>
                {/block}
            </div>
            <div class="col-4 offset-2 pull-right">
            {block name='header_nav'}
                <div class="row">
                    {hook h='displayNav'}
                </div> 
            {/block}
            </div>
        </div>
    </div>

  </nav>
