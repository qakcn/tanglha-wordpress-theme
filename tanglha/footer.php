
    </main>

    <footer class="main">
        <div class="wrapper">
            <p>proudly powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>.</p>
            <p>theme by <a href="https://tsukkomi.org/" target="_blank">qakcn</a>.</p>
            <p>license under <?php tanglha_info('license'); ?>.</p>
            <p>hosted on <?php tanglha_info('host'); ?>.</p>

            <?php
            $beian = get_option('zh_cn_l10n_icp_num');
            if(!empty(trim($beian))) {
                ?>
                <p>documented as <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $beian; ?></a>.</p>
                <?php
            }
            ?>

            <?php tanglha_info('statistic'); ?>
        </div>
    </footer>

    <aside id="global-button">
        <?php tanglha_global_button(); ?>
    </aside>

    <?php get_sidebar(); ?>

    <?php wp_footer(); ?>

</body>
</html>
