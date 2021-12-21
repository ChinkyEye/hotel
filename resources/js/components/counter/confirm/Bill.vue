<template>
<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bill Invoice</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <div class="col-8">
                  <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print"></i></button>
                  <div id="printMe">
                    <div class="invoice p-3 mb-3">
                      <!-- title row -->
                      <!-- <div class="row">
                        <div class="col-12">
                          <small class="float-right">{{today}}</small>
                          <h4 class="text-center">
                            <i class="fas fa-utensils"></i>  Kitchen Order Ticket
                          </h4>
                        </div>
                      </div> -->
                      <!-- info row -->
                      <div class="row invoice-info">
                        
                        <!-- <div class="col-sm-4 invoice-col">
                          <address>
                            Tankisinwari<br>
                            Biratnagar<br>
                            Phone: 9802711975<br>
                          </address>
                        </div> -->
                        <!-- /.col -->
                        <div class="col-sm-12 invoice-col">
                          <table class="table m-0 border-print">
                            <tr>
                              <td colspan="3">
                                <div class="w-100 text-center">
                                  <div><span><b>Bill Invoice</b></span></div>
                                  <h5><b>{{getFirstSetting['name']}}</b></h5>
                                  <div><small>{{getFirstSetting['address']}}</small></div>
                                  <div v-if="getFirstSetting['pan'] != null"><small>Pan no: {{getFirstSetting['pan']}}</small></div>
                                  <div><small>Phone: {{getFirstSetting['phone']}} <span v-if="getFirstSetting['email'] != null">| {{getFirstSetting['email']}}</span></small></div>
                                  <div><small>{{date}}</small></div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <strong>{{customer.name}}</strong> ({{customer.user_code}})<br>
                                Phone: {{customer.phone}}<br>
                                {{customer.address}}<br>
                              </td>
                            </tr>
                            <tr>
                              <td><b>Table:</b> {{table_name}}</td>
                              <td><b>Bill Sn:</b>{{allbill.bill_sn}}<span v-if="allbill.is_print != '0'">Copied Bill ({{allbill.print_count}})</span></td>
                              <td class="text-right"><b>Bill ID:</b> {{billid}}</td>
                            </tr>
                          </table>
                         <!--  To
                          <address>
                            <strong>{{customer.name}}</strong><br>
                            {{customer.address}}<br>
                            Phone: {{customer.phone}}<br>
                            Code: {{customer.user_code}}
                          </address> -->
                        </div>
                        <!-- /.col -->
                        <!-- <div class="col-sm-4 invoice-col">
                          <b>Bill ID: {{billid}}</b><br>
                          <b>Table:</b> {{table_name}}<br>
                          <b>Order Date:</b> {{date}}<br>
                        </div> -->
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                      <div class="row">
                        <div class="col-12 table-responsive">
                          <table class="table table-striped border-print">
                              <tr>
                                <!-- <th>SN</th> -->
                                <th>Item</th>
                                <th>Qty</th>
                                <!-- <th>Unit</th> -->
                                <th width="10">Price</th>
                                <th width="100" class="text-right">Total</th>
                              </tr>
                              <tr v-for="(post,index) in getAllBill" :key="post.id">
                                  <!-- <td>{{index+1}}</td> -->
                                  <td>{{post.item.name}}</td>
                                  <td>{{post.quantity}} {{post.unit.name}}</td>
                                  <!-- <td>{{post.unit.name}}</td> -->
                                  <td>{{post.item.price}}</td>
                                  <td class="text-right">{{post.item.price*post.quantity}}</td>
                              </tr>
                              <tr class="text-right">
                                <td colspan="3"><b>Subtotal:</b></td>
                                <td>Rs: {{amount}}</td>
                              </tr>
                              <tr class="text-right">
                                <td colspan="3"><b>Discount({{percent}} %):</b></td>
                                <td>Rs: {{discount}}</td>
                              </tr>
                              <tr class="text-right">
                                <td colspan="3"><b>Total:</b></td>
                                <td>Rs: {{total}}</td> 
                              </tr>
                              <tr class="text-right">
                                <td colspan="3"><b>Received:</b></td>
                                <td>Rs: {{receive}}</td>
                              </tr>
                              <tr class="text-left">
                                <td colspan="4">In words: Rs. {{receive | wordConvert}} only/-</td>
                              </tr>
                            <tr>
                              <td colspan="4">
                                <small class="float-left">Counter: {{receive_name}}</small>
                                <small class="float-right">{{today}}</small>
                              </td>
                            </tr>
                            <tr class="text-center">
                              <td colspan="5">{{getFirstSetting['footer_quote1']}}</td>
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
    name: "OrderBill",
     data(){
            return {
              amount: '',
              discount:'',
              total:'',
              id:'',
              bill_type:'',
              billid:'',
              table_name:'',
              receive_name:'',
              percent:'',
              receive:'',
              remain:'',
              date:'',
              today:'',
              customer:{},
              allbill:{},
            }
          },
    mounted(){
      this.$store.dispatch("allConfirmBill" ,this.$route.params.billid)
       this.$store.dispatch("allBillSetting");
    },
    computed:{
      getAllBill(){
        var data = this.$store.getters.getConfirmBill;
        // console.log(data);
        this.amount = data.total;
        this.discount = data.discount;
        this.total = data.grand_total;
        this.receive = data.received;
        this.remain = data.grand_total - data.received
        this.billid = data.bill_id;
        this.date = moment(data.created_at).format('LLLL');
        this.today = moment().format('LLLL');
        this.table_name = (typeof data.table)=="undefined"?'':data.table.name;
        this.receive_name = (typeof data.created_user)=="undefined"?'':data.created_user.name;
        this.percent = (typeof data.usertype)=="undefined"?'':data.usertype.discount;
        this.id = data.id;
        this.bill_type = data.bill_type;
        this.customer = (typeof data.customer)=="undefined"?[]:data.customer;
        this.allbill = (typeof data.allbill)=="undefined"?[]:data.allbill;
        return data.order;
      },
      getFirstSetting(){
        var avar = this.$store.getters.getBillSetting;
        return avar;
      }
    },
    methods:{
        print () {
          this.$htmlToPaper('printMe');
          axios.get('/counter/confirm/print/'+this.billid);
          // window.location.reload(true);

        }
    }
  }
</script>

<style scoped>
</style>