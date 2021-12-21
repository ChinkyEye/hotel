<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Edit Detail</h5>
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
                    <router-link to="/fiscal">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="updateSetting()">
                    <div class="card-body">
                    <div class="row">
                      <div class="form-group col-md-12">
                        <label for="name">Name <code>*</code></label>
                        <input type="text" class="form-control" id="name" placeholder="Add Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
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
                        <has-error :form="form" field="start_date"></has-error>
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
                        <has-error :form="form" field="end_date"></has-error>
                      </div>
                  </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Setting"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Name : {{form.name}}</h5>
                      <h5>Start Date : {{form.start_date}}</h5>
                      <h5>End Date : {{form.end_date}}</h5>
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
    name: "Edit",
    components: {
      DatePicker
    },
    data(){
        return {
          form: new Form({
            name: '',
            start_date:moment(new Date()).format('YYYY-MM-DD'),
            end_date:moment(new Date()).format('YYYY-MM-DD'),
          }),
          state: {
            isSending: false,
            isDisplay: true
          }
        }
    },
    mounted(){
      this.$Progress.start()
    	axios.get(`/home/fiscalyear/${this.$route.params.fiscalyearid}/edit`)
    	.then((response)=>{
    		console.log(response);
    		this.form.fill(response.data.fiscals)
    	})
      this.$Progress.finish()
    },
    methods:{
      updateSetting(){
        this.state.isSending = true;
        this.form.start_date = moment(this.form.start_date).format('YYYY-MM-DD');
        this.form.end_date = moment(this.form.end_date).format('YYYY-MM-DD');
        this.form.put(`/home/fiscalyear/${this.$route.params.fiscalyearid}`)
        .then((response)=>{
          this.$router.push('/fiscalyear')
          Toast.fire({
            icon: 'success',
            title: 'Data  Updated successfully'
          })
        })
        .catch(()=>{
          this.state.isSending = false
        })
      },
    }
  }
</script>