<template>
	<div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark xyz">AtivityLog List</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/#">Home</router-link></li>
              <li class="breadcrumb-item active">Logactivity</li>
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
                  <div class="col-md-10">
                    <!-- <input type="text" class="form-control" @keyup="searchSetting" v-model="search" placeholder="Search by name"> -->
                  </div>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm m-0">
                    <thead class="table-primary text-center">                  
                      <tr>
                        <th width="10">SN</th>
                        <th class="text-left">Log Name</th>
                        <th>Description</th>
                        <th>Properties</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr v-for="(data,index) in getALLActivityLog" :key="data.id">
                        <td>{{index+1}}</td>
                        <td class="text-left">{{data.log_name}}</td>
                        <td>{{data.description}}</td>
                        <td>{{data.properties}}</td>
                        <td>
                          {{data.created_at | timeformat}} 
                          <span class="badge badge-warning text-danger">{{data.created_at  | formatDate}}</span>
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
<script type="text/javascript">
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
      getALLActivityLog(){
        var avar = this.$store.getters.getActivityLog;
        // console.log(avar);
        if(avar.length==2)
          this.pagination = avar[1];
        return avar[0];
      }
    },
	  methods:{
      fetchPosts(){
        this.$Progress.start()
        this.$store.dispatch("allActivityLog", [this.pagination.current_page]);
        this.$Progress.finish()
      },
     
      searchSetting(){
        this.fetchPosts();
      }

	  }
}
</script>