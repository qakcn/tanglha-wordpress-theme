
    </main>

    <footer class="main">
        <div class="wrapper">
            <p><?=__('proudly powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>.', 'tanglha') ?></p>
            <p><?=__('theme by <a href="https://tsukkomi.org/" target="_blank">qakcn</a>.', 'tanglha') ?></p>
            <p><?=sprintf(__('license under %s.', 'tanglha'), tanglha_info('license')) ?></p>
            <p><?=sprintf(__('hosted on %s.', 'tanglha'), tanglha_info('host')) ?></p>

            <?php
            $beian = get_option('zh_cn_l10n_icp_num');
            if(!empty(trim($beian))) {
                echo '<p>';
                printf(__('documented as <a href="http://www.miibeian.gov.cn" target="_blank">%s</a>.', 'tanglha'), $beian);
                echo '</p>';
            }
            ?>

            <?=tanglha_info('statistic'); ?>
        </div>
    </footer>

    <aside id="global-button">
        <?php tanglha_global_button(); ?>
    </aside>

    <?php get_sidebar(); ?>

    <?php wp_footer(); ?>

</body>
</html>
