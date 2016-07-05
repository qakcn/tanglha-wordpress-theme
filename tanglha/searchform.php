<form role="search" method="get" id="search-form" class="search-form" action="<?php echo home_url( '/' ); ?>" ng-class="{show: inputshowed}" search-form>
    <input type="search" class="search-field" placeholder="keywords" value="<?php echo get_search_query() ?>" name="s" title="search">
    <input type="submit" title="search" class="search-submit" value="&#x1f50d;" ng-click="submit($event)">
</form>
