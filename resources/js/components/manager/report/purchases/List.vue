<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Purchases Report</h1>
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
                  <div class="form-group col-md mb-1">
                    <select name="type" v-model="type"  @change="typeChange" class="form-control">
                       <option value="">Please select Type</option> 
                        <option value="1">Ready Made</option>
                        <option value="2">Kitchen</option>
                        <option value="3">Bar</option>
                     </select>
                  </div>
                  <div class="form-group col-sm-5 pb-0">
                    <date-picker mode='range' v-model="date" lang="en" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()' is-range>
                      <template v-slot="{ inputValue, inputEvents }">
                        <div class="flex justify-center items-center">
                          <input
                            :value="inputValue.start"
                            v-on="inputEvents.start"
                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                          /><i class="fas fa-arrow-right fa-fw"></i>
                          <input
                            :value="inputValue.end"
                            v-on="inputEvents.end"
                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                          />
                        </div>
                      </template>
                    </date-picker>
                    <!-- <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()'></date-picker> -->
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
                          <th>Type</th>
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
                          <td v-if="stock.type == '1'"> Ready Made </td>
                          <td v-else-if="stock.type == '2'"> Kitchen </td>
                          <td v-else>Bar</td>
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
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker,
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
          type:'',
          date:{
            start:moment().subtract(1,'months')._d, // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          }
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllStock(){
        this.$Progress.start()
        var avar = this.$store.getters.getPurchaseOrderdetail;
        if(avar.length==2)
          this.pagination = avar[1];
        this.$Progress.finish()
        return avar[0];
      },
      getAllOrder(){
        this.$Progress.start()
        var bvar = this.$store.getters.getPurchaseOrderdetail;
        if(bvar.length == 0) return [];
        var avar = bvar[0].purchaseorderdetails.data;
        console.log(avar);
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
      // getAllItem(){
      //   var avar = this.$store.getters.getItemSelect;
      //   return avar.map(function(p){
      //       return {label: p.name, value: p.id};
      //   });
      // },
    },
    methods:{
      fetchPosts() {
        // this.$store.dispatch("allConfirmOrder",[this.pagination.current_page,0,0,this.date.start.toISOString().split('T')[0],this.date.end.toISOString().split('T')[0]]);
        this.pagechange();
        this.$store.dispatch("allCategorySelect")
        this.$store.dispatch("allBuyerCategorySelectAll")
        this.$store.dispatch("allBuyerSelect")
        // this.$store.dispatch("allItemSelect")
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
      // this.$store.dispatch("allStock",[this.pagination.current_page, this.search, 0,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
      this.$store.dispatch("allPurchaseOrderdetail", [this.pagination.current_page,this.buyer_id, this.search, this.category_id,this.type,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
    },
    categoryChange(){
      this.pagechange();
    },
    buyerChange(){
      this.pagechange();
    },
    postChange(post){
      this.$Progress.start()
      this.item_id = post?post.value:0;
      this.pagechange();
      this.$Progress.finish()
    },
    dateChange(){
      this.pagechange();
    },
    print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    },
    typeChange(){
      this.pagechange();
    },
    itemReportExport(){
      location.href = '/home/report/purchases/export?category_id='+this.category_id+'&item_id='+this.item_id+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
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