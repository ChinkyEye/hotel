<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row">
      
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
                  <div id="printMe">
                    <div class="invoice p-3 mb-3">
                      <div class="row invoice-info">
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
                              <td>Bill Status: <b>Not Confirmed</b></td>
                              <td class="text-right"><b>Bill ID:</b> {{billid}}</td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 table-responsive">
                          <table class="table table-striped border-print">
                              <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th width="10">Price</th>
                                <th width="100" class="text-right">Total</th>
                              </tr>
                              <tr v-for="(post,index) in getAllItem" :key="post.id">
                                  <td>{{post.item.name}}</td>
                                  <td>{{post.quantity}} {{post.unit.name}}</td>
                                  <td>{{post.item.price}}</td>
                                  <td class="text-right">{{post.item.price*post.quantity}}</td>
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
    name: "List",
    data(){
      return{
          id:'',
          billid:'',
          table_name:'',
          receive_name:'',
          date:'',
          today:'',
          customer:{},
        }
    },
    mounted(){
      this.$store.dispatch("allOrderBill" ,this.$route.params.billid)
      this.$store.dispatch("allBillSetting");
    },
    computed:{
      getAllItem(){
        var data = this.$store.getters.getOrderBill;
        this.billid = data.bill_id;
        this.date = moment(data.created_at).format('LLLL');
        this.today = moment().format('LLLL');
        this.table_name = (typeof data.table)=="undefined"?'':data.table.name;
        this.receive_name = (typeof data.created_user)=="undefined"?'':data.created_user.name;
        this.id = data.id;
        this.customer = (typeof data.customer)=="undefined"?[]:data.customer;
        return data.order;
      },
      getFirstSetting(){
        var avar = this.$store.getters.getBillSetting;
        return avar;
      }
    },
  }
</script>

<style scoped>
</style>