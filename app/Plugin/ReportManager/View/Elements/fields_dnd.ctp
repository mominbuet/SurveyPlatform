<?php

foreach ($modelSchema as $field => $attributes):
    echo '<tr>';
    echo '<td>';
    if (isset($this->data[$modelClass][$field]['Add']))
        $modelFieldAdd = $this->data[$modelClass][$field]['Add'];
    else
        $modelFieldAdd = true;
    echo $this->Form->checkbox($modelClass . '.' . $field . '.' . 'Add', array('hiddenField' => true, 'checked' => $modelFieldAdd));
    echo '</td>';
    echo '<td>';
    echo '<b><span class="checkAll"></span></b>';

    $tst= ( isset($labelFieldList[$modelClass][$field]) ? $labelFieldList[$modelClass][$field] : ( isset($labelFieldList['*'][$field]) ? $labelFieldList['*'][$field] : $field ));
   echo $tst;
    echo '</td>';
    echo '<td>';
    echo ($questionsText[$field]);
    echo '</td><td>';
    echo $this->Form->input($modelClass . '.' . $field . '.' . 'Position', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'size' => '4', 'maxlength' => '4', 'class' => 'position'));
    $currType = ( isset($attributes['type']) ? $attributes['type'] : $attributes['Type'] );
    echo $this->Form->input($modelClass . '.' . $field . '.' . 'Type', array('type' => 'hidden', 'value' => $currType));
    $currLength = ( isset($attributes['length']) ? $attributes['length'] :
                    ( isset($attributes['Length']) ? $attributes['Length'] : 10) );
    echo $this->Form->input($modelClass . '.' . $field . '.' . 'Length', array('type' => 'hidden', 'value' => $currLength));
    echo '</td>';
    echo '</tr>';
endforeach;
?>