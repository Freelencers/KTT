<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php
        
         // Loop menu section
          foreach($menuList["section"] as $section){
            echo '<li class="header">' . strtoupper($section->modSection) . '</li>';

            // Loop menu list in this section
            foreach($menuList["permission"] as $menu){

              // check this menu in section
              if($menu->modSection == $section->modSection){
                $menuName = $this->lang->line("module".ucfirst($menu->modSection).ucfirst($menu->modName));
                echo '<li><a href="' . base_url('index.php/'.$menu->modDestination) . '"><i class="' . $menu->modIcon . '"></i> <span>' . $menuName . '</span></a></li>';
              }
            }
          }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>