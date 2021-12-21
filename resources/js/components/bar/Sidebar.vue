<template>
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Customer
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item" v-for="usertype in getAllUsertype">
          <router-link :to="`/customer/${usertype.id}`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>{{usertype.name}}</p>
          </router-link>
        </li>
      </ul>
    </li> -->
    <li class="nav-item">
      <router-link to="/all-customer" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Customer
        </p>
      </router-link>
    </li>
    <!-- <li class="nav-item">
      <router-link to="/category" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Category
        </p>
      </router-link>
    </li> -->
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Category
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/category/buying`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Buying</p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/category/selling`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Selling</p>
          </router-link>
        </li>
      </ul>
    </li>
    <!-- <li class="nav-item">
      <router-link to="/package" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Package
        </p>
      </router-link>
    </li> -->
    <li class="nav-item">
      <router-link to="/unit" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Unit
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/stock" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Stock
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/table" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Table
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/item" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Menu
        </p>
      </router-link>
    </li>
    <!-- <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Billing
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
    <li class="nav-item">
      <router-link to="/confirm" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Bill
        </p>
      </router-link>
    </li>
      </ul>
    </li> -->
    <!-- <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Salary
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
      <router-link to="/salary/create" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Add Salary
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/salary" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Salary
        </p>
      </router-link>
    </li>
      </ul>
    </li> -->
    <!-- <li class="nav-item">
      <router-link to="/testcategory" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          TestCategory
        </p>
      </router-link>
    </li> -->
  </ul>
</template>
<script>
    export default {
        name: "New",
        data(){
            return {
              form: new Form({
                name:'',
                // email:'',
                user_type:'',
                phone:'',
                address:'',
                date_of_join:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        this.$store.dispatch("allUsertypeSelect");
        // var that = this;
        // window.addEventListener('keydown', (e) => {
        //   if (e.key == 'F6') {
        //     that.$router.push('/order');
        //     return false;
        //   } else if (e.key == 'F7') {
        //     that.$router.push('/review');
        //     return false;
        //   } else if (e.key == 'F8') {
        //     that.$router.push('/confirm');
        //     return false;
        //   }
        // });
    },
    computed:{
        getAllUsertype(){
            return this.$store.getters.getUsertypeSelect
        }
    },
    methods:{
         addNewUser(){
          this.state.isSending = true;
          this.form.post('/bar/user')
          .then((response)=>{
            this.$router.push('/user')
            Toast.fire({
                icon: 'success',
                title: 'User Added successfully'
            })
        })
          .catch(()=>{
              this.state.isSending = false;
          })
      }
    }
  }
</script>

<style scoped>

</style>