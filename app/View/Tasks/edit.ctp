<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-10 col-md-offset-1">
         <h1><?php echo '[' . $this->request->data['Task']['name'] . '] upravit atributy'; ?></h1>
        <?php
        echo $this->Form->create('Task', ['class' => 'form-horizontal']);
        $this->Form->inputDefaults(array(
            'div' => ['class' => 'form-group'],
            'class' => 'form-control'
                )
        );
        echo $this->Form->input('id');
        
        foreach ($this->request->data['Value'] as $i => $value){
            echo $this->Form->input('Value.'.$i.'.id');
            echo $this->Form->input('Value.'.$i.'.value', [
                'label' => ['class' => 'col-sm-2 control-label', 'text' => $value['Property']['name'] ]
                ]);
        }
        
        ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php
                echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Uložit', array('class' => 'btn btn-primary'));
                echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks', 'action' => 'view', $this->request->data['Task']['id']], ['class' => 'btn btn-warning pull-right', 'escape' => false]);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>