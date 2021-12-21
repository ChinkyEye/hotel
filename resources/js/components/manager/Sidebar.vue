<template>
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <router-link to="/waiter" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p class="text-danger">
          Waiter
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/counter" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p class="text-danger">
          Counter
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/kitchen" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p class="text-danger">
          Kitchen
        </p>
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/bar" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p class="text-danger">
          Bar
        </p>
      </router-link>
    </li>
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
    <li class="nav-item">
      <router-link to="/usertypeList" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Customer
        </p>
      </router-link>
    </li>
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
      <router-link to="/vendor" class="nav-link">
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
<!--         <li class="nav-item">
          <router-link to="/order" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>
              Order
            </p>
          </router-link>
        </li> -->
<!--         <li class="nav-item">
          <router-link to="/review" class="nav-link">
            <i class="far fa-circle nav-icon text-danger"></i>
            <p>
              Review
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
          this.form.post('/manager/user')
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