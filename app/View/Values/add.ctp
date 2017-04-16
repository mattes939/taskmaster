<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-md-offset-1">
        <h1><?php echo '[' . $task['Task']['name'] . '] Nový atribut'; ?></h1>
        <?php
        echo $this->Form->create('Value', ['class' => 'form-horizontal']);
        $this->Form->inputDefaults(array(
            'div' => ['class' => 'form-group'],
            'class' => 'form-control',
//            'required'
                )
        );
        echo $this->Form->input('Property.name', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'název'], 'required']);
        
//        $options = ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'hodnota']];
//        switch ($typeId){
//            case 1: $options['type'] = 'text';
//                break;
//            case 2: $options['type'] = 'number';
//                break;
//            case 3: $options['type'] = 'radio';
//                $options['legend'] = false;
//                $options['options'] = [1 => 'ano', 0 => 'ne'];
//                $options['class'] = '';
//                $options['label']['class'] = '';
//                $options['div'] = ['class' => 'col-sm-10 col-sm-offset-2 radio'];
//                break;
//            case 4: $options['type'] = 'text';
//                $options['class'] = 'form-control datepicker';
//                $options['onkeydown'] = 'return false';
//                break;
//            default : $options['type'] = 'text';
//                break;
//        }
//        echo $this->Form->input('value', $options);
        echo $this->Form->input('Property.type_id', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'typ', 'required']]);
        echo $this->Form->input('Property.options', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'možnosti'], 'div' => ['class' => 'form-group', 'id' => 'selectOptions', 'style' => 'display:none;'], 'type' => 'textarea', 'placeholder' => 'zadejte možnosti výběru oddělené středníkem']);
        ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php
                echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Vytvořit', array('class' => 'btn btn-primary', 'type' => 'submit'));
                echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks', 'action' => 'view', $task['Task']['id']], ['class' => 'btn btn-warning pull-right', 'escape' => false]);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>