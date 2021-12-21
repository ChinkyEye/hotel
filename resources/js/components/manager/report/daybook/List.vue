<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">DayBook Report</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">DayBook</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print">Print</i></button>
            <!-- main page load here-->
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-3">
                  <date-picker v-model="date" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()'>
                    <template v-slot="{ inputValue, inputEvents }">
                      <input
                        class="form-control bg-white border px-2 py-1 rounded"
                        :value="inputValue"
                        v-on="inputEvents"
                      />
                    </template>
                  </date-picker>
                </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div  class="d-none">
                {{getAllCounterStatus}}
              </div>
              <div id="printMe">
                <div class="row">
                  <div class="col-md-3">
                    <div class="info-box">
                      <span class="info-box-icon bg-success"><i class="fas fa-rupee-sign"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Total</span>
                        <span class="info-box-number h4">{{total}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-info">
                      <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Discount</span>
                        <span class="info-box-number h4">{{discount}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-success">
                      <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Grand Total</span>
                        <span class="info-box-number h4">{{grand_total}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-primary">
                      <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Due</span>
                        <span class="info-box-number h4">{{due}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-red">
                      <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Collection</span>
                        <span class="info-box-number h4">{{due_received}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-orange">
                      <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Net Amount</span>
                        <span class="info-box-number h4">{{totreceive}}</span>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-md-3">
                    <div class="info-box mb-3 bg-info">
                      <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Transferred</span>
                        <span class="info-box-number h4">{{amount_transferred}}</span>
                      </div>
                    </div>
                  </div> -->
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-purple">
                      <span class="info-box-icon"><i class="fas fa-sort-amount-up"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Bill Sold</span>
                        <span class="info-box-number h4">{{bill_sold}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="info-box mb-3 bg-info">
                      <span class="info-box-icon"><i class="fas fa-sort-amount-up"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text h3">Purchase</span>
                        <span class="info-box-number h4">{{amount_purchase}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
              
              </div>
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</template>
<script>
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      DatePicker,
    },
    data(){
      return{
          date: new Date(), // Jan 16th, 2018
          total:0,
          discount:0,
          grand_total:0,
          due:0,
          quantity:0,
          due_received:0,
          amount_transferred:0,
          bill_cancel:0,
          bill_sold:0,
          sold_return:0,
          amount_purchase:0,
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllCounterStatus(){
        var avar = this.$store.getters.getDaybook;
        if(avar.length == 0) return [];
        this.total = avar.total
        this.discount = avar.discount
        this.grand_total = avar.grand_total
        this.due = avar.due
        this.quantity = avar.quantity
        this.due_received = avar.due_received
        this.amount_transferred = avar.amount_transferred
        this.bill_cancel = avar.bill_cancel
        this.bill_sold = avar.bill_sold
        this.sold_return = avar.sold_return
        this.amount_purchase = avar.amount_purchase
      },
      totreceive(){
        return parseFloat(this.grand_total) - parseFloat(this.due) + parseFloat(this.due_received);
      },
    },
    methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allDaybook", [moment(this.date).format('YYYY-MM-DD')]);
        this.$Progress.finish()
      },
      print () {
        this.$htmlToPaper('printMe');
      },
      counterChange(){
        this.fetchPosts();
      },
      dateChange(){
        this.fetchPosts();
      },
    }
  }
</script>

<style scoped>
</style>