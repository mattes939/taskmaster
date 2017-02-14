<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="Author" content="www.tvorime-weby.cz" /> 
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $this->fetch('title'); ?>
        </title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/sc-1.4.2/datatables.min.css"/>

        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css([
            'http://fonts.googleapis.com/css?family=Open+Sans:700,300,400&subset=latin,latin-ext',
            'http://fonts.googleapis.com/css?family=Capriola&subset=latin,latin-ext',
            'main',
            'blog',
            'lightbox.min',
            'ekko-lightbox.min',
            'detail-chalupy',
            'tisk'
        ]);

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>
    <body>

        <div class="container">
            <div id="wrapper">
                <div id="header">
                    <div class="header-logo">
                        <a href="<?php echo "$hladresa/"; ?>" title="Úvodní stránka"><img src="<?php echo "$hladresa/"; ?>img/logo.png" width="129" height="60" /></a>
                    </div>
                    <div class="header-slogan hidden-xs hidden-sm hidden-md">
                        <h1><a href="<?php echo "$hladresa/"; ?>" title="Úvodní stránka">Chaty a chalupy k pronajmutí v ČR a SR</a></h1>
                    </div>
                    <div class="header-social hidden-xs hidden-sm hidden-md">
                        <a href="https://www.facebook.com/zars.cz" target="_blank"><img src="<?php echo "$hladresa/"; ?>img/facebook.png" width="35" height="35" /></a>
                    </div>

                </div>
                <div class="hidden-xs banner">
                    <b>Objednejte si dovolenou LÉTO 2017 s předstihem a využijte hned tří výhod - do konce roku zaplatíte zálohu pouze 10%, vyberete si z atraktivní nabídky ještě volných nejoblíbenějších chat a chalup, dovolenou můžete svým blízkým věnovat k vánocům:)</b> Požadavek na zálohu 10% napište do objednávky pobytu.
                </div>
                
                   <?php echo $this->Flash->render(); ?>

            <?php echo $this->fetch('content'); ?>
            </div>
        </div>

         


            <script
                src="https://code.jquery.com/jquery-1.12.4.min.js"
                integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>

            <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.2.0/r-2.1.0/sc-1.4.2/datatables.min.js"></script>
            <?php
            echo $this->Html->script([
                '//cdn.datatables.net/plug-ins/1.10.13/i18n/Czech.json',
                'misc'
            ]);
            ?>
    </body>
</html>