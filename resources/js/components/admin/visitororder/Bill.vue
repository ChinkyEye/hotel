<template>
<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Bill</h1>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{customer.name}} | </h3>
                        <span v-if="bill_type =='0'">
                            <i class="fas fa-times-circle" title="Due">Due</i>
                        </span>
                        <span v-else>
                            <i class="fas fa-check-circle" title="Paid">Paid</i>
                        </span>
                    </div>
                    <div class="card-body">
                        <form role="form">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="thead-light">                  
                                    <tr>
                                        <th>SN</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  v-for="(post,index) in getAllBill" :key="post.id">
                                        <td>{{index+1}}</td>
                                        <td>{{post.item.name}}</td>
                                        <td>{{post.quantity}}</td>
                                        <td>{{post.unit.name}}</td>
                                        <td>Rs: {{post.item.price}}</td>
                                        <td>Rs: {{post.item.price*post.quantity}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <label>Amount: </label>
                            </div>
                            <div class="col-md-3">
                                <label>Rs: {{amount}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <label>Discount: </label>
                            </div>
                            <div class="col-md-3">
                                <label>Rs: {{discount}}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <label>Total: </label>
                            </div>
                            <div class="col-md-3">
                                <label>Rs: {{total}}</label>
                            </div>
                        </div> 
                            <!-- <button type="submit" class="btn btn-warning">Print</button> -->
                        </form>
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
  export default{
    name: "OrderBill",
     data(){
            return {
              amount: '',
              discount:'',
              total:'',
              id:'',
              bill_type:'',
              customer:{},
            }
          },
    mounted(){
      this.$store.dispatch("allBill" ,this.$route.params.billid)
    },
    computed:{
      getAllBill(){
        var data = this.$store.getters.getBill;
        this.amount = data.total;
        this.discount = data.discount;
        this.total = data.grand_total;
        this.id = data.id;
        this.bill_type = data.bill_type;
        this.customer = (typeof data.customer)=="undefined"?[]:data.customer;
        return data.order;
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
        }
    }
  }
</script>

<style scoped>
</style>