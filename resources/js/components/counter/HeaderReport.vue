<template>
  <aside class="control-sidebar control-sidebar-dark sidebar-dark-primary">
    <div class="sidebar">
      <nav class="p-2 control-sidebar-content">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <router-link to="/report/sales" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Sale Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/items" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Item Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/customer" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Customer Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/report/overall" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Overall Report
              </span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/change-password" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <span>
                Change Password
              </span>
            </router-link>
          </li>
        </ul>
      
      </nav>
    </div>
  </aside>
</template>
<style scoped>
/*.control-sidebar .control-sidebar-dark{
  z-index: 999;
}*/
</style>