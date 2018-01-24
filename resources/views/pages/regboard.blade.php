@extends('layouts.app')

@section('content')
@include('inc.sidebar')
<div id="app">
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
          
            <div class="card" id="overflows">
              
                 {{ csrf_field() }}
              <input type="hidden" name="_token" id="csrf" value="<?php echo csrf_token(); ?>">
              <div class="card-header bg-success text-white">Inactive Boards</div>
             
            
              
               <ul class="list-group list-group-flush" id="unreg">
                  <div class="text-center" id="unregload">Loading...</div> 
                  <li class="list-group-item" v-cloak v-for="unregboard in unregboards" id="unregli">
                      <div class="card-block"> 
                                 
                          <div class="card-title v-cloak--hidden">                            
                           <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                           <!--  <a :href="'/registerlist/' + unregboard.boardId"> -->
                           <a :href="unregboard.boardId">
                            @{{ unregboard.name }}</a>
                            <p class="card-text"><small class="text-muted">@{{ unregboard.displayname }}</small></p>
                          
                          </div>
                      </div>
                  </li>
              </ul>
              
               <!--  <test></test> -->
                                 
             </div>
        </div>
       <p id="test"></p>
        <p id="test2"></p>
        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-warning text-white">Active Boards</div>

               <div class="text-center" id="regload">Loading...</div>
                 <ul class="list-group list-group-flush" >
                    <form method="post" id="boardsIds" action="">
                      <li class="list-group-item" v-cloak v-for="(regboard, index) in regboards" id="regli">

                          <div class="card-block">
                              
                              <div class="card-title v-cloak--hidden">
                                
                                  <a :href="regboard.boardId">@{{ regboard.name }}</a>
                                  <input type="text" :name="'board['+(index+1)+']'" :value="regboard.boardId" hidden />

                                <p class="card-text"><small class="text-muted">@{{ regboard.displayname }}</small></p>
                                
                              </div>
                              
                          </div>
                      </li>
                    </form>
                  </ul>
               
            </div>
        </div>
     </div>
       <input type="hidden" id="boardname" name="boards" value="">
     
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
                      unregboards:[],
                      regboards:[],
                      csrf: ''
                      }
                
              },

              mounted: function(){
                  this.fetchUnreg()
              }, methods:{
                  fetchUnreg: function(){
                    var vm = this;
                      var alldata = {'boards': [], 'lists':[]};
                      //var alldata = ['boards', 'lists'];
             
                      var retrieveSuccess1 = function(data) {
                        var orgname = data[0]["name"];
                        var displayname = data[0]["displayName"];
                        console.log(displayname);
                        var retrieveSuccess2 = function(data) {
              
                          var g_board=data;
                          
                          //console.log('Boards Data returned:' + JSON.stringify(data));

                          g_board.forEach(function(bx,bi){
                        //console.log(bx.name);

                        //  $('body').append("<h3><a href='"+bx.url+"' target='_blank'>"+bx.name+"</a></h3>");

                          var lists = bx.lists;
                          console.log(bx.name);
                          console.log(lists.length);
                          var bgImage = bx.prefs.backgroundImage; 

                          if (bgImage != null) {

                            vm.regboards.push({"boardId": bx.id, "name": bx.name, "displayname": displayname})
                             // alldata.push({"boardId": bx.id, "name": bx.name});
                            alldata['boards'].push({"boardId": bx.id, "name": bx.name});
                           
                            var list;
                            
                          for(i = 0; i < lists.length; i++){
                             alldata['lists'].push({"listid": lists[i].id, "name": lists[i].name, "boardid": lists[i].idBoard});
                          }
                        
                          }else{
                              vm.unregboards.push({"boardId": bx.id, "name": bx.name, "displayname": displayname});
                            
                            }
                          
                            
                          })

                          console.log(alldata);



                          var csrf_token = $('meta[name="csrf-token"]').attr('content');

                          vm.$http.post('{{ route("setboards") }}', {_token: csrf_token, data: alldata}, function(response){
                            console.log(response);
                          });
                          

                        }
        
                    
                    Trello.get("organizations/"+orgname+"/boards?filter=open", {lists: "open", fields: "name,displayName,url,prefs"}, retrieveSuccess2);

                      }

                      Trello.get("members/me/organizations", {fields: "name,displayName,url,closed"}, retrieveSuccess1);
                      
                
                
                  //  console.log(x);
                  //  console.log(alldata);
                  //  console.log(c);
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
