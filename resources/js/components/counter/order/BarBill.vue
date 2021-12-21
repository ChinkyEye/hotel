<template>
<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-danger m-0">Order Token (Ticket)</p>
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
                <div class="col-8">
                  <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print"></i></button>
                  <div id="printMe">
                    <div class="invoice p-3 mb-3">
                      <!-- info row -->
                      <div class="row invoice-info m-0">
                        <div class="col-sm-12 table-responsive p-0">
                          <table class="table table-sm m-0 border-print">
                            <tr>
                              <td colspan="2">
                                <div class="text-center">
                                  <h5><i class="fas fa-utensils"></i> Bar Order Ticket</h5>
                                  <div><small>{{date}}</small></div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td><b>Table:</b> {{table_name}} ({{customer.name}})</td>
                              <td class="text-right"><b>Bill ID:</b> {{billid}}</td>
                            </tr>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                      <div class="row">
                        <div class="col-12 table-responsive">
                          <table class="table table-sm table-striped border-print">
                            <tr>
                              <th width="10">SN</th>
                              <th class="text-left">Item</th>
                              <th>Qty</th>
                            </tr>
                            <tr v-for="(post,index) in getAllBill" :key="post.id">
                                <td>{{index+1}}</td>
                                <td class="text-left">{{post.item.name}}</td>
                                <td>{{post.quantity}} {{post.unit.name}}</td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <small class="float-left">Counter: {{receive_name}}</small>
                                <small class="float-right">{{today}}</small>
                              </td>
                            </tr>
                          </table>
                        </div>
                        <!-- /.col -->
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
  import moment from 'moment'
  export default{
    name: "OrderBarBill",
     data(){
            return {
              amount: '',
              discount:'',
              total:'',
              id:'',
              bill_type:'',
              billid:'',
              table_name:'',
              date:'',
              today:'',
              customer:{},
            }
          },
    mounted(){
      this.$store.dispatch("allBarBill" ,this.$route.params.billid)
    },
    computed:{
      getAllBill(){
        var data = this.$store.getters.getBarBill;
        this.amount = data.total;
        this.discount = data.discount;
        this.total = data.grand_total;
        this.billid = data.bill_id;
        this.date = moment(data.created_at).format('LLLL');
        this.receive_name = (typeof data.created_user)=="undefined"?'':data.created_user.name;
        this.today = moment().format('LLLL');
        this.table_name = (typeof data.table)=="undefined"?'':data.table.name;
        this.id = data.id;
        this.bill_type = data.bill_type;
        this.customer = (typeof data.customer)=="undefined"?[]:data.customer;
        // return data.orderbar;
        if((typeof data.orderbar)!="undefined" && data.orderbar.length == 0){
            this.$router.replace('/review')
        }
        return data.orderbar;
      }
    },
    methods:{
        print () {
          // Pass the element id here
          this.$htmlToPaper('printMe');
        }
    }
  }
</script>

<style scoped>
</style>