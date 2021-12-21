<template>
<div>
  <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h5 class="m-0 text-dark">Report</h5>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
          <li class="breadcrumb-item active">Dashboard v1</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div  v-for="(detail,index) in getAllOrder"></div>
      <div class="col-lg-3 col-6">
      <router-link to="/report/sales">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{product_count}}</h3>
            <p>Sale Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
      <router-link to="/report/purchases">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{order_count}}</h3>
            <p>Purchase Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/items">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{stock_count}}</h3>
            <p>Item Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/stocks">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{stock_level_count}}</h3>
            <p>Stock Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/kitchen-stocks">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{counter_count}}</h3>
            <p>Kitchen Stock Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/asset">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{bill_count}}</h3>

            <p>Asset Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/counter">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{bill_count}}</h3>

            <p>Counter Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/customer">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{bill_ageing_count}}</h3>

            <p>Customer Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/bill">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{bill_ageing_count}}</h3>

            <p>Bill Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/daybook">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{daybook_count}}</h3>
            <p>DayBook</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/waiter">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{daybook_count}}</h3>
            <p>Waiter</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/incomereport">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{daybook_count}}</h3>
            <p>Income Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/expensereport">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{daybook_count}}</h3>
            <p>Expense Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/roomreport">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{daybook_count}}</h3>
            <p>Room Available Report</p>
          </div>
        </div>
        </router-link>
      </div>
      <div class="col-lg-3 col-6">
        <router-link to="/report/change-password">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{credit_count}}</h3>
            <p>Change Password</p>
          </div>
        </div>
        </router-link>
      </div>
      
    </div>
</div>
</section>
</div>
</template>
<script>
export default{
    name: "List",
    components: {
    },
    data(){
      return{
          product_count:'',
          order_count:'',
          stock_count:0,
          stock_level_count:'',
          counter_count:'',
          bill_count:'',
          bill_ageing_count:'',
          daybook_count:0,
          credit_count:0,
          debit_count:0,
          debitdue_count:0,
          purchase_return_count:0,
          top_item_sale:0,
          top_item_customer:0,
        }
    },
        mounted(){
            this.$Progress.start()
            this.fetchPosts();
            this.$Progress.finish()
        },
        computed:{
            getAllOrder(){
                var bvar = this.$store.getters.getReportDashboard;
                if(bvar.length == 0) return [];
                this.product_count = bvar[0].product_count;
                this.order_count = bvar[0].order_count;
                this.stock_level_count = bvar[0].stock_level_count;
                this.counter_count = bvar[0].counter_count;
                this.bill_count = bvar[0].bill_count;
                this.bill_ageing_count = bvar[0].bill_ageing_count;
                this.purchase_return_count = bvar[0].purchase_return_count;
                this.top_item_sale = bvar[0].top_item_sale;
                this.top_item_customer = bvar[0].top_item_customer;
            }
        },
        methods:{
            fetchPosts() {
                this.$store.dispatch("allReportDashboard")
            }
        }
    }
</script>

<style scoped>
</style>