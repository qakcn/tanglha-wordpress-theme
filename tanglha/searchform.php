<form role="search" method="get" id="search-form" class="search-form" action="<?=home_url( '/' ); ?>" ng-class="{show: inputshowed}" search-form>
    <input type="search" class="search-field" placeholder="keywords" value="<?=get_search_query() ?>" name="s" title="<?=__('search keywords', 'tanglha') ?>">
    <input type="submit" title="<?=__('search', 'tanglha') ?>" class="search-submit" value="&#x1f50d;" ng-click="submit($event)">
</form>
