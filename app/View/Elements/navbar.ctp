<?php 
//debug($this->Session->read('Auth'));
?>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Router::url('/', true);?>">Taskmaster</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">                
                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Moje úkoly', ['controller' => 'tasks', 'action' => 'index'], ['escape' => false]); ?></li>
                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>&nbsp;Nový úkol', ['controller' => 'tasks', 'action' => 'add'], ['escape' => false]); ?></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">             
                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;'.$this->Session->read('Auth.User.username'), ['controller' => 'users', 'action' => 'edit'], ['escape' => false]); ?></li>
                <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Odhlásit se', ['controller' => 'users', 'action' => 'logout'], ['escape' => false]); ?></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
