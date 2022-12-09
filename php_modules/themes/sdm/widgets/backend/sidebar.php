<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?php echo $this->url . '/admin'; ?>">
            <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                <path d="M20 12L12 16L4 12"></path>
                <path d="M20 16L12 20L4 16"></path>
            </svg>
            <span class="sidebar-brand-text align-items-middle ms-2">
                SDM
            </span>
        </a>
        <ul class="sidebar-nav fs-4">
            <?php
            foreach ($this->menu as $row) {
                list($allow, $plural, $name, $icon, $submenu) = $row;
                $plural_tmp = str_replace('/', '\/', $plural); 
                preg_match('/^(\/admin\/' . $plural_tmp . ')(|\/)$/', $this->path_current, $match);
                if (is_array($match) && count($match)) {
                    $active = true;
                } else {
                    $active = false;
                    foreach ($allow as $single) {
                        $single = str_replace('/', '\/', $single);
                        preg_match('/^(\/admin\/' . $single . ')(|\/([0-9]*?))$/', $this->path_current, $match);
                        if (is_array($match) && count($match)) {
                            $active = true;
                            break;
                        }
                    }
                } 
                $check_submenu_active = false;
                if (is_array($submenu) && $submenu)
                {
                    $sub_actives = [];
                    foreach($submenu as $key => $sub)
                    {
                        $sub_actives[$key] = false;
                        list($allow_sub, $plural_sub, $name_sub, $icon_sub) = $sub;
                        $plural_tmp = str_replace('/', '\/', $plural_sub); 
                        preg_match('/^(\/admin\/' . $plural_tmp . ')(|\/)$/', $this->path_current, $match);
                        if (is_array($match) && count($match)) {
                            $sub_actives[$key] = true;
                            $check_submenu_active = true;
                        } else {
                            foreach ($allow_sub as $single) {
                                $single = str_replace('/', '\/', $single);
                                preg_match('/^(\/admin\/' . $single . ')(|\/([0-9]*?))$/', $this->path_current, $match);
                                if (is_array($match) && count($match)) {
                                    $sub_actives[$key] = true;
                                    break;
                                }
                            }
                        } 
                    }
                }
                ?>
                <li class="sidebar-item <?php echo $active ? 'active' : ''; ?>">
                    <a href="<?php echo (is_array($submenu) && $submenu) ? '' : $this->link_admin . $plural ?>" class="sidebar-link" <?php echo (is_array($submenu) && $submenu) ? 'data-bs-target="#Setting" data-bs-toggle="collapse" aria-expanded="true" ' : '' ?> >
                        <?php echo $icon ?> <span class="align-middle"><?php echo $name ?><?php echo (is_array($submenu) && $submenu) ? '<i id="icon" class="fa-solid  fa-caret-down  float-end mt-1 test1"></i>' : '' ?></span>
                    </a>
                    <?php if (is_array($submenu) && $submenu) : ?>
                        <ul id="Setting" class="sidebar-dropdown list-unstyled collapse ">
                            <?php foreach($submenu as $sub) :
                                list($allow_sub, $plural_sub, $name_sub, $icon_sub) = $sub;
                             ?>
                            <li class="sidebar-item ">
                                <a href="<?php echo $this->link_admin . $plural; ?>" class="sidebar-link"><i class="fa-solid fa-arrow-right"></i><?php echo $name_sub ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>