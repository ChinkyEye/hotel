<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Kitchen Stocks Report</h1>
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
                          <th>Stock</th>
                          <th>Unit</th>
                          <th>Issued</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(stock,index) in getAllKitchenStock" :key="stock.id" :class="stock.qty_rem == stock.stock ? 'btn-danger' : 'btn-primary'">
                          <td>{{index+1}}</td>
                          <td>{{stock.category.name}}</td>
                          <td>{{stock.name}}</td>
                          <td>Rs: {{stock.price}}</td>
                          <td>{{stock.quantity}}</td>
                          <td>{{stock.qty_rem}}</td>
                          <td>{{stock.unit.name}}</td>
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
          item_id:'',
          buyer_id:'',
          total:'',
          search:'',
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllKitchenStock(){
        this.$Progress.start()
        var bvar = this.$store.getters.getKitchenStockdetail;
        if(bvar.length == 0) return [];
        var avar = bvar[0].kitchenstockdetails.data;
        this.total = bvar[0].total;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
      getAllCategoryAll(){
          return this.$store.getters.getSellerCategorySelectAll
      },
    },
    methods:{
      fetchPosts() {
        this.pagechange();
        this.$store.dispatch("allSellerCategorySelectAll")
      },
      searchStock(){
        this.pagechange();
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
    pagechange(){
      this.$store.dispatch("allKitchenStockdetail", [this.pagination.current_page, this.search, this.category_id]);
    },
    categoryChange(){
      this.pagechange();
    },
    dateChange(){
      this.pagechange();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    },
    itemReportExport(){
      location.href = '/home/report/kitchen-sotck/export?search='+this.search+'category_id='+this.category_id;
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