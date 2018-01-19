
@extends('layouts.app')
@section('content')
@include('inc.sidebar')
<div id = "app">
    <div class="container" id="paddingtop">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="h4 card-header">CREATE AUTHENTICATION</div>
                    <div class="card-body">
              <div class="col-md-12">
                      <table class="table">
                        
              <thead class="thead-dark">
                <tr>
                  <th scope="col">User ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Role</th>
                </tr>
              </thead>
              <tbody>
                <paginate name="allroles" :list="roles" :per=5 tag="div"
  class="pagination">
                <tr v-for="role in paginated('allroles')" >
                    <td>@{{ role.id  }}</td>
                    <td>@{{ role.name }}</td>
                    <td>@{{ role.role_desc }}</a></td>
                </tr>
              </paginate>
              </tbody>
            </table>
            <div class="progress" v-show="loading">
               <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%" ></div>
            </div>
            
            <paginate-links for="allroles" :simple="{
    prev: 'Back',
    next: 'Next'
  }"
  :classes="{
    'ul': 'pagination',
    '.next > a': 'page-item',
    '.prev > a': 'page-item' // multiple classes
  }"></paginate-links>
                 
            </div>
    		</div>
		</div>
	</div>

  
</div>
<br/>
<form action = "{{ route('set_roles') }}">
<div class="row">
  <div class="col-md-12">
                <div class="card bg-light">
                    <div class="h4 card-header">SET ROLES</div>
                    <div class="card-body">
                 <form action="{{ route('post_users') }}">
                      <div class="input-group input-group-lg">
                 
                  <select class= "form-control"  name="users" >
                    <option v-for="user in users" :value="user.id" >@{{ user.name }}</option>
                        </select>
                        
              <span class="input-group-btn">
                   
                  </span>
              </div>
              <br/>
               
              <div class="form-group">
                <label for="sel1">Select Role:</label>
                    <select class="form-control" id="sel2" name="roles2">
                      <option v-for ="allrole in allroles" :value="role.id">@{{allrole.role_desc}}</option>
                    </select>
                   
            </div>
              <button class="btn bg-info text-white" type="submit" >Save</button>
          </form>
        </div>
    </div>
  </div>
</div>
</form>

</div>
</div>
    <script src="js/app.js"></script>
  <script>
         new Vue({
            el: '#app',
            name: 'test',
            data(){
                return{
                      count:'',
                      pcount:'',
                      loading: false,
                      users:[],
                      pages:[],
                      roles:[],
                      pagination: {},
                      paginate: ['allroles'],
                      allroles: []
                      }
                
              },

              mounted: function(){
                this.getalltasks()
              }, methods:{
                  getalltasks: function(){
                    var vm = this;
               console.log('revisions');

                     vm.$http.get('/auth').then(function(response){
                      console.log('allrevision');
                      console.log(response.data.files);
                      vm.pages = response.data.files;
                      vm.users = response.data.users;
                      vm.roles = response.data.roles;
                      vm.allroles = response.data.allroles;
                    }).catch(function(error){

                    });          
                  },

                  setmembers: function(){
                        
                    }
                  }

               

          });

         
        </script>

  
@endsection