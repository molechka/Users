<?
$user = array('_id' => "");
if (NoiCore::user()->isLogin()) {
    $user = NoiCore::user()->load();
}
?>
<h2>Пользователи</h2>
<?
if (NoiCore::user()->isLogin()) {
    ?>
    <p>
        <a class="btn btn-danger" href="<?php echo $mg->view->options['controller']->getRoute('admin/index/create'); ?>">Добавить пользователя</a>
    </p>
    <?
}
?>
<form action="/user/admin/index" method="GET">
    <table class="table">
        <tr >
            <td colspan="2" style="text-align:center;">Дата изменения</td>
        </tr>
        <tr>
            <td>C&nbsp;<input style="width:80%;display:inline;" class=" form-control" type="date" name="date_start" value='<?php
                if (isset($_GET['date_start']) and is_string($_GET['date_start'])) {
                    echo strip_tags($_GET['date_start']);
                }
                ?>'></td>
            <td>По&nbsp;<input style="width:80%;display:inline;" class="form-control" type="date" name="date_end" value='<?php
                if (isset($_GET['date_end']) and is_string($_GET['date_end'])) {
                    echo strip_tags($_GET['date_end']);
                }
                ?>'></td>

        </tr>
        <tr >
            <td colspan="2" style="text-align:center;">Поисковая строка</td>
        </tr>
        <tr>
            <td colspan="2"><input type="text" placeholder="Введите email или имя" value='<?php
                if (isset($_GET['q']) and is_string($_GET['q'])) {
                    echo strip_tags($_GET['q']);
                }
                ?>' name="q" class="form-control" value=""></td>

        </tr>
        <tr>
            <td ><button type="submit" class="btn btn-submit" >Найти</button></td>
            <td><a href="/">Сбросить фильтры</a></td>

        </tr>
    </table>
