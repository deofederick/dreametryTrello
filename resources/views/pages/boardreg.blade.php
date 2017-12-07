@extends('layouts.app')

@section('content')
@include('inc.sidebar')

<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-success text-white">SELECT BOARD</div>
             
              <div id="app">
              
               <ul class="list-group list-group-flush" id="unreg">
                  <div class="text-center" id="unregload">Loading...</div> 
                  <li class="list-group-item" v-cloak v-for="unregboard in unregboards" id="unregli">
                      <div class="card-block"> 
                                 
                          <div class="card-title v-cloak--hidden">                            
                           <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                           <!--  <a :href="'/registerlist/' + unregboard.boardId"> -->
                           <a :href="unregboard.boardId">
                            @{{ unregboard.boardName }}</a>
                            <p class="card-text"><small class="text-muted">@{{ unregboard.organization }}</small></p>
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

               <div id="app2">
               <div class="text-center" id="regload">Loading...</div>
                 <ul class="list-group list-group-flush" id="regli">
                      <li class="list-group-item" v-cloak v-for="regboard in regboards">

                          <div class="card-block">
                              
                              <div class="card-title v-cloak--hidden">
                                
                               <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                                <!-- <a href="/registerlist/@{{ regboard.boardId }}"></a> -->
                                @{{ regboard.boardName }}
                                <p class="card-text"><small class="text-muted">@{{ regboard.organization }}</small></p>
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

              mounted: function(){
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

              mounted: function(){
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
                      console.log(response);
                      vm.regboards = response.data.regBoards;
                      console.log(vm.regBoards);
                      

                    }).catch(function(error){

                    });

                    
                  }


              } 

          });



        </script>
        <script type="text/javascript">
          var time = setInterval(function(){
            if($('#unregli').length){
              $('#unregload').hide();
              clearInterval(time);
            }
          }, 500)

          var time2 = setInterval(function(){
            if($('#regli').length){
              $('#regload').hide();
              clearInterval(time2);
            }
          }, 500)

        </script>



@endsection
