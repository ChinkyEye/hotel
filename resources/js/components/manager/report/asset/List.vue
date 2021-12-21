<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Asset Report</h1>
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
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print"></i> Print</button>
            <button @click.prevent="itemReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="form-group">
                    <select class="form-control" id="buyer_id" v-model="buyer_id" name="buyer_id" @change="buyerChange"> 
                      <option disabled value="">Select one</option>
                      <option :value="buyer.id" v-for="buyer in getAllBuyer">{{buyer.user_code}} ({{buyer.name}})</option>
                    </select>
                    <!-- <has-error :form="form" field="buyer_id"></has-error> -->
                  </div>
                  <div class="form-group col-md">
                    <input type="text" class="form-control" @keyup="searchStock" v-model="search" placeholder="Search by name">
                  </div>
                  <div class="form-group col-md pb-0">
                    <select class="form-control" id="category_id" v-model="category_id"  @change="categoryChange"> 
                      <option value="">Select All Category</option>
                      <option :value="category.id" v-for="category in getAllCategoryAll">{{category.name}}</option>
                    </select>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div id="printMe">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                      <thead class="thead-dark">                  
                        <tr>
                          <th>SN</th>
                          <th>Category</th>
                          <th>Name</th>
                          <th>Price</th>
                          <th>Quantity</th>
                          <th>VAT</th>
                          <th>Rate</th>
                          <th>Total</th>
                          <th>Unit</th>
                          <th>From</th>
                          <th>Issued</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(stock,index) in getAllOrder" :key="stock.id">
                          <td>{{index+1}}</td>
                          <td>{{stock.category.name}}</td>
                          <td>{{stock.name}}</td>
                          <td>Rs: {{stock.price}}</td>
                          <td>{{stock.quantity}}</td>
                          <td>{{stock.vat}}</td>
                          <td>{{stock.rate}}</td>
                          <td>{{stock.total}}</td>
                          <td>{{stock.unit.name}}</td>
                          <td>{{stock.bought.name}} <span class="badge badge-info">{{stock.bought.user_code}}</span></td>
                          <td><span class="badge badge-warning"><span class="text-success">{{stock.created_at  | formatDate}}</span></span></td>
                        </tr>
                      </tbody>
                    </table>
                    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
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
  import pagination from '../../../../components/PaginationComponent.vue';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          defaultSelected: {
            label: "-- Please Select --",
            value: ''
          },
          category_id:'',
          buyer_id:'',
          total:'',
          search:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllOrder(){
        this.$Progress.start()
        var bvar = this.$store.getters.getAssetReport;
        if(bvar.length == 0) return [];
        var avar = bvar[0].assetreports.data;
        this.total = bvar[0].total;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
      getAllCategory(){
          return this.$store.getters.getCategorySelect
      },
      getAllCategoryAll(){
          return this.$store.getters.getBuyerCategorySelectAll
      },
      getAllBuyer(){
          return this.$store.getters.getBuyerSelect
      }
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allCategorySelect")
        this.$store.dispatch("allBuyerCategorySelectAll")
        this.$store.dispatch("allBuyerSelect")
        // this.$store.dispatch("allItemSelect")
      },
      searchStock(){
        this.pagechange();
      },
    pagechange(){
      this.$store.dispatch("allAssetReport", [this.pagination.current_page,this.buyer_id, this.search, this.category_id]);
    },
    categoryChange(){
      this.pagechange();
    },
    buyerChange(){
      this.pagechange();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    },
    itemReportExport(){
      location.href = '/manager/report/asset/export?buyer_id='+this.buyer_id+'&search='+this.search+'&category_id='+this.category_id;
    }
    }
  }
</script>

<style scoped>
.vs__selected-options{
  min-width:150px;
  min-height: 30px;
}
</style>