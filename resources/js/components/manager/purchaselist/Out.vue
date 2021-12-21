<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Out Stock ({{stock_name}})</h1>
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
            <div class="row">
              <div class="col-8">
                <div class="card card-primary">
                  <div class="card-header">
                    <router-link to="/purchase/list">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewCategory()">
                    <div class="card-body">
                      <div class="form-group">
                        <input type="hidden" class="form-control" id="price" placeholder="Add Price" v-model="form.id" name="id">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="description" placeholder="Add New Description" v-model="form.description" name="description" :class="{ 'is-invalid': form.errors.has('description') }">
                        <has-error :form="form" field="description"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="quantiti">Quantity <code>({{quantity}} / {{totalsum}})</code></label>
                        <input type="text" class="form-control" id="quantiti" placeholder="Add Quantity" v-model="form.quantiti" name="quantiti" :class="{ 'is-invalid': form.errors.has('quantiti') }" v-on:keyup="changePhoto($event)">
                        <has-error :form="form" field="quantiti"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="date">Date<span class="text-danger">*</span></label>
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
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Description : {{form.description}}</h5>
                      <h5>Quantity : {{form.quantity}}</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="table-responsive ">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(productimage,index) in getAllProductImage" :key="productimage.id">
                        <td>{{index+1}}</td>
                        <td>{{productimage.quantity}}</td>
                        <td>{{productimage.description}}</td>
                        <td>
                          <span class="badge badge-warning text-danger">{{productimage.date }}</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
  import DatePicker from 'v-calendar/lib/components/date-picker.umd';
  import moment from 'moment'
    export default {
        name: "New",
        components: {
          DatePicker
        },
        data(){
            return {
              form: new Form({
                id:this.$route.params.stockid,
                description:'',
                quantiti:'',
                date:moment(this.date).format('YYYY-MM-DD')
            }),
              date: new Date(),
              totalsum:'',
              quantity:'',
              stock_name:'',
              state: {
                isSending: false
            }
        }
    },
    mounted(){
      this.$Progress.start()
      axios.get(`/manager/stock/${this.$route.params.stockid}/out`)
      .then((response)=>{
        this.form.fill(response.data.stocks)
        this.stock_name = response.data.stocks.name;
        this.unit_id = response.data.stocks.unit.name;
        this.quantity = response.data.stocks.qty_rem;
        this.totalsum = response.data.stockouts;
      })
      this.$Progress.finish()
      this.fetchPosts();
    },
    computed:{
        getAllProductImage(){
          var bvar = this.$store.getters.getOutStockList;
          console.log(bvar);
          // if(bvar.length == 0) return [];
          var avar = bvar[0];
          // console.log(avar);
          // this.name = bvar[0].name; 
          // this.productimage = bvar[0].productimage; 
          // if(bvar.length==2)
          //   this.pagination = bvar[1];
          return avar;
        }
    },
    methods:{
      dateChange(e){
        this.form.date = moment(e).format("YYYY-MM-DD");
      },
      fetchPosts(){
        this.$Progress.start()
         this.$store.dispatch("allOutStockList", [this.$route.params.stockid]);
        this.$Progress.finish()
      },
      changePhoto(event){
        let file = event.target.value;
        let quantity = this.quantity;
        let total = this.totalsum;
        let value = parseInt(file) ;
        // 5 mb image
        if((value > quantity)){
          this.state.isSending = true;
          Swal.fire({
           icon: 'error',
           title: 'The entered quantity is greater than remained quantity!',
           text: 'ok!',
           footer: '<a href>Why do I have this issue?</a>'
          })
        }else{
          this.state.isSending = false;

        }

        if((quantity == 0)){
          Swal.fire({
           icon: 'error',
           title: ' Quantity has been returned!',
           text: 'ok!',
           footer: '<a href>Why do I have this issue?</a>'
          })

        }
       
      },
      addNewCategory(){
        this.state.isSending = true;
        this.form.post('/manager/purchase/list/store')
        .then((response)=>{
          this.$router.push('/purchase/list')
          Toast.fire({
            icon: 'success',
            title: 'Category Added successfully'
          })
        })
        .catch(()=>{
          this.state.isSending = false;
        })
      }
    },
    

  }
</script>

<style scoped>

</style>