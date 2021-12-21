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
            <div class="col-9">
              <div id="printMe">
                <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print  rounded-0"  target="_blank"></i></button>
                <div class="invoice p-3 mb-3">
                  <!-- title row -->
                  <!-- <div class="row">
                    <div class="col-12">
                      <h4>
                        <i class="fas fa-globe"></i> User Order
                        <small class="float-right">{{today}}</small>
                      </h4>
                    </div>
                  </div> -->
                  <!-- info row -->
                  <div class="row invoice-info">
                    <!-- <div class="col-sm-4 invoice-col">
                      From
                      <address>
                        <strong>Birat Kitchen</strong><br>
                        Tankisinwari<br>
                        Biratnagar<br>
                        Phone: 9802711975
                      </address>
                    </div> -->
                    <!-- /.col -->
                    <!-- <div class="col-sm-4 invoice-col">
                      To
                      <address>
                        <strong>{{customer.name}}</strong><br>
                        {{customer.address}}<br>
                        Phone: {{customer.phone}}<br>
                        Code: {{customer.user_code}}
                      </address>
                    </div> -->
                    <!-- /.col -->
                    <!-- <div class="col-sm-4 invoice-col">
                      <b>Bill ID: {{billid}}</b><br>
                      <b>Table:</b> {{table_name}}<br>
                      <b>Order Date:</b> {{date}}
                    </div> -->
                    <!-- /.col -->
                    <div class="col-sm-12 invoice-col">
                      <table class="table m-0 border-print">
                        <tr>
                          <td colspan="2">
                            <div class="w-100 text-center">
                              <div><span><b>Bill Invoice</b></span></div>
                              <h5><b>Birat Kitchen</b></h5>
                              <div><small>Tankisinwari, Biratnagar</small></div>
                              <div><small>Pan no: 609818347</small></div>
                              <div><small>Phone: 9802711975</small></div>
                              <div><small>{{date}}</small></div>
                            </div>
                          </td>
                        </tr>
                        <!-- <tr>
                          <td colspan="2">
                            <strong>{{customer.name}}</strong> ({{customer.user_code}})<br>
                            Phone: {{customer.phone}}<br>
                            {{customer.address}}<br>
                          </td>
                        </tr> -->
                        <tr>
                          <td><b>Table:</b> {{table_name}} (<strong>{{customer.name}}</strong>)</td>
                          <td class="text-right"><b>Bill ID:</b> {{billid}}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.row -->
                  <div class="row">
                    <div class="col-12 table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <!-- <th>SN</th> -->
                            <th>Item</th>
                            <th>Qty</th>
                            <!-- <th>Unit</th> -->
                            <th width="10">Price</th>
                            <th width="100" class="text-right">Total</th>
                          </tr>
                        </thead>
                        <tbody>
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
                            <td colspan="3"><b>Discount:</b></td>
                            <td>Rs: {{discount}}</td>
                          </tr>
                          <tr class="text-right">
                            <td colspan="3"><b>Total:</b></td>
                            <td>Rs: {{total}}</td> 
                          </tr>
                          <tr class="text-left">
                            <td colspan="4">In words: Rs. {{total | wordConvert}} only/-</td>
                          </tr>
                          <!-- <tr class="text-right">
                            <td colspan="3"><b>Received:</b></td>
                            <td>Rs: {{receive}}</td>
                          </tr> -->
                          <tr>
                            <td colspan="4">
                              <small class="float-left">Counter: {{receive_name}}</small>
                              <small class="float-right">{{today}}</small>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.col -->
                  </div>
                  <div class="row">
                    <!-- accepted payments column -->
                    <!-- <div class="col-6">

                    </div> -->
                    <!-- /.col -->
                    <!-- <div class="col-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <tr class="text-right">
                              <th style="width:50%">Subtotal:</th>
                              <td>Rs: {{amount}}</td>
                            </tr>
                            <tr class="text-right">
                              <th>Discount:</th>
                              <td>Rs: {{discount}}</td>
                            </tr>
                            <tr class="text-right">
                              <th>Total:</th>
                              <td>Rs: {{total}}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div> -->
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
  // var converter = require('number-to-words');
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
              date:'',
              today:'',
              customer:{},
              // word:'',
            }
          },
    mounted(){
      this.$store.dispatch("allConfirmBill" ,this.$route.params.billid)
    },
    computed:{
      getAllBill(){
        var data = this.$store.getters.getConfirmBill;
        this.amount = data.total;
        this.discount = data.discount;
        this.total = data.grand_total;
        // this.word = converter.toWords((typeof data.grand_total)=="undefined"?0:parseFloat(data.grand_total));
        this.billid = data.bill_id;
        this.date = moment(data.created_at).format('LLLL');
        this.today = moment().format('LLLL');
        this.table_name = (typeof data.table)=="undefined"?'':data.table.name;
        this.receive_name = (typeof data.created_user)=="undefined"?'':data.created_user.name;
        this.id = data.id;
        this.bill_type = data.bill_type;
        this.customer = (typeof data.customer)=="undefined"?[]:data.customer;
        return data.order;
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