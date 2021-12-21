<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Item Sales Report</h1>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- main page load here-->
            <button @click="print" class="btn btn-primary rounded-0"><i class="fas fa-print"></i> Print</button>
            <button @click.prevent="itemReportExport()" class="btn btn-success rounded-0"><i class="fas fa-print" title="Export To Excel"></i> Excel</button>
            <div class="card rounded-bottom">
              <div class="card-header">
                <div class="row">
                  <div class="form-group col-md pb-0">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" v-model="category_id"  @change="categoryChange"> 
                      <option value="">Select All Category</option>
                      <option :value="category.id" v-for="category in getAllCategory">{{category.name}}</option>
                    </select>
                  </div>
                  <div class="form-group col-md pb-0">
                    <label for="item_id">Item</label>
                    <v-select id="item_id" name="item_id" :options="getAllItem" v-on:input="postChange" v-model="defaultSelected"> 
                    </v-select>
                  </div>
                  <div class="form-group col-md pb-0">
                    <label for="bill_id">Date</label>
                    <date-picker mode='range' v-model="date" lang="en" type="date" format="YYYY-MM-dd" v-on:input="dateChange" :max-date='new Date()'></date-picker>
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <div id="printMe">
                    <table class="table table-sm table-bordered table-hover">
                      <thead class="table-primary">                  
                        <tr>
                          <th>SN</th>
                          <th>Category</th>
                          <th>Item</th>
                          <th>Qty</th>
                          <th>Unit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(order,index) in getAllOrder" :key="order.id"  :class="customerStatus(order.is_confirmed)">
                          <td>{{index+1}}</td>
                          <td>{{order.item.category.name}}</td>
                          <td>{{order.item.name}}</td>
                          <td>{{order.sumqty}}</td>
                          <td>{{order.unit.name}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
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
          total:'',
          date:{
            start: new Date(), // Jan 16th, 2018
            end: new Date()    // Jan 19th, 2018
          }
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
      getAllOrder(){
        this.$Progress.start()
        var bvar = this.$store.getters.getConfirmOrder;
        if(bvar.length == 0) return [];
        var avar = bvar[0].confirmorders.data;
        this.total = bvar[0].total;
        if(bvar.length==2)
          this.pagination = bvar[1];
        this.$Progress.finish()
        return avar;
      },
      getAllCategory(){
          return this.$store.getters.getCategorySelect
      },
      getAllItem(){
        var avar = this.$store.getters.getItemSelect;
        return avar.map(function(p){
            return {label: p.name, value: p.id};
        });
      },
    },
    methods:{
      fetchPosts() {
        // this.$store.dispatch("allConfirmOrder",[this.pagination.current_page,0,0,this.date.start.toISOString().split('T')[0],this.date.end.toISOString().split('T')[0]]);
        this.pagechange();
        this.$store.dispatch("allCategorySelect")
        this.$store.dispatch("allItemSelect")
      },
      customerStatus(id){
        return {
            'table-danger':!id,
            'table-default': id
        }
      },
    pagechange(){
      this.$store.dispatch("allConfirmOrder", [this.pagination.current_page, this.category_id, this.item_id,moment(this.date.start).format('YYYY-MM-DD'),moment(this.date.end).format('YYYY-MM-DD')]);
    },
    categoryChange(){
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
    itemReportExport(){
      location.href = '/bar/report/items/export?category_id='+this.category_id+'&item_id='+this.item_id+'&start_date='+moment(this.date.start).format('YYYY-MM-DD')+'&end_date='+moment(this.date.end).format('YYYY-MM-DD');
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