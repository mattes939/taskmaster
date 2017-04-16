<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-md-offset-1">
        <h1><?php echo '[' . $this->request->data['Task']['name'] . '] upravit popis'; ?></h1>
        <?php
        echo $this->Form->create('Task');
        echo $this->Form->input('id');
//        echo $this->Form->input('name', ['placeholder' => 'název úkolu',
//            'label' => false,
//            'div' => ['class' => 'form-group'],
//            'class' => 'form-control']
//        );
        echo $this->Form->input('description', ['label' => 'Popis',
        'div' => ['class' => 'form-group'],
        'class' => 'form-control'
        ]);
         echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Uložit', array('class' => 'btn btn-primary'));
                echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks', 'action' => 'view', $this->request->data['Task']['id']], ['class' => 'btn btn-warning pull-right', 'escape' => false]);
        echo $this->Form->end();
        ?>
    </div>
</div>
<!--<div class="row">
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

        foreach ($this->request->data['Value'] as $i => $value) {

            $options = ['label' => ['class' => 'col-sm-2 control-label', 'text' => $value['Property']['name']]];
            switch ($value['Property']['type_id']) {
                case 1: $options['type'] = 'text';
                    break;
                case 2: $options['type'] = 'number';
                    break;
                case 3: $options['type'] = 'radio';
                    $options['legend'] = false;
                    $options['options'] = [1 => 'ano', 0 => 'ne'];
                    $options['class'] = '';
                    $options['label']['class'] = '';
                    $options['div'] = ['class' => 'col-sm-10 col-sm-offset-0 radio'];
//                    echo '<div class="col-sm-2 text-right radio"><label>'.$value['Property']['name'].'</label></div>';
                    echo '<label class="col-sm-2 control-label">'.$value['Property']['name'].'&nbsp;&nbsp;</label>';
                    break;
                case 4: $options['type'] = 'text';
                    $options['class'] = 'form-control datepicker';
                    $options['onkeydown'] = 'return false';
                    break;
                default : $options['type'] = 'text';
                    break;
            }


            echo $this->Form->input('Value.' . $i . '.value', $options);

            echo $this->Form->input('Value.' . $i . '.id');
//            echo $this->Form->input('Value.' . $i . '.value', [
//                'label' => ['class' => 'col-sm-2 control-label', 'text' => $value['Property']['name']]
//            ]);
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
</div>-->