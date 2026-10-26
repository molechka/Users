<p>Плагин для управления пользователями</p>



<ul class="nav nav-tabs">
      <li class='<? if($controller->inner_href=="config/status_activate"){ echo "active";} ?>'><a href="<?php echo $controller->getUrl("config/status_activate")?>">Активация по Email</a></li>
    <li class='<? if($controller->inner_href=="config/default"){ echo "active";} ?>'><a href="<?php echo $controller->getUrl("config/default")?>">Настройки</a></li>
         <li class='<? if($controller->inner_href=="config/fields"){ echo "active";} ?>'><a href="<?php echo $controller->getUrl("config/fields")?>">Поля</a></li>
         <li class='<? if($controller->inner_href=="users"){ echo "active";} ?>'><a href="<?php echo $controller->getUrl("users")?>">Список пользователей</a></li>
     <li class='<? if($controller->inner_href=="config/roles"){ echo "active";} ?>'><a href="<?php echo $controller->getUrl("config/roles")?>">Роли</a></li>
      <li class='<? if($controller->inner_href=="config/pages"){ echo "active";} ?>'><a href="<?php echo $controller->getUrl("config/pages")?>">Страницы</a></li>

</ul>
