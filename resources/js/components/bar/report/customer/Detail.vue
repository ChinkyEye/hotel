<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer Detail Report</h1>
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
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- main page load here-->
            <div class="card">
              <div class="card-header">
                <form class="d-inline-block">
                  <a class="btn btn-primary mb-2" id="receive" href="javascript:void(0)" title="Add Received Amount" @click="openModalWindow()"> 
                    Add Receive
                    <i class="fas fa-user-plus"></i>
                  </a>
                </form>
                <button @click="print" class="btn btn-primary float-right mb-2"><i class="fas fa-print">Print</i></button>
              </div><!-- /.card-header -->
              <div id="printMe">
                <div class="card-body">
                  <div class="w-100 text-center mb-3">
                    <div class="h2 font-bolder"> {{name}}</div>
                    <div>
                      <span>{{address}}, Phone: {{phone}}</span>
                      <div>Code: {{user_code}}</div>
                    </div>
                  </div>
                  <span><b>Total Receive </b> Rs: {{totreceive}}</span>
                  <span class="mx-5"><b>Total Remaining </b> Rs: {{totremain}}</span>
                  <div class="row">
                    <div class="col-8">
                      <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover w-100">
                          <thead class="table-primary">                  
                            <tr>
                              <th>SN</th>
                              <th>Bill ID</th>
                              <th>Table</th>
                              <th>Total(Rs)</th>
                              <th>Discount(Rs)</th>
                              <th>Received(Rs)</th>
                              <th>Due(Rs)</th>
                              <th>Issued</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(orderdetail,index) in getAllOrderdetail" :key="orderdetail.id">
                              <td>{{index+1}}</td>
                              <td><router-link :to="`/confirm/${orderdetail.bill_id}/preview`" target="_blank">{{orderdetail.bill_id}}</router-link>({{orderdetail.count_count}})</td>
                              <td>{{orderdetail.table.name}}</td>
                              <td>{{orderdetail.total}}</td>
                              <td>{{orderdetail.discount}}</td>
                              <td>{{orderdetail.received}}</td>
                              <td>{{orderdetail.grand_total - orderdetail.received}}</td>
                              <td>{{orderdetail.created_at | timeformat}}<span class="badge badge-warning text-info">{{orderdetail.created_at  | formatDate}}</span></td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="3">Total:</td>
                              <td>Rs: {{total}}</td>
                              <td>Rs: {{discount}}</td>
                              <td>Rs: {{totreceive}}</td>
                              <td>Rs: {{totremain}}</td>
                            </tr>
                            <!-- <tr>
                              <td colspan="4">Discount:</td>
                              <td>Rs: {{discount}}</td>
                            </tr>
                            <tr>
                              <td colspan="4">Grand Total:</td>
                              <td>Rs: {{grand_total}}</td>
                            </tr>
                            <tr>
                              <td colspan="4">Total Receive:</td>
                              <td>Rs: {{totreceive}}</td>
                            </tr>
                            <tr>
                              <td colspan="4">Net Remaining Amount:</td>
                              <td>Rs: {{totremain}}</td>
                            </tr> -->
                          </tfoot>
                        </table>
                        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts1"></pagination>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover">
                          <thead class="table-primary">                  
                            <tr>
                              <th>SN</th>
                              <th>Bill ID</th>
                              <th>Received</th>
                              <th>Created At</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(orderdetail,index) in getAllPaydetail" :key="orderdetail.id">
                              <td>{{index+1}}</td>
                              <td>{{orderdetail.bill_id}}</td>
                              <td>{{orderdetail.received}}</td>
                              <td>{{orderdetail.created_at | timeformat}}<span class="badge badge-warning"><span class="text-info">{{orderdetail.created_at  | formatDate}}</span></span></td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="2">Total</td>
                              <td>Rs: {{paytotal}}</td>
                            </tr>
                          </tfoot>
                        </table>
                        <pagination v-if="pagination2.last_page > 1" :pagination="pagination2" :offset="5" @paginate="fetchPosts2"></pagination>
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
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addNewLabel">Amount Receive form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="createUser()">
              <div class="modal-body">
                <input type="hidden" v-model="form.user_id" name="user_id" >
                <div class="form-group">
                  <label>Amount</label>
                  <input type="text" class="form-control" placeholder="Add Amount" v-model="form.amount" :class="{ 'is-invalid': form.errors.has('amount') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Date</label>
                  <date-picker v-model="form.date" lang="en" type="date" :class="{ 'is-invalid': form.errors.has('date') }" :max-date='new Date()'></date-picker>
                  <has-error :form="form" field="name"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
  import pagination from '../../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment';
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker
    },
    data(){
      return{
        form: new Form({
            user_id:'',
            amount:'',
            date: new Date()
        }),
        pagination: {
            'current_page': 1
          },
         pagination2: {
            'current_page': 1
          },
          user_t_id:'',
          user_id:'',
          total:'',
          discount:'',
          grand_total:'',
          receive:'',
          paytotal:'',
          name:'',
          address:'',
          user_code:'',
          phone:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllOrderdetail(){
        this.$Progress.start()
        var bvar = this.$store.getters.getUserOrderdetail;
        if(bvar.length == 0) return [];
        var avar = bvar[0].userorderdetails.data;
        this.total = bvar[0].total;
        this.discount = bvar[0].discount;
        this.grand_total = bvar[0].grand_total;
        this.receive = bvar[0].receive;
        this.name = bvar[0].name;
        this.address = bvar[0].address;
        this.user_code = bvar[0].user_code;
        this.phone = bvar[0].phone;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
      getAllPaydetail(){
        this.$Progress.start()
        var paybvar = this.$store.getters.getUserPaydetail;
        if(paybvar.length == 0) return [];
        var payavar = paybvar[0].userpaydetails.data;
        this.paytotal = paybvar[0].paytotal;
        if(paybvar.length==2)
          this.pagination2 = paybvar[1];
        this.$Progress.finish()
        return payavar;
      },
      totreceive(){
        return parseFloat(this.receive) + parseFloat(this.paytotal);
      },
      totremain(){
        return (parseFloat(this.receive) + parseFloat(this.paytotal)) - parseFloat(this.grand_total);
      }
    },
    methods:{
      fetchPosts() {
        this.fetchPosts1();
        this.fetchPosts2();
      },
      fetchPosts1(){
        this.$store.dispatch("allUserOrderdetail",[this.pagination.current_page,this.$route.params.userid]);
      },
      fetchPosts2(){
        this.$store.dispatch("allUserPaydetail",[this.pagination2.current_page,this.$route.params.userid]);
      },
      dateChange(){
        this.pagechange();
      },
      openModalWindow(){
        // this.form.reset();
        this.form.user_id = this.$route.params.userid;
        $('#addNew').modal('show');
      },
      createUser(){
        var that = this;
        this.$Progress.start()
        this.form.post('/bar/report/customer/seller')
        .then(() => {
            Fire.$emit('AfterCreatedUserLoadIt'); //custom events
            Toast.fire({
                icon: 'success',
                title: 'User created successfully'
          })
            this.$Progress.finish()
            $('#addNew').modal('hide');
        })
        .catch(() => {
             console.log("Error......")
         })
        that.form.amount = '';
        this.fetchPosts();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    }
    }
  }
</script>

<style scoped>
</style>