<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php
       
          // initial
          $this->session->set_userdata("accessMaterial", 0);
          $this->session->set_userdata("accessProduct", 0);
          
         // Loop menu section
          foreach($menuList["section"] as $section){

            echo '<li class="header">' . strtoupper($section->modSection) . '</li>';

            // Loop menu list in this section
            foreach($menuList["permission"] as $menu){

              if($menu->modShow == 1){

                // check this menu in section
                if($menu->modSection == $section->modSection){
                  $menuName = $this->lang->line("module".ucfirst($menu->modSection).ucfirst($menu->modName));
                  echo '<li><a href="' . base_url('index.php/'.$menu->modDestination) . '"><i class="' . $menu->modIcon . '"></i> <span>' . $menuName . '</span></a></li>';
                }
              }else{

                switch($menu->modName){

                  case "accessMaterial" : $this->session->set_userdata("accessMaterial", 1);
                                          break;
                  case "accessProduct"  : $this->session->set_userdata("accessProduct", 1);
                                          break;
                }
              }
            }
          }
        ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>