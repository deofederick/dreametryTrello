
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
                 <form action="{{ route('post_users') }}">
                      <div class="input-group input-group-lg">
                 
                  <select class= "form-control"  name="page" >
                    <option v-for="page in pages" >@{{ page.filename }}</option>
                        </select>
                        
              <span class="input-group-btn">
                   
                  </span>
              </div>
              <br/>
               
              <div class="form-group">
                <label for="sel1">Select Role:</label>
                    <select class="form-control" id="sel2" name="users[]">
                      <option v-for ="role in roles" :value="role.id">@{{role.role_desc}}</option>
                    </select>
                   
            </div>
              <button class="btn bg-info text-white" type="submit" >Save</button>
          </form>
    		</div>
		</div>
	</div>
</div>

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
                      roles:[]
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
                    }).catch(function(error){

                    });          
                  },

                  setmembers: function(){
                        
                    }
                  }

               

          });

         
        </script>

  
@endsection