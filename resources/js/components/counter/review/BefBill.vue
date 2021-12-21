<template>
<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Re-Order Token (Ticket)</h1>
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
                      <!-- info row -->
                      <div class="row invoice-info m-0">
                        <div class="col-sm-12 table-responsive p-0">
                          <table class="table m-0 border-print">
                            <tr>
                              <td colspan="3">
                                <div class="text-center">
                                  <h5><i class="fas fa-utensils"></i> Kitchen Order Ticket</h5>
                                  <div><small>{{date}}</small></div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td><strong>Customer:</strong> {{customer.name}}</td>
                              <td><b>Table:</b> {{table_name}}</td>
                              <td class="text-right"><b>Bill ID:</b> {{billid}}</td>
                            </tr>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                      <div class="row">
                        <div class="col-12 table-responsive">
                          <table class="table table-striped border-print">
                            <tr>
                              <th width="10">SN</th>
                              <th class="text-left">Item</th>
                              <th>Qty</th>
                              <!-- <th>Unit</th> -->
                              <!-- <th>Price</th>
                              <th>Total</th> -->
                            </tr>
                            <tr v-for="(post,index) in getAllBill" :key="post.id">
                                <td>{{index+1}}</td>
                                <td class="text-left">{{post.item.name}}</td>
                                <td>{{post.quantity}} {{post.unit.name}}</td>
                                <!-- <td>{{post.unit.name}}</td> -->
                                <!-- <td>Rs: {{post.item.price}}</td>
                                <td>Rs: {{post.item.price*post.quantity}}</td> -->
                            </tr>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <span>Counter: {{receive_name}}</span>
                      <span><small class="float-right">{{today}}</small></span>
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
              date:'',
              today:'',
              receive_name:'',
              customer:{},
            }
          },
    mounted(){
      this.$store.dispatch("allBefReviewBill" ,this.$route.params.billid)
    },
    computed:{
      getAllBill(){
        var data = this.$store.getters.getBefReviewBill;
        this.amount = data.total;
        this.discount = data.discount;
        this.total = data.grand_total;
        this.billid = data.bill_id;
        this.date = moment(data.created_at).format('LLLL');
        this.today = moment().format('LLLL');
        this.table_name = (typeof data.table)=="undefined"?'':data.table.name;
        this.id = data.id;
        this.bill_type = data.bill_type;
        this.customer = (typeof data.customer)=="undefined"?[]:data.customer;
        this.receive_name = (typeof data.created_user)=="undefined"?'':data.created_user.name;
        if((typeof data.orderkitchenprevious)!="undefined" && data.orderkitchenprevious.length == 0){
            this.$router.replace('/review')
        }
        return data.orderkitchenprevious;
      }
    },
    methods:{
        billStatus(id, status){
          axios.get('/home/status-bill/'+id+'/'+status)
          .then(()=>{
            this.$store.dispatch("allBill" ,this.$route.params.billid)
            toast.fire({
                icon: 'success',
                title: 'Status changed successfully'
            })
          })
          .catch(()=>{

                    })
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