<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <p class="text-danger m-0">CheckIn</p>
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
                  <div class="col-md-8 border-right">
                    <form role="form" enctype="multipart/form-data" @submit.prevent="addNewCheckIn()">
                      <div class="form-group">
                        <label for="user_id">Customer<span class="text-danger">*</span></label>
                        <select class="form-control" id="user_id" v-model="form.user_id" name="user_id" :class="{ 'is-invalid': form.errors.has('user_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="buyer.id" v-for="buyer in getAllCustomer">{{buyer.user_code}} ({{buyer.name}})</option>
                        </select>
                        <has-error :form="form" field="user_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="room_id">Room<span class="text-danger">*</span></label><br>
                        <span v-for="(bar,index) in getAllRoom" :key="bar.id">
                          <input type="checkbox" id="room_id" v-on:click="postChange(bar)">
                          {{bar.room_type}}({{bar.price}})
                        </span>
                      </div>
                      <div class="row">
                        <div class="form-group col-md">
                          <label for="check_in_date">Check-in Date<span class="text-danger">*</span></label>
                          <date-picker v-model="form.date1" v-on:input="dateChange">
                            <template v-slot="{ inputValue, inputEvents }">
                              <input
                              class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
                              :value="inputValue"
                              v-on="inputEvents"
                              />
                            </template>
                          </date-picker>
                          <has-error :form="form" field="check_in_date"></has-error>
                        </div>
                        <div class="form-group col-md">
                          <label for="check_out_date">Check-out Date<span class="text-danger">*</span></label>
                          <date-picker v-model="form.date2" v-on:input="dateChange">
                            <template v-slot="{ inputValue, inputEvents }">
                              <input
                              class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300 form-control"
                              :value="inputValue"
                              v-on="inputEvents"
                              />
                            </template>
                          </date-picker>
                          <has-error :form="form" field="check_out_date"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="document_type">Document Type<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="document_type" placeholder="Add document_type" v-model="form.document_type" name="document_type" :class="{ 'is-invalid': form.errors.has('document_type') }" autocomplete="off">
                        <has-error :form="form" field="document_type"></has-error>
                      </div>
                      <!-- <div class="form-group">
                        <label for="photo" class="d-block">Photo <code>* Jpeg/Jpg Only with maximum size of 1 MB</code></label>
                        <input type="file" class="" @change="changePhoto($event)" id="photo" name="photo" :class="{ 'is-invalid': form.errors.has('photo') }">
                        <has-error :form="form" field="photo"></has-error>
                      </div> -->
                      <!-- /.card-body -->
                      <button type="submit" class="btn btn-primary btn-block" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add"}}</button>
                    </form>
                  </div>
                  <div class="col-4">
                    <div class="box box-default position-relative">
                      <div class="box-body">
                        <div class="callout callout-success">
                          <h5>CheckIn Date : {{form.date1}}</h5>
                          <h5>CheckOut Date : {{form.date2}}</h5>
                        </div>
                      </div>
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
                billid:'',
                user_id:'',
                room_id:[],
                document_type:'',
                // date1:moment(this.date1).format('YYYY-MM-DD'),
                // date2:moment(this.date2).format('YYYY-MM-DD'),
                date1:moment(new Date()).format('YYYY-MM-DD'),
                date2:moment(new Date()).format('YYYY-MM-DD'),
            }),
              state: {
                isSending: false
            },
            search:'',
            // date1: new Date(),
            // date2: new Date(),
            category_idSearch:0,
        }
    },
    mounted(){
      this.fetchPosts();
    },
    computed:{
        getAllStock(){
          this.$Progress.start()
          var avar = this.$store.getters.getStock;
          if(avar.length==2)
            this.pagination = avar[1];
          this.$Progress.finish()
          return avar[0];
        },
        getAllCustomer(){
            return this.$store.getters.getCustomerSelect
        },
        getAllRoom(){
            return this.$store.getters.getRoomSelect
        }
    },
    methods:{
      fetchPosts() {
        this.$store.dispatch("allStock",[this.pagination.current_page, this.search, this.category_idSearch]);
        this.$store.dispatch("allCustomerSelect")
        this.$store.dispatch("allRoomSelect")
      },
      postChange(post){
          this.form.room_id.push(post.id);
        },
      dateChange(){
        this.pagechange();
      },
      addNewCheckIn(){
        this.state.isSending = true;
          // console.log(this.form);
          this.form.date1 = moment(this.form.date1).format('YYYY-MM-DD');
          this.form.date2 = moment(this.form.date2).format('YYYY-MM-DD');
          this.form.post('/counter/checkin')
          .then((response)=>{
            this.$router.push('/checkin')
            Toast.fire({
              icon: 'success',
              title: 'Order Added successfully'
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
          this.$store.dispatch("allStock", [this.pagination.current_page,this.search,this.category_idSearch]);
        },
    },
      
  }
</script>

<style scoped>
</style>