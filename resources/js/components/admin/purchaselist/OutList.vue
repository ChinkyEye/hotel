<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <p class="text-danger m-0">Purchase Out List</p>
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

            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <!-- <form role="form" class="form-inline">
                      <div class="row">
                        <div class="form-group col-3 mb-1">
                          <select class="form-control w-100" v-model="category_idSearch"  @change="categoryChange">  
                            <option value="0">Please select All</option> 
                            <option :value="category.id" v-for="category in getAllCategoryAll">{{category.name}}</option>
                          </select>
                        </div>
                        <div class="form-group col-3 mb-1">
                          <input type="text" class="form-control w-100" @keyup="searchStock" v-model="search" placeholder="Search by name">
                        </div>
                        <div class="form-group col-3 mb-1">
                          <select name="type" v-model="type"  @change="typeChange" class="form-control">
                              <option>--- Select Type ---</option>
                              <option value="1">Ready Made</option>
                              <option value="2">Kitchen</option>
                              <option value="3">Bar</option>
                           </select>
                        </div>
                        <div class="form-group mb-1 col-3">
                          <date-picker v-model="date" v-on:input="dateChange">
                            <template v-slot="{ inputValue, inputEvents }">
                              <input
                                class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
                                :value="inputValue"
                                v-on="inputEvents"
                              />
                            </template>
                          </date-picker>
                        </div>
                      </div>
                    </form> -->
                    <div class="table-responsive">
                      <table class="table table-sm table-bordered table-hover">
                        <thead class="table-primary text-center">                  
                          <tr>
                            <th>SN</th>
                            <th class="text-left">Qty</th>
                            <th class="text-left">Date</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                          <tr v-for="(stock,index) in getAllStock" :key="stock.id">
                            <td>{{index+1}}</td>
                            <td class="text-left">{{stock.quantity}}</td>
                            <td class="text-left">
                              {{stock.date}}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts"></pagination>
                    </div>
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
  import pagination from '../../../components/PaginationComponent.vue';
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
  export default{
    name: "List",
    components: {
      pagination,
      DatePicker
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          form: new Form({
                category_id:'',
                buyer_id:'',
                unit_id:'',
                name:'',
                price:'',
                quantity:'',
                rate:'',
                vat:0,
                type: 1,

            }),
              state: {
                isSending: false
            },
            search:'',
            category_idSearch:0,
            type:'',
            date: new Date(),
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
        getAllStock(){
          this.$Progress.start()
          var avar = this.$store.getters.getStockOutList;
          if(avar.length==2)
            this.pagination = avar[1];
          this.$Progress.finish()
          return avar[0];
        },
        getAllCategory(){
            return this.$store.getters.getBuyerCategorySelect
        },
        getAllCategoryAll(){
            return this.$store.getters.getBuyerCategorySelectAll
        },
        getAllUnit(){
            return this.$store.getters.getUnitSelect
        },
        getAllBuyer(){
            return this.$store.getters.getBuyerSelect
        }
    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allStockOutList",[this.$route.params.stockid]);
        this.$store.dispatch("allBuyerCategorySelect")
        this.$store.dispatch("allBuyerCategorySelectAll")
        this.$store.dispatch("allUnitSelect")
        this.$store.dispatch("allBuyerSelect")
      },
   
    addNewStock(){
          this.state.isSending = true;
          this.form.post('/manager/stock')
          .then((response)=>{
              Toast.fire({
                  icon: 'success',
                  title: 'Stock Added successfully'
              })
              this.state.isSending = false;
          })
          .catch(()=>{
              this.state.isSending = false;
          })
          this.fetchPosts();
          this.resetForm(); //clear form automatically after successful request
      },
    resetForm() {
        this.form.reset();
      },
    pagechange(){
      this.$store.dispatch("allStockOutList",[this.$route.params.stockid]);
    },
    searchStock(){
      this.pagechange();
    },
    categoryChange(){
      this.pagechange();
    },
    typeChange(){
      this.pagechange();
    },
    dateChange(){
      this.pagechange();
    },

    },

      
  }
</script>

<style scoped>
</style>