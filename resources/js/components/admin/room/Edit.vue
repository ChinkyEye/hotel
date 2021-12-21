<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Room</h1>
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
                    <router-link to="/unit">
                      <i class="fas fa-arrow-left" title="Click to go back"></i>
                    </router-link>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" enctype="multipart/form-data" @submit.prevent="addNewRoom()">
                    <div class="card-body">
                      <!-- <div class="form-group">
                        <label for="nameID">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nameID" placeholder="Add New Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" autocomplete="off">
                        <has-error :form="form" field="name"></has-error>
                      </div> -->
                      <div class="form-group">
                        <label for="room_type">Room Type <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="room_type" placeholder="Add Room Type" v-model="form.room_type" name="room_type" :class="{ 'is-invalid': form.errors.has('room_type') }" autocomplete="off" autofocus="true">
                        <has-error :form="form" field="room_type"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="room_no">Room No.<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="room_no" placeholder="Add Room Type" v-model="form.room_no" name="room_no" :class="{ 'is-invalid': form.errors.has('room_no') }" autocomplete="off" autofocus="true">
                        <has-error :form="form" field="room_no"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="no_of_bed">No. of Bed<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_of_bed" placeholder="Add Room Type" v-model="form.no_of_bed" name="no_of_bed" :class="{ 'is-invalid': form.errors.has('no_of_bed') }" autocomplete="off" autofocus="true">
                        <has-error :form="form" field="no_of_bed"></has-error>
                      </div>
                      <div class="form-group">
                        <label for="price">Price/Rate<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price" placeholder="Add Room Type" v-model="form.price" name="price" :class="{ 'is-invalid': form.errors.has('price') }" autocomplete="off" autofocus="true">
                        <has-error :form="form" field="price"></has-error>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" :disabled="state.isSending">{{state.isSending ? "Loading..." : "Update Room"}}</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-4">
                <div class="box box-default position-relative">
                  <div class="box-body">
                    <div class="callout callout-success">
                      <h5>Room Type : {{form.room_type}}</h5>
                      <h5>Room No : {{form.room_no}}</h5>
                      <h5>No. of Bed : {{form.no_of_bed}}</h5>
                      <h5>Price : {{form.price}}</h5>
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
        name: "New",
        data(){
            return {
              form: new Form({
                room_type:'',
                room_no:'',
                no_of_bed:'',
                price:'',
            }),
              state: {
                isSending: false
            }
        }
    },
    mounted(){
        // this.$store.dispatch("allUnittypeSelect")
    },
    created(){
          axios.get(`/home/room/${this.$route.params.roomid}/edit`)
            .then((response)=>{
              this.form.fill(response.data.rooms)
            })
        },
    computed:{
        getAllUnittype(){
            return this.$store.getters.getUnittypeSelect
        }
    },
    methods:{
         addNewRoom(){
          this.state.isSending = true;
          this.form.put(`/home/room/${this.$route.params.roomid}`)
          .then((response)=>{
            this.$router.push('/room')
            Toast.fire({
                icon: 'success',
                title: 'Unit Added successfully'
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