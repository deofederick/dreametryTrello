
@extends('layouts.app')
@section('content')
@include('inc.sidebar')
<div id = "app">
    <div class="container" id="paddingtop">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="h4 card-header">TASK REPORT</div>
                    <div class="card-body">
                    	<div class="col-md-12">
                    		<div class="col-md-6">
                    		<div class="form-group">
                    	<form action="/search">
						    <div class="input-group input-group-lg">
						      
						      <select class= "form-control" name="user">
							 	@foreach($users as $user)
							  	<option value={{$user->trelloId}}>{{$user->name}}</option>
							  	@endforeach
							</select>

							<span class="input-group-btn">
						        <button class="btn bg-info text-white" type="submit">Search</button>
						      </span>
						  </div>
						  </form>
						  </div>
						</div>
						<div class="col-md-12">
                    	<table class="table">
						  <thead class="thead-dark">
						    <tr>
						      <th scope="col">DATE STARTED</th>
						      <th scope="col">URL</th>
						      <th scope="col">DATE FINISHED</th>
						      <th scope="col">STATUS</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($data as $d)
						  		<tr>
						  			<td>{{$d['date_started']}}</td>
						  			<td><a href={{$d['url']}}>{{$d['cardname']}}</a></td>
						  			<td>{{$d['date_finished']}}</td>
						  			<td>{{$d['status']}}</td>
						  		</tr>
						  	@endforeach
						  </tbody>
						  	
						</table>
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
                      count:'',
                      pcount:'',
                      loading: false,
                      users:[],
                      tasks:[]
                      }
                
              },

              mounted: function(){
                this.getalltasks()
              }, methods:{
                  getalltasks: function(){
                    var vm = this;
               console.log('revisions');

                     vm.$http.get('/mytasks').then(function(response){
                      console.log('allrevision');
                    //console.log(response.data.unRegBoards[0]);
                    
                    }).catch(function(error){

                    });          
                  }

              } 

          });

         
        </script>

  
@endsection