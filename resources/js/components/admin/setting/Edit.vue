<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Edit Setting</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Setting</li>
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
                    <router-link to="/setting">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="updateSetting()">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Name <code>*</code></label>
                        <input type="text" class="form-control" id="name" placeholder="Add Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="address">Address <code>*</code></label>
                        <input type="text" class="form-control" id="address" placeholder="Add Name" v-model="form.address" name="address" :class="{ 'is-invalid': form.errors.has('address') }" autocomplete="off">
                        <has-error :form="form" field="address"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="phone">Phone <code>*</code></label>
                        <input type="text" class="form-control" id="phone" placeholder="Add Name" v-model="form.phone" name="phone" :class="{ 'is-invalid': form.errors.has('phone') }" autocomplete="off">
                        <has-error :form="form" field="phone"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="email">Email </label>
                        <input type="text" class="form-control" id="email" placeholder="Add Name" v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }" autocomplete="off">
                        <has-error :form="form" field="email"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="pan">PAN </label>
                        <input type="text" class="form-control" id="pan" placeholder="Add Name" v-model="form.pan" name="pan" :class="{ 'is-invalid': form.errors.has('pan') }" autocomplete="off">
                        <has-error :form="form" field="pan"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="footer_quote1">Footer </label>
                        <input type="text" class="form-control" id="footer_quote1" placeholder="Add Name" v-model="form.footer_quote1" name="footer_quote1" :class="{ 'is-invalid': form.errors.has('footer_quote1') }" autocomplete="off">
                        <has-error :form="form" field="footer_quote1"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="footer_quote2">Footer </label>
                        <input type="text" class="form-control" id="footer_quote2" placeholder="Add Name" v-model="form.footer_quote2" name="footer_quote2" :class="{ 'is-invalid': form.errors.has('footer_quote2') }" autocomplete="off">
                        <has-error :form="form" field="footer_quote2"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="taxamount">Footer </label>
                        <input type="text" class="form-control" id="taxamount" placeholder="Add Name" v-model="form.taxamount" name="taxamount" :class="{ 'is-invalid': form.errors.has('taxamount') }" autocomplete="off">
                        <has-error :form="form" field="taxamount"></has-error>
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
                      <h5>Address : {{form.address}}</h5>
                      <h5>Phone No : {{form.phone}}</h5>
                      <h5>Email : {{form.email}}</h5>
                      <h5>PAN : {{form.pan}}</h5>
                      <h5>Footer : {{form.footer_quote}}</h5>
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
  export default {
    name: "Edit",
    data(){
        return {
          form: new Form({
            name: '',
            address:'',
            phone:'',
            email:'',
            pan:'',
            footer_quote1:'',
            footer_quote2:'',
            taxamount:'',
          }),
          state: {
            isSending: false,
            isDisplay: true
          }
        }
    },
    mounted(){
      this.$Progress.start()
    	axios.get(`/home/setting/${this.$route.params.settingid}/edit`)
    	.then((response)=>{
    		this.form.fill(response.data.settings)
    	})
      this.$Progress.finish()
    },
    methods:{
    updateSetting(){
      this.state.isSending = true;
        this.form.put(`/home/setting/${this.$route.params.settingid}`)
        .then((response)=>{
            this.$router.push('/setting')
            Toast.fire({
                icon: 'success',
                title: 'Setting Updated successfully'
            })
        })
        .catch(()=>{
          this.state.isSending = false
        })
    },
    }
  }
</script>

<style scoped>

</style>