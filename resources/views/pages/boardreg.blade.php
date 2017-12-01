@extends('layouts.app')

@section('content')
@include('inc.sidebar')

<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-success text-white">SELECT BOARD</div>
              <!-- <div class="card-body bg-success text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-clipboard"></i> 999999</h3>
                <p class="card-text">boards</p>
              </div> -->

             
              <div id="app">
              
               <ul class="list-group list-group-flush">
                  <li class="list-group-item" v-for="unregboard in unregboards">
                      <div class="card-block">
                          <div class="card-title" >
                            
                           <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                           <!--  <a :href="'/registerlist/' + unregboard.boardId"> -->
                           <a :href="unregboard.boardId">
                            @{{ unregboard.boardName }}</a>
                          </div>
                      </div>
                  </li>
              </ul>
               <!--  <test></test> -->
                          
              </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-warning text-white">REGISTERED BOARDS</div>
              <!-- <div class="card-body bg-warning text-white text-center">
                <h3 class="panel-hero-title justify-content-center"><i class="fa fa-clipboard"></i> 999999</h3>
                <p class="card-text">boards</p>
              </div> -->
               <div id="app2">
                 <ul class="list-group list-group-flush">
                      <li class="list-group-item" v-for="regboard in regboards">
                          <div class="card-block">
                              <div class="card-title">
                                
                               <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                                <!-- <a href="/registerlist/@{{ regboard.boardId }}"></a> -->
                                @{{ regboard.boardName }}
                              </div>
                          </div>
                      </li>
                  </ul>
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
                      message:'',
                      unregboards:[]
                      }
                
              },

              created: function(){
                  this.fetchUnreg()
              }, methods:{
                  fetchUnreg: function(){
                    var vm = this;

                   /* $.get('/registerlist', function(json){
                      console.log('testgiididididis');
                      console.log(json)
                      vm.unregboards = json['regBoards'];
                      console.log(unregboards);
                      
                    });*/
                    vm.$http.get('/registerlist').then(function(response){
                      console.log('test');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      vm.unregboards = response.data.unRegBoards;
                      console.log(vm.unregboards);
                      

                    }).catch(function(error){

                    });

                    
                  }


              } 

          });

         
        </script>

        <script>
          new Vue({
            el: '#app2',
            name: 'test',
            data(){
                return{
                      message:'',
                      regboards:[]
                      }
                
              },

              created: function(){
                  this.fetchReg()
              }, methods:{
                  fetchReg: function(){
                    var vm = this;

                   /* $.get('/registerlist', function(json){
                      console.log('testgiididididis');
                      console.log(json)
                      vm.unregboards = json['regBoards'];
                      console.log(unregboards);
                      
                    });*/
                    vm.$http.get('/registerlist').then(function(response){
                      console.log('test');
                    //console.log(response.data.unRegBoards[0]);
                    //console.log(response);
                      vm.regboards = response.data.regBoards;
                      console.log(vm.regBoards);
                      

                    }).catch(function(error){

                    });

                    
                  }


              } 

          });

        </script>
@endsection
