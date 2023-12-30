<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/_head.php'); ?>

    </head>
    <body class="">
    <?php $this->load->view('dashboard/block.head.php'); ?>
<?php } ?>
                        <title><?php echo $page_title; ?> - <?php echo lang('site_title'); ?></title>
                        <section class="vbox bg-gradient content-vbox">
                            <header class="header b-b b-t b-light bg-light lter">
                                <p class="font-bold"><?= $page_title ?></p>
                            </header>
                            <section class="scrollable wrapper">
                                <div id="my_account" class="wrapper">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-6">
                                            <section class="panel panel-default portlet-item">
                                                <header class="panel-heading"><?= lang('current_database_migration_version') ?>: <strong><?php echo $version ?></strong></header>
                                                <div class="panel-body">
                                                    <?php
                                                    if (!empty($migration_return_html)) {

                                                        ?>
                                                        <p><?= lang('actions_performed') ?></p>
                                                        <p><?= $migration_return_html ?></p>
                                                        <?php
                                                    } else {
                                                        echo "<center><img src='/public_html/images/verify.gif' class='img-responsive'/></center>";
                                                    }

                                                    ?>

                                                </div>
                                            </section>
                                        </div>
                                        <!-- EOF left column -->
                                        <!-- right column -->
                                        <div class="col-md-6">
                                            <section class="panel panel-default portlet-item">
                                                <header class="panel-heading"><?= lang('migrations_list') ?> <span class="badge bg-info"><?= count($migrations) ?></span></header>
                                                <section class="panel-body">
                                                    <?php
                                                    $count = 0;
                                                    foreach ($migrations as $migration) {
                                                        $count++;
                                                        $migrationdata = $this->migration->get_migration_data($migration);

                                                        if ($count > 1) {

                                                            ?>
                                                            <div class="line pull-in"></div>
                                                            <?php
                                                        }

                                                        ?>
                                                        <article class="media">
                                                            <div class="pull-left">
                                                                <span class="fa-stack fa-lg">
                                                                    <i class="fa fa-circle fa-stack-2x<?= ($migrationdata['version'] == $version) ? ' text-success' : '' ?>"></i>
                                                                    <i class="fa fa-stack-1x text-white"><?= $count ?></i>
                                                                </span>
                                                            </div>
                                                            <div class="media-body">
                                                                <span class="h4"><?= $migrationdata['migration_name'] ?></span>
                                                                <small class="block m-t-sm">
                                                                    <strong><?= lang('version'); ?>:</strong> <?= $migrationdata['version'] ?></a>
                                                                </small>
                                                                <small class="block">
                                                                    <strong><?= lang('file'); ?>:</strong> <?= $migrationdata['pathfile'] ?>
                                                                </small>
                                                            </div>
                                                        </article>
                                                    <?php } ?>

                                                </section>
                                            </section>
                                        </div>
                                        
                                        <!-- EOF right column -->
                                    </div>
                                </div>
                            </section>
                        </section>
<?php if (! isset($_SERVER["HTTP_X_PJAX"])) { ?>
    <?php $this->load->view('dashboard/block.foot.php'); ?>
<?php } ?>
