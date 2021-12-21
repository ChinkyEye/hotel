<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">Setting List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
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
            <div class="card card-info card-outline">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                    <router-link to="/setting/create" class="btn btn-primary btn-block" style="color:#fff"> Add <i class="fas fa-plus fa-fw"></i></i></router-link>
                  </div>
                  <div class="col-md-10">
                    <input type="text" class="form-control" @keyup="searchSetting" v-model="search" placeholder="Search by name">
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th class="text-left">Name</th>
                        <th>Address</th>
                        <th>Phone no</th>
                        <th>Email</th>
                        <th>PAN</th>
                        <th>Footer1</th>
                        <th>Footer2</th>
                        <th>Tax Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(setting,index) in getAllSetting" :key="setting.id"  :class="customerStatus(setting.is_active)">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{setting.name}}</td>
                        <td>{{setting.address}}</td>
                        <td>{{setting.phone}}</td>
                        <td>{{setting.email}}</td>
                        <td>{{setting.pan}}</td>
                        <td>{{setting.footer_quote1}}</td>
                        <td>{{setting.footer_quote2}}</td>
                        <td>{{setting.taxamount}}</td>
                        <td>{{setting.date_np}}</td>
                        <td v-if="setting.is_active == '0'">Inactive <a href="javascript:void(0)" @click.prevent="settingStatus(setting.id, setting.is_active)" title="Click to Publish"><i class="nav-icon fas fa-times-circle text-danger"></i></a></td>
                        <td v-else>Active <a href="javascript:void(0)" @click.prevent="settingStatus(setting.id, setting.is_active)" title="Click to Unpublish"><i class="nav-icon fas fa-check-circle text-success"></i></a></td>
                        <td>
                          {{setting.created_at | timeformat}} 
                          <span class="badge badge-warning text-danger">{{setting.created_at  | formatDate}}</span>
                        </td>
                        <td>
                          <router-link :to="`/setting/${setting.id}/edit`" class="btn btn-xs btn-outline-info"><i class="fas fa-pencil-alt" title="Click to edit"></i></router-link> 
                          <a href="" @click.prevent="deleteSetting(setting.id)" class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt" title="Click to delete"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
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
  import pagination from '../../../components/PaginationComponent.vue';
	export default{
		name: "List",
    components: {
      pagination,
    },
    data(){
      return{
        pagination: {
            'current_page': 1
          },
          search: ''
        }
    },
		mounted(){
      this.fetchPosts();
		},
		computed:{
			getAllSetting(){
				var avar = this.$store.getters.getSetting;
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
			}
		},
		methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allSetting", [this.pagination.current_page,this.search]);
        this.$Progress.finish()
      },
      customerStatus(id){
        return {
          'table-danger':!id,
          'table-default': id
        }
      },
      settingImage(img){
        if(img){
          return "image/setting/thumbnail/"+img;
        }
        else{
          return "image/noimage.png";
        }
      },
      deleteSetting(id){
        var that = this;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            buttonsStyling: true
        }).then(function (isConfirm) {
            if(isConfirm.value === true) {
                axios.delete('/home/setting/'+id)
                .then((response)=>{
                    Toast.fire({
                      icon: 'success',
                      title: 'Setting Deleted successfully'
                  })
                    that.$store.dispatch("allSetting", [0,0]);
                })
                .catch((response)=>{
                    Toast.fire({
                      icon: 'error',
                      title: 'Something went wrong'
                  })
                })
            }
            else{
                Toast.fire({
                  icon: 'error',
                  title: 'Setting not Deleted'
              })
            }
        })
      },
      settingStatus(clkid, show){
          axios.get('/home/setting/status/'+clkid+'/'+show)
          .then(()=>{
              this.$store.dispatch("allSetting", [0,0]);
              Toast.fire({
                  icon: 'success',
                  title: 'Status changed successfully'
              })
          })
          .catch(()=>{
        })
      },
      searchSetting(){
        this.fetchPosts();
      }
		}
	}
</script>

<style scoped>
</style>