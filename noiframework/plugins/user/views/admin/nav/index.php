<li class="<? if ($current_page == "p_user") {
    echo "active";
} ?> dropdown">
    <a class="sa-side2-users" href="">
        <span class="menu-item"><?php echo NoiCore::app()->lang('users_title'); ?></span>
    </a>
    <ul class="list-unstyled menu-item">


        <li   class='<? if ($controller->inner_href == "config/status_activate") {
    echo "active";
} ?>'><a href="<?php echo $controller->getUrl("config/status_activate") ?>"><?php echo NoiCore::app()->lang('users_activate_email'); ?></a></li>
        <li   class='<? if ($controller->inner_href == "config/default") {
    echo "active";
} ?>'><a href="<?php echo $controller->getUrl("config/default") ?>"><?php echo NoiCore::app()->lang('users_config'); ?></a></li>
        <li   class='<? if ($controller->inner_href == "config/fields") {
    echo "active";
} ?>'><a href="<?php echo $controller->getUrl("config/fields") ?>"><?php echo NoiCore::app()->lang('users_fields'); ?></a></li>
        <li   class='<? if ($controller->inner_href == "config/roles") {
    echo "active";
} ?>'><a href="<?php echo $controller->getUrl("config/roles") ?>"><?php echo NoiCore::app()->lang('users_roles'); ?></a></li>
        <li   class='<? if ($controller->inner_href == "config/pages") {
    echo "active";
} ?>'><a href="<?php echo $controller->getUrl("config/pages") ?>"><?php echo NoiCore::app()->lang('users_pages'); ?></a></li>
        <li  class='<? if ($controller->inner_href == "email/index") {
    echo "active";
} ?>'><a href="<?php echo $controller->getUrl("email/index") ?>"><?php echo NoiCore::app()->lang('users_mailing'); ?></a></li>

        <li ><a href="<?= $controller->getRoute('users/index') ?>">Пользователи</a></li>
        <li><a href="<?php echo NoiCore::app()->getRoute('p_tasks/config/users'); ?>">Emailы owneroв</a></li>



    </ul>
</li>