</form>
<table class="table ">
    <thead>
        <tr>

            <?
            if ($mg->fields->showid == true) {
                ?>
                <th>айди</th>
                <?
            }
            foreach ($mg->fields->array_fields as $field) {
                if (isset($mg->fields->not_show[$field]["list"])) {
                    
                } else {
                    $title = $mg->fields->array_type[$field]['label'];
                    ?>
                    <th><?php echo $title; ?><a href="?sort_type=asc&sort_field=<?php echo $field; ?>"><i class="fa <?php
                            if (isset($_GET['sort_type']) and $_GET['sort_type'] == "asc" and isset($_GET['sort_field']) and $_GET['sort_field'] == $field) {
                                echo 'fachoose';
                            }
                            ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=<?php echo $field; ?>"><i class="fa <?php
                                                                                                          if (isset($_GET['sort_type']) and $_GET['sort_type'] == "desc" and isset($_GET['sort_field']) and $_GET['sort_field'] == $field) {
                                                                                                              echo 'fachoose';
                                                                                                          }
                                                                                                          ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></th>
                                                                                                              <?
                                                                                                          }
                                                                                                      }
                                                                                                      ?>
            <th style="width:100px">ФИО<a href="?sort_type=asc&sort_field=name"><i class="fa <?php
                    if (isset($_GET['sort_type']) and $_GET['sort_type'] == "asc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "name") {
                        echo 'fachoose';
                    }
                    ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=name"><i class="fa <?php
                                                                                   if (isset($_GET['sort_type']) and $_GET['sort_type'] == "desc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "name") {
                                                                                       echo 'fachoose';
                                                                                   }
                                                                                   ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></th>
            <th>Автор<a href="?sort_type=asc&sort_field=by_user.email"><i class="fa <?php
                    if (isset($_GET['sort_type']) and $_GET['sort_type'] == "asc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "by_user.email") {
                        echo 'fachoose';
                    }
                    ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=by_user.email"><i class="fa <?php
                                                                          if (isset($_GET['sort_type']) and $_GET['sort_type'] == "desc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "by_user.email") {
                                                                              echo 'fachoose';
                                                                          }
                                                                          ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></th>
            <th>Дата изменения<a href="?sort_type=asc&sort_field=date_updated"><i class="fa <?php
                    if (isset($_GET['sort_type']) and $_GET['sort_type'] == "asc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "date_updated") {
                        echo 'fachoose';
                    }
                    ?> fa-sort-asc" aria-hidden="true"></i>&nbsp;</a> <a href="?sort_type=desc&sort_field=date_updated"><i class="fa <?php
                                                                                  if (isset($_GET['sort_type']) and $_GET['sort_type'] == "desc" and isset($_GET['sort_field']) and $_GET['sort_field'] == "date_updated") {
                                                                                      echo 'fachoose';
                                                                                  }
                                                                                  ?> fa-sort-desc" aria-hidden="true">&nbsp;</i></a></th>
                                                                                      <?
                                                                                      if (in_array("update", $mg->operations->available) and ! in_array("update", $mg->operations->denied_access)) {
                                                                                          ?>
                <th>Изменить</th>
                <?
            }
            ?>
            <?
            if (in_array("delete", $mg->operations->available) and ! in_array("delete", $mg->operations->denied_access)) {
                ?>
                <th>Удалить</th>
                <?
            }
            ?>
            <th></th>
        </tr>
    </thead>
    <tbody class="ajax_load_row">
        <?
        if (isset($mg->result) and isset($mg->result[0]['_id'])) {
            foreach ($mg->result as $row) {
                ?>
                <tr>

                    <?
                    if ($mg->fields->showid == true) {
                        ?>
                        <td>    <?php echo $row['last_id']; ?></td>
                        <?
                    }
                    foreach ($mg->fields->array_fields as $field) {
                        if (isset($mg->fields->not_show[$field]["list"])) {
                            
                        } else {




                            if (isset($mg->fields->array_type[$field]['type']) and $mg->fields->array_type[$field]['type'] == "image") {
                                //  $bin= new MongoBinData($row[$field]);
                                //echo $row[$field]->bin;
                                // $imagick=new Imagick();
                                //  $imagick->readimageblob($row[$field]->bin);
                                // $imagick->displayimage($row['_id']->__toString());


                                if (!isset($row[$field]->bin)) {
                                    $blob = $row[$field];
                                } else {
                                    $blob = $row[$field]->bin;
                                }
                                $js = 0;
                                if (isset($_GET['CKEditorFuncNum']) and isset($_GET['CKEditor']) and isset($_GET['langCode'])) {
                                    $funcNum = $_GET['CKEditorFuncNum'];
                                    $js = 1;
                                    // Optional: instance name (might be used to load a specific configuration file or anything else).
                                    $CKEditor = $_GET['CKEditor'];
                                    // Optional: might be used to provide localized messages.
                                    $langCode = $_GET['langCode'];
                                    $url_image = $blob;
                                } else {
                                    $url_image = $blob;
                                }
                                ?>
                                <td><?php echo GridImage::showImage($blob, 100, 100, $row['_id']->__toString(), $field, $url_image) ?></td>
                                <?
                            } else if (isset($row[$field])) {
                                if (is_array($row[$field])) {
                                    $row[$field] = count($row[$field]);
                                }
                                ?>
                                <td><?php echo $row[$field]; ?></td>
                                <?
                            } else {
                                ?>
                                <td></td>
                                <?
                            }
                        }
                    }
                    ?>
                    <td style=" max-width: 300px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;">
                        <?
                        if (isset($row['name'])) {
                            echo $row['name'];
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if (isset($row['by_user'])) {
                            ?>
                            <?php echo $row['by_user']['email']; ?>
                            <?
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if (isset($row['date_updated'])) {
                            ?>
                            <?php echo date('d.m.Y', $row['date_updated']->sec); ?>
                            <?
                        }
                        ?>
                    </td>
                    <?
                    if (( isset($row['by_user']) and $row['by_user']['_id'] and $row['by_user']['_id'] == $user['_id']) or \user\models\UserAccount::isManager()) {
                        ?>
                        <td><a class="btn btn-success" href="<?php echo $mg->setRoute('/update/' . $row['_id']->__toString()); ?>">Изменить</a></td>
                        <?
                    } else {
                        ?>
                        <td></td>
                        <?
                    }
                    ?>
                    <?
                    if ((in_array("delete", $mg->operations->available) and ! in_array("delete", $mg->operations->denied_access) and isset($row['_id']) and NoiCore::user()->isLogin() and isset($row['by_user']['_id']) and $row['by_user']['_id'] == $user['_id']) or \user\models\UserAccount::isManager()) {
                        ?>
                        <td><a class="btn btn-success" href="  <?php echo $mg->setRoute('/delete/' . $row['_id']->__toString()); ?>">Удалить</a></td>

                        <?
                    } else {
                        ?>
                        <td></td>
                        <?
                    }
                    ?>
                    <td><a class="btn btn-success" href="<?php echo $mg->view->options['controller']->getRoute('admin/view/' . $row['_id']->__toString()); ?>">Посмотреть</a></td></td>
                </tr>
                <?
            }
        }
        ?>
    </tbody>
</table>
<?
if (!isset($js)) {
    $js = 0;
}
if ($js == "1") {
    ?>
    <script>
        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);

            return (match && match.length > 1) ? match[ 1 ] : null;
        }
        function OpenFile(fileUrl)
        {

            //PATCH: Using CKEditors API we set the file in preview window.

            funcNum = getUrlParam('CKEditorFuncNum');
            //fixed the issue: images are not displayed in preview window when filename contain spaces due encodeURI encoding already encoded fileUrl
            window.top.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);

            ///////////////////////////////////
            window.top.close();
            window.top.opener.focus();
        }
        $(document).ready(function () {
            $("a img").on("click", function () {
                var href = $(this).attr("src");

                var funcNum = getUrlParam('CKEditorFuncNum');

                OpenFile(href);


            })
        })
    </script>
    <?
}
$count = 0;
if (isset($mg->result[0]['_count_'])) {
    $count = $mg->result[0]['_count_'];
}
?>
<mgplugin count="<?php echo $count; ?>" limit="<?php echo $mg->page_item; ?>">paginator</mgplugin>
