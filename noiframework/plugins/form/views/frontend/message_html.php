<?
use noicms\mongogrid\OneField;
 
?>
<h2>Новое сообщение из формы <?=$form['title'];?></h2>
<table >
                                      <?
                                      foreach($message['fields'] as $field){
                                      $tmp=new OneField();
                                      $tmp->init($field['name'], $field['type']);
                                      
                                      ?>
                                        <tr>
                                            <td><?=$field['label'];?></td>
                                            <td><?=$tmp->showInput($field['value']);?>

                                            </td>
                                        </tr>
                                      <?
                                      }
                                      ?>
                                    </table> 
<?
 
?>

