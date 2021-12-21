<template>
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <router-link to="/manager" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p class="text-danger">
          Manager
        </p>
      </router-link>
    </li>
    <!-- <li class="nav-item">
      <router-link to="/user-type" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Customer Category
        </p>
      </router-link>
    </li> -->
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Customer Category
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/customer/buyer`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Buyer</p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/customer/seller`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Seller</p>
          </router-link>
        </li>
      </ul>
    </li>
    <!-- <li class="nav-item">
      <router-link to="/user" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          User
        </p>
      </router-link>
    </li> -->
    <li class="nav-item">
      <router-link to="/usertypeList" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Customer
        </p>
      </router-link>
    </li>
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
    <!-- <li class="nav-item">
      <router-link to="/user" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          User
        </p>
      </router-link>
    </li> -->
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
          Purchase
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/purchase/list" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Purchase List
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/asset" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Asset
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
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Billing
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <!-- <li class="nav-item">
      <router-link to="/order" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Order
        </p>
      </router-link>
    </li> -->
    <li class="nav-item">
      <router-link to="/confirm" class="nav-link">
        <i class="far fa-circle nav-icon text-danger"></i>
        <p>
          Bill
        </p>
      </router-link>
    </li>
      </ul>
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-comments-dollar"></i>
        <p>
          Income Category
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/income/topic`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Topic</p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/income`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Income</p>
          </router-link>
        </li>
      </ul>
      
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-comments-dollar"></i>
        <p>
          Expense Category
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/expense/topic`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Topic</p>
          </router-link>
        </li>
      </ul>
      <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
          <router-link :to="`/expense`" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>Expense</p>
          </router-link>
        </li>
      </ul>
    </li>
    <li class="nav-item">
    <router-link to="/room" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Room
      </p>
    </router-link>
    </li>
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
        this.$store.dispatch("allUsertypeSelect")
    },
    computed:{
        getAllUsertype(){
            return this.$store.getters.getUsertypeSelect
        }
    },
    methods:{
         addNewUser(){
          this.state.isSending = true;
          this.form.post('/home/user')
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