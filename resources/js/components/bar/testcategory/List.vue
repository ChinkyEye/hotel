<template>
<div>
    <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Category List</h1>
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
  <div class="card-header">
    <div class="row">
      <div class="col-md-2">
        <h3 class="card-title">
          <button class="btn btn-primary">
              <router-link to="/category/create" style="color:#fff"> Add Category <i class="fas fa-user-plus fa-fw"></i></router-link>
          </button>
        </h3>
      </div>
      <div class="col-md-10">
        <div class="tableFilters">
            <input class="input" type="text" v-model="tableData.search" placeholder="Search Table" @input="getProjects()">
            <div class="control">
                <div class="select">
                    <select v-model="tableData.length" @change="getProjects()">
                        <option v-for="(records, index) in perPage" :key="index" :value="records">{{records}}</option>
                    </select>
                </div>
            </div>
        </div>
      </div>
  </div>
  </div><!-- /.card-header -->
  <div class="card-body">
    <div class="table-responsive">
    <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
        <tbody>
            <tr v-for="project in projects" :key="project.id">
                <td>{{project.name}}</td>
                <td>{{project.slug}}</td>
                <td>{{project.is_active}}</td>
            </tr>
        </tbody>
    </datatable>
    <pagination :pagination="pagination"
        @prev="getProjects(pagination.prevPageUrl)"
        @next="getProjects(pagination.nextPageUrl)">
    </pagination>
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
  import Datatable from '../../../components/Datatable.vue';
  import Pagination from '../../../components/Pagination.vue';
	export default{
		name: "List",
    components: { datatable: Datatable, pagination: Pagination },
    data() {
        let sortOrders = {};
        let columns = [
            {width: '33%', label: 'Name', name: 'name' },
            {width: '33%', label: 'Slug', name: 'slug'},
            {width: '33%', label: 'Status', name: 'is_active'}
        ];
        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        return {
            projects: [],
            columns: columns,
            sortKey: 'name',
            sortOrders: sortOrders,
            perPage: ['10', '20', '30'],
            tableData: {
                draw: 0,
                length: 10,
                search: '',
                column: 0,
                dir: 'desc',
            },
            pagination: {
                lastPage: '',
                currentPage: '',
                total: '',
                lastPageUrl: '',
                nextPageUrl: '',
                prevPageUrl: '',
                from: '',
                to: ''
            },
        }
    },
    // mounted(){
    //   this.fetchPosts();
    // },
    // computed:{
    //   getAllTestCategory(){
    //     this.$Progress.start()
    //     var avar = this.$store.getters.getTestCategory;
    //     return avar[0];
    //   }
    // },
		methods:{
      // fetchPosts() {
      //   this.$store.dispatch("allTestCategory",[this.pagination.current_page,0]);
      // },
      getProjects(url = '/bar/testcategory') {
          this.tableData.draw++;
          axios.get(url, {params: this.tableData})
              .then(response => {
                  let data = response.data;
                  if (this.tableData.draw == data.draw) {
                      this.projects = data.data.data;
                      this.configPagination(data.data);
                  }
              })
              .catch(errors => {
                  console.log(errors);
              });
        },
      configPagination(data) {
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, 'name', key);
            this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
            this.getProjects();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },
		}
	}
</script>

<style scoped>
</style>