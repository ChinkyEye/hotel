<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Add Detail</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fiscal Year</li>
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
                    <router-link to="/fiscalyear">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addFiscalYear()">
                    <div class="card-body">
                      <div class="row">
                      <div class="form-group col-md-12">
                        <label for="name">Fiscal Year <code>*</code></label>
                        <input type="text" class="form-control" id="name" placeholder="Add Year" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Start Date</label>
                        <date-picker v-model="form.start_date" format="YYYY-MM-dd" name="start_date" :max-date='new Date()'>
                          <template v-slot="{ inputValue, inputEvents }">
                            <input
                            class="bg-white border px-2 py-1 rounded form-control"
                            :value="inputValue"
                            v-on="inputEvents"
                            />
                          </template>
                        </date-picker>
                        <has-error :form="form" field="date"></has-error>
                      </div>
                      <div class="form-group col-md-6">
                        <label>End Date</label>
                        <date-picker v-model="form.end_date" format="YYYY-MM-dd" name="end_date">
                          <template v-slot="{ inputValue, inputEvents }">
                            <input
                            class="bg-white border px-2 py-1 rounded form-control"
                            :value="inputValue"
                            v-on="inputEvents"
                            />
                          </template>
                        </date-picker>
                        <has-error :form="form" field="date"></has-error>
                      </div>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Add Detail"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
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
          name:'',
          address:'',
          start_date:moment(new Date()).format('YYYY-MM-DD'),
          end_date:moment(new Date()).format('YYYY-MM-DD'),
        }),
        state: {
          isSending: false
        }
      }
    },
    mounted(){
      this.$Progress.start()
      this.$Progress.finish()
    },
    methods:{
     addFiscalYear(){
      this.state.isSending = true;
      this.form.start_date = moment(this.form.start_date).format('YYYY-MM-DD');
      this.form.end_date = moment(this.form.end_date).format('YYYY-MM-DD');
      this.form.post('/home/fiscalyear')
      .then((response)=>{
        console.log(response);
        this.$router.push('/fiscalyear')
        Toast.fire({
          icon: 'success',
          title: 'Detail Added successfully'
        })
      })
      .catch(()=>{
        this.state.isSending = false;
      })
      this.resetForm();
    },
    resetForm() {
      this.form.reset();
    }
  }
}
</script>
<style scoped>
</style>
