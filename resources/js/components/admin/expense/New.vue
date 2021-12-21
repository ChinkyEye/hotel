<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Expense</h1>
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
                    <router-link to="/expense">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewExpense()">
                    <div class="card-body">
                      <!-- <div class="form-group">
                        <label for="nameID">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.topic_id" name="topic_id" :class="{ 'is-invalid': form.errors.has('topic_id') }" autocomplete="off" autofocus="true">
                        <has-error :form="form" field="topic_id"></has-error>
                      </div> -->
                      <div class="form-group">
                        <label for="topic_id">Expense Topic <code>*</code></label>
                        <select class="form-control" id="topic_id" v-model="form.topic_id" name="topic_id" :class="{ 'is-invalid': form.errors.has('topic_id') }"> 
                          <option disabled value="">Select one</option>
                          <option :value="expensetopic.id" v-for="expensetopic in getExpenseTopicSelect">{{expensetopic.name}}</option>
                        </select>
                        <has-error :form="form" field="topic_id"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="descID">Description </label>
                        <input type="text" class="form-control" id="descID" placeholder="Add New Description" v-model="form.description" name="description" :class="{ 'is-invalid': form.errors.has('description') }" autocomplete="off" autofocus="true">
                      </div>
                      <div class="form-group">
                        <label for="amountID">Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amountID" placeholder="Add New Amount" v-model="form.amount" name="amount" :class="{ 'is-invalid': form.errors.has('amount') }" autocomplete="off" autofocus="true">
                        <has-error :form="form" field="amount"></has-error>
                      </div>
                      <div class="form-group">
                          <label for="date">Date <span class="text-danger">*</span></label>
                          <date-picker v-model="form.date">
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
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Expense"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <!-- <h5>Name : {{form.topic_id}}</h5> -->
                      <h5>Description : {{form.description}}</h5>
                      <h5>Amount : {{form.amount}}</h5>
                      <h5>Date : {{form.date}}</h5>
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
    export default {
        name: "New",
        components: {
          pagination,
          DatePicker
        },
        data(){
            return {
              pagination: {
                'current_page': 1
              },
              form: new Form({
                topic_id:'',
                description:'',
                amount:'',
                date:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        this.$Progress.start()
        // this.focusInput()
        this.$store.dispatch("allExpenseTopicSelect")
        this.$Progress.finish()
    },
    computed:{
        getExpenseTopicSelect(){
          var a = this.$store.getters.getExpenseTopicSelect
          return a;
        },
    },
    methods:{
         addNewExpense(){
          this.state.isSending = true;
          this.form.post('/home/expense')
          .then((response)=>{
            this.$router.push('/expense')
            Toast.fire({
                icon: 'success',
                title: 'Expense Added successfully'
            })
        })
          .catch(()=>{
              this.state.isSending = false;
          })
      }
    }
  }
</script>

<style scoped>

</style>