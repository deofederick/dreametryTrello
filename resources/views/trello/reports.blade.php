
@extends('layouts.app')
@section('content')
@include('inc.sidebar')
<div id = "app">
    <div class="container-fluid" id="paddingtop">
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-light">
                    <div class="h4 card-header">TASK REPORT</div>
                    <div class="card-body">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                             <input type="hidden" id="trelloId" name="userid" value="Content of the extra variable">
                @if(Auth::user()->role_id == 1)               
                <div class="form-group">
                
                <div class="input-group input-group-lg">
                  
                  <select class= "form-control"  name="user" v-model="selected">
                    <option v-for="user in users" :value="user.trelloId">@{{ user.name }}</option>
                        </select>
                        
              <span class="input-group-btn">
                    <button class="btn bg-info text-white" type="submit" v-on:click="getalltasks">Search</button>
                  </span>
              </div>

             
              </div>
              @else
              <div class=""></div>
              @endif
            </div>
            <div class="col-md-6"><button class="btn bg-primary text-white" type="submit" v-on:click="getdoing">Doing</button>

              <button class="btn btn-warning" type="submit" v-on:click="getforreview">For Review</button>
              <button class="btn btn-success" type="submit" v-on:click="getdone">Done</button>
              <button class="btn btn-dark" type="submit" v-on:click="getalltasks">All</button>
          </div>
          

                        </div>
                        
            <div class="col-md-12">
                      <table class="table">
                        
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Task No.</th>
                  <th scope="col">Date Started</th>
                  <th scope="col">Url</th>
                  <th scope="col">Date Finished</th>
                  <th scope="col">Due Date</th>
                  <th scope="col">Status</th>
                  <th scope="col">Points</th>
                </tr>
              </thead>
              <tbody>
                <paginate name="alltasks" :list="tasks" :per=5 tag="div"
  class="pagination">
                <tr v-for="(task, index) in paginated('alltasks')" >
                    <td>@{{ index + 1 }}</td>
                    <td> @{{ task.date_started }}</td>
                    <td><a :href="task.url">@{{ task.cardname }}</a></td>
                    <td>@{{task.date_finished}}</td>
                    <td>@{{task.due_date}}</td>
                    <td>@{{task.status}}</td>

                    <td>@{{task.points}}</td>
                </tr>
              </paginate>
              </tbody>
            </table>
            <div class="progress" v-show="loading">
               <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%" ></div>
            </div>
            
            <paginate-links for="alltasks" :simple="{
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
                      loading: false,
                      users:[],
                      selected: '',
                      tasks:[],
                      pagination: {},
                      current_url : '',
                      langs: ['JavaScript', 'PHP', 'HTML', 'CSS', 'Ruby', 'Python', 'Erlang'],
                      paginate: ['alltasks']
                      }
                
              },

              mounted: function(){
                this.getallusers()
              }, methods:{
                  getalltasks: function(){
                    var vm = this;
                    vm.loading = true;
               console.log('revisions');
                    vm.tasks = [];
                    document.getElementById('trelloId').value = this.selected;
                    var id =  document.getElementById('trelloId').value
                   var page_url ='/search/?user='+id || '/search/?user='+this.selected;
                     vm.$http.get(page_url).then(function(response){
                      
                      var tasks = response.data.sample.data;
                    
                        vm.tasks = response.data.sample.data;
                      
                      
                      vm.loading = false;

                    //console.log(response.data.unRegBoards[0]);
                    
                    }).catch(function(error){

                    });          
                  },

                  movepage: function(){
                    var vm = this;
               console.log('revisions');
                     vm.current_url = '/search/?user='+this.selected+vm.pagination.next_page_url;
                      

                    vm.$http.get(vm.current_url).then(function(response){
                      var tasks = response.data.sample;
                      vm.tasks = response.data.sample.data;
                      
                    
                      vm.pagination = {
                        "current_page": response.data.sample.current_page,
                        "last_page": response.data.sample.last_page,
                        "next_page_url": response.data.sample.next_page_url,
                        "prev_page_url": response.data.sample.prev_page_url
                      }
                      page_url = page_url || '/search/?user='+this.selected+response.data.next_page_url;
                      console.log(tasks);
                      vm.loading = false;

                    //console.log(response.data.unRegBoards[0]);
                    
                    }).catch(function(error){

                    });          
                  },


               getallusers: function(){
                    var vm = this;
               console.log('revisions');

                     vm.$http.get('/reports').then(function(response){
                      console.log('users');
                      var trelloId = response.data.trelloId.role_id;
                      var users = response.data.users;
                      
                      users.forEach(function(value, id){
                      vm.users.push({"name": value.name, "trelloId": value.trelloId})
                      
                    })
                      if(trelloId == 1){
                        
                      }
                      else{
                        vm.loading = true;
                        vm.tasks = response.data.sample.data;
                        vm.loading = false;
                        
                      }
                    
                    }).catch(function(error){

                    });          
                  },

                  getdone: function(){
                    var vm = this;
                    vm.loading = true;
              
                    vm.tasks = [];
                    var id = document.getElementById("trelloId").value

                     var page_url = page_url || '/search/?user='+id;
                     vm.$http.get(page_url).then(function(response){
                      
                      var tasks = response.data.sample.data;

                       tasks.forEach(function(key, value){
                        if(key.status == 'Done'){
                          vm.tasks.push({"cardname":key.cardname, "url": key.url, "date_started": key.date_started, "date_finished": key.date_finished, "status": key.status, "points": key.points, "due_date": key.due_date})
                        }

                       });
                    
                        //vm.tasks = response.data.sample.data;
                      
                      
                      vm.loading = false;

                    //console.log(response.data.unRegBoards[0]);
                    
                    }).catch(function(error){

                    });          
                          
                  },

                   getforreview: function(){
                    var vm = this;
                    vm.loading = true;
              
                    vm.tasks = [];
                    var id = document.getElementById("trelloId").value

                     var page_url = page_url || '/search/?user='+id;
                     vm.$http.get(page_url).then(function(response){
                      
                      var tasks = response.data.sample.data;

                       tasks.forEach(function(key, value){
                        if(key.status == 'For Review'){
                          vm.tasks.push({"cardname":key.cardname, "url": key.url, "date_started": key.date_started, "date_finished": key.date_finished, "status": key.status, "points": key.points, "due_date": key.due_date})
                        }

                       });
                    
                        //vm.tasks = response.data.sample.data;
                      
                      
                      vm.loading = false;

                    //console.log(response.data.unRegBoards[0]);
                    
                    }).catch(function(error){

                    });          
                          
                  },

                   getdoing: function(){
                    var vm = this;
                    vm.loading = true;
              
                    vm.tasks = [];
                    var id = document.getElementById("trelloId").value

                     var page_url = page_url || '/search/?user='+id;
                     vm.$http.get(page_url).then(function(response){
                      
                      var tasks = response.data.sample.data;

                       tasks.forEach(function(key, value){
                        if(key.status == 'Doing'){
                          vm.tasks.push({"cardname":key.cardname, "url": key.url, "date_started": key.date_started, "date_finished": key.date_finished, "status": key.status, "points": key.points, "due_date": key.due_date})
                        }

                       });
                    
                        //vm.tasks = response.data.sample.data;
                      
                      
                      vm.loading = false;

                    //console.log(response.data.unRegBoards[0]);
                    
                    }).catch(function(error){

                    });          
                          
                  },

               movePages: function(amount) {
                  var newStartRow = vm.startRow + (amount * vm.rowsPerPage);
                  if (newStartRow >= 0 && newStartRow < vm.tasks.length) {
                    vm.startRow = newStartRow;
                  }
                }
                } 

          });

         
        </script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
  
@endsection