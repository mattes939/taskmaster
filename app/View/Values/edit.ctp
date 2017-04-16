<div class="row">
    <div class="col-xs-12 ">
        <h1><?php echo $this->request->data['Task']['name'] . ' - editace atributu ' . $this->request->data['Property']['name']; ?></h1>

    </div>
</div>
<div class="row">
   <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-md-offset-1">
        <?php echo $this->Form->create('Value', ['class' => '']);
//        $this->Form->inputDefaults(array(
//            'div' => ['class' => 'form-group'],
//            'class' => 'form-control'
//                )
//        );
            echo $this->Form->input('id');

            echo $this->Form->input('processing_id', ['type' => 'radio', 'options' => $processing, 'legend' => false]);
            
            
            $options = ['label' => 'manuální zadání hodnoty','div' => ['class' => 'form-group'],
            'class' => 'form-control'];
            switch ($this->request->data['Property']['type_id']) {
                case 1: $options['type'] = 'text';
                    break;
                case 2: $options['type'] = 'number';
                    break;
                case 3: $options['type'] = 'radio';
                    $options['legend'] = false;
                    $options['options'] = [1 => 'ano', 0 => 'ne'];
                    $options['class'] = '';
                    $options['label'] = 'manuální zadání hodnoty';
                    $options['div'] = ['class' => 'radio'];
                    echo '<label class="col-sm-2 control-label">'.$this->request->data['Property']['name'].'&nbsp;&nbsp;</label>';
                    break;
                case 4: $options['type'] = 'text';
                    $options['class'] = 'form-control datepicker';
                    $options['onkeydown'] = 'return false';
                    break;
                case 5:
                    $options['type'] = 'select';
                    $options['empty'] = '(žádná možnost)';
                    $options['options'] = $this->request->data['Property']['options'];
                    break;
                    
                default : $options['type'] = 'text';
                    break;
            }


            echo $this->Form->input('Value.value', $options);
            
               echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Uložit', array('class' => 'btn btn-primary', 'label' => 'login',));
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks','action' => 'view', $this->request->data['Task']['id']], ['class' => 'btn btn-warning ', 'escape' => false]);
        echo $this->Form->end();
       
            ?>
       
       
    </div>
</div>